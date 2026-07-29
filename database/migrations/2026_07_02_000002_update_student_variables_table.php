<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Modifikasi tabel student_variables: 7 variabel sesuai angket pakar.
     * Hapus field lama (ipk_score, is_repeating_course, nilai_mk, dll).
     */
    public function up(): void
    {
        Schema::table('student_variables', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn([
                'ipk_score',
                'is_repeating_course',
                'skripsi_progress',
                'nilai_mk',
                'family_support',
                'teacher_quality',
                'admin_education',
                'self_motivation',
            ]);

            // Tambah 7 variabel baru sesuai angket pakar
            $table->enum('ipk_status', ['tinggi', 'rendah'])->after('user_id');
            $table->enum('skripsi_status', ['lancar', 'terlambat'])->after('ipk_status');
            $table->enum('dukungan_keluarga', ['tinggi', 'rendah'])->after('skripsi_status');
            $table->enum('kualitas_dosen', ['baik', 'kurang_baik'])->after('dukungan_keluarga');
            $table->enum('administrasi', ['lengkap', 'tidak_lengkap'])->after('kualitas_dosen');
            $table->enum('motivasi_diri', ['tinggi', 'rendah'])->after('administrasi');
            $table->enum('referensi_belajar', ['memadai', 'tidak_memadai'])->after('motivasi_diri');
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::table('student_variables', function (Blueprint $table) {
            $table->dropColumn([
                'ipk_status',
                'skripsi_status',
                'dukungan_keluarga',
                'kualitas_dosen',
                'administrasi',
                'motivasi_diri',
                'referensi_belajar',
            ]);

            // Kembalikan kolom lama
            $table->decimal('ipk_score', 3, 2)->after('user_id');
            $table->boolean('is_repeating_course')->default(false)->after('ipk_score');
            $table->enum('skripsi_progress', ['belum', 'berjalan', 'selesai'])->default('belum')->after('is_repeating_course');
            $table->enum('nilai_mk', ['A', 'B', 'C', 'D', 'E'])->default('B')->after('skripsi_progress');
            $table->decimal('family_support', 3, 2)->after('nilai_mk');
            $table->decimal('teacher_quality', 3, 2)->after('family_support');
            $table->decimal('admin_education', 3, 2)->after('teacher_quality');
            $table->decimal('self_motivation', 3, 2)->after('admin_education');
        });
    }
};
