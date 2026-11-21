<?php

namespace App\Console\Commands;

use App\Models\ModulDataEntri;
use App\Models\User;
use App\Models\Wilayah;
use App\Support\Bidang;
use App\Support\ModulData;
use App\Support\RingkasanBidang;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Data contoh (dummy) untuk semua modul data, agar tampilan bisa dicoba.
 *
 *   php artisan data:dummy          isi data contoh (data contoh lama diganti)
 *   php artisan data:dummy --hapus  hapus semua data contoh
 *
 * Semua baris contoh ditandai sumber_data = "Data contoh (dummy)", sehingga
 * mudah dihapus dan TIDAK pernah menimpa data asli (slot wilayah x periode
 * yang sudah berisi data asli dilewati).
 */
class DataDummy extends Command
{
    public const PENANDA = 'Data contoh (dummy)';

    protected $signature = 'data:dummy {--hapus : Hapus semua data contoh} {--force : Jalankan tanpa konfirmasi}';

    protected $description = 'Isi atau hapus data contoh (dummy) untuk seluruh modul data bidang';

    public function handle(): int
    {
        $koneksi = config('database.default');
        $db = config("database.connections.$koneksi.database");
        if (! $this->option('force') && ! $this->confirm("Database: $koneksi/$db. Lanjutkan?", true)) {
            return self::FAILURE;
        }

        $terhapus = $this->hapus();
        $this->info("Data contoh lama dihapus: $terhapus baris.");

        if (! $this->option('hapus')) {
            mt_srand(2026);
            $jumlah = $this->isi();
            $this->info("Data contoh ditambahkan: $jumlah baris.");
        }

        Cache::forget(RingkasanBidang::CACHE_KEY);

        return self::SUCCESS;
    }

    private function hapus(): int
    {
        $n = 0;
        foreach ($this->modulData() as $def) {
            $n += ModulData::query($def)->where('sumber_data', self::PENANDA)->delete();
        }

        return $n;
    }

    /** Definisi semua modul data yang aktif di config/bidang.php (tanpa duplikat model). */
    private function modulData(): array
    {
        return Bidang::semuaModul()
            ->filter(fn ($m) => $m['aktif'] && ! empty($m['data']))
            ->mapWithKeys(fn ($m) => [$m['data'] => ModulData::def($m['data'])])
            ->all();
    }

    private function isi(): int
    {
        $wilayah = Wilayah::urut()->get();
        $admin = User::where('role', 'admin')->value('id');
        $n = 0;

        foreach ($this->modulData() as $def) {
            $n += ModulData::isDaftar($def)
                ? $this->isiDaftar($def, $wilayah, $admin)
                : $this->isiRekap($def, $wilayah, $admin);
        }

        return $n;
    }

    /* ------------------------------------------------------------------ */

    private function isiRekap(array $def, $wilayah, ?int $admin): int
    {
        $kolom = ModulData::kolomPeriode($def);
        $periodeList = match ($def['periode']) {
            'bulan' => [[2026, 7], [2026, 8], [2026, 9], [2026, 10]],
            'tahun' => [[2024, 1], [2025, 1], [2026, 1]],
            default => [[2025, 1], [2025, 2], [2026, 1]],
        };

        // Slot yang sudah berisi data asli tidak disentuh
        $terisi = ModulData::query($def)->get(['wilayah_id', 'tahun', $kolom])
            ->map(fn ($r) => "{$r->wilayah_id}-{$r->tahun}-{$r->{$kolom}}")->flip();

        // Nilai dasar per wilayah agar antar periode tetap konsisten (tumbuh sedikit)
        $dasar = [];
        foreach ($wilayah as $w) {
            $dasar[$w->id] = $this->nilaiRekap($def);
        }

        $semuaBaris = [];
        foreach ($periodeList as $i => [$tahun, $periode]) {
            $terakhir = $i === count($periodeList) - 1;
            foreach ($wilayah as $j => $w) {
                // Periode terakhir: satu-dua kecamatan belum melapor (lebih realistis)
                if ($terakhir && $j % 4 === 3) {
                    continue;
                }
                if (isset($terisi["{$w->id}-$tahun-$periode"])) {
                    continue;
                }

                $faktor = 1 + $i * mt_rand(1, 4) / 100;
                $nilai = [];
                foreach ($dasar[$w->id] as $k => $v) {
                    $nilai[$k] = $this->bulatkan($def, $k, $v * $faktor);
                }
                $nilai = $this->batasiMaks($def, ModulData::hitungTotal($def, $nilai));
                $nilai = ModulData::hitungTotal($def, $nilai);

                $baris = [
                    'wilayah_id' => $w->id,
                    'tahun' => $tahun,
                    $kolom => $periode,
                    'sumber_data' => self::PENANDA,
                    'created_by' => $admin,
                    'created_at' => now()->subDays(mt_rand(0, 40))->subMinutes(mt_rand(0, 900)),
                ];
                $baris['updated_at'] = $baris['created_at'];

                $semuaBaris[] = $def['penyimpanan'] === 'json'
                    ? $baris + ['modul' => $def['kunci'], 'nilai' => json_encode($nilai)]
                    : $baris + $nilai;
            }
        }

        return $this->simpan($def['model'], $semuaBaris);
    }

