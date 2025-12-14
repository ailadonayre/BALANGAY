<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Story;
use App\Models\Donation;
use App\Models\FeaturedArtist;
use App\Models\FeaturedCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_sellers' => Seller::count(),
            'verified_sellers' => Seller::where('verification_status', 'approved')->count(),
            'pending_sellers' => Seller::where('verification_status', 'pending')->count(),
            'total_products' => Product::count(),
            'pending_products' => Product::where('approval_status', 'pending')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'artisans_supported' => Seller::where('verification_status', 'approved')->count(),
            'products_sold' => OrderItem::sum('quantity'),
            'income_provided' => OrderItem::sum('subtotal'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function getAnalytics()
    {
        try {
            $analytics = [
                // User Analytics
                'total_users' => User::count(),
                
                // Seller Analytics
                'total_sellers' => Seller::count(),
                'verified_sellers' => Seller::where('verification_status', 'approved')->count(),
                'pending_sellers' => Seller::where('verification_status', 'pending')->count(),
                'sellers_by_tribe' => Seller::selectRaw('indigenous_tribe, count(*) as count')
                    ->groupBy('indigenous_tribe')
                    ->get(),
                
                // Product Analytics
                'total_products' => Product::count(),
                'approved_products' => Product::where('approval_status', 'approved')->count(),
                'pending_products' => Product::where('approval_status', 'pending')->count(),
                
                // Order Analytics
                'total_orders' => Order::count(),
                'orders_this_month' => Order::whereMonth('created_at', now()->month)->count(),
                'total_revenue' => OrderItem::sum('subtotal') ?? 0,
                'revenue_this_month' => OrderItem::whereHas('order', function($q) {
                    $q->whereMonth('created_at', now()->month);
                })->sum('subtotal') ?? 0,
                
                // Homepage Stats
                'artisans_supported' => Seller::where('verification_status', 'approved')->count(),
                'products_sold' => OrderItem::sum('quantity') ?? 0,
                'income_provided' => OrderItem::sum('subtotal') ?? 0,
                'orders_count' => Order::count(),
                'artists_onboarded' => FeaturedArtist::count(),
                // Time series (last 6 months)
                'monthly_revenue' => [],
                'monthly_orders' => [],
            ];

            // Build last 6 months series
            $monthlyRevenue = [];
            $monthlyOrders = [];
            for ($i = 5; $i >= 0; $i--) {
                $m = now()->subMonths($i);
                $label = $m->format('M Y');

                $revenue = Order::whereYear('created_at', $m->year)
                    ->whereMonth('created_at', $m->month)
                    ->where('status', 'completed')
                    ->sum('total_amount');

                $orders = Order::whereYear('created_at', $m->year)
                    ->whereMonth('created_at', $m->month)
                    ->count();

                $monthlyRevenue[] = ['label' => $label, 'value' => (float) $revenue];
                $monthlyOrders[] = ['label' => $label, 'value' => (int) $orders];
            }

            $analytics['monthly_revenue'] = $monthlyRevenue;
            $analytics['monthly_orders'] = $monthlyOrders;
            return response()->json($analytics);
        } catch (\Exception $e) {
            Log::error('Analytics Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // User Management
    public function getUsers()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->get();
            return response()->json($users);
        } catch (\Exception $e) {
            Log::error('Get Users Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    // Seller Management
    public function getSellers(Request $request)
    {
        try {
            $query = Seller::query();

            if ($request->has('status')) {
                $query->where('verification_status', $request->status);
            }

            if ($request->has('tribe')) {
                $query->where('indigenous_tribe', $request->tribe);
            }

            $sellers = $query->orderBy('created_at', 'desc')->get();
            return response()->json($sellers);
        } catch (\Exception $e) {
            Log::error('Get Sellers Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateSellerStatus(Request $request, $id)
    {
        $request->validate([
            'verification_status' => 'required|in:pending,approved,rejected',
        ]);

        $seller = Seller::findOrFail($id);
        $seller->verification_status = $request->verification_status;
        $seller->save();

        return response()->json([
            'success' => true,
            'message' => 'Seller status updated successfully'
        ]);
    }

    public function deleteSeller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();
        return response()->json(['success' => true, 'message' => 'Seller deleted successfully']);
    }

    // Product Management
    public function getProducts(Request $request)
    {
        try {
            $query = Product::with('seller');

            if ($request->has('status')) {
                $query->where('approval_status', $request->status);
            }

            $products = $query->orderBy('created_at', 'desc')->get();
            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Get Products Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateProductStatus(Request $request, $id)
    {
        $request->validate([
            'approval_status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'required_if:approval_status,rejected',
        ]);

        $product = Product::findOrFail($id);
        $product->approval_status = $request->approval_status;
        $product->rejection_reason = $request->rejection_reason;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully'
        ]);
    }

    public function toggleFeaturedProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->featured = !$product->featured;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product featured status updated'
        ]);
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
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
    }

    // Story Management
    public function getStories()
    {
        try {
            $stories = Story::orderBy('created_at', 'desc')->get();
            return response()->json($stories);
        } catch (\Exception $e) {
            Log::error('Get Stories Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createStory(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'tribe' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/stories'), $filename);
            $imagePath = $filename;
        }

        $story = Story::create([
            'admin_id' => auth()->guard('admin')->id(),
            'title' => $request->title,
            'author_name' => $request->author_name,
            'excerpt' => $request->excerpt,
            'content' => $request->input('content'),
            'tribe' => $request->tribe,
            'image' => $imagePath,
            'published' => $request->published ?? false,
            'published_at' => $request->published ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Story created successfully',
            'story' => $story
        ]);
    }

    public function updateStory(Request $request, $id)
    {
        $story = Story::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'tribe' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($story->image && file_exists(public_path('assets/stories/' . $story->image))) {
                unlink(public_path('assets/stories/' . $story->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/stories'), $filename);
            $story->image = $filename;
        }

        $story->update([
            'title' => $request->title,
            'author_name' => $request->author_name,
            'excerpt' => $request->excerpt,
            'content' => $request->input('content'),
            'tribe' => $request->tribe,
            'published' => $request->published ?? $story->published,
            'published_at' => $request->published && !$story->published_at ? now() : $story->published_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Story updated successfully',
            'story' => $story
        ]);
    }

    public function deleteStory($id)
    {
        $story = Story::findOrFail($id);
        
        // Delete image if exists
        if ($story->image && file_exists(public_path('assets/stories/' . $story->image))) {
            unlink(public_path('assets/stories/' . $story->image));
        }

        $story->delete();
        return response()->json(['success' => true, 'message' => 'Story deleted successfully']);
    }

    // Donation Management
    public function getDonations()
    {
        try {
            $donations = Donation::orderBy('created_at', 'desc')->get();
            return response()->json($donations);
        } catch (\Exception $e) {
            Log::error('Get Donations Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createDonation(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'nullable|numeric|min:0',
            'tribe' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/donations'), $filename);
            $imagePath = $filename;
        }

        $donation = Donation::create([
            'admin_id' => auth()->guard('admin')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'tribe' => $request->tribe,
            'image' => $imagePath,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Donation initiative created successfully',
            'donation' => $donation
        ]);
    }

    public function updateDonation(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'nullable|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'tribe' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,completed,paused',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($donation->image && file_exists(public_path('assets/donations/' . $donation->image))) {
                unlink(public_path('assets/donations/' . $donation->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/donations'), $filename);
            $donation->image = $filename;
        }

        $donation->update([
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount ?? $donation->current_amount,
            'tribe' => $request->tribe,
            'status' => $request->status ?? $donation->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Donation updated successfully',
            'donation' => $donation
        ]);
    }

    public function deleteDonation($id)
    {
        $donation = Donation::findOrFail($id);
        
        if ($donation->image && file_exists(public_path('assets/donations/' . $donation->image))) {
            unlink(public_path('assets/donations/' . $donation->image));
        }

        $donation->delete();
        return response()->json(['success' => true, 'message' => 'Donation deleted successfully']);
    }

    // Featured Artist Management
    public function getFeaturedArtists()
    {
        try {
            $artists = FeaturedArtist::with(['seller', 'admin'])
                ->orderBy('display_order')
                ->get();
            return response()->json($artists);
        } catch (\Exception $e) {
            Log::error('Get Featured Artists Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createFeaturedArtist(Request $request)
    {
        $request->validate([
            'seller_id' => 'nullable|exists:sellers,id',
            'name' => 'required|string|max:255',
            'tribe' => 'required|string|max:100',
            'craft' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'display_order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/artisans'), $filename);
            $imagePath = $filename;
        }

        $artist = FeaturedArtist::create([
            'admin_id' => auth()->guard('admin')->id(),
            'seller_id' => $request->seller_id,
            'name' => $request->name,
            'tribe' => $request->tribe,
            'craft' => $request->craft,
            'description' => $request->description,
            'image' => $imagePath,
            'display_order' => $request->display_order ?? 0,
            'active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Featured artist added successfully',
            'artist' => $artist
        ]);
    }

    public function updateFeaturedArtist(Request $request, $id)
    {
        $artist = FeaturedArtist::findOrFail($id);

        $request->validate([
            'seller_id' => 'nullable|exists:sellers,id',
            'name' => 'required|string|max:255',
            'tribe' => 'required|string|max:100',
            'craft' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'display_order' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($artist->image && file_exists(public_path('assets/artisans/' . $artist->image))) {
                unlink(public_path('assets/artisans/' . $artist->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/artisans'), $filename);
            $artist->image = $filename;
        }

        $artist->update([
            'seller_id' => $request->seller_id,
            'name' => $request->name,
            'tribe' => $request->tribe,
            'craft' => $request->craft,
            'description' => $request->description,
            'display_order' => $request->display_order ?? $artist->display_order,
            'active' => $request->active ?? $artist->active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Featured artist updated successfully',
            'artist' => $artist
        ]);
    }

    public function deleteFeaturedArtist($id)
    {
        $artist = FeaturedArtist::findOrFail($id);
        
        if ($artist->image && file_exists(public_path('assets/artisans/' . $artist->image))) {
            unlink(public_path('assets/artisans/' . $artist->image));
        }

        $artist->delete();
        return response()->json(['success' => true, 'message' => 'Featured artist deleted successfully']);
    }

    // Featured Communities Management
    public function getFeaturedCommunities()
    {
        try {
            $communities = FeaturedCommunity::orderBy('display_order')->orderBy('created_at', 'desc')->get();
            return response()->json($communities);
        } catch (\Exception $e) {
            Log::error('Get Featured Communities Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createFeaturedCommunity(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'display_order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/tribes'), $filename);
            $imagePath = $filename;
        }

        $community = FeaturedCommunity::create([
            'name' => $request->name,
            'region' => $request->region,
            'description' => $request->description,
            'image' => $imagePath,
            'display_order' => $request->display_order ?? 0,
            'active' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Featured community created successfully',
            'community' => $community
        ]);
    }

    public function updateFeaturedCommunity(Request $request, $id)
    {
        $community = FeaturedCommunity::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'region' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'display_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($community->image && file_exists(public_path('assets/tribes/' . $community->image))) {
                unlink(public_path('assets/tribes/' . $community->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/tribes'), $filename);
            $community->image = $filename;
        }

        $community->update([
            'name' => $request->name ?? $community->name,
            'region' => $request->region ?? $community->region,
            'description' => $request->description,
            'display_order' => $request->display_order ?? $community->display_order,
            'active' => $request->active ?? $community->active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Featured community updated successfully',
            'community' => $community
        ]);
    }

    public function deleteFeaturedCommunity($id)
    {
        $community = FeaturedCommunity::findOrFail($id);
        
        if ($community->image && file_exists(public_path('assets/tribes/' . $community->image))) {
            unlink(public_path('assets/tribes/' . $community->image));
        }

        $community->delete();
        return response()->json(['success' => true, 'message' => 'Featured community deleted successfully']);
    }
}