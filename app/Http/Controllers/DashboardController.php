<?php

namespace App\Http\Controllers;

use App\Models\KawasanHutan;
use App\Models\LahanKritis;

class DashboardController extends Controller
{
    /**
     * =========================================================
     * DASHBOARD VIEWER / PUBLIK
     * =========================================================
     */
    public function index()
{
    $data = $this->getDashboardData();

    // Rincian per kecamatan: [sangat kritis, kritis, agak kritis]
    $lahanPerKecamatan = LahanKritis::selectRaw('
            kecamatan,
            SUM(dalam_sangat_kritis + luar_sangat_kritis) as sangat_kritis,
            SUM(dalam_kritis + luar_kritis) as kritis,
            SUM(dalam_agak_kritis + luar_agak_kritis) as agak_kritis
        ')
        ->whereNotNull('kecamatan')
        ->groupBy('kecamatan')
        ->orderBy('kecamatan')
        ->get()
        ->mapWithKeys(fn ($r) => [
            $r->kecamatan => [
                (float) $r->sangat_kritis,
                (float) $r->kritis,
                (float) $r->agak_kritis,
            ],
        ])
        ->all();

    $agakKritis  = collect($lahanPerKecamatan)->sum(fn ($v) => $v[2]);
    $tidakKritis = max(
        $data['totalLahanKritis'] - $data['totalSangatKritis'] - $data['totalKritis'] - $agakKritis,
        0
    );

    $ringkasan = [
        ['label' => 'Sangat Kritis', 'ha' => (float) $data['totalSangatKritis'], 'color' => '#f2602a'],
        ['label' => 'Kritis',        'ha' => (float) $data['totalKritis'],       'color' => '#fbab2e'],
        ['label' => 'Agak Kritis',   'ha' => (float) $agakKritis,                'color' => '#8cc22b'],
        ['label' => 'Tidak Kritis',  'ha' => (float) $tidakKritis,               'color' => '#d9dee5'],
    ];

    return view('dashboard-viewer', [
        'totalKawasan'      => $data['totalKawasan'],
        'totalLuasKawasan'  => $data['totalLuasKawasan'],
        'kecKawasanHutan'   => $data['jumlahKecamatanKawasan'],
        'kecLahanKritis'    => $data['jumlahKecamatanLahanKritis'],
        'lahanPerKecamatan' => $lahanPerKecamatan,
        'ringkasan'         => $ringkasan,
    ]);
}

    /**
     * =========================================================
     * DASHBOARD ADMIN
     * =========================================================
     */
    public function adminIndex()
    {
        $data = $this->getDashboardData();

        return view('admin.dashboard', $data);
    }


    /**
     * =========================================================
     * DATA DASHBOARD
     * =========================================================
     *
     * Data digunakan oleh Viewer dan Admin.
     */
    private function getDashboardData()
    {
        // =====================================================
        // KAWASAN HUTAN
        // =====================================================

        $totalKawasan = KawasanHutan::count();

        $totalLuasKawasan = KawasanHutan::sum('luas_ha');

        $jumlahKecamatanKawasan = KawasanHutan::whereNotNull('kecamatan')
            ->distinct()
            ->count('kecamatan');


        // =====================================================
        // LAHAN KRITIS
        // =====================================================

        $jumlahKecamatanLahanKritis = LahanKritis::whereNotNull('kecamatan')
            ->distinct()
            ->count('kecamatan');

        $totalLahanKritis = LahanKritis::sum('total_ha');

        $totalSangatKritis =
            LahanKritis::sum('dalam_sangat_kritis') +
            LahanKritis::sum('luar_sangat_kritis');

        $totalKritis =
            LahanKritis::sum('dalam_kritis') +
            LahanKritis::sum('luar_kritis');


        // =====================================================
        // GRAFIK LAHAN KRITIS
        // =====================================================

        $grafikLahan = LahanKritis::selectRaw(
            'kecamatan, SUM(total_ha) as total_luas'
        )
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $labelGrafik = $grafikLahan
            ->pluck('kecamatan')
            ->values();

        $dataGrafik = $grafikLahan
            ->pluck('total_luas')
            ->map(function ($nilai) {
                return (float) $nilai;
            })
            ->values();


        // =====================================================
        // RETURN DATA
        // =====================================================

        return compact(
            'totalKawasan',
            'totalLuasKawasan',
            'jumlahKecamatanKawasan',

            'jumlahKecamatanLahanKritis',
            'totalLahanKritis',
            'totalSangatKritis',
            'totalKritis',

            'labelGrafik',
            'dataGrafik'
        );
    }
}