    /** Insert massal (per 200 baris) agar cepat walau database berada jauh. */
    private function simpan(string $model, array $baris): int
    {
        // Semua baris satu model harus punya kolom yang sama untuk insert massal
        $kolom = collect($baris)->flatMap(fn ($b) => array_keys($b))->unique()->all();
        $baris = array_map(fn ($b) => array_merge(array_fill_keys($kolom, null), $b), $baris);

        foreach (array_chunk($baris, 200) as $potongan) {
            $model::insert($potongan);
        }
        $this->line('  '.class_basename($model).': '.count($baris).' baris');

        return count($baris);
    }

    /** Nilai acak wajar per field berdasarkan satuan & hubungan antar field. */
    private function nilaiRekap(array $def): array
    {
        $nilai = [];
        foreach ($def['fields'] as $k => $f) {
            if (empty($f['maks'])) {
                $nilai[$k] = $this->acak($k, $f);
            }
        }

        // Total (mis. total_kasus) dihitung dulu karena bisa menjadi batas field lain
        $nilai = ModulData::hitungTotal($def, $nilai);

        // Field "bagian" per batas. Beberapa bagian dengan batas sama (mis. desa
        // mandiri/maju/berkembang dari jumlah desa) dibagi agar jumlahnya tidak melebihi batas.
        $grup = collect($def['fields'])->filter(fn ($f) => ! empty($f['maks']))->groupBy('maks', true);
        foreach ($grup as $maks => $anggota) {
            $batas = $nilai[$maks] ?? 100;
            if ($anggota->count() === 1) {
                $k = $anggota->keys()->first();
                $nilai[$k] = $batas * $this->rasio($def, $k);

                continue;
            }
            $bobot = $anggota->map(fn () => mt_rand(10, 100));
            $bagian = mt_rand(70, 98) / 100;
            foreach ($bobot as $k => $b) {
                $nilai[$k] = $batas * $bagian * $b / $bobot->sum();
            }
        }

        // Persentase bertarget (≤ 100%): pembilang diturunkan dari penyebut
        foreach ($def['persentase'] as $p) {
            $batas = $p['target'] ?? $p['target_maks'] ?? null;
            if ($batas !== null && $batas <= 100 && isset($nilai[$p['penyebut']], $def['fields'][$p['pembilang']])
                && empty($def['fields'][$p['pembilang']]['maks'])) {
                $nilai[$p['pembilang']] = $nilai[$p['penyebut']] * $this->rasio($def, $p['pembilang']);
            }
        }

        // Hanya field input (total dihitung ulang saat disimpan), urut sesuai definisi
        return array_replace($def['fields'], array_intersect_key($nilai, $def['fields']));
    }

    /** Rasio bagian/total: mengikuti target persentase agar status bervariasi. */
    private function rasio(array $def, string $k): float
    {
        foreach ($def['persentase'] as $p) {
            if ($p['pembilang'] !== $k) {
                continue;
            }
            if (isset($p['target'])) {
                return mt_rand(max(50, $p['target'] - 15), 100) / 100 * 0.995;
            }
            if (isset($p['target_maks'])) {
                return mt_rand((int) max(1, $p['target_maks'] * 0.5), (int) ($p['target_maks'] * 1.4)) / 100;
            }
        }

        return mt_rand(55, 95) / 100;
    }

