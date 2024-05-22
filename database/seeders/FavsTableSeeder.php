<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavsTableSeeder extends Seeder
{
    public function run()
    {
        $uniqueFavs = [];

        for ($i = 1; $i <= 12; $i++) {
            $user_id = rand(1, 12);
            $publication_id = rand(1, 20);

            while (in_array([$user_id, $publication_id], $uniqueFavs)) {
                $user_id = rand(1, 12);
                $publication_id = rand(1, 20);
            }

            DB::table('favs')->insert([
                'user_id' => $user_id,
                'publication_id' => $publication_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $uniqueFavs[] = [$user_id, $publication_id];
        }
    }
}
