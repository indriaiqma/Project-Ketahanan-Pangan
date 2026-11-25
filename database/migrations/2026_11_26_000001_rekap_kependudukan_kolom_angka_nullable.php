<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Kolom angka Rekap Kependudukan boleh kosong (NULL).
 * Data resmi (mis. BPS) tidak selalu memuat semua indikator; nilai yang belum
 * tersedia harus tampil "–", bukan 0. Data yang sudah ada tidak diubah.
 */
return new class extends Migration
{
    private const KOLOM = ['laki_laki', 'perempuan', 'total_penduduk', 'jumlah_kk', 'wajib_ktp_el', 'sudah_rekam_ktp_el', 'penduduk_0_18', 'punya_akta'];

    public function up(): void
    {
        foreach (self::KOLOM as $k) {
            match (DB::getDriverName()) {
                'pgsql' => DB::statement("ALTER TABLE rekap_kependudukan ALTER COLUMN $k DROP NOT NULL, ALTER COLUMN $k DROP DEFAULT"),
                'mysql', 'mariadb' => DB::statement("ALTER TABLE rekap_kependudukan MODIFY $k INT UNSIGNED NULL DEFAULT NULL"),
                default => null, // sqlite: kolom tidak diubah
            };
        }
    }

    public function down(): void
    {
        foreach (self::KOLOM as $k) {
            DB::table('rekap_kependudukan')->whereNull($k)->update([$k => 0]);
            match (DB::getDriverName()) {
                'pgsql' => DB::statement("ALTER TABLE rekap_kependudukan ALTER COLUMN $k SET DEFAULT 0, ALTER COLUMN $k SET NOT NULL"),
                'mysql', 'mariadb' => DB::statement("ALTER TABLE rekap_kependudukan MODIFY $k INT UNSIGNED NOT NULL DEFAULT 0"),
                default => null,
            };
        }
    }
};
