<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendataanKeluarga extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_id',
        'user_id',
        'ranting_id',
        'no_kk',
        'nik',
        'status_keluarga',
        'nama_lengkap',
        'umur',
        'status_kawin',
        'pendidikan',
        'pekerjaan',
        'alamat_dusun',
        'no_rumah',
        'indikator_gj',
        'indikator_rmp',
        'status_kesehatan',
    ];

    protected function casts(): array
    {
        return [
            'indikator_gj' => 'array',
            'indikator_rmp' => 'array',
        ];
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ranting(): BelongsTo
    {
        return $this->belongsTo(Ranting::class);
    }
}
