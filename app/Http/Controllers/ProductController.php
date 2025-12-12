<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('seller')
            ->where('stock', '>', 0)
            ->where('approval_status', 'approved')
            ->get();
        
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with(['seller', 'orderItems'])
            ->where('approval_status', 'approved')
            ->findOrFail($id);
        
        return response()->json($product);
    }

    public function search(Request $request)
    {
        $query = Product::with('seller')
            ->where('approval_status', 'approved');

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
            ->distinct()
            ->pluck('category');
        return response()->json($categories);
    }

    public function getCommunities()
    {
        $communities = Product::where('approval_status', 'approved')
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
            ->get();
        
        return response()->json(['data' => $products]);
    }

    public function getFeatured()
    {
        $products = Product::with('seller')
            ->where('featured', true)
            ->where('approval_status', 'approved')
            ->where('stock', '>', 0)
            ->get();
        
        return response()->json($products);
    }
}