<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Master wilayah (kecamatan) yang dipakai modul data generik.
 * Tabel kehutanan lama tetap memakai kolom teks "kecamatan" dan tidak diubah.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('kabupaten')->default('Kabupaten Malang');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });

        // 9 kecamatan Malang Selatan (sama dengan daftar di modul Lahan Kritis)
        $now = now();
        $kecamatan = ['Ampelgading', 'Bantur', 'Dampit', 'Donomulyo', 'Gedangan', 'Kalipare', 'Pagak', 'Sumbermanjing Wetan', 'Tirtoyudo'];

        DB::table('wilayah')->insert(collect($kecamatan)->values()->map(fn ($nama, $i) => [
            'nama' => $nama,
            'kabupaten' => 'Kabupaten Malang',
            'urutan' => $i + 1,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all());
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
