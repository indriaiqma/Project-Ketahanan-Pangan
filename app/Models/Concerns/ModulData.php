<?php

namespace App\Models\Concerns;

use App\Models\Lampiran;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Perilaku bersama semua model modul data generik:
 * 1 baris = 1 wilayah x 1 periode, ditambah field umum
 * (sumber_data, lampiran, keterangan, created_by).
 */
trait ModulData
{
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
