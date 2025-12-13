<?php
// Load Laravel bootstrap
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

// Check for existing admins
$admins = Admin::all();
echo "Existing admins: " . $admins->count() . "\n";
foreach ($admins as $admin) {
    echo "  - Username: {$admin->username}, Email: {$admin->email}\n";
}

if ($admins->count() === 0) {
    echo "\nNo admins found. Creating one...\n";
    $admin = Admin::create([
        'username' => 'admin',
        'email' => 'admin@balangay.com',
        'password' => Hash::make('admin123'),
        'full_name' => 'Administrator'
    ]);
    echo "Admin created:\n";
    echo "  - Username: {$admin->username}\n";
    echo "  - Email: {$admin->email}\n";
    echo "  - Password: admin123\n";
}
?>
