<?php

namespace App\Console\Commands;

use App\Models\ModulDataEntri;
use App\Models\User;
use App\Models\Wilayah;
use App\Support\ModulData;
use App\Support\RingkasanBidang;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

/**
 * Impor data resmi BPS untuk 9 kecamatan Malang Selatan.
 *
 *   php artisan data:bps            impor / perbarui data dari database/data/bps-malang-selatan-2025.json
 *
 * Sumber: BPS Kabupaten Malang, "Kabupaten Malang Dalam Angka 2026" dan
 * "Kecamatan ... Dalam Angka 2026" (Tirtoyudo: edisi 2025). Cara ekstraksi dan
 * verifikasinya ada di database/data/bps/ (lihat README di folder tersebut).
 *
 * Aman dijalankan ulang: baris hasil impor BPS sebelumnya diperbarui, sedangkan
 * data yang diinput petugas pada wilayah & periode yang sama TIDAK ditimpa.
 */
class DataBps extends Command
{
    /** Awalan sumber_data untuk menandai baris hasil impor ini. */
    public const PENANDA = 'BPS Kabupaten Malang';

    protected $signature = 'data:bps {--file=database/data/bps-malang-selatan-2025.json} {--force : Jalankan tanpa konfirmasi}';

    protected $description = 'Impor data resmi BPS (Kabupaten/Kecamatan Dalam Angka) untuk modul data bidang';

    private array $hasil = ['baru' => 0, 'diperbarui' => 0, 'dilewati' => 0];

    /** Rincian desa yang sudah ada: "wilayah|kode" => baris. */
    private array $desaLama = [];

    public function handle(): int
    {
        $data = json_decode((string) @file_get_contents(base_path($this->option('file'))), true);
        if (! is_array($data) || empty($data['kecamatan'])) {
            $this->error('File data tidak ditemukan atau tidak valid.');

            return self::FAILURE;
        }

        $koneksi = config('database.default');
        if (! $this->option('force') && ! $this->confirm("Impor data BPS ke database $koneksi?", true)) {
            return self::FAILURE;
        }

        $wilayah = Wilayah::pluck('id', 'nama');
        $admin = User::where('role', 'admin')->value('id');
        $tahun = (int) $data['tahun'];

        foreach ($data['kecamatan'] as $kec => $modul) {
            $wid = $wilayah[$kec] ?? null;
            if (! $wid) {
                $this->warn("Wilayah \"$kec\" tidak ada di tabel wilayah, dilewati.");

                continue;
            }
            foreach ($modul as $kunci => $nilai) {
                $this->simpanRekap($kunci, $nilai, $wid, $tahun, $data, $kec, $admin);
            }
        }

        $this->desaLama = ModulDataEntri::where('modul', 'daftar-desa')->get()
            ->keyBy(fn ($e) => (int) $e->kecamatan.'|'.$e->kode)->all();
        foreach ($data['desa'] ?? [] as $kec => $daftar) {
            if ($wid = $wilayah[$kec] ?? null) {
                foreach ($daftar as $desa) {
                    $this->simpanDesa($desa, $wid, $kec, $data, $admin);
                }
            }
        }

        Cache::forget(RingkasanBidang::CACHE_KEY);
        $this->info("Data BPS: {$this->hasil['baru']} baris baru, {$this->hasil['diperbarui']} diperbarui, {$this->hasil['dilewati']} dilewati (sudah ada data petugas).");

        return self::SUCCESS;
    }

