<?php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('hero');
})->name('home');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/product/{id}', function ($id) {
    return view('product-detail', ['productId' => $id]);
})->name('product.detail');

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');
    
    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');
    
    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');
});

// Seller Routes
Route::middleware(['auth:seller'])->prefix('seller')->group(function () {
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});

// Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});