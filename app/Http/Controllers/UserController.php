<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('aksesBidang')->orderBy('id', 'asc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
        ] + $this->aturanPenugasan($request));

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            $this->simpanPenugasan($user, $request);
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
        ] + $this->aturanPenugasan($request));

        // Admin tidak boleh menurunkan role akunnya sendiri,
        // agar sistem tidak kehilangan administrator.
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->withInput()->withErrors([
                'role' => 'Anda tidak dapat mengubah role akun Anda sendiri.',
            ]);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::transaction(function () use ($user, $data, $request) {
            $user->update($data);
            $this->simpanPenugasan($user, $request);
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Validasi penugasan bidang. Nilai berbentuk "bidang|sub_bidang"
     * dan harus ada di config/bidang.php. Petugas wajib punya minimal satu.
     */
    private function aturanPenugasan(Request $request): array
    {
        $valid = collect(Bidang::opsiPenugasan())->flatMap(fn ($g) => array_column($g['opsi'], 'nilai'))->all();

        return [
            'penugasan' => [$request->input('role') === 'petugas' ? 'required' : 'nullable', 'array'],
            'penugasan.*' => ['string', Rule::in($valid)],
        ];
    }

    /** Simpan ulang penugasan; hanya petugas yang memiliki penugasan. */
    private function simpanPenugasan(User $user, Request $request): void
    {
        $user->aksesBidang()->delete();

        if ($user->role !== 'petugas') {
            return;
        }

        foreach (array_unique($request->input('penugasan', [])) as $nilai) {
            [$bidang, $sub] = explode('|', $nilai, 2) + [1 => ''];
            $user->aksesBidang()->create(['bidang' => $bidang, 'sub_bidang' => $sub !== '' ? $sub : null]);
        }
    }
}