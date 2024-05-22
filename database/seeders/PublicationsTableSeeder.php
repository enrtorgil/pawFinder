<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicationsTableSeeder extends Seeder
{
    public function run()
    {
        $types = ['se busca', 'se adopta'];
        $type_animals = ['perro', 'gato', 'otro'];
        $sizes = ['Mediano', 'Pequeño', 'Grande'];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('publications')->insert([
                'user_id' => rand(1, 12),
                'name' => 'Publication ' . $i,
                'type' => $types[array_rand($types)],
                'type_animal' => $type_animals[array_rand($type_animals)],
                'size' => $sizes[array_rand($sizes)],
                'image' => 'image' . $i . '.jpg',
                'date' => now(),
                'description' => 'Description for publication ' . $i,
                'street' => 'Street ' . $i,
                'city' => 'City ' . $i,
                'country' => 'Country ' . $i,
                'zip' => rand(10000, 99999),
                'latitude' => rand(-90, 90),
                'longitude' => rand(-180, 180),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
