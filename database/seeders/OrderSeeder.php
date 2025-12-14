<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there's at least one user
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $products = Product::all();
        if ($products->isEmpty()) return;

        // Create sample orders with items
        for ($i = 0; $i < 8; $i++) {
            DB::beginTransaction();
            try {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'status' => ['pending', 'completed', 'processing'][array_rand(['pending', 'completed', 'processing'])],
                    'shipping_address' => '123 Sample St, Test City',
                    'payment_method' => 'card',
                    'payment_status' => 'paid',
                ]);

                // Add 1-3 items per order
                $numItems = rand(1, 3);
                $total = 0;
                for ($j = 0; $j < $numItems; $j++) {
                    $product = $products->random();
                    $qty = rand(1, 3);
                    $unit = $product->price;
                    $subtotal = $unit * $qty;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'seller_id' => $product->seller_id,
                        'quantity' => $qty,
                        'unit_price' => $unit,
                        'subtotal' => $subtotal,
                    ]);

                    $total += $subtotal;
                }

                $order->total_amount = $total;
                $order->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                continue;
            }
        }
    }
}
