<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->id();
            $table->string('label');                          // Nama variabel (tampilan)
            $table->string('variable_name')->unique();        // Key internal (ipk_status, dst)
            $table->string('positif_value');                  // Value opsi positif (tinggi)
            $table->string('positif_label');                  // Label opsi positif (Tinggi 3.51-4.00)
            $table->string('negatif_value');                  // Value opsi negatif (rendah)
            $table->string('negatif_label');                  // Label opsi negatif (Rendah 2.76-3.50)
            $table->integer('urutan')->default(0);            // Urutan tampil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variables');
    }
};
