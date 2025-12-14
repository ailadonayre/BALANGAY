<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function dashboard()
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();
        
        $stats = [
            'total_products' => $seller->products()->count(),
            'approved_products' => $seller->approvedProducts()->count(),
            'pending_products' => $seller->pendingProducts()->count(),
            'total_sales' => $seller->orderItems()->sum('subtotal'),
            'orders_count' => $seller->orderItems()->distinct('order_id')->count(),
            'verification_status' => $seller->verification_status,
        ];

        return view('seller.dashboard', compact('stats'));
    }

    public function getProducts($sellerId)
    {
        try {
            $seller = Seller::findOrFail($sellerId);
            $products = $seller->products()->orderBy('created_at', 'desc')->get();
            
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Seller not found'], 404);
        }
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $seller = Auth::guard('seller')->user();

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/products'), $filename);
                $imagePath = $filename;
            }

            $product = Product::create([
                'seller_id' => $seller->id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category' => $request->category,
                'community' => $seller->indigenous_tribe ?? $seller->shop_name ?? 'Independent Artisan',
                'image' => $imagePath ?? 'default.jpg',
                'approval_status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully and pending approval',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProduct(Request $request, $productId)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'category' => 'sometimes|required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $seller = Auth::guard('seller')->user();

        try {
            $product = Product::findOrFail($productId);

            if ($product->seller_id !== $seller->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            if ($request->hasFile('image')) {
                if ($product->image && $product->image !== 'default.jpg') {
                    $oldPath = public_path('assets/products/' . $product->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/products'), $filename);
                $product->image = $filename;
            }

            $product->update($request->only('name', 'description', 'price', 'stock', 'category'));
            
            // Reset approval status when product is edited
            $product->approval_status = 'pending';
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully and pending re-approval',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteProduct($productId)
    {
        $seller = Auth::guard('seller')->user();

        try {
            $product = Product::findOrFail($productId);

            if ($product->seller_id !== $seller->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            if ($product->image && $product->image !== 'default.jpg') {
                $imagePath = public_path('assets/products/' . $product->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();

        $request->validate([
            'artisan_name' => 'sometimes|required|string|max:255',
            'shop_name' => 'sometimes|required|string|max:255',
            'shop_description' => 'nullable|string',
            'phone_number' => 'sometimes|required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {
                if ($seller->profile_picture && file_exists(public_path('assets/sellers/profiles/' . $seller->profile_picture))) {
                    unlink(public_path('assets/sellers/profiles/' . $seller->profile_picture));
                }

                $file = $request->file('profile_picture');
                $filename = 'profile_' . $seller->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/sellers/profiles'), $filename);
                $seller->profile_picture = $filename;
            }

            if ($request->hasFile('banner_image')) {
                if ($seller->banner_image && file_exists(public_path('assets/sellers/banners/' . $seller->banner_image))) {
                    unlink(public_path('assets/sellers/banners/' . $seller->banner_image));
                }

                $file = $request->file('banner_image');
                $filename = 'banner_' . $seller->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/sellers/banners'), $filename);
                $seller->banner_image = $filename;
            }

            $seller->update($request->only([
                'artisan_name',
                'shop_name',
                'shop_description',
                'phone_number',
                'address',
                'city',
                'province',
                'postal_code',
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'seller' => $seller
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAnalytics()
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();

        $analytics = [
            'total_products' => $seller->products()->count(),
            'approved_products' => $seller->approvedProducts()->count(),
            'pending_products' => $seller->pendingProducts()->count(),
            'rejected_products' => $seller->products()->where('approval_status', 'rejected')->count(),
            
            'total_sales' => $seller->orderItems()->sum('subtotal'),
            'total_orders' => $seller->orderItems()->distinct('order_id')->count(),
            'total_items_sold' => $seller->orderItems()->sum('quantity'),
            
            'sales_this_month' => $seller->orderItems()
                ->whereHas('order', function($query) {
                    $query->whereMonth('created_at', now()->month);
                })
                ->sum('subtotal'),
            
            'orders_this_month' => $seller->orderItems()
                ->whereHas('order', function($query) {
                    $query->whereMonth('created_at', now()->month);
                })
                ->distinct('order_id')
                ->count(),

            'best_selling_products' => $seller->products()
                ->withCount(['orderItems as total_sold' => function($query) {
                    $query->selectRaw('sum(quantity)');
                }])
                ->orderBy('total_sold', 'desc')
                ->take(5)
                ->get(),
        ];

        return response()->json($analytics);
    }

    public function getOrders()
    {
        /** @var Seller $seller */
        $seller = Auth::guard('seller')->user();

        $orders = OrderItem::with(['order.user', 'product'])
            ->where('seller_id', $seller->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('order_id');

        return response()->json($orders);
    }

    public function getProfile()
    {
        $seller = Auth::guard('seller')->user();
        return response()->json($seller);
    }

    public function updateBanner(Request $request)
    {
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $seller = Auth::guard('seller')->user();

        try {
            // Delete old banner if exists
            if ($seller->banner_image && file_exists(public_path('assets/sellers/banners/' . $seller->banner_image))) {
                unlink(public_path('assets/sellers/banners/' . $seller->banner_image));
            }

            // Create directories if they don't exist
            if (!file_exists(public_path('assets/sellers/banners'))) {
                mkdir(public_path('assets/sellers/banners'), 0755, true);
            }

            $file = $request->file('banner_image');
            $filename = 'banner_' . $seller->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/sellers/banners'), $filename);

            $seller->banner_image = $filename;
            $seller->save();

            return response()->json([
                'success' => true,
                'message' => 'Banner updated successfully',
                'banner_url' => asset('assets/sellers/banners/' . $filename)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating banner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $seller = Auth::guard('seller')->user();

        try {
            // Delete old profile picture if exists
            if ($seller->profile_picture && file_exists(public_path('assets/sellers/profiles/' . $seller->profile_picture))) {
                unlink(public_path('assets/sellers/profiles/' . $seller->profile_picture));
            }

            // Create directories if they don't exist
            if (!file_exists(public_path('assets/sellers/profiles'))) {
                mkdir(public_path('assets/sellers/profiles'), 0755, true);
            }

            $file = $request->file('profile_picture');
            $filename = 'profile_' . $seller->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/sellers/profiles'), $filename);

            $seller->profile_picture = $filename;
            $seller->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully',
                'profile_url' => asset('assets/sellers/profiles/' . $filename)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile picture: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get seller orders
    public function getSellerOrders()
    {
        $seller = Auth::guard('seller')->user();
        
        $orders = OrderItem::where('seller_id', $seller->id)
            ->with(['order', 'product'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('order_id')
            ->map(function ($items) {
                $firstItem = $items->first();
                $order = $firstItem->order;
                
                return [
                    'order_id' => $order->id,
                    'order_number' => $order->id,
                    'customer_name' => $order->customer_name ?? $order->user->name ?? 'N/A',
                    'customer_email' => $order->customer_email ?? $order->user->email ?? 'N/A',
                    'customer_phone' => $order->customer_phone ?? 'N/A',
                    'shipping_address' => $order->shipping_address,
                    'payment_method' => $order->payment_method,
                    'order_status' => $order->status,
                    'created_at' => $order->created_at,
                    'total_amount' => $items->sum('subtotal'),
                    'items' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_name' => $item->product->name,
                            'product_image' => $item->product->image,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->unit_price,
                            'subtotal' => $item->subtotal,
                        ];
                    })
                ];
            })
            ->values();
        
        return response()->json($orders);
    }

    // Update order status
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,to_ship,shipped,to_receive,completed,cancelled'
        ]);

        $seller = Auth::guard('seller')->user();
        
        // Find the order and verify seller has items in it
        $orderItems = OrderItem::where('order_id', $orderId)
            ->where('seller_id', $seller->id)
            ->get();
        
        if ($orderItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or unauthorized'
            ], 404);
        }

        // Update the main order status
        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully'
        ]);
    }
}