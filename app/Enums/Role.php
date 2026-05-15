<?php

namespace App\Enums;

enum Role: int
{
    case ADMIN       = 1;
    case MAHASISWA   = 2;
    case VERIFIKATOR = 3;
    case PIMPINAN    = 4;
    case PRODI       = 5;
    case FAKULTAS    = 6;

    /**
     * Nama role untuk middleware / route
     */
    public function key(): string
    {
        return match ($this) {
            self::ADMIN       => 'admin',
            self::MAHASISWA   => 'mahasiswa',
            self::VERIFIKATOR => 'verifikator',
            self::PIMPINAN    => 'pimpinan',
            self::PRODI       => 'prodi',
            self::FAKULTAS    => 'fakultas',
        };
    }

    /**
     * Route dashboard per role
     */
    public function dashboardRoute(): string
    {
        return match ($this) {
            self::ADMIN       => 'admin.dashboard',
            self::MAHASISWA   => 'mahasiswa.dashboard',
            self::VERIFIKATOR => 'verifikator.dashboard',
            self::PIMPINAN    => 'pimpinan.dashboard',
            self::PRODI       => 'prodi.dashboard',
            self::FAKULTAS    => 'fakultas.dashboard',
        };
    }

    /**
     * Ambil enum dari peran_id user
     */
    public static function fromId(int $id): ?self
    {
        return self::tryFrom($id);
    }
}
