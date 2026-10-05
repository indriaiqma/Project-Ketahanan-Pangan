<?php

namespace App\Exports;

use App\Models\LahanKritis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LahanKritisExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LahanKritis::orderBy('kabupaten')
            ->orderBy('kecamatan')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kabupaten',
            'Kecamatan',

            'Dalam - Sangat Kritis',
            'Dalam - Kritis',
            'Dalam - Agak Kritis',
            'Dalam - Potensial Kritis',
            'Dalam - Tidak Kritis',

            'Luar - Sangat Kritis',
            'Luar - Kritis',
            'Luar - Agak Kritis',
            'Luar - Potensial Kritis',
            'Luar - Tidak Kritis',

            'Total (Ha)',
        ];
    }

    public function map($lahanKritis): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $lahanKritis->kabupaten,
            $lahanKritis->kecamatan,

            $lahanKritis->dalam_sangat_kritis,
            $lahanKritis->dalam_kritis,
            $lahanKritis->dalam_agak_kritis,
            $lahanKritis->dalam_potensial_kritis,
            $lahanKritis->dalam_tidak_kritis,

            $lahanKritis->luar_sangat_kritis,
            $lahanKritis->luar_kritis,
            $lahanKritis->luar_agak_kritis,
            $lahanKritis->luar_potensial_kritis,
            $lahanKritis->luar_tidak_kritis,

            $lahanKritis->total_ha,
        ];
    }
}