<?php

namespace App\Exports;

use App\Models\KawasanHutan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KawasanHutanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return KawasanHutan::orderBy('kabupaten')
            ->orderBy('kecamatan')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kabupaten',
            'Kecamatan',
            'Desa',
            'Nama Kawasan',
            'Jenis Kawasan',
            'Luas (Ha)',
            'Keterangan',
        ];
    }

    public function map($kawasanHutan): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $kawasanHutan->kabupaten,
            $kawasanHutan->kecamatan,
            $kawasanHutan->desa,
            $kawasanHutan->nama_kawasan,
            $kawasanHutan->jenis_kawasan,
            $kawasanHutan->luas_ha,
            $kawasanHutan->keterangan,
        ];
    }
}