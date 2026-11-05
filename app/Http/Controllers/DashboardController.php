<?php

namespace App\Http\Controllers;

use App\Models\KawasanHutan;
use App\Models\LahanKritis;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * =========================================================
     * DASHBOARD VIEWER / PUBLIK
     * =========================================================
     */
    /**
     * Kunci cache ringkasan dashboard. Dihapus otomatis saat data
     * kawasan hutan / lahan kritis berubah (lihat booted() di model).
     */
    public const CACHE_KEY = 'dashboard.data';

    public function index()
    {
        return view('dashboard-viewer', $this->getDashboardData());
    }

    /**
     * =========================================================
     * DASHBOARD ADMIN
     * =========================================================
     */
    public function adminIndex()
    {
        return view('admin.dashboard', $this->getDashboardData());
    }


    /**
     * =========================================================
     * DATA DASHBOARD
     * =========================================================
     *
     * Data digunakan oleh Viewer dan Admin.
     */
    private function getDashboardData(): array
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(5), fn () => $this->hitungDashboardData());
    }

    private function hitungDashboardData(): array
    {
        // Database (Supabase) berada jauh, jadi setiap query mahal.
        // Semua angka dashboard diambil dengan 2 query rekap per kecamatan,
        // lalu dihitung di PHP.

        // =====================================================
        // KAWASAN HUTAN (1 query)
        // =====================================================

        $kawasan = KawasanHutan::selectRaw('
                kecamatan,
                COUNT(*) as jumlah,
                COALESCE(SUM(luas_ha), 0) as total_luas,
                MAX(updated_at) as terakhir
            ')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $totalKawasan           = (int) $kawasan->sum('jumlah');
        $totalLuasKawasan       = (float) $kawasan->sum('total_luas');
        $jumlahKecamatanKawasan = $kawasan->whereNotNull('kecamatan')->count();

        $kawasanPerKecamatan = $kawasan
            ->whereNotNull('kecamatan')
            ->mapWithKeys(fn ($r) => [$r->kecamatan => (float) $r->total_luas])
            ->all();


        // =====================================================
        // LAHAN KRITIS (1 query)
        // =====================================================

        // Tingkat kekritisan (dalam + luar kawasan hutan)
        $kategori = [
            'sangat_kritis'    => ['Sangat Kritis',    '#e5484d'],
            'kritis'           => ['Kritis',           '#f5a524'],
            'agak_kritis'      => ['Agak Kritis',      '#7cb82f'],
            'potensial_kritis' => ['Potensial Kritis', '#2f80c2'],
            'tidak_kritis'     => ['Tidak Kritis',     '#c9d1cc'],
        ];

        $selectKategori = collect($kategori)->keys()
            ->map(fn ($k) => "COALESCE(SUM(dalam_{$k} + luar_{$k}), 0) as {$k}")
            ->implode(', ');

        $lahan = LahanKritis::selectRaw("
                kecamatan,
                {$selectKategori},
                COALESCE(SUM(total_ha), 0) as total_ha,
                MAX(updated_at) as terakhir
            ")
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $jumlahKecamatanLahanKritis = $lahan->whereNotNull('kecamatan')->count();
        $totalLahanKritis           = (float) $lahan->sum('total_ha');
        $totalSangatKritis          = (float) $lahan->sum('sangat_kritis');
        $totalKritis                = (float) $lahan->sum('kritis');

        $ringkasan = collect($kategori)
            ->map(fn ($meta, $k) => [
                'label' => $meta[0],
                'ha'    => (float) $lahan->sum($k),
                'color' => $meta[1],
            ])
            ->values()
            ->all();

        // Grafik per kecamatan: [sangat kritis, kritis, agak kritis]
        $lahanPerKecamatan = $lahan
            ->whereNotNull('kecamatan')
            ->mapWithKeys(fn ($r) => [
                $r->kecamatan => [
                    (float) $r->sangat_kritis,
                    (float) $r->kritis,
                    (float) $r->agak_kritis,
                ],
            ])
            ->all();


        // =====================================================
        // PEMBARUAN TERAKHIR
        // =====================================================

        $terakhir = $kawasan->pluck('terakhir')
            ->merge($lahan->pluck('terakhir'))
            ->filter()
            ->max();

        $terakhirDiperbarui = $terakhir
            ? Carbon::parse($terakhir)->locale('id')->translatedFormat('d F Y, H:i')
            : null;


        return compact(
            'totalKawasan',
            'totalLuasKawasan',
            'jumlahKecamatanKawasan',

            'jumlahKecamatanLahanKritis',
            'totalLahanKritis',
            'totalSangatKritis',
            'totalKritis',

            'ringkasan',
            'lahanPerKecamatan',
            'kawasanPerKecamatan',
            'terakhirDiperbarui'
        );
    }
}
