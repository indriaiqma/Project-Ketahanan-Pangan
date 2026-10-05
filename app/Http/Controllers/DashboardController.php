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

        return view('dashboard', $data);
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