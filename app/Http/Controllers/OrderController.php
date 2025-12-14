<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,gcash,bank_transfer',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string'
        ]);

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.seller')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 422);
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($cartItems as $cartItem) {
            $subtotal = $cartItem->quantity * $cartItem->product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'seller_id' => $cartItem->product->seller_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->product->price,
                'subtotal' => $subtotal,
            ]);

            // Update stock
            $cartItem->product->decrement('stock', $cartItem->quantity);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order_id' => $order->id,
            'order' => $order->load('items.product')
        ]);
    }

    public function getOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function getOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order);
    }
}