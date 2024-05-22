<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            DB::table('texts')->insert([
                'emitter_id' => rand(1, 12),
                'receiver_id' => rand(1, 12),
                'subject' => 'Subject ' . $i,
                'short_description' => 'Short description for text ' . $i,
                'is_read' => (bool) rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
