<?php

namespace App\Support;

use App\Models\ModulDataEntri;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * Logika bersama modul data generik (definisi di config/modul_data.php).
 *
 * Dua jenis modul:
 *   - rekap  : 1 baris = 1 wilayah x 1 periode (tahun + semester/bulan/tahunan)
 *   - daftar : 1 baris = 1 entri bebas (mis. proyek, kerja sama, dokumen kajian)
 *
 * Dua cara penyimpanan:
 *   - tabel  : modul punya tabel & model sendiri (mis. Rekap Kependudukan)
 *   - json   : tabel bersama "modul_data", nilai field di kolom JSON (bawaan)
 */
class ModulData
{
    public const BULAN = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    public const STATUS = [
        'baik' => 'Baik',
        'bawah' => 'Di bawah target',
        'belum' => 'Belum lapor',
    ];

    /** Definisi modul, dilengkapi nilai bawaan. */
    public static function def(string $kunci): array
    {
        $def = config("modul_data.$kunci");
        abort_unless(is_array($def), 404);

        $def += [
            'kunci' => $kunci,
            'jenis' => 'rekap',
            'periode' => 'semester',
            'deskripsi' => null,
            'fields' => [],
            'total' => [],
            'persentase' => [],
            'metrik' => [],
            'tabel' => [],
            'grafik' => [],
            'ringkasan' => null,
            'filter' => null,
            'cari' => [],
            'nama' => null,
            'icon' => null,
            'induk' => null,
        ];

        $def['penyimpanan'] = empty($def['model']) ? 'json' : 'tabel';
        $def['model'] ??= ModulDataEntri::class;

        return $def;
    }

    public static function isDaftar(array $def): bool
    {
        return $def['jenis'] === 'daftar';
    }

    /** Query dasar data modul ini (tabel bersama otomatis difilter per modul). */
    public static function query(array $def): Builder
    {
        $query = $def['model']::query();

        return $def['penyimpanan'] === 'json' ? $query->where('modul', $def['kunci']) : $query;
    }

    /** Nama kolom periode di tabel & nama field periode di form. */
    public static function kolomPeriode(array $def): string
    {
        if ($def['penyimpanan'] === 'json') {
            return 'periode';
        }

        return $def['periode'] === 'bulan' ? 'bulan' : 'semester';
    }

    /** Pilihan periode dalam satu tahun: [nilai => label]. */
    public static function opsiPeriode(array $def): array
    {
        return match ($def['periode']) {
            'bulan' => self::BULAN,
            'tahun' => [1 => 'Tahunan'],
            default => [1 => 'Semester I (Jan–Jun)', 2 => 'Semester II (Jul–Des)'],
        };
    }

    public static function labelPeriode(array $def, int $tahun, int $periode): string
    {
        return match ($def['periode']) {
            'bulan' => (self::BULAN[$periode] ?? $periode)." $tahun",
            'tahun' => "Tahun $tahun",
            default => 'Semester '.($periode === 1 ? 'I' : 'II')." $tahun",
        };
    }

    /** Periode berjalan berdasarkan tanggal hari ini. */
    public static function periodeSekarang(array $def): array
    {
        $now = now();

        return [(int) $now->year, match ($def['periode']) {
            'bulan' => (int) $now->month,
            'tahun' => 1,
            default => $now->month <= 6 ? 1 : 2,
        }];
    }

    /** Label & satuan untuk kunci field, total, atau persentase. */
    public static function info(array $def, string $kunci): array
    {
        if (isset($def['persentase'][$kunci])) {
            return $def['persentase'][$kunci] + ['satuan' => '%', 'jenis' => 'persen'];
        }

        return ($def['total'][$kunci] ?? $def['fields'][$kunci] ?? ['label' => $kunci]) + ['satuan' => '', 'jenis' => 'angka'];
    }

    public static function desimal(array $def, string $kunci): bool
    {
        $tipe = $def['fields'][$kunci]['tipe'] ?? null;
        if (isset($def['total'][$kunci])) {
            return collect($def['total'][$kunci]['dari'])->contains(fn ($f) => self::desimal($def, $f));
        }

        return in_array($tipe, ['desimal', 'persen'], true);
    }

    /** Hitung kolom total otomatis dari data input. */
    public static function hitungTotal(array $def, array $data): array
    {
        foreach ($def['total'] as $kunci => $t) {
            $jumlah = array_sum(array_map(fn ($f) => (float) ($data[$f] ?? 0), $t['dari']));
            $data[$kunci] = self::desimal($def, $kunci) ? round($jumlah, 2) : (int) $jumlah;
        }

        return $data;
    }

    /**
     * Persentase dari satu baris (model atau array jumlah).
     * Mengembalikan [kunci => float|null]; null bila penyebut 0.
     */
    public static function persen(array $def, Model|array|null $baris): array
    {
        $hasil = [];
        foreach ($def['persentase'] as $kunci => $p) {
            $pembilang = (float) data_get($baris, $p['pembilang'], 0);
            $penyebut = (float) data_get($baris, $p['penyebut'], 0);
            $hasil[$kunci] = $penyebut > 0 ? round($pembilang / $penyebut * 100, 2) : null;
        }

        return $hasil;
    }

