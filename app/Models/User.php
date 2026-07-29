<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi massal.
     */
    protected $fillable = [
        'name',
        'role',
        'username_nim',
        'angkatan',
        'password',
    ];

    /**
     * Kolom yang di-hidden saat toArray/toJson.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'angkatan' => 'integer',
            'password' => 'hashed',
        ];
    }

    // ── Relasi ──

    /** Satu mahasiswa punya banyak sesi input variabel. */
    public function studentVariables(): HasMany
    {
        return $this->hasMany(StudentVariable::class);
    }

    /** Satu mahasiswa punya banyak hasil prediksi. */
    public function predictionResults(): HasMany
    {
        return $this->hasMany(PredictionResult::class);
    }

    /** Satu mahasiswa punya satu pre-screening. */
    public function preScreening(): HasOne
    {
        return $this->hasOne(PreScreening::class);
    }

    // ── Scopes ──

    /** Scope: filter berdasarkan role. */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}
