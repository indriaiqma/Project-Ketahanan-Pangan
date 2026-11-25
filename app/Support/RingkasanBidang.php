<?php

namespace App\Support;

use App\Models\KawasanHutan;
use App\Models\LahanKritis;
use App\Models\ModulDataEntri;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Ringkasan hasil input seluruh bidang untuk situs publik (landing page & Data Bidang).
 *
 * Data mentah dihitung sekali lalu disimpan di cache (CACHE_KEY) karena database
 * berada jauh. Cache dihapus otomatis saat data modul berubah (lihat
 * Concerns\ModulData, KawasanHutan, LahanKritis). Penyaringan per user
 * (petugas hanya sub bidang tugasnya) dilakukan setelah cache.
 */
class RingkasanBidang
{
    public const CACHE_KEY = 'publik.ringkasan';

    /* ==================================================================
     | Data mentah (di-cache)
     * ================================================================== */

    /**
     * @return array{statistik: array, sorotan: array, pembaruan: array, wilayah: array}
     */
    public static function mentah(): array
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(5), fn () => self::hitung());
    }

    private static function hitung(): array
    {
        $wilayah = Wilayah::urut()->get();
        $namaWilayah = $wilayah->pluck('nama', 'id');

        // Semua baris modul data (tabel bersama) diambil sekali lalu dikelompokkan di PHP
        $semuaJson = ModulDataEntri::query()
            ->get(['id', 'modul', 'wilayah_id', 'tahun', 'periode', 'nilai', 'updated_at'])
            ->groupBy('modul');

        $statistik = [];
        $sorotan = [];
        $pembaruan = collect();
        $perWilayah = [];

        foreach (Bidang::semuaModul() as $m) {
            if (! empty($m['route'])) {
                continue;
            }
            if (! $m['aktif'] || empty($m['data'])) {
                $statistik[$m['slug']] = self::isi(0, null);

                continue;
            }

            $def = ModulData::def($m['data']);
            $baris = $def['penyimpanan'] === 'json'
                ? ($semuaJson->get($def['kunci']) ?? collect())
                : ModulData::query($def)->get();

            $statistik[$m['slug']] = self::isi($baris->count(), $baris->max('updated_at'));
            if ($baris->isEmpty()) {
                continue;
            }

            if (empty($m['induk']) && $s = self::sorotanModul($m, $def, $baris)) {
                $sorotan[] = $s;
            }

            // Pembaruan terbaru (3 per modul, nanti diurutkan & dipotong)
            $kolom = ModulData::isDaftar($def) ? null : ModulData::kolomPeriode($def);
            foreach ($baris->sortByDesc('updated_at')->take(3) as $r) {
                $pembaruan->push([
                    'modul' => $m['slug'],
                    'bidang' => $m['bidang'],
                    'nama' => $m['nama'],
                    'icon' => $m['icon'] ?? 'grid',
                    'bidang_nama' => $m['bidang_nama'],
                    'keterangan' => $kolom
                        ? ($namaWilayah[$r->wilayah_id] ?? 'Wilayah').' · '.ModulData::labelPeriode($def, (int) $r->tahun, (int) $r->{$kolom})
                        : 'Entri baru: '.str((string) $r->{array_key_first($def['fields'])})->limit(48),
                    'waktu' => Carbon::parse($r->updated_at),
                ]);
            }

            // Jumlah data per kecamatan (modul rekap)
            if ($kolom) {
                foreach ($baris->countBy('wilayah_id') as $id => $jml) {
                    $perWilayah[$id] = ($perWilayah[$id] ?? 0) + $jml;
                }
            }
        }

        // Modul kehutanan (tabel sendiri)
        $k = KawasanHutan::selectRaw('COUNT(*) as jumlah, MAX(updated_at) as terakhir')->first();
        $l = LahanKritis::selectRaw('COUNT(*) as jumlah, MAX(updated_at) as terakhir')->first();
        $statistik['kawasan-hutan'] = self::isi($k->jumlah ?? 0, $k->terakhir ?? null);
        $statistik['lahan-kritis'] = self::isi($l->jumlah ?? 0, $l->terakhir ?? null);

        return [
            'statistik' => $statistik,
            'sorotan' => collect($sorotan)->sortByDesc('waktu')->values()->all(),
            'pembaruan' => $pembaruan->sortByDesc('waktu')->take(30)->values()->all(),
            'wilayah' => $wilayah->map(fn ($w) => ['nama' => $w->nama, 'jumlah' => $perWilayah[$w->id] ?? 0])->all(),
        ];
    }

    /** Satu indikator utama modul pada periode terakhir yang ada datanya. */
    private static function sorotanModul(array $m, array $def, Collection $baris): ?array
    {
        $dasar = [
            'modul' => $m['slug'],
            'bidang' => $m['bidang'],
            'nama' => $m['nama'],
            'icon' => $m['icon'] ?? 'grid',
            'sub_nama' => $m['sub_nama'] ?? $m['bidang_nama'],
            'waktu' => Carbon::parse($baris->max('updated_at')),
        ];

        if (ModulData::isDaftar($def)) {
            // Metrik kedua biasanya paling informatif (mis. "Aktif"), metrik pertama = total
            $metrik = $def['metrik'][1] ?? $def['metrik'][0] ?? ['label' => 'Total Data', 'satuan' => 'data'];
            $nilai = ModulData::metrikDaftar($metrik, $baris);

            return $dasar + [
                'label' => $metrik['label'],
                'nilai' => angka($nilai ?? 0, fmod((float) $nilai, 1) ? 1 : 0),
                'satuan' => $metrik['satuan'] ?? '',
                'periode' => 'dari '.angka($baris->count(), 0).' data',
                'status' => null,
            ];
        }

        $kolom = ModulData::kolomPeriode($def);
        $terakhir = $baris->sortByDesc(fn ($r) => $r->tahun * 100 + $r->{$kolom})->first();
        $periode = $baris->where('tahun', $terakhir->tahun)->where($kolom, $terakhir->{$kolom});

        $jumlah = [];
        foreach (array_merge(array_keys($def['fields']), array_keys($def['total'])) as $k) {
            $jumlah[$k] = $periode->sum(fn ($r) => (float) $r->{$k});
        }

        // Utamakan persentase bertarget, lalu field ringkasan, lalu metrik pertama
        $kunci = collect($def['persentase'])->filter(fn ($p) => isset($p['target']) || isset($p['target_maks']))->keys()->first()
            ?? $def['ringkasan'] ?? $def['metrik'][0] ?? array_key_first($def['fields']);
        $info = ModulData::info($def, $kunci);
        $nilai = ModulData::nilai($def, $jumlah, $kunci);
        $p = $def['persentase'][$kunci] ?? null;

        return $dasar + [
            'label' => $info['label'],
            'nilai' => ModulData::format($def, $kunci, $nilai),
            'satuan' => $p ? '' : ($info['satuan'] ?? ''),
            'periode' => ModulData::labelPeriode($def, (int) $terakhir->tahun, (int) $terakhir->{$kolom}).' · '.$periode->count().' kecamatan',
            'status' => $p && (isset($p['target']) || isset($p['target_maks']))
                ? ['baik' => ModulData::capaiTarget($p, $nilai), 'target' => ModulData::labelTarget($p)]
                : null,
        ];
    }

    /* ==================================================================
     | Disaring per user
     * ================================================================== */

    /** Statistik per modul: [slug => ['jumlah' => int, 'terakhir' => ?Carbon]]. */
    public static function statistikModul(): array
    {
        return self::mentah()['statistik'];
    }

    /**
     * Ringkasan setiap bidang yang boleh dilihat user (tanpa user: semua bidang, untuk situs publik).
     *
     * @return Collection<int, array>
     */
    public static function semua(?User $user = null): Collection
    {
        $statistik = self::statistikModul();
        $daftar = $user ? Bidang::untuk($user) : Bidang::semua();

        return $daftar->map(function ($b) use ($statistik) {
            $modul = Bidang::modulBidang($b)->map(function ($m) use ($statistik) {
                // Statistik modul termasuk data rinciannya (mis. Daftar Sekolah)
                $st = $statistik[$m['slug']] ?? self::isi(0, null);
                if (! empty($m['rincian']) && ($r = $statistik[$m['rincian']['slug']] ?? null)) {
                    $st = [
                        'jumlah' => $st['jumlah'] + $r['jumlah'],
                        'terakhir' => collect([$st['terakhir'], $r['terakhir']])->filter()->max(),
                    ];
                }

                return $m + ['statistik' => $st, 'href_publik' => self::href($m)];
            });

            return [
                'bidang' => $b,
                'modul' => $modul,
                'jumlah_modul' => $modul->count(),
                'modul_terisi' => $modul->filter(fn ($m) => $m['statistik']['jumlah'] > 0)->count(),
                'jumlah_data' => $modul->sum('statistik.jumlah'),
                'khusus' => ! empty($b['khusus']),
                'terakhir' => $modul->pluck('statistik.terakhir')->filter()->max(),
            ];
        })->values();
    }

    /** Data landing page: bidang, sorotan indikator, pembaruan terbaru, cakupan wilayah. */
    public static function landing(?User $user = null): array
    {
        $mentah = self::mentah();
        $bidang = self::semua($user);

        // Hanya modul yang boleh dilihat user (petugas: sub bidang tugasnya)
        $boleh = $bidang->flatMap(fn ($r) => $r['modul']->flatMap(fn ($m) => array_filter([
            $m['bidang'].'/'.$m['slug'],
            ! empty($m['rincian']) ? $m['bidang'].'/'.$m['rincian']['slug'] : null,
        ])))->flip();
        $saring = fn ($daftar) => collect($daftar)
            ->filter(fn ($s) => isset($boleh[$s['bidang'].'/'.$s['modul']]))
            ->map(fn ($s) => $s + ['href' => route('data.modul', ['bidang' => $s['bidang'], 'modul' => $s['modul']])])
            ->values();

        return [
            'bidang' => $bidang->where('khusus', false)->values(),
            'khusus' => $bidang->where('khusus', true)->values(),
            'sorotan' => $saring($mentah['sorotan'])->take(8),
            'pembaruan' => $saring($mentah['pembaruan'])->take(6),
            'wilayah' => collect($mentah['wilayah']),
            'total' => [
                'bidang' => $bidang->where('khusus', false)->count(),
                'modul' => $bidang->sum('jumlah_modul'),
                'terisi' => $bidang->sum('modul_terisi'),
                'data' => $bidang->sum('jumlah_data'),
                'terakhir' => $bidang->pluck('terakhir')->filter()->max(),
            ],
        ];
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
