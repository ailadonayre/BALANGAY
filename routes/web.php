<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\SellerController;

// Public Routes
Route::get('/', function () {
    return view('hero');
})->name('home');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/product/{id}', function ($id) {
    return view('product-detail', ['productId' => $id]);
})->name('product.detail');

Route::get('/communities', function () {
    return view('communities');
})->name('communities');

Route::get('/stories', function () {
    return view('stories');
})->name('stories');

// Auth Routes
Route::post('/auth/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth/register', [RegisterController::class, 'register'])->name('register');
Route::post('/auth/logout', [LoginController::class, 'logout'])->name('logout')->middleware(['auth:web,seller,admin']);

// Protected Routes - User Only
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    Route::get('/api/user/profile', [UserController::class, 'getProfile'])->name('api.user.profile');
    Route::post('/api/user/profile', [UserController::class, 'updateProfile'])->name('api.user.update');
    Route::post('/api/user/password', [UserController::class, 'changePassword'])->name('api.user.password');

    // Cart
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');
    Route::get('/api/cart', [CartController::class, 'getCart'])->name('api.cart.get');
    Route::post('/api/cart/add', [CartController::class, 'addToCart'])->name('api.cart.add');
    Route::put('/api/cart/{id}', [CartController::class, 'updateQuantity'])->name('api.cart.update');
    Route::delete('/api/cart/{id}', [CartController::class, 'removeFromCart'])->name('api.cart.remove');
    Route::post('/api/cart/clear', [CartController::class, 'clearCart'])->name('api.cart.clear');

    // Checkout & Orders
    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');
    Route::post('/api/orders/checkout', [OrderController::class, 'checkout'])->name('api.orders.checkout');
    
    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');
    Route::get('/api/orders', [OrderController::class, 'getOrders'])->name('api.orders.list');
    Route::get('/api/orders/{id}', [OrderController::class, 'getOrder'])->name('api.orders.show');
});

// Product API Routes (Public)
Route::get('/api/products', [ProductController::class, 'index'])->name('api.products.list');
Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');
Route::get('/api/products/category/{category}', [ProductController::class, 'getByCategory'])->name('api.products.category');
Route::get('/api/products/{id}', [ProductController::class, 'show'])->name('api.products.show');
Route::get('/api/categories', [ProductController::class, 'getCategories'])->name('api.categories');
Route::get('/api/products-communities', [ProductController::class, 'getCommunities'])->name('api.products.communities');

// Community API Routes (Public)
Route::get('/api/communities/all', [CommunityController::class, 'index'])->name('api.communities.list');
Route::get('/api/communities/{id}', [CommunityController::class, 'show'])->name('api.communities.show');

// Seller API Routes
Route::get('/api/sellers/{sellerId}/products', [SellerController::class, 'getProducts'])->name('api.seller.products');

// Seller Routes
Route::middleware(['auth:seller'])->prefix('seller')->group(function () {
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
    
    // Seller Product API Routes
    Route::post('/api/products', [SellerController::class, 'createProduct'])->name('api.seller.create.product');
    Route::put('/api/products/{id}', [SellerController::class, 'updateProduct'])->name('api.seller.update.product');
    Route::delete('/api/products/{id}', [SellerController::class, 'deleteProduct'])->name('api.seller.delete.product');
});

// Seller API Routes (Protected)
Route::middleware(['auth:seller'])->group(function () {
    Route::get('/api/seller/profile', [SellerController::class, 'getProfile'])->name('api.seller.profile');
    Route::post('/api/seller/update-profile', [SellerController::class, 'updateProfile'])->name('api.seller.update.profile');
    Route::post('/api/seller/update-banner', [SellerController::class, 'updateBanner'])->name('api.seller.update.banner');
    Route::post('/api/seller/update-profile-picture', [SellerController::class, 'updateProfilePicture'])->name('api.seller.update.picture');
    Route::get('/api/seller/analytics', [SellerController::class, 'getAnalytics'])->name('api.seller.analytics');
    Route::get('/api/seller/orders', [SellerController::class, 'getOrders'])->name('api.seller.orders');
});

// Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Admin API Routes
    Route::get('/api/analytics', [AdminController::class, 'getAnalytics']);
    Route::get('/api/users', [AdminController::class, 'getUsers']);
    Route::delete('/api/users/{id}', [AdminController::class, 'deleteUser']);
    
    Route::get('/api/sellers', [AdminController::class, 'getSellers']);
    Route::post('/api/sellers/{id}/status', [AdminController::class, 'updateSellerStatus']);
    Route::delete('/api/sellers/{id}', [AdminController::class, 'deleteSeller']);
    
    Route::get('/api/products', [AdminController::class, 'getProducts']);
    Route::post('/api/products/{id}/status', [AdminController::class, 'updateProductStatus']);
    Route::post('/api/products/{id}/featured', [AdminController::class, 'toggleFeaturedProduct']);
    Route::delete('/api/products/{id}', [AdminController::class, 'deleteProduct']);
    
    Route::get('/api/stories', [AdminController::class, 'getStories']);
    Route::post('/api/stories', [AdminController::class, 'createStory']);
    Route::post('/api/stories/{id}', [AdminController::class, 'updateStory']);
    Route::delete('/api/stories/{id}', [AdminController::class, 'deleteStory']);
    
    Route::get('/api/donations', [AdminController::class, 'getDonations']);
    Route::post('/api/donations', [AdminController::class, 'createDonation']);
    Route::post('/api/donations/{id}', [AdminController::class, 'updateDonation']);
    Route::delete('/api/donations/{id}', [AdminController::class, 'deleteDonation']);
    
    Route::get('/api/featured-artists', [AdminController::class, 'getFeaturedArtists']);
    Route::post('/api/featured-artists', [AdminController::class, 'createFeaturedArtist']);
    Route::post('/api/featured-artists/{id}', [AdminController::class, 'updateFeaturedArtist']);
    Route::delete('/api/featured-artists/{id}', [AdminController::class, 'deleteFeaturedArtist']);
});