<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PendaftaranAkunNotification;
use App\Support\Bidang;
use App\Support\Surel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as AturanPassword;

/**
 * Pendaftaran akun Petugas secara mandiri. Akun baru berstatus "menunggu" dan
 * baru bisa dipakai setelah disetujui Administrator (lihat UserController).
 * Akun Administrator tidak dapat didaftarkan sendiri.
 */
class PendaftaranController extends Controller
{
    public function form()
    {
        return view('auth.daftar', ['opsiPenugasan' => Bidang::opsiPenugasan()]);
    }

    public function simpan(Request $request)
    {
        // Honeypot sederhana: diisi oleh bot, tidak terlihat oleh manusia
        if ($request->filled('situs_web')) {
            return redirect()->route('login')->with('status', 'Pendaftaran berhasil dikirim.');
        }

        $opsi = collect(Bidang::opsiPenugasan())->flatMap(fn ($g) => array_column($g['opsi'], 'nilai'))->all();
        $valid = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'no_hp' => ['required', 'regex:/^(\+62|62|0)8[0-9]{7,12}$/'],
            'jabatan' => 'required|string|max:150',
            'penugasan' => 'required|array|min:1',
            'penugasan.*' => ['string', Rule::in($opsi)],
            'catatan' => 'nullable|string|max:255',
            'password' => ['required', 'confirmed', AturanPassword::min(8)->letters()->numbers()],
            'setuju' => 'accepted',
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Gunakan menu masuk atau lupa password.',
            'no_hp.regex' => 'Nomor HP tidak valid. Contoh: 081234567890.',
            'penugasan.required' => 'Pilih minimal satu sub bidang yang Anda ajukan.',
            'setuju.accepted' => 'Centang pernyataan bahwa data yang Anda isi benar.',
        ], [
            'name' => 'nama lengkap', 'no_hp' => 'nomor HP', 'jabatan' => 'jabatan/unit kerja', 'password' => 'password',
        ]);

        $user = User::create([
            'name' => $valid['name'],
            'email' => $valid['email'],
            'no_hp' => preg_replace('/^(\+62|62)/', '0', $valid['no_hp']),
            'jabatan' => $valid['jabatan'],
            'password' => Hash::make($valid['password']),
            'role' => 'petugas',
            'status_akun' => 'menunggu',
            'pengajuan_penugasan' => array_values(array_unique($valid['penugasan'])),
            'catatan_pendaftaran' => $valid['catatan'] ?? null,
        ]);

        // Beri tahu Administrator lewat email bila pengiriman email sudah aktif
        if (Surel::siap()) {
            try {
                Notification::send(User::where('role', 'admin')->where('status_akun', 'aktif')->get(), new PendaftaranAkunNotification('masuk', $user));
            } catch (\Throwable $e) {
                Log::warning('Email pemberitahuan pendaftaran gagal: '.$e->getMessage());
            }
        }

        return redirect()->route('login')->with('status',
            'Pendaftaran berhasil dikirim. Akun Anda akan aktif setelah disetujui Administrator. '
            .(Surel::siap() ? 'Pemberitahuan akan dikirim ke email Anda.' : 'Silakan coba masuk kembali setelah dikonfirmasi Administrator.'));
    }
}
