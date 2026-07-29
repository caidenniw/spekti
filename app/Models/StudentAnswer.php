<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAnswer extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi massal.
     */
    protected $fillable = [
        'student_variable_id',
        'variable_name',
        'variable_value',
        'cf_user',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'cf_user' => 'decimal:2',
        ];
    }

    // ── Relasi ──

    /** Jawaban milik satu sesi input variabel. */
    public function studentVariable(): BelongsTo
    {
        return $this->belongsTo(StudentVariable::class);
    }
}
