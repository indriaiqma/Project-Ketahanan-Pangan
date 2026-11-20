<?php

namespace App\Http\Middleware;

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

        if (! in_array(auth()->user()->role, $roles, true)) {
            // Viewer tidak memakai panel pengelola: arahkan ke halaman Data Bidang
            if (auth()->user()->isViewer() && $request->isMethod('GET') && $request->is('admin', 'admin/*')) {
                return redirect()->route('data.index');
            }


            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
