<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Penugasan petugas ke bidang / sub bidang (config/bidang.php).
 * sub_bidang = null berarti seluruh bidang (dipakai bidang tanpa sub bidang).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_bidang_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('bidang', 100);
            $table->string('sub_bidang', 100)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'bidang', 'sub_bidang'], 'user_bidang_access_unique');
        });

        // Petugas yang sudah ada sebelum fitur ini bisa mengelola data kehutanan.
        // Agar aksesnya tidak hilang, tugaskan mereka ke Sub Bidang Sarpras II.
        $now = now();
        $petugas = DB::table('users')->where('role', 'petugas')->pluck('id');

        if ($petugas->isNotEmpty()) {
            DB::table('user_bidang_access')->insert($petugas->map(fn ($id) => [
                'user_id' => $id,
                'bidang' => 'sarana-prasarana',
                'sub_bidang' => 'sarpras-2',
                'created_at' => $now,
                'updated_at' => $now,
            ])->all());
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_bidang_access');
    }
};
