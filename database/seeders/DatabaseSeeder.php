<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'phone_number' => '1234567890',
        ]);

        // Run admin seeder
        $this->call(AdminSeeder::class);
        
        // Run product seeder
        $this->call(ProductSeeder::class);
        
        // Run seller seeder
        $this->call(SellerSeeder::class);
    }
}
