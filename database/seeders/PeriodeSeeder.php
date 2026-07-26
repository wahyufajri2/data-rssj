<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        // Buat periode tahun ini (aktif) dan tahun lalu (tidak aktif)
        $periodes = [
            ['tahun' => date('Y'), 'is_active' => true],
            ['tahun' => date('Y') - 1, 'is_active' => false],
        ];

        foreach ($periodes as $periode) {
            Periode::firstOrCreate(
                ['tahun' => $periode['tahun']],
                ['is_active' => $periode['is_active']]
            );
        }
    }
}
