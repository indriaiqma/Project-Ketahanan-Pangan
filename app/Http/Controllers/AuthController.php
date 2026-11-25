<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGIN ADMIN & PETUGAS
        |--------------------------------------------------------------------------
        | Hanya akun dengan role yang terdaftar di User::ROLES dan berstatus aktif
        | (sudah disetujui Administrator) yang boleh masuk.
        */

        $credentials[] = fn ($query) => $query->whereIn('role', array_keys(User::ROLES))->where('status_akun', 'aktif');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Admin & Petugas ke panel pengelola
            return redirect()->intended($request->user()->beranda());
        }

        // Pesan khusus status pendaftaran hanya bila password benar (tidak membocorkan akun)
        $akun = User::where('email', $request->email)->first();
        if ($akun && ! $akun->isAktif() && Hash::check($request->password, $akun->password)) {
            return back()->withErrors(['email' => $akun->status_akun === 'menunggu'
                ? 'Akun Anda masih menunggu persetujuan Administrator. Anda dapat masuk setelah pendaftaran disetujui.'
                : 'Pendaftaran akun Anda tidak disetujui Administrator.'.($akun->alasan_ditolak ? ' Alasan: '.$akun->alasan_ditolak : ''),
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun Anda tidak memiliki akses.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}