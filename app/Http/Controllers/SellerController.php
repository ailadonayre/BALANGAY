<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * Get seller's products
     */
    public function getProducts($sellerId)
    {
        try {
            $seller = Seller::findOrFail($sellerId);
            $products = $seller->products()->get();
            
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Seller not found'], 404);
        }
    }

    /**
     * Create a new product
     */
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
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
                'image' => $imagePath ?? 'default.jpg',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a product
     */
    public function updateProduct(Request $request, $productId)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'category' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $seller = Auth::guard('seller')->user();

        try {
            $product = Product::findOrFail($productId);

            // Verify seller owns this product
            if ($product->seller_id !== $seller->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            if ($request->hasFile('image')) {
                // Delete old image if it exists
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

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product
     */
    public function deleteProduct($productId)
    {
        $seller = Auth::guard('seller')->user();

        try {
            $product = Product::findOrFail($productId);

            // Verify seller owns this product
            if ($product->seller_id !== $seller->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Delete image if it exists
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
}
