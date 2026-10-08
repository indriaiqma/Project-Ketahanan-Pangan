<?php

namespace App\Imports;

use App\Models\LahanKritis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LahanKritisImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Batasi hanya kecamatan Malang Selatan
        $kecamatanMalangSelatan = [
            'Ampelgading',
            'Bantur',
            'Dampit',
            'Donomulyo',
            'Gedangan',
            'Kalipare',
            'Pagak',
            'Sumbermanjing Wetan',
            'Tirtoyudo',
        ];

        if (
            !isset($row['kecamatan']) ||
            !in_array($row['kecamatan'], $kecamatanMalangSelatan)
        ) {
            return null;
        }

        $data = [
            'kabupaten' => $row['kabupaten'] ?? 'Kabupaten Malang',

            'dalam_sangat_kritis' => $row['dalam_sangat_kritis'] ?? 0,
            'dalam_kritis' => $row['dalam_kritis'] ?? 0,
            'dalam_agak_kritis' => $row['dalam_agak_kritis'] ?? 0,
            'dalam_potensial_kritis' => $row['dalam_potensial_kritis'] ?? 0,
            'dalam_tidak_kritis' => $row['dalam_tidak_kritis'] ?? 0,

            'luar_sangat_kritis' => $row['luar_sangat_kritis'] ?? 0,
            'luar_kritis' => $row['luar_kritis'] ?? 0,
            'luar_agak_kritis' => $row['luar_agak_kritis'] ?? 0,
            'luar_potensial_kritis' => $row['luar_potensial_kritis'] ?? 0,
            'luar_tidak_kritis' => $row['luar_tidak_kritis'] ?? 0,

            'total_ha' => $row['total_ha'] ?? 0,
        ];

        $existing = LahanKritis::where('kabupaten', $data['kabupaten'])
            ->where('kecamatan', $row['kecamatan'])
            ->first();

        if ($existing) {
            $existing->update($data);

            return null;
        }

        return new LahanKritis(array_merge(
            [
                'kecamatan' => $row['kecamatan'],
            ],
            $data
        ));
    }
}