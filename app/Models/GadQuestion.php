<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GadQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'order_num',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi: Satu pertanyaan GAD dijawab di banyak sesi skrining.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(ScreeningGadAnswer::class, 'gad_question_id');
    }
}
