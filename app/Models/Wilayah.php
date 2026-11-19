<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** Master wilayah (kecamatan) untuk modul data generik. */
class Wilayah extends Model
{
    protected $table = 'wilayah';

    protected $fillable = ['nama', 'kabupaten', 'urutan'];

    public function scopeUrut(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }
}
