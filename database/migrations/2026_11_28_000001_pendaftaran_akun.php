<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pendaftaran akun mandiri (Petugas) dengan persetujuan Administrator.
 * Akun yang sudah ada otomatis berstatus "aktif" sehingga tidak terpengaruh.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status_akun', 20)->default('aktif')->after('role'); // aktif | menunggu | ditolak
            $table->string('no_hp', 20)->nullable()->after('email');
            $table->string('jabatan', 150)->nullable()->after('no_hp');          // jabatan / unit kerja
            $table->json('pengajuan_penugasan')->nullable();                     // sub bidang yang diajukan saat mendaftar
            $table->string('catatan_pendaftaran', 255)->nullable();
            $table->string('alasan_ditolak', 255)->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->index('status_akun');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['diverifikasi_oleh']);
            $table->dropIndex(['status_akun']);
            $table->dropColumn(['status_akun', 'no_hp', 'jabatan', 'pengajuan_penugasan', 'catatan_pendaftaran',
                'alasan_ditolak', 'diverifikasi_oleh', 'diverifikasi_pada']);
        });
    }
};
