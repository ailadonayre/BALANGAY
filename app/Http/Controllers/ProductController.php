<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Story;
use App\Models\FeaturedArtist;
use App\Models\FeaturedCommunity;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('seller')
            ->where('stock', '>', 0)
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->get();
        
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with(['seller', 'orderItems'])
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->findOrFail($id);
        
        return response()->json($product);
    }

    public function search(Request $request)
    {
        $query = Product::with('seller')
            ->where('approval_status', 'approved')
            ->where('is_active', true);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%')
                ->orWhere('description', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('community')) {
            $query->where('community', $request->community);
        }

        if ($request->filled('sort')) {
            match($request->sort) {
                'price-asc' => $query->orderBy('price', 'asc'),
                'price-desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->orderBy('created_at', 'desc'),
                'popular' => $query->orderBy('stock', 'desc'),
                default => $query->orderBy('created_at', 'desc')
            };
        }

        $products = $query->paginate(12);
        
        return response()->json($products);
    }

    public function getCategories()
    {
        $categories = Product::where('approval_status', 'approved')
            ->where('is_active', true)
            ->distinct()
            ->pluck('category');
        return response()->json($categories);
    }

    public function getCommunities()
    {
        $communities = Product::where('approval_status', 'approved')
            ->where('is_active', true)
            ->distinct()
            ->pluck('community');
        return response()->json($communities);
    }

    public function getByCategory($category)
    {
        $products = Product::with('seller')
            ->where('category', $category)
            ->where('stock', '>', 0)
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->get();
        
        return response()->json(['data' => $products]);
    }

    public function getFeatured()
    {
        $products = Product::with('seller')
            ->where('featured', true)
            ->where('approval_status', 'approved')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->get();
        
        return response()->json($products);
    }

    public function getPublicStories()
    {
        $stories = \App\Models\Story::where('published', true)
            ->orderBy('published_at', 'desc')
            ->get();
        
        return response()->json($stories);
    }

    public function getPublicFeaturedArtists()
    {
        $artists = \App\Models\FeaturedArtist::where('active', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        return response()->json($artists);
    }

    public function getPublicFeaturedCommunities()
    {
        $communities = FeaturedCommunity::where('active', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($communities);
    }

    public function getPublicAnalytics()
    {
        try {
            $analytics = [
                'artisans_supported' => \App\Models\Seller::where('verification_status', 'approved')->count(),
                'artists_onboarded' => \App\Models\Seller::count(),
                'income_provided' => \App\Models\OrderItem::sum('subtotal') ?? 0,
                'products_sold' => \App\Models\OrderItem::sum('quantity') ?? 0,
            ];

            return response()->json($analytics);
        } catch (\Exception $e) {
            \Log::error('Public Analytics Error: ' . $e->getMessage());
            return response()->json([
                'artisans_supported' => 0,
                'artists_onboarded' => 0,
                'income_provided' => 0,
                'products_sold' => 0,
            ]);
        }
    }
}