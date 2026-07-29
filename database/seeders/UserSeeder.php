<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed data pengguna: 1 admin saja.
     * Mahasiswa mendaftar sendiri via /register.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'username_nim' => 'admin',
            'angkatan' => null,
            'password' => Hash::make('password'),
        ]);
    }
}
