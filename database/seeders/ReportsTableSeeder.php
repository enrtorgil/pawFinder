<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportsTableSeeder extends Seeder
{
    public function run()
    {
        $reasons = ['Contenido inapropiado', 'Información incorrecta', 'Spam', 'Otra razón'];

        for ($i = 1; $i <= 12; $i++) {
            DB::table('reports')->insert([
                'publication_id' => rand(1, 20),
                'user_id' => rand(1, 12),
                'additional_info' => 'Additional info ' . $i,
                'reason' => $reasons[array_rand($reasons)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
