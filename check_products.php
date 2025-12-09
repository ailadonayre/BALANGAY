<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Get product count
$products = \App\Models\Product::all();
echo "Total products in database: " . count($products) . "\n\n";

if (count($products) > 0) {
    echo "First 3 products:\n";
    foreach ($products->take(3) as $product) {
        echo "- {$product->name} (Seller: {$product->seller_id}, Price: {$product->price})\n";
    }
} else {
    echo "No products found!\n";
}

// Check sellers
$sellers = \App\Models\Seller::all();
echo "\nTotal sellers: " . count($sellers) . "\n";
foreach ($sellers as $seller) {
    echo "- {$seller->artisan_name} ({$seller->email}) - Products: " . $seller->products()->count() . "\n";
}
?>