    /** Apakah modul punya target (menentukan arti status "Baik"). */
    public static function punyaTarget(array $def): bool
    {
        return collect($def['persentase'])->contains(fn ($p) => isset($p['target']) || isset($p['target_maks']));
    }

    /**
     * Status baris: 'baik' | 'bawah' | 'belum' (tidak ada data).
     * target      : persentase minimal (makin tinggi makin baik)
     * target_maks : persentase maksimal (makin rendah makin baik, mis. stunting)
     */
    public static function status(array $def, ?Model $baris): string
    {
        if (! $baris) {
            return 'belum';
        }

        foreach (self::persen($def, $baris) as $kunci => $nilai) {
            $p = $def['persentase'][$kunci];
            if (isset($p['target']) && ($nilai === null || $nilai < $p['target'])) {
                return 'bawah';
            }
            if (isset($p['target_maks']) && ($nilai === null || $nilai > $p['target_maks'])) {
                return 'bawah';
            }
        }

        return 'baik';
    }

    /** Label status; tanpa target, data yang masuk cukup disebut "Sudah lapor". */
    public static function labelStatus(array $def, string $status): string
    {
        return $status === 'baik' && ! self::punyaTarget($def) ? 'Sudah lapor' : self::STATUS[$status];
    }

    /** Teks syarat status "Baik", mis. "Perekaman KTP-el ≥ 95% dan Stunting ≤ 14%". */
    public static function syaratBaik(array $def): string
    {
        return collect($def['persentase'])->map(fn ($p) => match (true) {
            isset($p['target']) => $p['label'].' ≥ '.$p['target'].'%',
            isset($p['target_maks']) => $p['label'].' ≤ '.$p['target_maks'].'%',
            default => null,
        })->filter()->implode(' dan ');
    }

    /** Teks target untuk kartu metrik persentase. */
    public static function labelTarget(array $p): string
    {
        return match (true) {
            isset($p['target']) => 'target ≥ '.$p['target'].'%',
            isset($p['target_maks']) => 'target ≤ '.$p['target_maks'].'%',
            default => 'dihitung otomatis',
        };
    }

    /** Apakah nilai persentase sudah memenuhi targetnya. */
    public static function capaiTarget(array $p, ?float $nilai): bool
    {
        if ($nilai === null) {
            return false;
        }

        return match (true) {
            isset($p['target']) => $nilai >= $p['target'],
            isset($p['target_maks']) => $nilai <= $p['target_maks'],
            default => true,
        };
    }

    /** Nilai sebuah kunci (field/total/persentase) dari satu baris. */
    public static function nilai(array $def, Model|array|null $baris, string $kunci): ?float
    {
        if (isset($def['persentase'][$kunci])) {
            return self::persen($def, $baris)[$kunci];
        }

        $v = data_get($baris, $kunci);

        return $v === null ? null : (float) $v;
    }

    /** Format tampilan nilai, mis. "12.345", "1.250,50", atau "96,4%". */
    public static function format(array $def, string $kunci, ?float $nilai): string
    {
        if ($nilai === null) {
            return '–';
        }

        if (isset($def['persentase'][$kunci])) {
            return angka($nilai, 1).'%';
        }

        return angka($nilai, self::desimal($def, $kunci) && fmod($nilai, 1) !== 0.0 ? 2 : 0);
    }

    /* ------------------------------------------------------------------
     | Validasi
     * ------------------------------------------------------------------ */

    /** Aturan validasi server (rekap atau daftar), dibangun dari definisi field. */
    public static function rules(array $def, ?int $abaikanId = null): array
    {
        $umum = [
            'sumber_data' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,xls,xlsx,csv,doc,docx', 'max:2048'],
            'hapus_lampiran' => ['nullable', 'boolean'],
        ];

        return self::isDaftar($def) ? self::rulesDaftar($def) + $umum : self::rulesRekap($def, $abaikanId) + $umum;
    }

