<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = [
            [
                'id' => 1,
                'name' => 'Ati',
                'region' => 'Panay Island',
                'image' => 'ati.png',
                'history' => 'The Ati are one of the oldest indigenous groups in the Philippines, with a history spanning thousands of years. Known as skilled hunters and gatherers, they have maintained their unique cultural traditions despite the challenges of modernization. The Ati continue to preserve their ancestral knowledge of medicinal plants and traditional hunting techniques.'
            ],
            [
                'id' => 2,
                'name' => 'Igorot',
                'region' => 'Cordillera',
                'image' => 'igorot.png',
                'history' => 'The Igorot people of the Cordillera are renowned for their engineering prowess, particularly in rice terracing. Their intricate knowledge systems have allowed them to create agricultural marvels that have stood for centuries. Igorot communities are also famous for their elaborate textiles, metalwork, and their strong communal traditions of "bayanihan."'
            ],
            [
                'id' => 3,
                'name' => 'Lumad',
                'region' => 'Mindanao',
                'image' => 'lumad.png',
                'history' => 'The Lumad of Mindanao encompasses several distinct groups united by their forest-based heritage. They are skilled in weaving, beadwork, and traditional medicine. Lumad communities have developed sophisticated irrigation systems and sustainable forest management practices that reflect their deep understanding of the natural environment.'
            ],
            [
                'id' => 4,
                'name' => 'Mangyan',
                'region' => 'Mindoro',
                'image' => 'mangyan.png',
                'history' => 'The Mangyan people of Mindoro are known for their exceptional craftsmanship and their practice of baybayin, an ancient Filipino script. They have preserved this writing system and continue to use it in their cultural practices. Mangyan communities are also renowned for their intricate beadwork and basket weaving that showcases their artistic heritage.'
            ],
            [
                'id' => 5,
                'name' => 'T\'boli',
                'region' => 'South Cotabato',
                'image' => 'tboli.png',
                'history' => 'The T\'boli people are master weavers, famous for their t\'nalak fabric created through an intricate tie-dyeing process. Their designs represent stories of their ancestors and spiritual beliefs. T\'boli weavers are recognized nationally and internationally for their exquisite artistry and cultural significance.'
            ],
            [
                'id' => 6,
                'name' => 'Kalinga',
                'region' => 'Cordillera',
                'image' => 'kalinga.png',
                'history' => 'The Kalinga people are known for their distinctive tattooing traditions and their role as historical peace-pact holders. Their traditional body art is a mark of honor and status within the community. Kalinga artisans are also skilled in metalwork, weaving, and the creation of traditional musical instruments.'
            ],
            [
                'id' => 7,
                'name' => 'Ifugao',
                'region' => 'Cordillera',
                'image' => 'ifugao.png',
                'history' => 'The Ifugao are custodians of the world-renowned Banaue Rice Terraces, a UNESCO World Heritage Site. Their sophisticated knowledge of hydraulic engineering and sustainable agriculture has been passed down through generations. Ifugao culture is rich in oral traditions, traditional crafts, and spiritual ceremonies.'
            ],
            [
                'id' => 8,
                'name' => 'Maguindanao',
                'region' => 'Mindanao',
                'image' => 'maguindanao.png',
                'history' => 'The Maguindanao people have a rich Islamic heritage and are skilled in traditional metalwork, particularly in the creation of the legendary kris or kampilan swords. They are also known for their vibrant textiles, intricate malong weaving, and their contributions to Philippine maritime history.'
            ]
        ];

        return response()->json($communities);
    }

    public function show($id)
    {
        $communities = collect($this->getCommunities())->firstWhere('id', (int)$id);
        
        if (!$communities) {
            return response()->json(['error' => 'Community not found'], 404);
        }

        return response()->json($communities);
    }

    private function getCommunities()
    {
        return [
            [
                'id' => 1,
                'name' => 'Ati',
                'region' => 'Panay Island',
                'image' => 'ati.png',
                'history' => 'The Ati are one of the oldest indigenous groups in the Philippines, with a history spanning thousands of years. Known as skilled hunters and gatherers, they have maintained their unique cultural traditions despite the challenges of modernization. The Ati continue to preserve their ancestral knowledge of medicinal plants and traditional hunting techniques.'
            ],
            [
                'id' => 2,
                'name' => 'Igorot',
                'region' => 'Cordillera',
                'image' => 'igorot.png',
                'history' => 'The Igorot people of the Cordillera are renowned for their engineering prowess, particularly in rice terracing. Their intricate knowledge systems have allowed them to create agricultural marvels that have stood for centuries. Igorot communities are also famous for their elaborate textiles, metalwork, and their strong communal traditions of "bayanihan."'
            ],
            [
                'id' => 3,
                'name' => 'Lumad',
                'region' => 'Mindanao',
                'image' => 'lumad.png',
                'history' => 'The Lumad of Mindanao encompasses several distinct groups united by their forest-based heritage. They are skilled in weaving, beadwork, and traditional medicine. Lumad communities have developed sophisticated irrigation systems and sustainable forest management practices that reflect their deep understanding of the natural environment.'
            ],
            [
                'id' => 4,
                'name' => 'Mangyan',
                'region' => 'Mindoro',
                'image' => 'mangyan.png',
                'history' => 'The Mangyan people of Mindoro are known for their exceptional craftsmanship and their practice of baybayin, an ancient Filipino script. They have preserved this writing system and continue to use it in their cultural practices. Mangyan communities are also renowned for their intricate beadwork and basket weaving that showcases their artistic heritage.'
            ],
            [
                'id' => 5,
                'name' => 'T\'boli',
                'region' => 'South Cotabato',
                'image' => 'tboli.png',
                'history' => 'The T\'boli people are master weavers, famous for their t\'nalak fabric created through an intricate tie-dyeing process. Their designs represent stories of their ancestors and spiritual beliefs. T\'boli weavers are recognized nationally and internationally for their exquisite artistry and cultural significance.'
            ],
            [
                'id' => 6,
                'name' => 'Kalinga',
                'region' => 'Cordillera',
                'image' => 'kalinga.png',
                'history' => 'The Kalinga people are known for their distinctive tattooing traditions and their role as historical peace-pact holders. Their traditional body art is a mark of honor and status within the community. Kalinga artisans are also skilled in metalwork, weaving, and the creation of traditional musical instruments.'
            ],
            [
                'id' => 7,
                'name' => 'Ifugao',
                'region' => 'Cordillera',
                'image' => 'ifugao.png',
                'history' => 'The Ifugao are custodians of the world-renowned Banaue Rice Terraces, a UNESCO World Heritage Site. Their sophisticated knowledge of hydraulic engineering and sustainable agriculture has been passed down through generations. Ifugao culture is rich in oral traditions, traditional crafts, and spiritual ceremonies.'
            ],
            [
                'id' => 8,
                'name' => 'Maguindanao',
                'region' => 'Mindanao',
                'image' => 'maguindanao.png',
                'history' => 'The Maguindanao people have a rich Islamic heritage and are skilled in traditional metalwork, particularly in the creation of the legendary kris or kampilan swords. They are also known for their vibrant textiles, intricate malong weaving, and their contributions to Philippine maritime history.'
            ]
        ];
    }
}
