<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function pendataanKeluargas(): HasMany
    {
        return $this->hasMany(PendataanKeluarga::class);
    }

    public function kuesionerMandiris(): HasMany
    {
        return $this->hasMany(KuesionerMandiri::class);
    }
}
