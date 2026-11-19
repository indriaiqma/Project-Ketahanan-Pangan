<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Modul Rekap Kependudukan (Sub Bidang Pemerintahan I).
 * Satu baris = 1 wilayah x 1 periode (tahun + semester).
 * Persentase tidak disimpan; dihitung saat ditampilkan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_kependudukan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayah')->restrictOnDelete();
            $table->unsignedSmallInteger('tahun');
            $table->unsignedTinyInteger('semester');

            $table->unsignedInteger('laki_laki')->default(0);
            $table->unsignedInteger('perempuan')->default(0);
            $table->unsignedInteger('total_penduduk')->default(0); // otomatis: laki_laki + perempuan
            $table->unsignedInteger('jumlah_kk')->default(0);
            $table->unsignedInteger('wajib_ktp_el')->default(0);
            $table->unsignedInteger('sudah_rekam_ktp_el')->default(0);
            $table->unsignedInteger('penduduk_0_18')->default(0);
            $table->unsignedInteger('punya_akta')->default(0);

            // Field umum semua modul data
            $table->string('sumber_data')->nullable();
            $table->foreignId('lampiran_id')->nullable()->constrained('lampiran')->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['wilayah_id', 'tahun', 'semester'], 'rekap_kependudukan_wilayah_periode_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_kependudukan');
    }
};