    private function simpanRekap(string $kunci, array $nilai, int $wid, int $tahun, array $data, string $kec, ?int $admin): void
    {
        $def = ModulData::def($kunci);
        $kolom = ModulData::kolomPeriode($def);
        $periode = 1; // Tahunan; untuk modul semester = Semester I (data pertengahan tahun BPS)

        // Hanya field yang dikenal modul; total dihitung ulang dari komponennya
        $isi = array_intersect_key($nilai, $def['fields']);
        foreach ($isi as $k => $v) {
            if ($v !== null && ! ModulData::desimal($def, $k)) {
                $isi[$k] = (int) round($v);
            }
        }
        $isi = ModulData::hitungTotal($def, $isi);
        foreach (array_intersect_key($nilai, $def['total']) as $k => $v) {
            // Total resmi tersedia walau rinciannya tidak (mis. penduduk Tirtoyudo 2025)
            if ($isi[$k] === null && $v !== null) {
                $isi[$k] = ModulData::desimal($def, $k) ? $v : (int) round($v);
            }
        }

        $sumber = $this->sumber($data, $kunci, $kec);
        $atribut = ['sumber_data' => $sumber, 'keterangan' => 'Data resmi BPS, diimpor dari '.$data['url_kabupaten']];

        $lama = ModulData::query($def)->where('wilayah_id', $wid)->where('tahun', $tahun)->where($kolom, $periode)->first();
        if ($lama && ! $this->dariBps($lama->sumber_data)) {
            $this->hasil['dilewati']++;

            return;
        }

        $baris = $lama ?? new ($def['model']);
        if ($def['penyimpanan'] === 'json') {
            $baris->fill(['modul' => $def['kunci'], 'nilai' => $isi]);
        } else {
            $baris->fill($isi);
        }
        $baris->fill($atribut + ['wilayah_id' => $wid, 'tahun' => $tahun, $kolom => $periode]);
        $baris->created_by ??= $admin;
        $baris->save();
        $this->hasil[$lama ? 'diperbarui' : 'baru']++;
    }

    private function simpanDesa(array $d, int $wid, string $kec, array $data, ?int $admin): void
    {
        $edisi = $data['publikasi_kecamatan'][$kec] ?? null;
        $nilai = [
            'nama' => $d['nama'],
            'kode' => $d['kode'],
            'kecamatan' => $wid,
            'jenis_pemerintahan' => $d['jenis'],
            'luas_wilayah' => $d['luas'],
            'jumlah_dusun' => $d['dusun'] === null ? null : (int) $d['dusun'],
            'jumlah_rw' => $d['rw'] === null ? null : (int) $d['rw'],
            'jumlah_rt' => $d['rt'] === null ? null : (int) $d['rt'],
            'penduduk_laki' => $d['laki'] === null ? null : (int) $d['laki'],
            'penduduk_perempuan' => $d['perempuan'] === null ? null : (int) $d['perempuan'],
            'jumlah_penduduk' => $d['jumlah'] === null ? null : (int) $d['jumlah'],
            'tahun_data' => $edisi ? $edisi - 1 : null,
        ];

        // Desa yang sama (kecamatan + kode BPS) diperbarui, tidak digandakan
        $lama = $this->desaLama[$wid.'|'.$d['kode']] ?? null;
        if ($lama && ! $this->dariBps($lama->sumber_data)) {
            $this->hasil['dilewati']++;

            return;
        }

        $baris = $lama ?? new ModulDataEntri;
        $baris->fill([
            'modul' => 'daftar-desa',
            'nilai' => $nilai,
            'sumber_data' => self::PENANDA.', Kecamatan '.$kec.' Dalam Angka '.$edisi.' (Tabel 1.1, 2.1.1, 3.1)',
            'keterangan' => 'Data resmi BPS (luas: Kemendagri; RW/RT: DPMD Kab. Malang).',
        ]);
        $baris->created_by ??= $admin;
        $baris->save();
        $this->hasil[$lama ? 'diperbarui' : 'baru']++;
    }

    private function sumber(array $data, string $kunci, string $kec): string
    {
        $tabel = collect($data['sumber_tabel'][$kunci] ?? [])
            ->map(fn ($t) => str_starts_with($t, 'Kecamatan ') && ! str_contains($t, $kec) ? null : $t)
            ->filter()->map(fn ($t) => str_replace('Kecamatan '.$kec.' Dalam Angka', 'Kec. '.$kec.' Dalam Angka', $t))
            ->implode('; ');

        return mb_substr(self::PENANDA.', Kab. Malang Dalam Angka 2026 ('.$tabel.')', 0, 255);
    }

    private function dariBps(?string $sumber): bool
    {
        // Hanya baris impor BPS sebelumnya atau data contoh yang boleh diperbarui
        return $sumber !== null && (str_starts_with($sumber, self::PENANDA) || $sumber === DataDummy::PENANDA);
    }
}
