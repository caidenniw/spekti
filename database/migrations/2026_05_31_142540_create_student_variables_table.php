<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Tabel student_variables = Input jawaban kuesioner dari mahasiswa.
     * 8 variabel prediksi sesuai metode Certainty Factor.
     */
    public function up(): void
    {
        Schema::create('student_variables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('ipk_score', 3, 2);              // IPK (0.00 - 4.00)
            $table->boolean('is_repeating_course')->default(false); // Mengulang MK?
            $table->enum('skripsi_progress', ['belum', 'berjalan', 'selesai'])->default('belum');
            $table->enum('nilai_mk', ['A', 'B', 'C', 'D', 'E'])->default('B'); // Status nilai MK
            $table->decimal('family_support', 3, 2);         // Dukungan keluarga (0-1)
            $table->decimal('teacher_quality', 3, 2);        // Kualitas pengajar (0-1)
            $table->decimal('admin_education', 3, 2);        // Administrasi pendidikan (0-1)
            $table->decimal('self_motivation', 3, 2);        // Motivasi diri (0-1)
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_variables');
    }
};
