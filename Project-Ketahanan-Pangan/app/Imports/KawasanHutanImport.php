<?php

namespace App\Imports;

use App\Models\KawasanHutan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KawasanHutanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan data utama tersedia
        if (
            empty($row['kabupaten']) ||
            empty($row['kecamatan']) ||
            empty($row['nama_kawasan']) ||
            empty($row['jenis_kawasan'])
        ) {
            return null;
        }


        // Data yang akan disimpan / diperbarui
        $data = [
            'kabupaten'     => $row['kabupaten'],
            'kecamatan'     => $row['kecamatan'],
            'desa'          => $row['desa'] ?? null,
            'nama_kawasan'  => $row['nama_kawasan'],
            'jenis_kawasan' => $row['jenis_kawasan'],
            'luas_ha'       => $row['luas_ha'] ?? null,
            'keterangan'    => $row['keterangan'] ?? null,
        ];


        // Cek apakah data kawasan sudah pernah ada
        $existing = KawasanHutan::where(
            'kabupaten',
            $row['kabupaten']
        )
            ->where(
                'kecamatan',
                $row['kecamatan']
            )
            ->where(
                'nama_kawasan',
                $row['nama_kawasan']
            )
            ->first();


        // Jika sudah ada, update data lama
        if ($existing) {

            $existing->update($data);

            return null;
        }


        // Jika belum ada, buat data baru
        return new KawasanHutan($data);
    }
}