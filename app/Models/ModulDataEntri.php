<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Satu baris data modul generik yang disimpan di tabel bersama "modul_data".
 * Nilai field modul ada di kolom JSON "nilai", tetapi bisa dibaca seperti
 * kolom biasa: $baris->jumlah_umkm sama dengan $baris->nilai['jumlah_umkm'].
 */
class ModulDataEntri extends Model
{
    use Concerns\ModulData;

    protected $table = 'modul_data';

    protected $casts = [
        'nilai' => 'array',
    ];

    public function getAttribute($key)
    {
        $nilai = parent::getAttribute($key);

        // Kunci yang bukan kolom/relasi dibaca dari JSON "nilai"
        if ($nilai === null && $key !== 'nilai'
            && ! array_key_exists($key, $this->attributes)
            && ! $this->relationLoaded($key)
            && ! method_exists($this, $key)) {
            return parent::getAttribute('nilai')[$key] ?? null;
        }

        return $nilai;
    }
}
