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
    }
}