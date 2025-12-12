@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#F8F4EE] via-white to-[#F8F4EE] pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Profile Banner -->
        <div class="relative mb-8 rounded-2xl overflow-hidden shadow-xl">
            <!-- Banner Image -->
            <div class="h-48 md:h-64 bg-gradient-to-r from-[#5B5843] to-[#252525] relative">
                <img id="banner-preview" 
                     src="{{ Auth::guard('seller')->user()->banner_image ? asset('assets/sellers/banners/' . Auth::guard('seller')->user()->banner_image) : asset('assets/hero/hero.png') }}" 
                     alt="Shop Banner" 
                     class="w-full h-full object-cover opacity-60">
                
                <!-- Edit Banner Button -->
                <label for="banner-upload" class="absolute top-4 right-4 bg-white/90 hover:bg-white text-gray-800 px-4 py-2 rounded-lg cursor-pointer transition-all duration-300 flex items-center gap-2 shadow-lg backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Change Banner</span>
                </label>
                <input type="file" id="banner-upload" accept="image/*" class="hidden" onchange="uploadBanner(this)">
            </div>
            
            <!-- Profile Info Overlay -->
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                <div class="flex items-end gap-6">
                    <!-- Profile Picture -->
                    <div class="relative group">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-white">
                            <img id="profile-preview" 
                                 src="{{ Auth::guard('seller')->user()->profile_picture ? asset('assets/sellers/profiles/' . Auth::guard('seller')->user()->profile_picture) : asset('assets/logo/dark-green-logo.png') }}" 
                                 alt="Profile" 
                                 class="w-full h-full object-cover">
                        </div>
                        <label for="profile-upload" class="absolute bottom-0 right-0 bg-[#5B5843] hover:bg-[#252525] text-white p-2 rounded-full cursor-pointer transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </label>
                        <input type="file" id="profile-upload" accept="image/*" class="hidden" onchange="uploadProfile(this)">
                    </div>
                    
                    <!-- Seller Info -->
                    <div class="flex-1 text-white pb-2">
                        <h1 class="text-3xl md:text-4xl font-bold mb-2" style="font-family: 'Elinga', serif;">
                            {{ Auth::guard('seller')->user()->shop_name ?: Auth::guard('seller')->user()->artisan_name }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm">
                            <span class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ Auth::guard('seller')->user()->indigenous_tribe }} Community
                            </span>
                            <span class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                {{ ucfirst(Auth::guard('seller')->user()->seller_type) }} Seller
                            </span>
                            <span class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ ucfirst(Auth::guard('seller')->user()->verification_status) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-3 pb-2">
                        <button onclick="openEditProfileModal()" class="bg-white hover:bg-gray-100 text-gray-800 px-4 py-2 rounded-lg transition-all duration-300 flex items-center gap-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="hidden md:inline">Edit Profile</span>
                        </button>
                        <button onclick="logoutSeller()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center gap-2 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">Total Products</p>
                <p id="stat-total-products" class="text-3xl font-bold text-gray-900">0</p>
                <div class="mt-2 flex items-center text-sm">
                    <span id="stat-approved-products" class="text-green-600">0 approved</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span id="stat-pending-products" class="text-yellow-600">0 pending</span>
                </div>
            </div>

            <!-- Total Sales -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">Total Revenue</p>
                <p id="stat-total-sales" class="text-3xl font-bold text-gray-900">₱0</p>
                <p id="stat-sales-this-month" class="mt-2 text-sm text-gray-600">₱0 this month</p>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">Total Orders</p>
                <p id="stat-total-orders" class="text-3xl font-bold text-gray-900">0</p>
                <p id="stat-orders-this-month" class="mt-2 text-sm text-gray-600">0 this month</p>
            </div>

            <!-- Items Sold -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">Items Sold</p>
                <p id="stat-items-sold" class="text-3xl font-bold text-gray-900">0</p>
                <p class="mt-2 text-sm text-gray-600">All time</p>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px overflow-x-auto">
                    <button onclick="switchSellerTab('products')" class="seller-tab active px-6 py-4 text-sm font-medium border-b-2 border-[#5B5843] text-[#5B5843] whitespace-nowrap">
                        Products
                    </button>
                    <button onclick="switchSellerTab('analytics')" class="seller-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Analytics
                    </button>
                    <button onclick="switchSellerTab('orders')" class="seller-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Orders
                    </button>
                </nav>
            </div>
        </div>

        <!-- Products Tab -->
        <div id="products-tab" class="seller-content">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h2 class="text-xl font-semibold text-gray-900">My Products</h2>
                    <button onclick="openAddProductModal()" class="bg-[#5B5843] hover:bg-[#252525] text-white px-6 py-3 rounded-lg transition-all duration-300 flex items-center gap-2 shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Product
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Price</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Stock</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Category</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="products-table-body" class="divide-y divide-gray-200">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#5B5843] mb-4"></div>
                                        <p class="text-gray-500">Loading products...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Analytics Tab -->
        <div id="analytics-tab" class="seller-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Sales Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Sales Overview</h3>
                    <div class="h-64 flex items-center justify-center text-gray-400">
                        <p>Sales chart will be displayed here</p>
                    </div>
                </div>
                
                <!-- Best Selling Products -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Best Selling Products</h3>
                    <div id="best-selling-products" class="space-y-3">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Tab -->
        <div id="orders-tab" class="seller-content hidden">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
                </div>
                <div id="orders-list" class="divide-y divide-gray-200">
                    <div class="px-6 py-12 text-center text-gray-500">
                        Loading orders...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div id="product-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeProductModal()"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-8 transform transition-all">
            <button onclick="closeProductModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <h3 class="text-2xl font-bold mb-6" id="product-modal-title">Add New Product</h3>
            
            <form id="product-form" class="space-y-4">
                <input type="hidden" id="product-id" name="product_id">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" id="product-name" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea id="product-description" name="description" required rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price (₱) *</label>
                        <input type="number" id="product-price" name="price" required step="0.01" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                        <input type="number" id="product-stock" name="stock" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select id="product-category" name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        <option value="">Select a category</option>
                        <option value="Jewelry">Jewelry</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Home Decor">Home Decor</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Footwear">Footwear</option>
                        <option value="Bags">Bags</option>
                        <option value="Art">Art</option>
                        <option value="Textiles">Textiles</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                    <input type="file" id="product-image" name="image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Optional: Upload a product image</p>
                </div>
                
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-[#5B5843] hover:bg-[#252525] text-white py-3 rounded-lg transition-all duration-300 font-medium">
                        Save Product
                    </button>
                    <button type="button" onclick="closeProductModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg transition-all duration-300 font-medium">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="edit-profile-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeEditProfileModal()"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-8 transform transition-all">
            <button onclick="closeEditProfileModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <h3 class="text-2xl font-bold mb-6">Edit Profile</h3>
            
            <form id="edit-profile-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Artisan Name</label>
                    <input type="text" name="artisan_name" id="edit-artisan-name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shop Name</label>
                    <input type="text" name="shop_name" id="edit-shop-name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shop Description</label>
                    <textarea name="shop_description" id="edit-shop-description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="phone_number" id="edit-phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" name="city" id="edit-city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                        <input type="text" name="province" id="edit-province" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                    </div>
                </div>
                
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-[#5B5843] hover:bg-[#252525] text-white py-3 rounded-lg transition-all duration-300 font-medium">
                        Save Changes
                    </button>
                    <button type="button" onclick="closeEditProfileModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg transition-all duration-300 font-medium">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div id="notification-toast" class="hidden fixed bottom-4 right-4 bg-white rounded-lg shadow-2xl p-4 z-50 transform transition-all duration-300">
    <div class="flex items-center gap-3">
        <!-- Icon (success, error, info, etc.) -->
        <div id="notification-icon" class="flex-shrink-0 w-6 h-6 text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Message -->
        <div id="notification-message" class="text-gray-800 text-sm">
            Success! Your changes have been saved.
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ----------------------
    // Tab Switching
    // ----------------------
    function switchSellerTab(tab) {
        document.querySelectorAll('.seller-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(`${tab}-tab`).classList.remove('hidden');

        document.querySelectorAll('.seller-tab').forEach(btn => btn.classList.remove('active', 'border-[#5B5843]', 'text-[#5B5843]'));
        document.querySelector(`.seller-tab[onclick="switchSellerTab('${tab}')"]`).classList.add('active', 'border-[#5B5843]', 'text-[#5B5843]');
    }

    // ----------------------
    // Product Modal Functions
    // ----------------------
    function openAddProductModal() {
        document.getElementById('product-modal-title').textContent = 'Add New Product';
        document.getElementById('product-form').reset();
        document.getElementById('product-id').value = '';
        document.getElementById('product-modal').classList.remove('hidden');
    }

    function closeProductModal() {
        document.getElementById('product-modal').classList.add('hidden');
    }

    // ----------------------
    // Edit Profile Modal
    // ----------------------
    function openEditProfileModal() {
        document.getElementById('edit-profile-modal').classList.remove('hidden');
    }

    function closeEditProfileModal() {
        document.getElementById('edit-profile-modal').classList.add('hidden');
    }

    // ----------------------
    // Banner & Profile Image Preview
    // ----------------------
    function uploadBanner(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = e => document.getElementById('banner-preview').src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }

    function uploadProfile(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = e => document.getElementById('profile-preview').src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }

    function showNotification(message, type = 'success') {
        const toast = document.getElementById('notification-toast');
        const icon = document.getElementById('notification-icon');
        const msg = document.getElementById('notification-message');

        msg.textContent = message;

        // Change icon color based on type
        if (type === 'success') icon.classList.replace('text-red-600', 'text-green-600');
        else if (type === 'error') icon.classList.replace('text-green-600', 'text-red-600');

        toast.classList.remove('hidden');
        toast.classList.add('opacity-100');

        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('opacity-100');
        }, 3000);
    }

    // ----------------------
    // Dummy Data (Replace with AJAX)
    // ----------------------
    const products = [
        {id: 1, name: 'Beaded Necklace', price: 500, stock: 10, category: 'Jewelry', status: 'Approved'},
        {id: 2, name: 'Handwoven Basket', price: 1200, stock: 5, category: 'Home Decor', status: 'Pending'},
    ];

    const orders = [
        {id: 101, product: 'Beaded Necklace', qty: 2, total: 1000, status: 'Pending'},
        {id: 102, product: 'Handwoven Basket', qty: 1, total: 1200, status: 'Shipped'},
    ];

    const stats = {
        totalProducts: products.length,
        approvedProducts: products.filter(p => p.status === 'Approved').length,
        pendingProducts: products.filter(p => p.status === 'Pending').length,
        totalSales: orders.reduce((sum, o) => sum + o.total, 0),
        salesThisMonth: 2200, // example
        totalOrders: orders.length,
        ordersThisMonth: 1, // example
        itemsSold: orders.reduce((sum, o) => sum + o.qty, 0)
    };

    // ----------------------
    // Populate Stats
    // ----------------------
    document.getElementById('stat-total-products').textContent = stats.totalProducts;
    document.getElementById('stat-approved-products').textContent = `${stats.approvedProducts} approved`;
    document.getElementById('stat-pending-products').textContent = `${stats.pendingProducts} pending`;

    document.getElementById('stat-total-sales').textContent = `₱${stats.totalSales}`;
    document.getElementById('stat-sales-this-month').textContent = `₱${stats.salesThisMonth} this month`;

    document.getElementById('stat-total-orders').textContent = stats.totalOrders;
    document.getElementById('stat-orders-this-month').textContent = `${stats.ordersThisMonth} this month`;

    document.getElementById('stat-items-sold').textContent = stats.itemsSold;

    // ----------------------
    // Populate Products Table
    // ----------------------
    const productsTable = document.getElementById('products-table-body');
    productsTable.innerHTML = '';
    products.forEach(p => {
        productsTable.innerHTML += `
            <tr>
                <td class="px-6 py-4">${p.name}</td>
                <td class="px-6 py-4">₱${p.price}</td>
                <td class="px-6 py-4">${p.stock}</td>
                <td class="px-6 py-4">${p.category}</td>
                <td class="px-6 py-4">${p.status}</td>
                <td class="px-6 py-4 flex gap-2">
                    <button onclick="editProduct(${p.id})" class="text-blue-600 hover:underline">Edit</button>
                    <button onclick="deleteProduct(${p.id})" class="text-red-600 hover:underline">Delete</button>
                </td>
            </tr>
        `;
    });

    function editProduct(id) {
        const product = products.find(p => p.id === id);
        document.getElementById('product-modal-title').textContent = 'Edit Product';
        document.getElementById('product-id').value = product.id;
        document.getElementById('product-name').value = product.name;
        document.getElementById('product-price').value = product.price;
        document.getElementById('product-stock').value = product.stock;
        document.getElementById('product-category').value = product.category;
        document.getElementById('product-modal').classList.remove('hidden');
    }

    function deleteProduct(id) {
        alert('Delete functionality not implemented yet.');
    }

    // ----------------------
    // Populate Orders Tab
    // ----------------------
    const ordersList = document.getElementById('orders-list');
    ordersList.innerHTML = '';
    orders.forEach(o => {
        ordersList.innerHTML += `
            <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <p class="text-gray-900 font-medium">Order #${o.id} - ${o.product}</p>
                <p class="text-gray-600">Qty: ${o.qty} | Total: ₱${o.total} | Status: ${o.status}</p>
            </div>
        `;
    });

    // ----------------------
    // Sales Chart (Analytics Tab)
    // ----------------------
    const ctx = document.createElement('canvas');
    ctx.id = 'sales-chart';
    const analyticsTab = document.getElementById('analytics-tab');
    analyticsTab.querySelector('.bg-white.rounded-xl.shadow-lg.p-6').appendChild(ctx);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Revenue (₱)',
                data: [500,1200,800,900,1500,700,1300,1100,900,1400,1000,1600],
                backgroundColor: 'rgba(37,37,37,0.2)',
                borderColor: '#252525',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
        }
    });

    // ----------------------
    // Dummy Best Selling Products
    // ----------------------
    const bestSellingContainer = document.getElementById('best-selling-products');
    const bestSelling = products.slice(0,3); // top 3
    bestSelling.forEach(p => {
        bestSellingContainer.innerHTML += `
            <div class="flex items-center justify-between bg-gray-50 px-4 py-2 rounded-lg">
                <span>${p.name}</span>
                <span class="text-gray-600">₱${p.price}</span>
            </div>
        `;
    });
</script>
@endpush
