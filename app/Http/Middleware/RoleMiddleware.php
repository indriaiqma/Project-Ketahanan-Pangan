<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

/**
 * Membatasi akses berdasarkan role pengguna.
 * Contoh di route: ->middleware('role:admin') atau ->middleware('role:admin,petugas')
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Akun dengan role yang sudah tidak dipakai (mis. "viewer" lama): keluarkan
        if (! array_key_exists(auth()->user()->role, User::ROLES) || ! auth()->user()->isAktif()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda tidak aktif atau belum disetujui Administrator. Data tetap dapat dilihat di situs publik tanpa login.',
            ]);
        }

        if (! in_array(auth()->user()->role, $roles, true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
