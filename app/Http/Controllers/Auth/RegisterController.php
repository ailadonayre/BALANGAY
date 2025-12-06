<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Seller;
use App\Models\Admin;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:sellers,email|unique:admins,email',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,seller,admin'
        ]);

        $data = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ];

        $user = match($request->role) {
            'user' => User::create(array_merge($data, ['full_name' => $request->full_name])),
            'seller' => Seller::create(array_merge($data, [
                'artisan_name' => $request->full_name,
                'community' => $request->community ?? 'Not specified'
            ])),
            'admin' => Admin::create(array_merge($data, ['username' => $request->username ?? explode('@', $request->email)[0]])),
        };

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'redirect' => route('home')
        ]);
    }
}