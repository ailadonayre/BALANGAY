<?php
// app/Http/Controllers/DonationController.php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($donations);
    }

    public function adminIndex()
    {
        $donations = Donation::orderBy('created_at', 'desc')->paginate(20);
        return response()->json($donations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'nullable|numeric|min:0',
            'tribe' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120',
            'status' => 'in:active,completed,paused',
        ]);

        $data = $request->only(['title', 'description', 'target_amount', 'tribe', 'status']);
        $data['admin_id'] = auth('admin')->id();
        $data['current_amount'] = 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('donations', 'public');
            $data['image'] = $path;
        }

        $donation = Donation::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Donation initiative created successfully',
            'donation' => $donation,
        ]);
    }

    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'nullable|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'tribe' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120',
            'status' => 'in:active,completed,paused',
        ]);

        $data = $request->only(['title', 'description', 'target_amount', 'current_amount', 'tribe', 'status']);

        if ($request->hasFile('image')) {
            if ($donation->image) {
                Storage::disk('public')->delete($donation->image);
            }
            $path = $request->file('image')->store('donations', 'public');
            $data['image'] = $path;
        }

        $donation->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Donation initiative updated successfully',
            'donation' => $donation,
        ]);
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        
        if ($donation->image) {
            Storage::disk('public')->delete($donation->image);
        }
        
        $donation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Donation initiative deleted successfully',
        ]);
    }
}