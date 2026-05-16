<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GadQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $questions = [
            [
                'question'   => 'Merasa gugup, cemas, atau tegang',
                'order_num'  => 1,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Tidak mampu menghentikan atau mengendalikan rasa khawatir',
                'order_num'  => 2,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Terlalu banyak mengkhawatirkan berbagai hal',
                'order_num'  => 3,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Sulit untuk merasa rileks',
                'order_num'  => 4,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Sangat gelisah sehingga sulit untuk diam',
                'order_num'  => 5,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Mudah merasa kesal atau mudah marah',
                'order_num'  => 6,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Merasa takut seolah-olah sesuatu yang buruk akan terjadi',
                'order_num'  => 7,
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Mencegah duplikasi data jika seeder dijalankan lebih dari sekali
        // menggunakan updateOrInsert berdasarkan teks pertanyaan
        foreach ($questions as $q) {
            DB::table('gad_questions')->updateOrInsert(
                ['question' => $q['question']], // Cek berdasarkan pertanyaan
                [
                    'order_num'  => $q['order_num'],
                    'is_active'  => $q['is_active'],
                    'created_at' => $q['created_at'],
                    'updated_at' => $q['updated_at'],
                ]
            );
        }
    }
}
