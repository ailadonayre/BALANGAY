<?php
// app/Http/Controllers/StoryController.php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::where('published', true)
            ->orderBy('published_at', 'desc')
            ->get();
        
        return response()->json($stories);
    }

    public function adminIndex()
    {
        $stories = Story::orderBy('created_at', 'desc')->paginate(20);
        return response()->json($stories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'tribe' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120',
            'published' => 'boolean',
        ]);

        $data = $request->only(['title', 'author_name', 'excerpt', 'content', 'tribe', 'published']);
        $data['admin_id'] = auth('admin')->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');
            $data['image'] = $path;
        }

        if ($request->published) {
            $data['published_at'] = now();
        }

        $story = Story::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Story created successfully',
            'story' => $story,
        ]);
    }

    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'tribe' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120',
            'published' => 'boolean',
        ]);

        $data = $request->only(['title', 'author_name', 'excerpt', 'content', 'tribe', 'published']);

        if ($request->hasFile('image')) {
            if ($story->image) {
                Storage::disk('public')->delete($story->image);
            }
            $path = $request->file('image')->store('stories', 'public');
            $data['image'] = $path;
        }

        if ($request->published && !$story->published) {
            $data['published_at'] = now();
        }

        $story->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Story updated successfully',
            'story' => $story,
        ]);
    }

    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        
        if ($story->image) {
            Storage::disk('public')->delete($story->image);
        }
        
        $story->delete();

        return response()->json([
            'success' => true,
            'message' => 'Story deleted successfully',
        ]);
    }
}