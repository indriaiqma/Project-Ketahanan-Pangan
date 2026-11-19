<?php

namespace App\Support;

use App\Models\KawasanHutan;
use App\Models\LahanKritis;
use Illuminate\Support\Carbon;

/**
 * Ringkasan angka singkat per modul untuk halaman ringkasan bidang,
 * mis. "2 data · 67.754 ha", beserta waktu data terakhir diinput.
 */
class RingkasanModul
{
    /** @return array{teks: string, terakhir: ?Carbon} */
    public static function untuk(array $modul): array
    {
        if (! $modul['aktif']) {
            return ['teks' => 'Modul sedang disiapkan', 'terakhir' => null];
        }

        return match (true) {
            $modul['slug'] === 'kawasan-hutan' => self::kawasanHutan(),
            $modul['slug'] === 'lahan-kritis' => self::lahanKritis(),
            ! empty($modul['data']) => self::modulData($modul['data']),
            default => ['teks' => 'Modul aktif', 'terakhir' => null],
        };
    }

    private static function kawasanHutan(): array
    {
        $r = KawasanHutan::selectRaw('COUNT(*) as jumlah, COALESCE(SUM(luas_ha), 0) as luas, MAX(updated_at) as terakhir')->first();

        return self::hasil($r->jumlah, angka($r->jumlah, 0).' data · '.angka($r->luas, 0).' ha', $r->terakhir);
    }

    private static function lahanKritis(): array
    {
        $r = LahanKritis::selectRaw('COUNT(*) as jumlah, COALESCE(SUM(total_ha), 0) as luas, MAX(updated_at) as terakhir')->first();

        return self::hasil($r->jumlah, angka($r->jumlah, 0).' kecamatan · '.angka($r->luas, 0).' ha', $r->terakhir);
    }

    /** Modul data generik: ringkasan periode terakhir yang sudah ada datanya. */
    private static function modulData(string $kunci): array
    {
        $def = ModulData::def($kunci);
        $model = $def['model'];
        $kolom = ModulData::kolomPeriode($def);

        $terakhir = $model::query()->orderByDesc('tahun')->orderByDesc($kolom)->first(['tahun', $kolom]);
        if (! $terakhir) {
            return ['teks' => 'Belum ada data', 'terakhir' => null];
        }

        $utama = $def['ringkasan'];
        $r = $model::query()
            ->where('tahun', $terakhir->tahun)->where($kolom, $terakhir->{$kolom})
            ->selectRaw('COUNT(*) as jumlah'.($utama ? ", COALESCE(SUM($utama), 0) as utama" : ''))
            ->first();

        $teks = ModulData::labelPeriode($def, $terakhir->tahun, $terakhir->{$kolom})
            .' · '.angka($r->jumlah, 0).' wilayah';
        if ($utama) {
            $info = ModulData::info($def, $utama);
            $teks .= ' · '.angka($r->utama, 0).' '.$info['satuan'];
        }

        return self::hasil(1, $teks, $model::max('updated_at'));
    }

    private static function hasil(int $jumlah, string $teks, $terakhir): array
    {
        return [
            'teks' => $jumlah > 0 ? $teks : 'Belum ada data',
            'terakhir' => $terakhir ? Carbon::parse($terakhir) : null,
        ];
    }
}
