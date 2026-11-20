<?php

namespace App\Support;

use App\Models\KawasanHutan;
use App\Models\LahanKritis;
use App\Models\ModulDataEntri;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Ringkasan jumlah data per bidang untuk halaman publik (landing page & Data Bidang).
 * Semua angka diambil dengan sedikit query rekap (database berada jauh).
 */
class RingkasanBidang
{
    /**
     * Jumlah data & waktu input terakhir per modul.
     *
     * @return array<string, array{jumlah: int, terakhir: ?Carbon}> kunci = slug modul
     */
    public static function statistikModul(): array
    {
        $hasil = [];

        // Modul data bersama (tabel modul_data): 1 query untuk semua modul
        $perKunci = ModulDataEntri::query()
            ->selectRaw('modul, COUNT(*) as jumlah, MAX(updated_at) as terakhir')
            ->groupBy('modul')
            ->get()
            ->keyBy('modul');

        foreach (Bidang::semuaModul() as $m) {
            if (! empty($m['route'])) {
                continue;
            }
            if (empty($m['data'])) {
                $hasil[$m['slug']] = self::isi(0, null);

                continue;
            }

            $def = ModulData::def($m['data']);
            if ($def['penyimpanan'] === 'json') {
                $r = $perKunci->get($def['kunci']);
                $hasil[$m['slug']] = self::isi($r->jumlah ?? 0, $r->terakhir ?? null);
            } else {
                $r = ModulData::query($def)->selectRaw('COUNT(*) as jumlah, MAX(updated_at) as terakhir')->first();
                $hasil[$m['slug']] = self::isi($r->jumlah ?? 0, $r->terakhir ?? null);
            }
        }

        // Modul kehutanan (tabel sendiri)
        $k = KawasanHutan::selectRaw('COUNT(*) as jumlah, MAX(updated_at) as terakhir')->first();
        $l = LahanKritis::selectRaw('COUNT(*) as jumlah, MAX(updated_at) as terakhir')->first();
        $hasil['kawasan-hutan'] = self::isi($k->jumlah ?? 0, $k->terakhir ?? null);
        $hasil['lahan-kritis'] = self::isi($l->jumlah ?? 0, $l->terakhir ?? null);

        return $hasil;
    }

    /**
     * Ringkasan setiap bidang yang boleh dilihat user (atau semua bidang untuk tamu).
     *
     * @return Collection<int, array>
     */
    public static function semua(?User $user, ?array $statistik = null): Collection
    {
        $statistik ??= self::statistikModul();
        $daftar = $user ? Bidang::untuk($user) : Bidang::semua();

        return $daftar->map(function ($b) use ($statistik) {
            $modul = Bidang::modulBidang($b)->map(fn ($m) => $m + [
                'statistik' => $statistik[$m['slug']] ?? self::isi(0, null),
                'href_publik' => self::href($m),
            ]);

            return [
                'bidang' => $b,
                'modul' => $modul,
                'jumlah_modul' => $modul->count(),
                'modul_terisi' => $modul->filter(fn ($m) => $m['statistik']['jumlah'] > 0)->count(),
                'jumlah_data' => $modul->sum('statistik.jumlah'),
                'terakhir' => $modul->pluck('statistik.terakhir')->filter()->max(),
            ];
        })->values();
    }

    /** Tautan halaman publik sebuah modul. */
    public static function href(array $m): string
    {
        return ! empty($m['route'])
            ? route(str_replace('admin.', '', $m['route']))
            : route('data.modul', ['bidang' => $m['bidang'], 'modul' => $m['slug']]);
    }

    private static function isi($jumlah, $terakhir): array
    {
        return ['jumlah' => (int) $jumlah, 'terakhir' => $terakhir ? Carbon::parse($terakhir) : null];
    }
}
