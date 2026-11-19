<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modul Rekap Kependudukan. Definisi field, rumus, dan target ada di
 * config/modul_data.php (kunci "rekap-kependudukan").
 */
class RekapKependudukan extends Model
{
    use Concerns\ModulData;

    protected $table = 'rekap_kependudukan';
}
