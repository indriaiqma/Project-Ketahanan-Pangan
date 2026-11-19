<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel bersama untuk modul data generik (config/modul_data.php) yang tidak
 * memiliki tabel sendiri. Nilai field disimpan di kolom JSON "nilai", sehingga
 * field modul bisa diubah lewat config tanpa migration baru.
 *
 * - Modul jenis "rekap"  : 1 baris = 1 wilayah x 1 periode (unik per modul)
 * - Modul jenis "daftar" : 1 baris = 1 entri (wilayah/tahun/periode kosong)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modul_data', function (Blueprint $table) {
            $table->id();
            $table->string('modul', 100)->index();
            $table->foreignId('wilayah_id')->nullable()->constrained('wilayah')->restrictOnDelete();
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->unsignedTinyInteger('periode')->nullable();
            $table->json('nilai');

            // Field umum semua modul data
            $table->string('sumber_data')->nullable();
            $table->foreignId('lampiran_id')->nullable()->constrained('lampiran')->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['modul', 'wilayah_id', 'tahun', 'periode'], 'modul_data_wilayah_periode_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modul_data');
    }
};
