<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed data pengguna: admin, pakar, dan sample mahasiswa.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'username_nim' => 'admin',
            'angkatan' => null,
            'password' => Hash::make('password'),
        ]);

        // Sample Mahasiswa
        $mahasiswa = [
            ['name' => 'Andi Pratama', 'nim' => '2022001', 'angkatan' => 2022],
            ['name' => 'Siti Nurhaliza', 'nim' => '2022002', 'angkatan' => 2022],
            ['name' => 'Rizki Ramadhan', 'nim' => '2023001', 'angkatan' => 2023],
            ['name' => 'Maya Putri', 'nim' => '2023002', 'angkatan' => 2023],
        ];

        foreach ($mahasiswa as $m) {
            User::create([
                'name' => $m['name'],
                'role' => 'mahasiswa',
                'username_nim' => $m['nim'],
                'angkatan' => $m['angkatan'],
                'password' => Hash::make('password'),
            ]);
        }
    }
}
