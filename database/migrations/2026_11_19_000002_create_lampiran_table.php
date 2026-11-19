<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Lampiran (PDF/Excel) modul data.
 * Isi file disimpan di database (base64) agar tetap permanen saat aplikasi
 * berjalan di Vercel, yang sistem filenya hanya-baca. Ukuran dibatasi 2 MB.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lampiran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->string('mime', 150);
            $table->unsignedInteger('ukuran');
            $table->longText('isi');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lampiran');
    }
};
