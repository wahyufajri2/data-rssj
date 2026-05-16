<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScreeningGadAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'screening_id',
        'gad_question_id',
        'score',
    ];

    /**
     * Relasi: Jawaban ini bagian dari sesi Skrining mana.
     */
    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }

    /**
     * Relasi: Jawaban ini merujuk ke Pertanyaan GAD mana.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(GadQuestion::class, 'gad_question_id');
    }
}
