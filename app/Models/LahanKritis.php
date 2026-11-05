<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\DashboardController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LahanKritis extends Model
{
    use HasFactory;

    protected $table = 'lahan_kritis';

    protected $fillable = [
        'kabupaten',
        'kecamatan',

        'dalam_sangat_kritis',
        'dalam_kritis',
        'dalam_agak_kritis',
        'dalam_potensial_kritis',
        'dalam_tidak_kritis',

        'luar_sangat_kritis',
        'luar_kritis',
        'luar_agak_kritis',
        'luar_potensial_kritis',
        'luar_tidak_kritis',

        'total_ha',
    ];

    protected static function booted(): void
    {
        // Ringkasan dashboard di-cache; hapus cache setiap kali data berubah
        $hapusCache = fn () => Cache::forget(DashboardController::CACHE_KEY);

        static::saved($hapusCache);
        static::deleted($hapusCache);
    }
}