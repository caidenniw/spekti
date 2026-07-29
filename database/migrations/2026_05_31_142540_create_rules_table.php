<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Tabel rules = Knowledge Base CF dari Pakar.
     */
    public function up(): void
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rule', 10)->unique();        // R001, R002, dst
            $table->text('deskripsi_rule');                     // Deskripsi IF-THEN
            $table->decimal('mb', 3, 2);                       // Measure of Belief
            $table->decimal('md', 3, 2);                       // Measure of Disbelief
            $table->decimal('cf_pakar', 3, 2);                 // CF_Pakar = MB - MD
            $table->enum('status_prediksi', ['Lulus', 'Tidak Lulus']); // Output rule
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
