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
            [
                'name'              => 'admin',
                'fullname'          => 'Admin BKA',
                'email'             => 'kemahasiswaan@unisayogya.ac.id',
                'email_verified_at' => $now,
                'password'          => Hash::make('bka$unisa#unggul'),
                'no_hp'             => '082134910932',
                'peran_id'          => 1,
                'prodi_id'          => null,
                'active'            => true,
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ];

        DB::table('users')->upsert($users, ['email'], [
            'name',
            'fullname',
            'password',
            'no_hp',
            'peran_id',
            'prodi_id',
            'active',
            'email_verified_at',
            'updated_at'
        ]);
    }
}
