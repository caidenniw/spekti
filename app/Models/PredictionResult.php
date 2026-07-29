<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PredictionResult extends Model
{
    use HasFactory;

    /**
     * Status prediksi.
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_REVISION_ALLOWED = 'revision_allowed';
    const STATUS_REVISION_REJECTED = 'revision_rejected';

    /**
     * Kolom yang bisa diisi massal.
     */
    protected $fillable = [
        'user_id',
        'student_variable_id',
        'total_cf_score',
        'persentase_keyakinan',
        'hasil_prediksi',
        'tanggal_prediksi',
        'status',
        'revision_requested_at',
        'revision_approved_at',
        'revision_notes',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'total_cf_score' => 'decimal:4',
            'persentase_keyakinan' => 'integer',
            'tanggal_prediksi' => 'date',
            'revision_requested_at' => 'datetime',
            'revision_approved_at' => 'datetime',
        ];
    }

    // ── Relasi ──

    /** Prediksi milik satu mahasiswa. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Prediksi berdasarkan satu sesi input variabel. */
    public function studentVariable(): BelongsTo
    {
        return $this->belongsTo(StudentVariable::class);
    }

    // ── Status Helpers ──

    /** Apakah prediksi aktif (final)? */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /** Apakah sedang menunggu approval admin? */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /** Apakah sudah di-approve admin untuk edit? */
    public function isRevisionAllowed(): bool
    {
        return $this->status === self::STATUS_REVISION_ALLOWED;
    }

    /** Apakah permintaan edit ditolak admin? */
    public function isRevisionRejected(): bool
    {
        return $this->status === self::STATUS_REVISION_REJECTED;
    }
}
