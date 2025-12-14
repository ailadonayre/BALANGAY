<?php
// Test seller functionality
require __DIR__ . '/bootstrap/app.php';

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    
    echo "✓ App initialized successfully\n";
    
    // Check if Seller model exists
    $seller = \App\Models\Seller::first();
    if ($seller) {
        echo "✓ Seller found: " . $seller->artisan_name . "\n";
        echo "  - Email: " . $seller->email . "\n";
        echo "  - Community: " . $seller->community . "\n";
    } else {
        echo "! No sellers in database yet\n";
    }
    
    // Check auth configuration
    echo "\n✓ Auth configuration:\n";
    echo "  - Guards configured: " . implode(", ", array_keys(config('auth.guards'))) . "\n";
    echo "  - Providers configured: " . implode(", ", array_keys(config('auth.providers'))) . "\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
