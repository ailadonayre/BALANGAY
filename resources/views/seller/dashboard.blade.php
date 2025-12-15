@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#F8F4EE] via-white to-[#F8F4EE] pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Profile Banner -->
        <div class="relative mb-8 rounded-2xl overflow-hidden shadow-xl">
            <!-- Banner Image -->
            <div class="h-48 md:h-64 bg-gradient-to-r from-[#5B5843] to-[#5B5843] relative">
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
                    <button onclick="switchSellerTab(event, 'products')" class="seller-tab products-tab active px-6 py-4 text-sm font-medium border-b-2 border-[#5B5843] text-[#5B5843] whitespace-nowrap">
                        Products
                    </button>
                    <button onclick="switchSellerTab(event, 'analytics')" class="seller-tab analytics-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Analytics
                    </button>
                    <button onclick="switchSellerTab(event, 'orders')" class="seller-tab orders-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Seller ID (from Auth)
    const sellerId = {{ Auth::guard('seller')->user()?->id ?? 0 }};
    
    // Verify seller is logged in
    if (!sellerId || sellerId === 0) {
        console.error('Seller not authenticated');
        window.location.href = '/';
    }

    // ===== TAB SWITCHING =====
    function switchSellerTab(event, tabName) {
        event.preventDefault();
        
        // Hide all content tabs
        document.querySelectorAll('.seller-content').forEach(el => el.classList.add('hidden'));
        
        // Show selected content tab
        const selectedTab = document.getElementById(`${tabName}-tab`);
        if (selectedTab) {
            selectedTab.classList.remove('hidden');
        }

        // Update tab button styling - remove active state from all
        document.querySelectorAll('.seller-tab').forEach(btn => {
            btn.classList.remove('active', 'border-[#5B5843]', 'text-[#5B5843]');
            btn.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Mark current tab button as active
        if (event.target && event.target.classList) {
            event.target.classList.add('border-[#5B5843]', 'text-[#5B5843]');
            event.target.classList.remove('border-transparent', 'text-gray-500');
        }
        
        // Load content for specific tabs
        if (tabName === 'analytics') {
            loadAnalytics();
        } else if (tabName === 'orders') {
            loadOrders();
        }
    }

    // ===== NOTIFICATION TOAST =====
    function showNotification(message, type = 'success') {
        const toast = document.getElementById('notification-toast');
        const icon = document.getElementById('notification-icon');
        const msg = document.getElementById('notification-message');

        msg.textContent = message;

        // Update icon color
        icon.classList.remove('text-green-600', 'text-red-600');
        if (type === 'success') {
            icon.classList.add('text-green-600');
        } else if (type === 'error') {
            icon.classList.add('text-red-600');
        }

        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }

    // ===== BANNER AND PROFILE UPLOAD =====
    function uploadBanner(input) {
        if (!input.files || !input.files[0]) return;

        const formData = new FormData();
        formData.append('banner_image', input.files[0]);

        fetch('/api/seller/update-banner', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return res.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('banner-preview').src = data.banner_url + '?t=' + new Date().getTime();
                showNotification('Banner updated successfully!');
                // Reset the file input
                input.value = '';
            } else {
                showNotification(data.message || 'Failed to update banner', 'error');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showNotification('Error uploading banner: ' + err.message, 'error');
        });
    }

    function uploadProfile(input) {
        if (!input.files || !input.files[0]) return;

        const formData = new FormData();
        formData.append('profile_picture', input.files[0]);

        fetch('/api/seller/update-profile-picture', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return res.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('profile-preview').src = data.profile_url + '?t=' + new Date().getTime();
                showNotification('Profile picture updated successfully!');
                input.value = '';
            } else {
                showNotification('Failed to update profile picture', 'error');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showNotification('Error uploading profile picture: ' + err.message, 'error');
        });
    }

    // ===== EDIT PROFILE MODAL =====
    function openEditProfileModal() {
        document.getElementById('edit-profile-modal').classList.remove('hidden');
        // Pre-fill current values
        fetch('/api/seller/profile', {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                return res.json();
            })
            .then(data => {
                document.getElementById('edit-artisan-name').value = data.artisan_name || '';
                document.getElementById('edit-shop-name').value = data.shop_name || '';
                document.getElementById('edit-shop-description').value = data.shop_description || '';
                document.getElementById('edit-phone').value = data.phone_number || '';
                document.getElementById('edit-city').value = data.city || '';
                document.getElementById('edit-province').value = data.province || '';
            })
            .catch(err => {
                console.error('Error loading profile:', err);
                showNotification('Error loading profile data', 'error');
            });
    }

    function closeEditProfileModal() {
        document.getElementById('edit-profile-modal').classList.add('hidden');
    }

    // Setup event listeners when DOM is ready
    function setupFormListeners() {
        // Handle edit profile form submission
        const editProfileForm = document.getElementById('edit-profile-form');
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const formData = new FormData(editProfileForm);
                
                try {
                    const response = await fetch('/api/seller/update-profile', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        showNotification('Profile updated successfully!');
                        closeEditProfileModal();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showNotification(data.message || 'Failed to update profile', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Error updating profile: ' + error.message, 'error');
                }
            });
        }
    }

    // ===== PRODUCT MODAL =====
    let editingProductId = null;

    function openAddProductModal() {
        editingProductId = null;
        document.getElementById('product-modal-title').textContent = 'Add New Product';
        document.getElementById('product-form').reset();
        document.getElementById('product-id').value = '';
        document.getElementById('product-modal').classList.remove('hidden');
    }

    function closeProductModal() {
        document.getElementById('product-modal').classList.add('hidden');
        editingProductId = null;
    }

    // ===== LOAD AND DISPLAY PRODUCTS =====
    async function loadProducts() {
        try {
            console.log('loadProducts() called, sellerId:', sellerId);
            const response = await fetch(`/api/sellers/${sellerId}/products`);
            
            console.log('Products API response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const products = await response.json();
            console.log('Products data:', products);
            
            // Ensure products is an array
            const productList = Array.isArray(products) ? products : (products.data || []);
            console.log('Product list:', productList);

            const tbody = document.getElementById('products-table-body');
            
            if (!tbody) {
                console.error('Products table body not found');
                return;
            }
            
            tbody.innerHTML = '';

            if (!productList || productList.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No products yet. <a href="#" onclick="openAddProductModal(); return false;" class="text-[#5B5843] hover:underline">Add your first product</a>
                        </td>
                    </tr>
                `;
                updateStats([]);
                return;
            }

            productList.forEach(product => {
                const statusColor = product.approval_status === 'approved' ? 'text-green-600' : 'text-yellow-600';
                const statusBg = product.approval_status === 'approved' ? 'bg-green-50' : 'bg-yellow-50';
                
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="/assets/products/${product.image || 'default.jpg'}" alt="${product.name}" class="w-10 h-10 rounded object-cover bg-gray-100" onerror="this.src='/assets/logo/dark-green-logo.png'">
                                <span class="font-medium text-gray-900">${product.name}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</td>
                        <td class="px-6 py-4">${product.stock}</td>
                        <td class="px-6 py-4">${product.category}</td>
                        <td class="px-6 py-4">
                            <span class="${statusColor} ${statusBg} px-3 py-1 rounded-full text-sm font-medium">
                                ${product.approval_status.charAt(0).toUpperCase() + product.approval_status.slice(1)}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <button onclick="editProduct(${product.id})" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">Edit</button>
                            <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-800 font-medium text-sm transition-colors">Delete</button>
                        </td>
                    </tr>
                `;
            });

            // Update stats with loaded products
            updateStats(productList);
        } catch (error) {
            console.error('Error loading products:', error);
            const tbody = document.getElementById('products-table-body');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-red-500">
                            Error loading products. Please try refreshing the page.
                        </td>
                    </tr>
                `;
            }
        }
    }

    async function editProduct(productId) {
        try {
            const response = await fetch(`/api/products/${productId}`);
            const product = await response.json();

            document.getElementById('product-modal-title').textContent = 'Edit Product';
            document.getElementById('product-id').value = product.id;
            document.getElementById('product-name').value = product.name;
            document.getElementById('product-description').value = product.description;
            document.getElementById('product-price').value = product.price;
            document.getElementById('product-stock').value = product.stock;
            document.getElementById('product-category').value = product.category;
            
            editingProductId = product.id;
            document.getElementById('product-modal').classList.remove('hidden');
        } catch (error) {
            console.error('Error loading product:', error);
            showNotification('Error loading product details', 'error');
        }
    }

    async function deleteProduct(productId) {
        if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) return;

        try {
            const response = await fetch(`/seller/api/products/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                if (data.archived) {
                    showNotification('Product archived successfully (has order history)', 'success');
                } else {
                    showNotification('Product deleted successfully!');
                }
                loadProducts();
                loadAnalytics();
            } else {
                showNotification(data.message || 'Error deleting product', 'error');
            }
        } catch (error) {
            console.error('Delete Error:', error);
            showNotification('Error deleting product: ' + error.message, 'error');
        }
    }

    // ===== UPDATE STATS =====
    function updateStats(products) {
        const totalProducts = products.length;
        const approvedProducts = products.filter(p => p.approval_status === 'approved').length;
        const pendingProducts = products.filter(p => p.approval_status === 'pending').length;

        document.getElementById('stat-total-products').textContent = totalProducts;
        document.getElementById('stat-approved-products').textContent = `${approvedProducts} approved`;
        document.getElementById('stat-pending-products').textContent = `${pendingProducts} pending`;
    }

    // ===== LOAD ORDERS =====
    async function loadOrders() {
        console.log('loadOrders called');
        try {
            console.log('Fetching orders from /seller/api/orders');
            const response = await fetch('/seller/api/orders', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const orders = await response.json();
            console.log('Orders received:', orders);
            
            const container = document.getElementById('orders-list');
            
            if (!container) {
                console.error('orders-list container not found!');
                return;
            }
            
            if (!orders || orders.length === 0) {
                console.log('No orders found');
                container.innerHTML = `
                    <div class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p>No orders yet</p>
                    </div>
                `;
                return;
            }
            
            console.log('Rendering', orders.length, 'orders');
            container.innerHTML = orders.map(order => {
                const statusMap = {
                    'pending': { label: 'Pending', class: 'bg-yellow-100 text-yellow-800' },
                    'to_ship': { label: 'To Ship', class: 'bg-blue-100 text-blue-800' },
                    'shipped': { label: 'Shipped', class: 'bg-purple-100 text-purple-800' },
                    'to_receive': { label: 'To Receive', class: 'bg-indigo-100 text-indigo-800' },
                    'completed': { label: 'Completed', class: 'bg-green-100 text-green-800' },
                    'cancelled': { label: 'Cancelled', class: 'bg-red-100 text-red-800' }
                };
                const status = statusMap[order.order_status] || statusMap['pending'];
                
                return `
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Order #${order.order_number}</h3>
                                <p class="text-sm text-gray-600">${new Date(order.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${status.class}">
                                    ${status.label}
                                </span>
                                <p class="text-lg font-bold text-[#5B5843] mt-2">₱${parseFloat(order.total_amount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <h4 class="font-medium text-gray-900 mb-2">Customer Information</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">Name</p>
                                    <p class="font-medium">${order.customer_name}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Phone</p>
                                    <p class="font-medium">${order.customer_phone}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-gray-600">Email</p>
                                    <p class="font-medium">${order.customer_email}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-gray-600">Shipping Address</p>
                                    <p class="font-medium">${order.shipping_address}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Payment Method</p>
                                    <p class="font-medium">${order.payment_method.toUpperCase()}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <h4 class="font-medium text-gray-900">Items</h4>
                            ${order.items.map(item => `
                                <div class="flex items-center gap-3 p-2 bg-white rounded">
                                    <img src="/assets/products/${item.product_image}" alt="${item.product_name}" class="w-12 h-12 object-cover rounded">
                                    <div class="flex-1">
                                        <p class="font-medium text-sm">${item.product_name}</p>
                                        <p class="text-xs text-gray-600">Qty: ${item.quantity} × ₱${parseFloat(item.unit_price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                                    </div>
                                    <p class="font-semibold">₱${parseFloat(item.subtotal).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                                </div>
                            `).join('')}
                        </div>
                        
                        <div class="flex gap-2">
                            <select onchange="updateOrderStatus(${order.order_id}, this.value)" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                                <option value="pending" ${order.order_status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="to_ship" ${order.order_status === 'to_ship' ? 'selected' : ''}>To Ship</option>
                                <option value="shipped" ${order.order_status === 'shipped' ? 'selected' : ''}>Shipped</option>
                                <option value="to_receive" ${order.order_status === 'to_receive' ? 'selected' : ''}>To Receive</option>
                                <option value="completed" ${order.order_status === 'completed' ? 'selected' : ''}>Completed</option>
                                <option value="cancelled" ${order.order_status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                `;
            }).join('');
            
        } catch (error) {
            console.error('Error loading orders:', error);
            document.getElementById('orders-list').innerHTML = `
                <div class="px-6 py-12 text-center text-red-500">
                    Error loading orders. Please refresh the page.
                </div>
            `;
        }
    }

    // ===== UPDATE ORDER STATUS =====
    async function updateOrderStatus(orderId, status) {
        console.log('updateOrderStatus called:', { orderId, status });
        try {
            console.log(`Updating order ${orderId} to status ${status}`);
            const response = await fetch(`/seller/api/orders/${orderId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status })
            });
            
            console.log('Update response status:', response.status);
            
            const data = await response.json();
            console.log('Update response data:', data);
            
            if (data.success) {
                showNotification('Order status updated successfully!');
                loadOrders();
            } else {
                showNotification(data.message || 'Error updating order status', 'error');
            }
        } catch (error) {
            console.error('Error updating order status:', error);
            showNotification('Error updating order status', 'error');
        }
    }

    async function loadAnalytics() {
        try {
            const response = await fetch('/api/seller/analytics');
            const analytics = await response.json();
            
            const bestSellingContainer = document.getElementById('best-selling-products');
            if (!bestSellingContainer) return;
            
            bestSellingContainer.innerHTML = '';
            
            if (!analytics.best_selling_products || analytics.best_selling_products.length === 0) {
                bestSellingContainer.innerHTML = '<p class="text-gray-500 text-sm">No sales data yet</p>';
                return;
            }
            
            analytics.best_selling_products.forEach(product => {
                bestSellingContainer.innerHTML += `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <img src="/assets/products/${product.image || 'default.jpg'}" alt="${product.name}" class="w-8 h-8 rounded object-cover" onerror="this.src='/assets/logo/dark-green-logo.png'">
                            <span class="text-sm font-medium text-gray-900">${product.name}</span>
                        </div>
                        <span class="text-sm text-gray-600">${product.total_sold || 0} sold</span>
                    </div>
                `;
            });
        } catch (error) {
            console.error('Error loading analytics:', error);
        }
    }

    // ===== LOGOUT =====
    function logoutSeller() {
        if (!confirm('Are you sure you want to logout?')) return;
        
        // Create and submit a form to properly logout
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/auth/logout';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }

    // ===== INITIALIZE ON LOAD =====
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            try {
                console.log('Dashboard DOMContentLoaded fired, sellerId:', sellerId);
                
                setupFormListeners();
                console.log('Form listeners setup complete');
                
                const productForm = document.getElementById('product-form');
                if (productForm) {
                    productForm.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        console.log('Product form submitted');

                        const formData = new FormData(productForm);
                        const productId = document.getElementById('product-id').value;
                        
                        const url = productId ? `/seller/api/products/${productId}` : '/seller/api/products';
                        const method = productId ? 'PUT' : 'POST';
                        
                        console.log('Submitting product to:', url, 'Method:', method);

                        try {
                            const response = await fetch(url, {
                                method: method,
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            console.log('Product response status:', response.status);
                            const data = await response.json();
                            console.log('Product response data:', data);

                            if (data.success) {
                                showNotification(productId ? 'Product updated successfully!' : 'Product added successfully!');
                                closeProductModal();
                                loadProducts();
                            } else {
                                showNotification(data.message || 'Error saving product', 'error');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            showNotification('Error saving product: ' + error.message, 'error');
                        }
                    });
                    console.log('Product form listener attached');
                }
                
                console.log('Loading products...');
                loadProducts();
            } catch (error) {
                console.error('Dashboard initialization error:', error);
                alert('Dashboard initialization error. Check console for details.');
            }
        });
    } else {
        // DOM is already loaded
        try {
            console.log('DOM already loaded, sellerId:', sellerId);
            setupFormListeners();
            const productForm = document.getElementById('product-form');
            if (productForm) {
                productForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(productForm);
                    const productId = document.getElementById('product-id').value;
                    const url = productId ? `/seller/api/products/${productId}` : '/seller/api/products';
                    const method = productId ? 'PUT' : 'POST';
                    try {
                        const response = await fetch(url, {
                            method: method,
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            showNotification(productId ? 'Product updated successfully!' : 'Product added successfully!');
                            closeProductModal();
                            loadProducts();
                        } else {
                            showNotification(data.message || 'Error saving product', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('Error saving product: ' + error.message, 'error');
                    }
                });
            }
            loadProducts();
        } catch (error) {
            console.error('Dashboard initialization error:', error);
        }
    }
</script>

@endsection