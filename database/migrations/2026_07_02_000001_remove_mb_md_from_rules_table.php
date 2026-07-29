<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Modifikasi tabel rules: hapus mb/md, cf_pakar langsung dari skala pakar.
     */
    public function up(): void
    {
        Schema::table('rules', function (Blueprint $table) {
            $table->dropColumn(['mb', 'md']);
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::table('rules', function (Blueprint $table) {
            $table->decimal('mb', 3, 2)->after('deskripsi_rule');
            $table->decimal('md', 3, 2)->after('mb');
        });
    }
};
