<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vas_score',
        'vas_category',
        'gad_score',
        'gad_category',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at'   => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Relasi: Sesi Skrining ini milik satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Sesi Skrining ini memiliki banyak jawaban GAD-7.
     */
    public function gadAnswers(): HasMany
    {
        return $this->hasMany(ScreeningGadAnswer::class);
    }
}
