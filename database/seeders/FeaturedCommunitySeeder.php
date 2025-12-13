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
                'name' => 'Ifugao',
                'region' => 'Cordillera Administrative Region',
                'description' => 'The Ifugao people are renowned for their ancient rice terraces, carved into the mountains over 2,000 years ago. These terraces are a testament to their engineering prowess and sustainable agricultural practices.',
                'image' => 'tribe1.jpg',
                'active' => true,
                'display_order' => 1
            ],
            [
                'name' => 'T\'boli',
                'region' => 'South Cotabato, Mindanao',
                'description' => 'The T\'boli are known for their vibrant traditional clothing and intricate brassware. Their artistry is showcased in the famous t\'nalak cloth, woven from abaca fibers and dyed with natural colors.',
                'image' => 'tribe2.jpg',
                'active' => true,
                'display_order' => 2
            ],
            [
                'name' => 'Mangyan',
                'region' => 'Mindoro',
                'description' => 'The Mangyan people have preserved their ancient script and traditional way of life. They are skilled in basket weaving and creating intricate beadwork, maintaining their cultural heritage through generations.',
                'image' => 'tribe3.jpg',
                'active' => true,
                'display_order' => 3
            ],
            [
                'name' => 'Yakan',
                'region' => 'Basilan, Mindanao',
                'description' => 'The Yakan are master weavers known for their colorful textiles featuring geometric patterns. Their traditional face decorations and vibrant clothing make them one of the most visually distinctive indigenous groups.',
                'image' => 'tribe4.jpg',
                'active' => true,
                'display_order' => 4
            ]
        ];

        foreach ($communities as $community) {
            FeaturedCommunity::create($community);
        }
    }
}
