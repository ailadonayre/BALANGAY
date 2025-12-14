<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SELLERS ===\n";
$sellers = DB::table('sellers')->select('id', 'artisan_name', 'email')->get();
foreach ($sellers as $seller) {
    echo "ID: {$seller->id} - {$seller->artisan_name} ({$seller->email})\n";
}

echo "\n=== PRODUCTS BY SELLER ===\n";
$products = DB::table('products')
    ->join('sellers', 'products.seller_id', '=', 'sellers.id')
    ->select('products.id', 'products.name', 'products.seller_id', 'sellers.artisan_name')
    ->orderBy('products.seller_id')
    ->get();

foreach ($products as $product) {
    echo "Product ID {$product->id}: {$product->name} - Seller {$product->seller_id} ({$product->artisan_name})\n";
}
