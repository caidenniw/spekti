<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prediction_results', function (Blueprint $table) {
            $table->enum('status', ['active', 'pending', 'revision_allowed'])->default('active')->after('tanggal_prediksi');
            $table->timestamp('revision_requested_at')->nullable()->after('status');
            $table->timestamp('revision_approved_at')->nullable()->after('revision_requested_at');
            $table->text('revision_notes')->nullable()->after('revision_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prediction_results', function (Blueprint $table) {
            $table->dropColumn(['status', 'revision_requested_at', 'revision_approved_at', 'revision_notes']);
        });
    }
};
