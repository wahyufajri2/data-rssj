<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KuesionerMandiri extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_id',
        'user_id',
        'ranting_id',
        'nama',
        'tanggal_mengisi',
        'jenis_kelamin',
        'status_kawin',
        'umur',
        'jumlah_anak',
        'pendidikan',
        'no_hp',
        'pekerjaan',
        'nik',
        'agama',
        'alamat',
        'skor_srq',
        'interpretasi_srq',
        'skor_kebiasaan',
        'interpretasi_kebiasaan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mengisi' => 'date',
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
