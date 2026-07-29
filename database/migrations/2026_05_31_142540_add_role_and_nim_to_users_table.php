<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Modifikasi tabel users: drop email (pakai NIM), tambah role, username_nim, angkatan.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email', 'email_verified_at']);
            $table->enum('role', ['admin', 'mahasiswa'])->default('mahasiswa')->after('name');
            $table->string('username_nim')->unique()->after('role');
            $table->integer('angkatan')->nullable()->after('username_nim');
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'username_nim', 'angkatan']);
            $table->string('email')->unique()->after('name');
            $table->timestamp('email_verified_at')->nullable()->after('email');
        });
    }
};
