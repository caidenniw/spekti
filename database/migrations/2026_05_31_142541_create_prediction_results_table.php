<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Tabel prediction_results = Output hasil perhitungan CFEngineService.
     */
    public function up(): void
    {
        Schema::create('prediction_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_variable_id')->constrained('student_variables')->onDelete('cascade');
            $table->decimal('total_cf_score', 5, 4);         // CF kombinasi (-1.0000 s/d 1.0000)
            $table->unsignedInteger('persentase_keyakinan');   // Persentase 0-100
            $table->string('hasil_prediksi');                  // "Lulus 3,5 Tahun" / "Tidak Lulus 3,5 Tahun"
            $table->date('tanggal_prediksi');                  // Tanggal prediksi
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediction_results');
    }
};
