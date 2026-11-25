<?php

namespace App\Console\Commands;

use App\Models\PermintaanResetPassword;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Jalur darurat bila satu-satunya Administrator lupa password dan email belum aktif.
 * Dijalankan oleh pengelola server:
 *
 *   php artisan user:reset-password admin@bakorwil3.jatimprov.go.id
 *
 * Membuat password sementara; pengguna wajib menggantinya saat login.
 */
class ResetPasswordPengguna extends Command
{
    protected $signature = 'user:reset-password {email : Email akun yang direset}';

    protected $description = 'Buat password sementara untuk akun yang lupa password (wajib diganti saat login)';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();
        if (! $user) {
            $this->error('Akun dengan email tersebut tidak ditemukan.');

            return self::FAILURE;
        }

        if (! $this->confirm("Buat password sementara untuk {$user->name} ({$user->roleLabel()})?", true)) {
            return self::FAILURE;
        }

        $sementara = Str::password(10, true, true, false);
        $user->forceFill([
            'password' => Hash::make($sementara),
            'remember_token' => Str::random(60),
            'wajib_ganti_password' => true,
        ])->save();
        PermintaanResetPassword::menunggu()->where('user_id', $user->id)
            ->update(['status' => 'selesai', 'diproses_pada' => now()]);

        $this->info("Password sementara: {$sementara}");
        $this->line('Sampaikan secara pribadi. Pengguna wajib membuat password baru saat masuk.');

        return self::SUCCESS;
    }
}
