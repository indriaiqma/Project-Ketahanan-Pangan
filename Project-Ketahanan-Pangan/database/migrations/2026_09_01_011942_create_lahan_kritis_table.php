<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahan_kritis', function (Blueprint $table) {
            $table->id();

            $table->string('kabupaten');
            $table->string('kecamatan');

            // Dalam Kawasan Hutan
            $table->decimal('dalam_sangat_kritis', 15, 2)->default(0);
            $table->decimal('dalam_kritis', 15, 2)->default(0);
            $table->decimal('dalam_agak_kritis', 15, 2)->default(0);
            $table->decimal('dalam_potensial_kritis', 15, 2)->default(0);
            $table->decimal('dalam_tidak_kritis', 15, 2)->default(0);

            // Luar Kawasan Hutan
            $table->decimal('luar_sangat_kritis', 15, 2)->default(0);
            $table->decimal('luar_kritis', 15, 2)->default(0);
            $table->decimal('luar_agak_kritis', 15, 2)->default(0);
            $table->decimal('luar_potensial_kritis', 15, 2)->default(0);
            $table->decimal('luar_tidak_kritis', 15, 2)->default(0);

            // Total luas seluruh kategori
            $table->decimal('total_ha', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lahan_kritis');
    }
};