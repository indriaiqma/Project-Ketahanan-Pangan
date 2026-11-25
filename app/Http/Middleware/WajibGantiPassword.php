<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Pengguna dengan password sementara (dibuat Administrator) harus menggantinya
 * dulu sebelum bisa memakai panel pengelola.
 */
class WajibGantiPassword
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user?->wajib_ganti_password && ! $request->routeIs('admin.profile', 'admin.profile.password', 'logout')) {
            if ($request->isMethod('GET')) {
                return redirect()->route('admin.profile')
                    ->with('warning', 'Anda masuk dengan password sementara. Demi keamanan, buat password baru terlebih dahulu.');
            }
            abort(403, 'Ganti password sementara Anda terlebih dahulu.');
        }

        return $next($request);
    }
}
