<?php

namespace App\Exports;

use App\Support\ModulData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Export Excel generik untuk modul data (config/modul_data.php).
 * Tanpa tahun & periode: seluruh periode.
 */
class ModulDataExport implements FromCollection, WithHeadings, WithMapping
{
    private int $no = 0;

    public function __construct(
        private array $def,
        private ?int $tahun = null,
        private ?int $periode = null,
    ) {}

    public function collection()
    {
        $kolom = ModulData::kolomPeriode($this->def);

        return $this->def['model']::query()
            ->with(['wilayah:id,nama,urutan', 'pembuat:id,name', 'lampiran:id,nama_file'])
            ->when($this->tahun && $this->periode, fn ($q) => $q->where('tahun', $this->tahun)->where($kolom, $this->periode))
            ->orderByDesc('tahun')->orderByDesc($kolom)
            ->get()
            ->sortBy(fn ($r) => [-$r->tahun, -$r->{$kolom}, $r->wilayah?->urutan])
            ->values();
    }

    public function headings(): array
    {
        $judul = ['No', 'Wilayah', 'Tahun', 'Periode'];

        foreach ($this->kunciAngka() as $k) {
            $info = ModulData::info($this->def, $k);
            $judul[] = $info['label'].($info['satuan'] ? " ({$info['satuan']})" : '');
        }

        return array_merge($judul, ['Status', 'Sumber Data', 'Keterangan', 'Lampiran', 'Diinput Oleh', 'Diperbarui']);
    }

    public function map($baris): array
    {
        $kolom = ModulData::kolomPeriode($this->def);
        $opsi = ModulData::opsiPeriode($this->def);

        $isi = [++$this->no, $baris->wilayah?->nama, $baris->tahun, $opsi[$baris->{$kolom}] ?? $baris->{$kolom}];

        foreach ($this->kunciAngka() as $k) {
            $isi[] = ModulData::nilai($this->def, $baris, $k);
        }

        return array_merge($isi, [
            ModulData::STATUS[ModulData::status($this->def, $baris)],
            $baris->sumber_data,
            $baris->keterangan,
            $baris->lampiran?->nama_file,
            $baris->pembuat?->name,
            $baris->updated_at?->format('d-m-Y H:i'),
        ]);
    }

    /** Field input, kolom total, lalu persentase. */
    private function kunciAngka(): array
    {
        return array_merge(array_keys($this->def['fields']), array_keys($this->def['total']), array_keys($this->def['persentase']));
    }
}
