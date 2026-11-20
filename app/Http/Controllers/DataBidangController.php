<?php

namespace App\Http\Controllers;

use App\Support\Bidang;
use App\Support\RingkasanBidang;
use App\Support\RingkasanModul;
use Illuminate\Http\Request;

/**
 * Halaman "Data Bidang" di situs publik (layout landing page), hanya-baca.
 * Dipakai terutama oleh role Viewer untuk melihat hasil input Admin & Petugas
 * di seluruh bidang. Wajib login; akses per bidang diperiksa middleware bidang:lihat.
 */
class DataBidangController extends Controller
{
    /** URL: /data - semua bidang beserta jumlah data per modul. */
    public function index(Request $request)
    {
        $ringkasan = RingkasanBidang::semua($request->user());

        return view('data.index', [
            'ringkasan' => $ringkasan,
            'total' => [
                'bidang' => $ringkasan->count(),
                'modul' => $ringkasan->sum('jumlah_modul'),
                'terisi' => $ringkasan->sum('modul_terisi'),
                'data' => $ringkasan->sum('jumlah_data'),
                'terakhir' => $ringkasan->pluck('terakhir')->filter()->max(),
            ],
        ]);
    }

    /** URL: /data/{bidang} - ringkasan satu bidang per sub bidang. */
    public function bidang(Request $request, string $bidang)
    {
        $b = Bidang::cariUntuk($request->user(), $bidang);
        abort_unless($b, 404);

        $kelompok = collect(Bidang::kelompok($b))->map(function ($k) {
            $k['modul'] = collect($k['modul'])->map(fn ($m) => $m + [
                'ringkasan' => RingkasanModul::untuk($m),
                'href_publik' => RingkasanBidang::href($m),
            ])->all();

            return $k;
        })->all();

        $semuaModul = collect($kelompok)->flatMap(fn ($k) => $k['modul']);

        return view('data.bidang', [
            'bidang' => $b,
            'kelompok' => $kelompok,
            'jumlahModul' => $semuaModul->count(),
            'terakhir' => $semuaModul->pluck('ringkasan.terakhir')->filter()->max(),
            'semuaBidang' => Bidang::untuk($request->user()),
        ]);
    }

    /** URL: /data/{bidang}/{modul} - tabel & grafik modul (tanpa tombol ubah). */
    public function modul(Request $request, string $bidang, string $modul)
    {
        $m = Bidang::cariModul($bidang, $modul);
        abort_unless($m && $m['aktif'], 404);

        // Kawasan Hutan & Lahan Kritis punya halaman publik sendiri
        if (! empty($m['route'])) {
            return redirect(RingkasanBidang::href($m));
        }

        abort_if(empty($m['data']), 404);

        return app(ModulDataController::class)->index($request, $bidang, $modul);
    }
}
