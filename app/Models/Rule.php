<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rule extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi massal.
     * cf_pakar langsung dari skala keyakinan pakar (SY/Y/C/K/TY).
     */
    protected $fillable = [
        'kode_rule',
        'deskripsi_rule',
        'cf_pakar',
        'status_prediksi',
    ];

    /**
     * Casting tipe data.
     */
    protected function casts(): array
    {
        return [
            'cf_pakar' => 'decimal:2',
        ];
    }
}
