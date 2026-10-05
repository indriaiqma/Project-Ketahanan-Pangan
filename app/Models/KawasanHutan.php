<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KawasanHutan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kabupaten',
        'kecamatan',
        'desa',
        'nama_kawasan',
        'jenis_kawasan',
        'luas_ha',
        'keterangan',
    ];
}