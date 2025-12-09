<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seller::create([
            'artisan_name' => 'Maria Santos',
            'email' => 'maria@seller.com',
            'phone_number' => '09123456789',
            'password' => Hash::make('password123'),
            'community' => 'Ifugao',
        ]);

        Seller::create([
            'artisan_name' => 'Juan Dela Cruz',
            'email' => 'juan@seller.com',
            'phone_number' => '09987654321',
            'password' => Hash::make('password123'),
            'community' => 'Ilocos',
        ]);

        Seller::create([
            'artisan_name' => 'Rosa Garcia',
            'email' => 'rosa@seller.com',
            'phone_number' => '09111111111',
            'password' => Hash::make('password123'),
            'community' => 'Mindanao',
        ]);
    }
}
