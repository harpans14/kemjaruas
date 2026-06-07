<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@greenbin.test',
            'username' => 'admin',
            'password' => bcrypt('Admin123!'),
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Petugas Lapangan',
            'email' => 'petugas@greenbin.test',
            'username' => 'petugas',
            'password' => bcrypt('Petugas123!'),
            'role' => 'petugas',
        ]);

        User::create([
            'nama' => 'Warga Biasa',
            'email' => 'warga@greenbin.test',
            'username' => 'warga',
            'password' => bcrypt('Warga123!'),
            'role' => 'warga',
        ]);
    }
}
