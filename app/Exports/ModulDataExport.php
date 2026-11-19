<?php

namespace App\Exports;

use App\Models\Wilayah;
use App\Support\ModulData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Export Excel generik untuk modul data (config/modul_data.php).
 * Rekap tanpa tahun & periode, serta modul jenis daftar: seluruh data.
 */
class ModulDataExport implements FromCollection, WithHeadings, WithMapping
{
    private int $no = 0;

    private $wilayah;

    public function __construct(
        private array $def,
        private ?int $tahun = null,
        private ?int $periode = null,
    ) {
        $this->wilayah = Wilayah::urut()->get()->keyBy('id');
    }

    public function collection()
    {
        $query = ModulData::query($this->def)->with(['wilayah:id,nama,urutan', 'pembuat:id,name', 'lampiran:id,nama_file']);

        if (ModulData::isDaftar($this->def)) {
            return $query->latest()->get();
        }

        $kolom = ModulData::kolomPeriode($this->def);

        return $query
            ->when($this->tahun && $this->periode, fn ($q) => $q->where('tahun', $this->tahun)->where($kolom, $this->periode))
            ->get()
            ->sortBy(fn ($r) => [-$r->tahun, -$r->{$kolom}, $r->wilayah?->urutan])
            ->values();
    }

    public function headings(): array
    {
        $penutup = ['Sumber Data', 'Keterangan', 'Lampiran', 'Diinput Oleh', 'Diperbarui'];

        if (ModulData::isDaftar($this->def)) {
            $judul = ['No'];
            foreach ($this->def['fields'] as $f) {
                $judul[] = $f['label'].(isset($f['satuan']) ? " ({$f['satuan']})" : '');
            }

            return array_merge($judul, $penutup);
        }

        $judul = ['No', 'Wilayah', 'Tahun', 'Periode'];
        foreach ($this->kunciAngka() as $k) {
            $info = ModulData::info($this->def, $k);
            $judul[] = $info['label'].($info['satuan'] ? " ({$info['satuan']})" : '');
        }

        return array_merge($judul, ['Status'], $penutup);
    }

    public function map($baris): array
    {
        $penutup = [
            $baris->sumber_data,
            $baris->keterangan,
            $baris->lampiran?->nama_file,
            $baris->pembuat?->name,
            $baris->updated_at?->format('d-m-Y H:i'),
        ];

        if (ModulData::isDaftar($this->def)) {
            $isi = [++$this->no];
            foreach ($this->def['fields'] as $k => $f) {
                $v = $baris->{$k};
                $isi[] = match ($f['tipe'] ?? 'teks') {
                    'wilayah' => $this->wilayah->get((int) $v)?->nama,
                    'angka', 'desimal', 'persen', 'tahun' => $v === null ? null : (float) $v,
                    default => $v,
                };
            }

            return array_merge($isi, $penutup);
        }

        $kolom = ModulData::kolomPeriode($this->def);
        $opsi = ModulData::opsiPeriode($this->def);

        $isi = [++$this->no, $baris->wilayah?->nama, $baris->tahun, $opsi[$baris->{$kolom}] ?? $baris->{$kolom}];
        foreach ($this->kunciAngka() as $k) {
            $isi[] = ModulData::nilai($this->def, $baris, $k);
        }

        return array_merge($isi, [ModulData::labelStatus($this->def, ModulData::status($this->def, $baris))], $penutup);
    }

    /** Field input, kolom total, lalu persentase. */
    private function kunciAngka(): array
    {
        return array_merge(array_keys($this->def['fields']), array_keys($this->def['total']), array_keys($this->def['persentase']));
    }
}
