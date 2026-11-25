<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Fitur lupa password:
 *  - users.wajib_ganti_password : pengguna harus mengganti password setelah
 *    Administrator membuatkan password sementara.
 *  - permintaan_reset_password  : permintaan reset yang dikirim dari halaman
 *    login untuk diproses Administrator (cadangan bila email tidak tersedia).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('wajib_ganti_password')->default(false)->after('role');
        });

        Schema::create('permintaan_reset_password', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status', 20)->default('menunggu'); // menunggu | selesai | ditolak
            $table->string('catatan', 255)->nullable();       // catatan pemohon (opsional)
            $table->string('ip', 45)->nullable();
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('diproses_pada')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_reset_password');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('wajib_ganti_password');
        });
    }
};
