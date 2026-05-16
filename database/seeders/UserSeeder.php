<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $users = [
            // 1. Akun Admin (Diambil dari data sebelumnya)
            [
                'name'              => 'Admin Embrace', // Menggabungkan name dan fullname
                'no_hp'             => '082134910932',
                'email'             => 'embrace@unisayogya.ac.id',
                'role'              => 'admin', // Menggunakan enum dari migration baru
                'email_verified_at' => $now,
                'password'          => Hash::make('password123'), // Password default admin
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            // 2. Akun Pasien Contoh
            [
                'name'              => 'Pasien Contoh',
                'no_hp'             => '081234567890',
                'email'             => 'pasien@example.com', // Bisa diisi null karena di migration diset nullable()
                'role'              => 'patient',
                'email_verified_at' => $now,
                'password'          => Hash::make('password123'), // Password default pasien
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ];

        // Menggunakan 'no_hp' sebagai parameter unik (kunci) untuk upsert,
        // karena no_hp sekarang digunakan sebagai username mutlak saat login.
        DB::table('users')->upsert($users, ['no_hp'], [
            'name',
            'email',
            'role',
            'password',
            'email_verified_at',
            'updated_at'
        ]);
    }
}
