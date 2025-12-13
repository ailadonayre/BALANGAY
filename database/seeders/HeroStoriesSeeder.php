<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroStoriesSeeder extends Seeder
{
    public function run()
    {
        $stories = [
            [
                'title' => 'Preserving T\'nalak Traditions',
                'author_name' => 'Amparo Balansi Mabanag',
                'tribe' => 'T\'boli',
                'excerpt' => 'How T\'boli dreamweavers keep ancient textile art alive',
                'content' => 'Amparo Balansi Mabanag is a master T\'boli weaver who has dedicated her life to preserving the ancient art of t\'nalak weaving. For over forty years, she has created intricate patterns that tell stories of her ancestors and spiritual beliefs. Each piece takes months to complete, using traditional tie-dyeing techniques passed down through generations. Amparo\'s work has gained international recognition, yet she remains committed to teaching younger generations the sacred knowledge embedded in every thread. Her t\'nalak pieces are not merely fabric—they are living records of T\'boli history, spirituality, and artistic excellence. Through her dedication, the world has come to recognize the T\'boli people as master artists and guardians of an irreplaceable cultural heritage.',
                'image' => 'Amparo-Balansi-Mabanag.jpg',
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Art of Metal Smithing',
                'author_name' => 'Eduardo Mutuc',
                'tribe' => 'Ifugao',
                'excerpt' => 'Eduardo Mutuc\'s journey to becoming a National Living Treasure',
                'content' => 'Eduardo Mutuc is a legendary Ifugao metal smith who was recognized as a National Living Treasure by the Philippine government. His mastery of traditional metalworking techniques, passed down through his family for countless generations, has made him one of the most respected artisans in the Philippines. Eduardo\'s creations range from traditional ceremonial items to contemporary artistic pieces, all crafted using age-old methods. Despite the availability of modern tools and materials, he continues to work with handforged techniques, believing that the soul of the craft lies in the direct contact between artisan and material. His workshop has become a gathering place for young artisans eager to learn the secrets of Ifugao metalwork. Eduardo\'s legacy extends beyond his creations; he is a living link to an ancient tradition that continues to inspire artists worldwide.',
                'image' => 'Eduardo-Mutuc.jpg',
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Weaving Community Together',
                'author_name' => 'Magdalena Gamayo',
                'tribe' => 'Ilocano',
                'excerpt' => 'Inabel weavers creating economic opportunities in Ilocos',
                'content' => 'Magdalena Gamayo is a master Inabel weaver from the Ilocos region whose work has transformed her community\'s economic landscape. Inabel, also known as Abel Iloco, is a handwoven textile that represents the cultural heritage of the Ilocano people. Magdalena leads a cooperative of weavers, empowering women in her community to earn sustainable income while preserving their craft. Her commitment to fair wages and ethical production has made her products sought after by conscious consumers worldwide. Magdalena\'s innovative approach blends traditional patterns with contemporary designs, making Inabel relevant to modern markets. Through her leadership, she has helped establish her village as a center of textile excellence, creating opportunities for younger artisans to learn and thrive. Her work demonstrates how traditional crafts can be vehicles for economic empowerment and cultural preservation.',
                'image' => 'Magdalena-Gamayo.jpeg',
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert only if stories don't exist
        foreach ($stories as $story) {
            $exists = DB::table('stories')
                ->where('title', $story['title'])
                ->exists();
                
            if (!$exists) {
                DB::table('stories')->insert($story);
            }
        }

        $this->command->info('Hero stories seeded successfully!');
    }
}
