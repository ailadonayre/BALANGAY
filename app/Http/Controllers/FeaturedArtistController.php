<?php
// app/Http/Controllers/FeaturedArtistController.php

namespace App\Http\Controllers;

use App\Models\FeaturedArtist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeaturedArtistController extends Controller
{
    public function index()
    {
        $artists = FeaturedArtist::where('active', true)
            ->orderBy('display_order')
            ->get();
        
        return response()->json($artists);
    }

    public function adminIndex()
    {
        $artists = FeaturedArtist::with('seller')
            ->orderBy('display_order')
            ->paginate(20);
        
        return response()->json($artists);
    }

    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'nullable|exists:sellers,id',
            'name' => 'required|string|max:255',
            'tribe' => 'required|string|max:100',
            'craft' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'display_order' => 'integer|min:0',
            'active' => 'boolean',
        ]);

        $data = $request->only(['seller_id', 'name', 'tribe', 'craft', 'description', 'display_order', 'active']);
        $data['admin_id'] = auth('admin')->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('featured-artists', 'public');
            $data['image'] = $path;
        }

        $artist = FeaturedArtist::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Featured artist added successfully',
            'artist' => $artist,
        ]);
    }

    public function update(Request $request, $id)
    {
        $artist = FeaturedArtist::findOrFail($id);

        $request->validate([
            'seller_id' => 'nullable|exists:sellers,id',
            'name' => 'required|string|max:255',
            'tribe' => 'required|string|max:100',
            'craft' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'display_order' => 'integer|min:0',
            'active' => 'boolean',
        ]);

        $data = $request->only(['seller_id', 'name', 'tribe', 'craft', 'description', 'display_order', 'active']);

        if ($request->hasFile('image')) {
            if ($artist->image) {
                Storage::disk('public')->delete($artist->image);
            }
            $path = $request->file('image')->store('featured-artists', 'public');
            $data['image'] = $path;
        }

        $artist->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Featured artist updated successfully',
            'artist' => $artist,
        ]);
    }

    public function destroy($id)
    {
        $artist = FeaturedArtist::findOrFail($id);
        
        if ($artist->image) {
            Storage::disk('public')->delete($artist->image);
        }
        
        $artist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Featured artist removed successfully',
        ]);
    }
}