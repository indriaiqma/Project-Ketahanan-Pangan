<?php

namespace App\Models\Concerns;

use App\Models\Lampiran;
use App\Models\User;
use App\Models\Wilayah;
use App\Support\RingkasanBidang;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

/**
 * Perilaku bersama semua model modul data generik:
 * 1 baris = 1 wilayah x 1 periode, ditambah field umum
 * (sumber_data, lampiran, keterangan, created_by).
 */
trait ModulData
{
    /** Ringkasan di landing page dihitung ulang setiap kali data berubah. */
    public static function bootModulData(): void
    {
        $hapusCache = fn () => Cache::forget(RingkasanBidang::CACHE_KEY);

        static::saved($hapusCache);
        static::deleted($hapusCache);
    }

    public function initializeModulData(): void
    {
        // Semua kolom boleh diisi; yang benar-benar disimpan sudah disaring
        // oleh ModulDataController berdasarkan definisi field di config.
        $this->guarded = ['id'];
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function lampiran(): BelongsTo
    {
        return $this->belongsTo(Lampiran::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