    private function acak(string $k, array $f): float
    {
        // Beberapa nama field punya rentang khusus agar lebih realistis
        $khusus = match (true) {
            str_contains($k, 'kematian') => [0, 6],
            str_contains($k, 'posyandu') => [35, 120],
            (bool) preg_match('/puskesmas|rumah_sakit|pasar|menara|destinasi|klub|sanggar|kampung|trayek|pos_|terminal/', $k) => [1, 14],
            default => null,
        };
        if ($khusus) {
            [$min, $maks] = $khusus;

            return mt_rand($min * 100, $maks * 100) / 100;
        }

        [$min, $maks] = match ($f['satuan'] ?? '') {
            'jiwa' => [18000, 62000],
            'KK' => [6000, 19000],
            'desa' => str_starts_with($k, 'jumlah') ? [10, 18] : [0, 8],
            'orang', 'siswa' => [150, 4500],
            'ton' => [400, 24000],
            'ha' => [150, 5200],
            'juta Rp' => [800, 48000],
            'ekor' => [600, 28000],
            'km' => [8, 140],
            'kasus', 'kejadian' => [0, 28],
            'balita', 'pasangan' => [900, 4800],
            'kunjungan', 'eksemplar' => [600, 16000],
            'unit' => [6, 380],
            '%' => [55, 98],
            'RT' => [60, 420],
            'anak' => [40, 700],
            default => [2, 60],
        };

        return mt_rand($min * 100, $maks * 100) / 100;
    }

    private function bulatkan(array $def, string $k, float $v): float|int
    {
        return ModulData::desimal($def, $k) ? round($v, 2) : (int) round($v);
    }

    /** Pastikan field "bagian" tidak melebihi field batasnya setelah dibulatkan. */
    private function batasiMaks(array $def, array $nilai): array
    {
        foreach ($def['fields'] as $k => $f) {
            if (! empty($f['maks']) && isset($nilai[$f['maks']])) {
                $nilai[$k] = min($nilai[$k], $nilai[$f['maks']]);
            }
        }

        return $nilai;
    }

    /* ------------------------------------------------------------------ */

    private function isiDaftar(array $def, $wilayah, ?int $admin): int
    {
        $semuaBaris = [];
        $jumlah = mt_rand(6, 10);
        for ($i = 1; $i <= $jumlah; $i++) {
            $nilai = [];
            foreach ($def['fields'] as $k => $f) {
                $nilai[$k] = $this->nilaiDaftar($def, $k, $f, $i, $wilayah, $nilai);
            }

            $waktu = now()->subDays(mt_rand(0, 60))->subMinutes(mt_rand(0, 900));
            $semuaBaris[] = [
                'modul' => $def['kunci'],
                'nilai' => json_encode($nilai),
                'sumber_data' => self::PENANDA,
                'created_by' => $admin,
                'created_at' => $waktu,
                'updated_at' => $waktu,
            ];
        }

        return $this->simpan(ModulDataEntri::class, $semuaBaris);
    }

    private function nilaiDaftar(array $def, string $k, array $f, int $i, $wilayah, array $sebelumnya): mixed
    {
        $tipe = $f['tipe'] ?? 'teks';

        return match ($tipe) {
            'pilihan' => $f['opsi'][array_rand($f['opsi'])],
            'wilayah' => $wilayah->random()->id,
            'tahun' => mt_rand(2023, 2026),
            'tanggal' => ! empty($f['setelah']) && ! empty($sebelumnya[$f['setelah']])
                ? date('Y-m-d', strtotime($sebelumnya[$f['setelah']].' +'.mt_rand(6, 36).' months'))
                : date('Y-m-d', mktime(0, 0, 0, mt_rand(1, 12), mt_rand(1, 28), mt_rand(2024, 2026))),
            'persen' => mt_rand(1500, 10000) / 100,
            'desimal' => round($this->acak($k, $f), 2),
            'angka' => (int) round($this->acak($k, $f)),
            'teks_panjang' => 'Contoh uraian '.mb_strtolower($f['label']).' untuk keperluan uji tampilan.',
            default => $this->teksContoh($f, $i, $wilayah),
        };
    }

    private function teksContoh(array $f, int $i, $wilayah): string
    {
        $kec = $wilayah[($i - 1) % $wilayah->count()]->nama;
        $label = $f['label'];

        return match (true) {
            str_contains(mb_strtolower($label), 'nomor') => sprintf('%03d/BKW-III/%d', mt_rand(1, 400), mt_rand(2024, 2026)),
            str_contains(mb_strtolower($label), 'mitra') => ['Pemkab Blitar', 'Pemkab Lumajang', 'PT Jasa Tirta I', 'Universitas Brawijaya', 'Perhutani KPH Malang'][mt_rand(0, 4)],
            str_contains(mb_strtolower($label), 'dasar') => 'Perbup Malang No. '.mt_rand(10, 90).' Tahun '.mt_rand(2019, 2025),
            default => "$label $kec ".($i),
        };
    }
}
