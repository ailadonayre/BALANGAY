<?php
// Activate all featured communities
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Activate all communities
$updated = DB::table('featured_communities')
    ->where('active', false)
    ->update(['active' => true]);

$total = DB::table('featured_communities')->count();

echo "✓ Updated {$updated} inactive communities\n";
echo "✓ Total active communities: {$total}\n";
echo "\nAll featured communities are now active and will show up on the communities page!\n";
