<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bakorwil3.jatimprov.go.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('GantiPasswordIni123'),
                'role'     => 'admin',
            ]
        );

        // Akun petugas awal. Dibuat sekali saja; jika sudah ada tidak diubah.
        User::firstOrCreate(
            ['email' => 'petugas@bakorwil3.jatimprov.go.id'],
            [
                'name'     => 'Petugas',
                'password' => Hash::make('PetugasBakorwil123'),
                'role'     => 'petugas',
            ]
        );

        // Akun viewer awal (hanya-baca). Dibuat sekali saja; jika sudah ada tidak diubah.
        User::firstOrCreate(
            ['email' => 'viewer@bakorwil3.jatimprov.go.id'],
            [
                'name'     => 'Viewer',
                'password' => Hash::make('ViewerBakorwil123'),
                'role'     => 'viewer',
            ]
        );
    }
}