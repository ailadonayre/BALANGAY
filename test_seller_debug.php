<?php
// Test seller login directly

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Http\Kernel::class);

// Boot the application
$app->boot();

use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

echo "=== Seller Debug Info ===\n\n";

// Check sellers
$sellers = Seller::all();
echo "Total sellers in database: " . count($sellers) . "\n\n";

if (count($sellers) > 0) {
    foreach ($sellers as $seller) {
        echo "Seller: {$seller->artisan_name}\n";
        echo "  Email: {$seller->email}\n";
        echo "  ID: {$seller->id}\n";
        echo "  Verification Status: " . ($seller->verification_status ?? 'NULL') . "\n";
        echo "  Password Hash exists: " . (!empty($seller->password) ? 'YES' : 'NO') . "\n";
        
        // Test password verification
        $testPassword = 'password123';
        $passwordMatches = Hash::check($testPassword, $seller->password);
        echo "  Password 'password123' matches: " . ($passwordMatches ? 'YES' : 'NO') . "\n";
        echo "\n";
    }
} else {
    echo "No sellers found!\n";
}

// Also check if we can query by email
echo "\n=== Query Test ===\n";
$seller = Seller::where('email', 'maria@seller.com')->first();
if ($seller) {
    echo "Found seller by email (maria@seller.com): {$seller->artisan_name}\n";
} else {
    echo "Could not find seller with email maria@seller.com\n";
}
?>
