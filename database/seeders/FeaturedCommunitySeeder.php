<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeaturedCommunity;

class FeaturedCommunitySeeder extends Seeder
{
    public function run(): void
    {
        $communities = [
            [
                'name' => 'Ati',
                'region' => 'Panay Island',
                'description' => 'The Ati are one of the oldest indigenous groups in the Philippines. Known as skilled hunters and gatherers, they have maintained their unique cultural traditions and ancestral knowledge of medicinal plants and traditional hunting techniques.',
                'image' => 'ati.png',
                'active' => true,
                'display_order' => 1
            ],
            [
                'name' => 'Igorot',
                'region' => 'Cordillera',
                'description' => 'The Igorot people are renowned for their engineering prowess, particularly in rice terracing. Their intricate knowledge has created agricultural marvels and they are famous for their elaborate textiles and metalwork.',
                'image' => 'igorot.png',
                'active' => true,
                'display_order' => 2
            ],
            [
                'name' => 'Lumad',
                'region' => 'Mindanao',
                'description' => 'The Lumad of Mindanao are skilled in weaving, beadwork, and traditional medicine. They have developed sophisticated irrigation systems and sustainable forest management practices that reflect their deep understanding of nature.',
                'image' => 'lumad.png',
                'active' => true,
                'display_order' => 3
            ],
            [
                'name' => 'Mangyan',
                'region' => 'Mindoro',
                'description' => 'The Mangyan people have preserved their ancient script and traditional way of life. They are skilled in basket weaving and creating intricate beadwork, maintaining their cultural heritage through generations.',
                'image' => 'mangyan.png',
                'active' => true,
                'display_order' => 4
            ]
        ];

        foreach ($communities as $community) {
            FeaturedCommunity::create($community);
        }
    }
}
