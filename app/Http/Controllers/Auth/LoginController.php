<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Seller;
use App\Models\Admin;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'role' => 'required|in:user,seller,admin'
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        // Handle admin login separately (username instead of email)
        if ($role === 'admin') {
            $admin = Admin::where('username', $request->email)
                ->orWhere('email', $request->email)
                ->first();

            if ($admin && Hash::check($request->password, $admin->password)) {
                Auth::guard('admin')->login($admin, $request->filled('remember'));

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'redirect' => route('admin.dashboard')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid admin credentials'
            ], 401);
        }

        // Determine which model to use based on role
        $model = match($role) {
            'user' => User::class,
            'seller' => Seller::class,
        };

        $user = $model::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Check seller verification status
            if ($role === 'seller' && $user->verification_status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your seller account is pending approval or has been rejected.'
                ], 403);
            }

            // Set the appropriate guard based on role
            $guard = match($role) {
                'user' => 'web',
                'seller' => 'seller',
            };

            Auth::guard($guard)->login($user, $request->filled('remember'));

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => $this->getRedirectUrl($role)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    private function getRedirectUrl($role)
    {
        return match($role) {
            'user' => route('home'),
            'seller' => route('seller.dashboard'),
            'admin' => route('admin.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        // Check which guard is being used and logout from that guard
        if (Auth::guard('seller')->check()) {
            Auth::guard('seller')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}