<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Ranting;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Superadmin
        User::firstOrCreate(
            ['email' => 'superadmin@rssj.com'],
            [
                'name' => 'Superadmin RSSJ',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        // 2. Buat Admin Ranting (Ngadisuryan)
        // Cari Ranting Ngadisuryan, jika belum ada kita buatkan data dummy-nya
        $ranting = Ranting::where('nama_ranting', 'LIKE', '%Ngadisuryan%')->first();
        
        if (!$ranting) {
            $ranting = Ranting::firstOrCreate(
                ['nama_ranting' => 'Ngadisuryan'],
                [
                    'cabang_id' => 1, // Fallback ke cabang ID 1
                    'no_sk' => 'SK-NGADISURYAN-2026'
                ]
            );
        }

        User::firstOrCreate(
            ['email' => 'admin.ngadisuryan@rssj.com'],
            [
                'name' => 'Admin Ranting Ngadisuryan',
                'password' => Hash::make('password123'),
                'role' => 'admin_ranting',
                'ranting_id' => $ranting->id,
                'is_active' => true,
            ]
        );
    }
}
