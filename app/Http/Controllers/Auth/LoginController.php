<?php
// app/Http/Controllers/Auth/LoginController.php
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
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:user,seller,admin'
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        // Determine which model to use based on role
        $model = match($role) {
            'user' => User::class,
            'seller' => Seller::class,
            'admin' => Admin::class,
        };

        $user = $model::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Set the appropriate guard based on role
            $guard = match($role) {
                'user' => 'web',
                'seller' => 'seller',
                'admin' => 'admin',
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

