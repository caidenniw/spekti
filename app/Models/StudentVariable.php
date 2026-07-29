<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentVariable extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi massal.
     * 7 variabel sesuai angket pakar.
     */
    protected $fillable = [
        'user_id',
        'ipk_status',
        'skripsi_status',
        'dukungan_keluarga',
        'kualitas_dosen',
        'administrasi',
        'motivasi_diri',
        'referensi_belajar',
    ];

    // ── Relasi ──

    /** Variabel milik satu mahasiswa. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Satu sesi input menghasilkan satu prediksi. */
    public function predictionResult(): HasOne
    {
        return $this->hasOne(PredictionResult::class);
    }

    /** Satu sesi input punya banyak jawaban per variabel (CF_User). */
    public function answers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }

    // ── Helper ──

    /**
     * Ambil semua jawaban dalam bentuk array [variable_name => cf_user].
     */
    public function getCFUserMap(): array
    {
        return $this->answers->pluck('cf_user', 'variable_name')->toArray();
    }

    /**
     * Ambil semua jawaban dalam bentuk array [variable_name => variable_value].
     */
    public function getStatusMap(): array
    {
        return $this->answers->pluck('variable_value', 'variable_name')->toArray();
    }
}
