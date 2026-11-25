<?php

namespace App\Http\Controllers;

use App\Models\PermintaanResetPassword;
use App\Models\User;
use App\Notifications\PendaftaranAkunNotification;
use App\Support\Bidang;
use App\Support\Surel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // Pendaftar yang menunggu ditampilkan terpisah di panel persetujuan
        $users = User::with('aksesBidang')->where('status_akun', '!=', 'menunggu')->orderBy('id', 'asc')->get();
        $pendaftar = User::menungguPersetujuan()->oldest()->get();
        $permintaan = PermintaanResetPassword::menunggu()->with('user')->latest()->get();

        return view('admin.users.index', compact('users', 'pendaftar', 'permintaan'));
    }

    /**
     * Setujui pendaftaran akun Petugas. Penugasan memakai pilihan Administrator
     * (bawaan: sub bidang yang diajukan pendaftar).
     */
    public function setujui(Request $request, User $user)
    {
        abort_unless($user->status_akun === 'menunggu', 404);

        $request->merge(['role' => 'petugas']);
        $request->validate($this->aturanPenugasan($request), [
            'penugasan.required' => 'Pilih minimal satu sub bidang untuk petugas ini.',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->forceFill([
                'status_akun' => 'aktif',
                'role' => 'petugas',
                'alasan_ditolak' => null,
                'diverifikasi_oleh' => auth()->id(),
                'diverifikasi_pada' => now(),
            ])->save();
            $this->simpanPenugasan($user, $request);
        });

        $this->kabari($user, 'disetujui');

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$user->name} disetujui dan sudah dapat digunakan untuk masuk.");
    }

    /** Tolak pendaftaran akun (alasan opsional, disampaikan ke pendaftar saat mencoba masuk). */
    public function tolak(Request $request, User $user)
    {
        abort_unless($user->status_akun === 'menunggu', 404);
        $request->validate(['alasan' => 'nullable|string|max:255'], [], ['alasan' => 'alasan']);

        $user->forceFill([
            'status_akun' => 'ditolak',
            'alasan_ditolak' => $request->alasan,
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ])->save();

        $this->kabari($user, 'ditolak');

        return redirect()->route('admin.users.index')->with('success', "Pendaftaran {$user->name} ditolak.");
    }

    /** Kirim email hasil verifikasi bila pengiriman email sudah aktif. */
    private function kabari(User $user, string $jenis): void
    {
        if (! Surel::siap()) {
            return;
        }
        try {
            $user->notify(new PendaftaranAkunNotification($jenis, $user));
        } catch (\Throwable $e) {
            Log::warning('Email hasil verifikasi pendaftaran gagal: '.$e->getMessage());
        }
    }

    /**
     * Buat password sementara untuk pengguna yang lupa password.
     * Password hanya ditampilkan sekali kepada Administrator; pengguna wajib
     * menggantinya saat login berikutnya. Permintaan reset yang menunggu ditandai selesai.
     */
    public function resetPassword(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Untuk akun Anda sendiri, ganti password melalui menu Profil Saya.');
        }

        $sementara = Str::password(10, true, true, false);
        $user->forceFill([
            'password' => Hash::make($sementara),
            'remember_token' => Str::random(60),
            'wajib_ganti_password' => true,
        ])->save();

        PermintaanResetPassword::menunggu()->where('user_id', $user->id)->update([
            'status' => 'selesai',
            'diproses_oleh' => auth()->id(),
            'diproses_pada' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('password_sementara', [
            'nama' => $user->name,
            'email' => $user->email,
            'password' => $sementara,
        ]);
    }

    /** Tolak/abaikan permintaan reset (mis. bukan permintaan pemilik akun). */
    public function tolakPermintaan(PermintaanResetPassword $permintaan)
    {
        $permintaan->update(['status' => 'ditolak', 'diproses_oleh' => auth()->id(), 'diproses_pada' => now()]);

        return redirect()->route('admin.users.index')->with('success', 'Permintaan reset password ditolak.');
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