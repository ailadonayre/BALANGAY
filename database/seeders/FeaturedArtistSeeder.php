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
                'name' => 'Amparo Balansi Mabanag',
                'tribe' => 'T\'boli',
                'craft' => 'T\'nalak Weaving',
                'description' => 'Master T\'boli weaver who has dedicated her life to preserving the ancient art of t\'nalak weaving. Her intricate patterns tell stories of ancestors and spiritual beliefs.',
                'image' => 'Amparo-Balansi-Mabanag.jpg',
                'active' => true,
                'display_order' => 1
            ],
            [
                'name' => 'Eduardo Mutuc',
                'tribe' => 'Ifugao',
                'craft' => 'Metal Smithing',
                'description' => 'Legendary Ifugao metal smith and National Living Treasure. His mastery of traditional metalworking techniques has made him one of the most respected artisans in the Philippines.',
                'image' => 'Eduardo-Mutuc.jpg',
                'active' => true,
                'display_order' => 2
            ],
            [
                'name' => 'Magdalena Gamayo',
                'tribe' => 'Ilocano',
                'craft' => 'Inabel Weaving',
                'description' => 'Master Inabel weaver from Ilocos region. She leads a cooperative of weavers, empowering women in her community while preserving their traditional craft.',
                'image' => 'Magdalena-Gamayo.jpeg',
                'active' => true,
                'display_order' => 3
            ]
        ];

        foreach ($artists as $artist) {
            FeaturedArtist::create($artist);
        }
    }
}
