<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Seller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:sellers,email',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,seller',
        ];

        // Add seller-specific validation
        if ($request->role === 'seller') {
            $rules['indigenous_tribe'] = 'required|string|max:100';
            $rules['seller_type'] = 'required|in:solo,enterprise';
            $rules['shop_name'] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ];

        if ($request->role === 'user') {
            $user = User::create(array_merge($data, [
                'full_name' => $request->full_name,
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'redirect' => route('home')
            ]);
        } else {
            $seller = Seller::create(array_merge($data, [
                'artisan_name' => $request->full_name,
                'indigenous_tribe' => $request->indigenous_tribe,
                'seller_type' => $request->seller_type,
                'shop_name' => $request->shop_name ?? $request->full_name . "'s Shop",
                'verification_status' => 'pending',
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Registration successful. Your account is pending verification.',
                'redirect' => route('seller.dashboard')
            ]);
        }
    }
}