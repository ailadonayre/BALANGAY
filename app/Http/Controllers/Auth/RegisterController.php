<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $role = $request->input('role', 'user');

        if ($role === 'seller') {
            return $this->registerSeller($request);
        }

        return $this->registerUser($request);
    }

    protected function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect' => route('home'),
        ]);
    }

    protected function registerSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sellers',
            'phone_number' => 'required|string|max:20',
            'indigenous_tribe' => 'required|string|max:100',
            'seller_type' => 'required|in:solo,enterprise',
            'shop_name' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $seller = Seller::create([
            'artisan_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'indigenous_tribe' => $request->indigenous_tribe,
            'seller_type' => $request->seller_type,
            'shop_name' => $request->shop_name,
            'password' => Hash::make($request->password),
            'verification_status' => 'pending',
        ]);

        Auth::guard('seller')->login($seller);

        return response()->json([
            'success' => true,
            'message' => 'Seller registration successful! Your account is pending approval.',
            'redirect' => route('seller.dashboard'),
        ]);
    }
}