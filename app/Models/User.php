<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'no_hp',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mengecek apakah user memiliki role tertentu.
     * (Asumsinya Anda memiliki kolom 'role' di tabel users)
     */
    public function hasRole($roleName)
    {
        return $this->role === $roleName;
    }

    /**
     * Relasi: Satu User (Pasien) memiliki banyak sesi Skrining.
     */
    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }
}
