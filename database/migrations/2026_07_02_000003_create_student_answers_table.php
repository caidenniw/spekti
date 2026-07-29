<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Tabel student_answers = CF_User per variabel dari mahasiswa.
     * Mahasiswa memilih tingkat keyakinan (SY/Y/C/K/TY) untuk setiap variabel.
     */
    public function up(): void
    {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_variable_id')->constrained('student_variables')->onDelete('cascade');
            $table->string('variable_name');              // nama variabel (ipk_status, skripsi_status, dst)
            $table->string('variable_value');             // nilai yang dipilih (tinggi/rendah, lancar/terlambat, dst)
            $table->decimal('cf_user', 3, 2);             // CF_User dari skala (1.0, 0.8, 0.6, 0.4, 0.2)
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
