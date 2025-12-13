<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeaturedArtist;

class FeaturedArtistSeeder extends Seeder
{
    public function run(): void
    {
        $artists = [
            [
                'name' => 'Maria Santos',
                'tribe' => 'Tingguian',
                'craft' => 'Abel Textile Weaving',
                'description' => 'Master weaver from Abra, specializing in traditional Abel textiles with intricate patterns passed down through generations.',
                'image' => 'artisan1.jpg',
                'active' => true,
                'display_order' => 1
            ],
            [
                'name' => 'Juan dela Cruz',
                'tribe' => 'Tagalog',
                'craft' => 'Wood Carving',
                'description' => 'Expert woodcarver from Paete, creating stunning religious icons and decorative pieces using traditional techniques.',
                'image' => 'artisan2.jpg',
                'active' => true,
                'display_order' => 2
            ],
            [
                'name' => 'Rosa Reyes',
                'tribe' => 'Ilocano',
                'craft' => 'Burnay Pottery',
                'description' => 'Skilled potter from Ilocos, known for her beautiful burnay (earthenware) jars and traditional clay crafts.',
                'image' => 'artisan3.jpg',
                'active' => true,
                'display_order' => 3
            ]
        ];

        foreach ($artists as $artist) {
            FeaturedArtist::create($artist);
        }
    }
}
