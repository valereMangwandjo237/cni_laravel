<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 5; $i <= 24; $i++) {
            // Génère recto
            Image::factory()->create([
                'immat_id' => $i,
                'type' => 'recto',
            ]);

            // Génère verso
            Image::factory()->create([
                'immat_id' => $i,
                'type' => 'verso',
            ]);
        }
    }
}
