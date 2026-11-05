<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\DashboardController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    protected static function booted(): void
    {
        // Ringkasan dashboard di-cache; hapus cache setiap kali data berubah
        $hapusCache = fn () => Cache::forget(DashboardController::CACHE_KEY);

        static::saved($hapusCache);
        static::deleted($hapusCache);
    }
}