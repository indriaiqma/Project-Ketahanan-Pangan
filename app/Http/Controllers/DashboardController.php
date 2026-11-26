<?php

namespace App\Http\Controllers;

use App\Models\PermintaanResetPassword;
use App\Models\User;
use App\Support\Bidang;
use App\Support\RingkasanBidang;
use App\Support\RingkasanModul;

class DashboardController extends Controller
{
    /**
     * Kunci cache lama ringkasan kehutanan. Masih dihapus oleh model KawasanHutan
     * & LahanKritis; ringkasan dashboard kini memakai RingkasanBidang::CACHE_KEY.
     */
    public const CACHE_KEY = 'dashboard.data';

    /**
     * =========================================================
     * BERANDA PUBLIK (landing page)
     * =========================================================
     */
    public function index()
    {
        // Landing page publik: hasil input Admin & Petugas di seluruh bidang,
        // terbuka untuk semua pengunjung tanpa login
        return view('beranda', RingkasanBidang::landing());
    }

    /**
     * =========================================================
     * DASHBOARD PANEL PENGELOLA
     * =========================================================
     * Ringkasan seluruh bidang & modul yang boleh dilihat pengguna:
     * Admin melihat semua, Petugas hanya sub bidang tugasnya.
     */
    public function adminIndex()
    {
        $user = auth()->user();
        $dibatasi = Bidang::dibatasi($user);
        $ringkasan = RingkasanBidang::landing($user);

        // Tautan sorotan & pembaruan mengarah ke halaman modul di panel
        $keAdmin = fn ($s) => ['href' => route('admin.bidang.modul', ['bidang' => $s['bidang'], 'modul' => $s['modul']])] + $s;
        $ringkasan['sorotan'] = $ringkasan['sorotan']->map($keAdmin);
        $ringkasan['pembaruan'] = $ringkasan['pembaruan']->map($keAdmin);

        // Semua bidang (termasuk menu khusus) untuk kartu kelengkapan data
        $semua = $ringkasan['bidang']->concat($ringkasan['khusus']);

        // Modul aktif yang belum berisi data -> perlu tindakan
        $modulKosong = $semua->flatMap(fn ($r) => $r['modul'])
            ->filter(fn ($m) => $m['aktif'] && ! $m['statistik']['jumlah'])
            ->values();

        return view('admin.dashboard', $ringkasan + [
            'semua' => $semua,
            'modulKosong' => $modulKosong,
            'dibatasi' => $dibatasi,
            'tugas' => $dibatasi ? $this->modulTugas($user) : [],
            'menungguPendaftaran' => $user->isAdmin() ? User::menungguPersetujuan()->count() : 0,
            'menungguReset' => $user->isAdmin() ? PermintaanResetPassword::menunggu()->count() : 0,
        ]);
    }

    /**
     * Modul yang ditugaskan ke petugas, dikelompokkan per sub bidang,
     * lengkap dengan ringkasan angka dan tautan input data.
     */
    private function modulTugas($user): array
    {
        return Bidang::untuk($user)->flatMap(fn ($b) => collect(Bidang::kelompok($b))->map(fn ($k) => [
            'bidang' => $b,
            'sub' => $k['sub'],
            'modul' => collect($k['modul'])->map(fn ($m) => $m + [
                'ringkasan' => RingkasanModul::untuk($m),
                'input' => match (true) {
                    ! empty($m['route']) => route(str_replace('.index', '.create', $m['route'])),
                    $m['aktif'] && ! empty($m['data']) => route('admin.modul.create', ['bidang' => $m['bidang'], 'modul' => $m['slug']]),
                    default => null,
                },
            ])->all(),
        ]))->values()->all();
    }
}
