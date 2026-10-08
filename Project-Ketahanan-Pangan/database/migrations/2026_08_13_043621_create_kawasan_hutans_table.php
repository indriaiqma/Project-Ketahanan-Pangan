<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('kawasan_hutans', function (Blueprint $table) {
        $table->id();
        $table->string('kabupaten');
        $table->string('kecamatan');
        $table->string('desa')->nullable();
        $table->string('nama_kawasan');
        $table->string('jenis_kawasan');
        $table->decimal('luas_ha', 12, 2)->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kawasan_hutans');
    }
};
