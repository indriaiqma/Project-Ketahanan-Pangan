<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Lampiran modul data. Isi file disimpan base64 di kolom "isi"
 * (lihat migration create_lampiran_table untuk alasannya).
 */
class Lampiran extends Model
{
    protected $table = 'lampiran';

    protected $fillable = ['nama_file', 'mime', 'ukuran', 'isi', 'uploaded_by'];

    // Isi file tidak ikut saat model diubah ke array/JSON
    protected $hidden = ['isi'];

    public function ukuranLabel(): string
    {
        return $this->ukuran >= 1048576
            ? angka($this->ukuran / 1048576, 1).' MB'
            : angka(max($this->ukuran / 1024, 1), 0).' KB';
    }
}
