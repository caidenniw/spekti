<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreScreening extends Model
{
    protected $fillable = [
        'user_id',
        'nilai_ab_only',
    ];

    protected function casts(): array
    {
        return [
            'nilai_ab_only' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
