<?php
// Check featured communities in database
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$communities = DB::table('featured_communities')->get();

echo "Total Featured Communities: " . $communities->count() . "\n\n";

foreach ($communities as $community) {
    echo "ID: {$community->id}\n";
    echo "Name: {$community->name}\n";
    echo "Region: {$community->region}\n";
    echo "Active: " . ($community->active ? 'YES' : 'NO') . "\n";
    echo "Display Order: {$community->display_order}\n";
    echo "Image: {$community->image}\n";
    echo "---\n";
}
