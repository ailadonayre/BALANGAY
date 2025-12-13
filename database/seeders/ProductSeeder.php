<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Get sellers (they should be created by SellerSeeder first)
        $sellers = Seller::all();
        
        if ($sellers->isEmpty()) {
            // Create a default seller if none exist
            $sellers = [
                Seller::firstOrCreate(
                    ['email' => 'seller@example.com'],
                    [
                        'artisan_name' => 'Master Artisan',
                        'password' => bcrypt('password'),
                        'phone_number' => '09123456789',
                        'community' => 'Mindanao Weavers'
                    ]
                )
            ];
        }

        $products = [
            [
                'name' => 'Margarita Beaded Earrings',
                'description' => 'Beautiful handcrafted beaded earrings with intricate traditional designs.',
                'price' => 890,
                'image' => 'Margarita-Beaded-Earrings.webp',
                'category' => 'Jewelry',
                'community' => 'Coastal Artisans',
                'stock' => 15
            ],
            [
                'name' => 'Itneg Embroidered Jacket',
                'description' => 'Traditional hand-embroidered jacket featuring authentic Itneg patterns.',
                'price' => 3200,
                'image' => 'Itneg-Hand-Embroidered-Cropped-Jacket.webp',
                'category' => 'Clothing',
                'community' => 'Cordillera Weavers',
                'stock' => 8
            ],
            [
                'name' => 'Mother of Pearl Plate',
                'description' => 'Exquisite plate inlaid with mother of pearl, a masterpiece of craftsmanship.',
                'price' => 1450,
                'image' => 'Mother-of-Pearl-Plate.webp',
                'category' => 'Home Decor',
                'community' => 'Visayan Craftsmen',
                'stock' => 12
            ],
            [
                'name' => 'Jusi Fan',
                'description' => 'Elegant traditional fan made from jusi fabric with intricate designs.',
                'price' => 750,
                'image' => 'Jusi-Fan.webp',
                'category' => 'Accessories',
                'community' => 'Philippine Heritage',
                'stock' => 20
            ],
            [
                'name' => 'Bagobo Slip-on',
                'description' => 'Comfortable traditional Bagobo slip-on shoes with authentic craftsmanship.',
                'price' => 2100,
                'image' => 'Bagobo-Slip-on.jpg',
                'category' => 'Footwear',
                'community' => 'Mindanao Artisans',
                'stock' => 10
            ],
            [
                'name' => 'Abaca Handbag',
                'description' => 'Durable and stylish handbag woven from sustainable abaca fiber.',
                'price' => 2850,
                'image' => 'Abaca-Handbag.webp',
                'category' => 'Bags',
                'community' => 'Mindanao Weavers',
                'stock' => 18
            ],
            [
                'name' => 'Capiz Jewelry Box',
                'description' => 'Beautiful jewelry box adorned with capiz shells, perfect for storage and display.',
                'price' => 1650,
                'image' => 'Capiz-Square-Diamond-Jewelry-Box.webp',
                'category' => 'Home Decor',
                'community' => 'Visayan Craftsmen',
                'stock' => 14
            ],
            [
                'name' => 'Fresh Water Pearl Necklace',
                'description' => 'Elegant necklace featuring beautiful fresh water pearls in traditional design.',
                'price' => 4200,
                'image' => 'Fresh-Water-Pearl-Necklace.webp',
                'category' => 'Jewelry',
                'community' => 'Coastal Artisans',
                'stock' => 9
            ],
        ];

        foreach ($products as $index => $product) {
            $seller = $sellers[$index % count($sellers)];
            Product::create(array_merge($product, [
                'seller_id' => $seller->id,
                'approval_status' => 'approved'  // Mark as approved so it shows in shop
            ]));
        }
    }
}
