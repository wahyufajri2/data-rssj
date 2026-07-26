<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ranting extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabang_id',
        'nama_ranting',
        'no_sk',
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
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
