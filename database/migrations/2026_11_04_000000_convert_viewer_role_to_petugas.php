<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Dulu migration ini mengubah akun "viewer" menjadi "petugas".
 * Role viewer kini dipakai kembali (akses hanya-baca), jadi migration
 * ini sengaja dikosongkan agar akun viewer tidak ikut berubah.
 * File tetap disimpan karena sudah tercatat di tabel migrations.
 */
return new class extends Migration
{
    public function up(): void
    {
        //
    }

    public function down(): void
    {
        //
    }
};
