<?php

namespace App\Http\Controllers;

use App\Support\Bidang;
use App\Support\RingkasanModul;
use Illuminate\Http\Request;

/**
 * Halaman ringkasan bidang dan halaman modul, berdasarkan config/bidang.php.
 * Akses dasar (bidang ada & boleh dilihat) sudah diperiksa middleware bidang:lihat.
 */
class BidangController extends Controller
{
    /**
     * Ringkasan satu bidang.
     * URL: /admin/bidang/{bidang}
     */
    public function show(string $bidang)
    {
        // Petugas hanya mendapat sub bidang yang ditugaskan (lihat Bidang::untuk)
        $b = Bidang::cariUntuk(auth()->user(), $bidang);
        abort_unless($b, 404);

        $kelompok = collect(Bidang::kelompok($b))->map(function ($k) {
            $k['modul'] = collect($k['modul'])->map(fn ($m) => $m + ['ringkasan' => RingkasanModul::untuk($m)])->all();
            $k['jumlah_aktif'] = collect($k['modul'])->where('aktif', true)->count();

            return $k;
        })->all();

        $semuaModul = collect($kelompok)->flatMap(fn ($k) => $k['modul']);
        $terakhir = $semuaModul->pluck('ringkasan.terakhir')->filter()->max();

        return view('admin.bidang.show', [
            'bidang' => $b,
            'kelompok' => $kelompok,
            'jumlahSub' => count($b['sub_bidang']),
            'jumlahModul' => $semuaModul->count(),
            'jumlahAktif' => $semuaModul->where('aktif', true)->count(),
            'terakhir' => $terakhir,
            'bisaUbah' => fn (?string $sub) => Bidang::bolehUbah(auth()->user(), $b['slug'], $sub),
        ]);
    }

    /**
     * Halaman satu modul.
     * URL: /admin/bidang/{bidang}/{modul}
     * - modul lama (Kawasan Hutan, Lahan Kritis) diarahkan ke route lamanya
     * - modul data aktif ditampilkan oleh ModulDataController
     * - modul "segera" menampilkan halaman placeholder
     */
    public function modul(Request $request, string $bidang, string $modul)
    {
        $b = Bidang::cari($bidang);
        $m = Bidang::cariModul($bidang, $modul);
        abort_unless($b && $m, 404);

        if (! empty($m['route'])) {
            return redirect()->route($m['route']);
        }

        if ($m['aktif'] && ! empty($m['data'])) {
            return app(ModulDataController::class)->index($request, $bidang, $modul);
        }

        return view('admin.bidang.segera', ['bidang' => $b, 'modul' => $m]);
    }
}
