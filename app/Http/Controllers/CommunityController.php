<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeaturedCommunity;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = FeaturedCommunity::where('active', true)
            ->orderBy('display_order')
            ->get()
            ->map(function($community) {
                return [
                    'id' => $community->id,
                    'name' => $community->name,
                    'region' => $community->region,
                    'image' => $community->image,
                    'history' => $community->description
                ];
            });

        return response()->json($communities);
    }

    public function show($id)
    {
        $community = FeaturedCommunity::where('active', true)
            ->where('id', $id)
            ->first();
        
        if (!$community) {
            return response()->json(['error' => 'Community not found'], 404);
        }

        return response()->json([
            'id' => $community->id,
            'name' => $community->name,
            'region' => $community->region,
            'image' => $community->image,
            'history' => $community->description
        ]);
    }
}
