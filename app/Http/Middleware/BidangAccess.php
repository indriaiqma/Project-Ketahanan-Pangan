<?php

namespace App\Http\Middleware;

use App\Support\Bidang;
use Closure;
use Illuminate\Http\Request;

/**
 * Pemeriksaan akses per bidang (penugasan di tabel user_bidang_access).
 *
 * Pemakaian di route:
 *   bidang:lihat                              bidang dari parameter route {bidang}
 *   bidang:ubah                               bidang & modul dari parameter route {bidang}/{modul}
 *   bidang:ubah,sarana-prasarana,sarpras-2    bidang & sub bidang ditulis langsung (route lama)
 */
class BidangAccess
{
    public function handle(Request $request, Closure $next, string $mode = 'lihat', ?string $bidang = null, ?string $sub = null)
    {
        $user = $request->user();
        $bidang ??= $request->route('bidang');

        if (! is_string($bidang) || ! Bidang::cari($bidang)) {
            abort(404);
        }

        // Bidang yang disembunyikan (opsi 'hidden') diperlakukan seperti tidak ada
        if (! Bidang::bolehLihat($user, $bidang)) {
            abort(404);
        }

        if ($mode === 'ubah') {
            if ($sub === null && is_string($slugModul = $request->route('modul'))) {
                $modul = Bidang::cariModul($bidang, $slugModul);
                abort_unless($modul, 404);
                $sub = $modul['sub'];
            }

            if (! Bidang::bolehUbah($user, $bidang, $sub)) {
                abort(403, 'Anda tidak ditugaskan untuk mengubah data di bidang ini.');
            }
        }

        return $next($request);
    }
}