    private static function rulesRekap(array $def, ?int $abaikanId): array
    {
        $kolom = self::kolomPeriode($def);
        $tabel = (new $def['model'])->getTable();
        $maksPeriode = count(self::opsiPeriode($def));

        $unik = Rule::unique($tabel, $kolom)
            ->where(fn ($q) => $q->where('wilayah_id', request('wilayah_id'))->where('tahun', request('tahun')))
            ->ignore($abaikanId);
        if ($def['penyimpanan'] === 'json') {
            $unik->where('modul', $def['kunci']);
        }

        $rules = [
            'wilayah_id' => ['required', 'integer', 'exists:wilayah,id'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
            // Satu wilayah hanya boleh punya satu data per periode
            $kolom => ['required', 'integer', 'min:1', "max:$maksPeriode", $unik],
        ];

        foreach ($def['fields'] as $kunci => $f) {
            $rules[$kunci] = ($f['tipe'] ?? 'bulat') === 'desimal'
                ? ['required', 'numeric', 'min:0', 'max:999999999999', 'decimal:0,2']
                : ['required', 'integer', 'min:0', 'max:2000000000'];
            if (! empty($f['maks']) && isset($def['total'][$f['maks']])) {
                // Batas atas berupa total otomatis (mis. kasus ditangani <= total kasus)
                $total = $def['total'][$f['maks']];
                $rules[$kunci][] = function ($atribut, $nilai, $gagal) use ($total) {
                    $batas = array_sum(array_map(fn ($f) => (float) request($f, 0), $total['dari']));
                    if ((float) $nilai > $batas) {
                        $gagal('Tidak boleh melebihi '.mb_strtolower($total['label']).' ('.angka($batas, 0).').');
                    }
                };
            } elseif (! empty($f['maks'])) {
                // Nilai bagian tidak boleh melebihi totalnya
                $rules[$kunci][] = 'lte:'.$f['maks'];
            }
        }

        return $rules;
    }

    private static function rulesDaftar(array $def): array
    {
        $rules = [];
        foreach ($def['fields'] as $kunci => $f) {
            $wajib = ($f['wajib'] ?? false) ? 'required' : 'nullable';
            $rules[$kunci] = match ($f['tipe'] ?? 'teks') {
                'teks_panjang' => [$wajib, 'string', 'max:5000'],
                'angka' => [$wajib, 'integer', 'min:0', 'max:2000000000'],
                'desimal' => [$wajib, 'numeric', 'min:0', 'max:999999999999', 'decimal:0,2'],
                'persen' => [$wajib, 'numeric', 'min:0', 'max:100'],
                'tanggal' => array_filter([$wajib, 'date', isset($f['setelah']) ? 'after_or_equal:'.$f['setelah'] : null]),
                'tahun' => [$wajib, 'integer', 'min:1945', 'max:'.(now()->year + 10)],
                'pilihan' => [$wajib, 'string', Rule::in($f['opsi'] ?? [])],
                'wilayah' => [$wajib, 'integer', 'exists:wilayah,id'],
                default => [$wajib, 'string', 'max:255'],
            };
        }

        return $rules;
    }

    /** Label atribut agar pesan validasi berbahasa Indonesia mudah dibaca. */
    public static function atribut(array $def): array
    {
        $atribut = [
            'wilayah_id' => 'wilayah',
            self::kolomPeriode($def) => 'periode',
            'sumber_data' => 'sumber data',
        ];
        foreach ($def['fields'] as $kunci => $f) {
            $atribut[$kunci] = mb_strtolower($f['label']);
        }

        return $atribut;
    }

    /** Field dikelompokkan per grup untuk form: [grup => [kunci => field]]. */
    public static function grupField(array $def): array
    {
        $grup = [];
        foreach ($def['fields'] as $kunci => $f) {
            $grup[$f['grup'] ?? 'Data'][$kunci] = $f;
        }

        return $grup;
    }

    /* ------------------------------------------------------------------
     | Modul jenis "daftar"
     * ------------------------------------------------------------------ */

    /** Tampilan satu nilai field daftar, mis. tanggal "12 Mar 2026" atau nama kecamatan. */
    public static function tampilDaftar(array $def, Model $baris, string $kunci, $wilayah = null): string
    {
        $f = $def['fields'][$kunci] ?? [];
        $v = $baris->{$kunci};
        if ($v === null || $v === '') {
            return '–';
        }

        return match ($f['tipe'] ?? 'teks') {
            'angka' => angka($v, 0).(isset($f['satuan']) ? ' '.$f['satuan'] : ''),
            'desimal' => angka($v, fmod((float) $v, 1) !== 0.0 ? 2 : 0).(isset($f['satuan']) ? ' '.$f['satuan'] : ''),
            'persen' => angka($v, 1).'%',
            'tanggal' => \Illuminate\Support\Carbon::parse($v)->translatedFormat('d M Y'),
            'wilayah' => $wilayah?->get((int) $v)?->nama ?? '–',
            default => (string) $v,
        };
    }

    /** Kunci field bertipe wilayah (kecamatan) pada modul daftar, bila ada. */
    public static function fieldWilayah(array $def): ?string
    {
        return collect($def['fields'])->search(fn ($f) => ($f['tipe'] ?? null) === 'wilayah') ?: null;
    }

    /** Nilai metrik daftar: jumlah entri, hitung per nilai, jumlah, atau rata-rata field. */
    public static function metrikDaftar(array $m, $entri): ?float
    {
        return match ($m['agregat'] ?? 'jumlah') {
            'hitung' => (float) $entri->filter(fn ($e) => $e->{$m['field']} === $m['nilai'])->count(),
            'sum' => (float) $entri->sum(fn ($e) => (float) $e->{$m['field']}),
            'avg' => $entri->isEmpty() ? null : round($entri->avg(fn ($e) => (float) $e->{$m['field']}), 1),
            default => (float) $entri->count(),
        };
    }
}
