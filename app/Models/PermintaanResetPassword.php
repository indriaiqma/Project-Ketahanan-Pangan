<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Permintaan reset password yang dikirim pengguna dari halaman "Lupa Password"
 * untuk diproses Administrator (jalur cadangan bila email tidak tersedia).
 */
class PermintaanResetPassword extends Model
{
    protected $table = 'permintaan_reset_password';

    protected $fillable = ['user_id', 'status', 'catatan', 'ip', 'diproses_oleh', 'diproses_pada'];

    protected $casts = ['diproses_pada' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pemroses(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function scopeMenunggu(Builder $q): Builder
    {
        return $q->where('status', 'menunggu');
    }
}
