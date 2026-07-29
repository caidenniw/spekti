<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variable extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'variable_name',
        'positif_value',
        'positif_label',
        'negatif_value',
        'negatif_label',
        'urutan',
    ];

    /**
     * Ambil semua variabel dalam format array untuk form kuesioner.
     * Format: [variable_name => ['label' => ..., 'options' => [...]]]
     */
    public static function getFormFormat(): array
    {
        $variables = self::orderBy('urutan')->get();
        $result = [];

        foreach ($variables as $var) {
            $result[$var->variable_name] = [
                'label'       => $var->label,
                'description' => $var->description,
                'options'     => [
                    $var->positif_value => $var->positif_label,
                    $var->negatif_value => $var->negatif_label,
                ],
            ];
        }

        return $result;
    }
}
