<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * Logika bersama modul data generik (definisi di config/modul_data.php).
 * Satu baris data = 1 wilayah x 1 periode (tahun + semester/bulan).
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

        return $def + [
            'kunci' => $kunci,
            'periode' => 'semester',
            'deskripsi' => null,
            'total' => [],
            'persentase' => [],
            'metrik' => [],
            'tabel' => [],
            'grafik' => [],
            'ringkasan' => null,
        ];
    }

    /** Kolom periode di tabel: 'semester' atau 'bulan'. */
    public static function kolomPeriode(array $def): string
    {
        return $def['periode'] === 'bulan' ? 'bulan' : 'semester';
    }

    /** Pilihan periode dalam satu tahun: [nilai => label]. */
    public static function opsiPeriode(array $def): array
    {
        return $def['periode'] === 'bulan'
            ? self::BULAN
            : [1 => 'Semester I (Jan–Jun)', 2 => 'Semester II (Jul–Des)'];
    }

    public static function labelPeriode(array $def, int $tahun, int $periode): string
    {
        $label = $def['periode'] === 'bulan'
            ? (self::BULAN[$periode] ?? $periode)
            : 'Semester '.($periode === 1 ? 'I' : 'II');

        return "$label $tahun";
    }

    /** Periode berjalan berdasarkan tanggal hari ini. */
    public static function periodeSekarang(array $def): array
    {
        $now = now();

        return [(int) $now->year, $def['periode'] === 'bulan' ? (int) $now->month : ($now->month <= 6 ? 1 : 2)];
    }

    /** Label & satuan untuk kunci field, total, atau persentase. */
    public static function info(array $def, string $kunci): array
    {
        if (isset($def['persentase'][$kunci])) {
            return $def['persentase'][$kunci] + ['satuan' => '%', 'jenis' => 'persen'];
        }

        return ($def['total'][$kunci] ?? $def['fields'][$kunci] ?? ['label' => $kunci]) + ['satuan' => '', 'jenis' => 'angka'];
    }

    /** Hitung kolom total otomatis dari data input. */
    public static function hitungTotal(array $def, array $data): array
    {
        foreach ($def['total'] as $kunci => $t) {
            $data[$kunci] = array_sum(array_map(fn ($f) => (int) ($data[$f] ?? 0), $t['dari']));
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

    /** Status baris: 'baik' | 'bawah' | 'belum' (tidak ada data). */
    public static function status(array $def, ?Model $baris): string
    {
        if (! $baris) {
            return 'belum';
        }

        foreach (self::persen($def, $baris) as $kunci => $nilai) {
            $target = $def['persentase'][$kunci]['target'] ?? null;
            if ($target !== null && ($nilai === null || $nilai < $target)) {
                return 'bawah';
            }
        }

        return 'baik';
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

    /** Format tampilan nilai, mis. "12.345" atau "96,4%". */
    public static function format(array $def, string $kunci, ?float $nilai): string
    {
        if ($nilai === null) {
            return '–';
        }

        return isset($def['persentase'][$kunci]) ? angka($nilai, 1).'%' : angka($nilai, 0);
    }

    /** Aturan validasi server, dibangun dari definisi field. */
    public static function rules(array $def, ?int $abaikanId = null): array
    {
        $kolom = self::kolomPeriode($def);
        $tabel = (new $def['model'])->getTable();
        $maksPeriode = $def['periode'] === 'bulan' ? 12 : 2;

        $rules = [
            'wilayah_id' => ['required', 'integer', 'exists:wilayah,id'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:'.(now()->year + 1)],
            $kolom => [
                'required', 'integer', 'min:1', "max:$maksPeriode",
                // Satu wilayah hanya boleh punya satu data per periode
                Rule::unique($tabel, $kolom)
                    ->where(fn ($q) => $q->where('wilayah_id', request('wilayah_id'))->where('tahun', request('tahun')))
                    ->ignore($abaikanId),
            ],
            'sumber_data' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,xls,xlsx,csv', 'max:2048'],
            'hapus_lampiran' => ['nullable', 'boolean'],
        ];

        foreach ($def['fields'] as $kunci => $f) {
            $rules[$kunci] = ['required', 'integer', 'min:0', 'max:2000000000'];
            if (! empty($f['maks'])) {
                // Nilai bagian tidak boleh melebihi totalnya
                $rules[$kunci][] = 'lte:'.$f['maks'];
            }
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
}
