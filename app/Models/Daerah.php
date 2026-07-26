<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Daerah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kabupaten_kota',
        'no_sk',
        'nama_wilayah',
    ];

    public function cabangs(): HasMany
    {
        return $this->hasMany(Cabang::class);
    }
}
