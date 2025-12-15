@extends('layouts.app')

@section('content')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .admin-tab.active {
        border-color: #5B5843 !important;
        color: #5B5843 !important;
    }
</style>
<div class="min-h-screen bg-gray-50 pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900" style="font-family: 'Elinga', serif;">Admin Dashboard</h1>
                <p class="text-gray-600 mt-2">Manage BALANGAY platform</p>
            </div>
            <button onclick="logoutAdmin()" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                Logout
            </button>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Users</p>
                        <p id="stat-users" class="text-3xl font-bold text-gray-900 mt-2">0</p>
                    </div>
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Verified Sellers</p>
                        <p id="stat-sellers" class="text-3xl font-bold text-gray-900 mt-2">0</p>
                    </div>
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Products</p>
                        <p id="stat-products" class="text-3xl font-bold text-gray-900 mt-2">0</p>
                    </div>
                    <div class="bg-purple-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Revenue</p>
                        <p id="stat-revenue" class="text-3xl font-bold text-gray-900 mt-2">₱0</p>
                    </div>
                    <div class="bg-yellow-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="switchAdminTab('overview')" class="admin-tab active px-6 py-4 text-sm font-medium border-b-2 border-[#5B5843] text-[#5B5843]">
                        Overview
                    </button>
                    <button onclick="switchAdminTab('users')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Users
                    </button>
                    <button onclick="switchAdminTab('sellers')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Sellers
                    </button>
                    <button onclick="switchAdminTab('products')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Products
                    </button>
                    <button onclick="switchAdminTab('stories')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Stories
                    </button>
                    <button onclick="switchAdminTab('featured')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Featured Artists
                    </button>
                    <button onclick="switchAdminTab('communities')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Communities
                    </button>
                </nav>
            </div>
        </div>

        <!-- Overview Tab -->
        <div id="overview-tab" class="admin-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Homepage Analytics -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold mb-4">Homepage Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Artisans Supported</span>
                            <span id="homepage-artisans" class="text-2xl font-bold text-[#5B5843]">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Products Sold</span>
                            <span id="homepage-products-sold" class="text-2xl font-bold text-[#5B5843]">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Income Provided</span>
                            <span id="homepage-income" class="text-2xl font-bold text-[#5B5843]">₱0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Orders</span>
                            <span id="homepage-orders" class="text-2xl font-bold text-[#5B5843]">0</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Approvals -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold mb-4">Pending Approvals</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-lg">
                            <div>
                                <p class="font-medium">Pending Sellers</p>
                                <p class="text-sm text-gray-600">Awaiting verification</p>
                            </div>
                            <span id="pending-sellers-count" class="text-2xl font-bold text-yellow-600">0</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                            <div>
                                <p class="font-medium">Pending Products</p>
                                <p class="text-sm text-gray-600">Awaiting approval</p>
                            </div>
                            <span id="pending-products-count" class="text-2xl font-bold text-blue-600">0</span>
                        </div>
                    </div>
                </div>

                <!-- Sellers by Tribe -->
                <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
                    <h3 class="text-xl font-semibold mb-4">Sellers by Indigenous Tribe</h3>
                    <div id="sellers-by-tribe" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Tab -->
        <div id="users-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-semibold">User Management</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Phone</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Joined</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="users-table" class="divide-y divide-gray-200">
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Loading users...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sellers Tab -->
        <div id="sellers-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Seller Management</h3>
                    <div class="flex gap-2">
                        <button onclick="filterSellers('all')" class="seller-filter-btn active px-4 py-2 text-sm rounded-lg bg-[#5B5843] text-white">All</button>
                        <button onclick="filterSellers('pending')" class="seller-filter-btn px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-700">Pending</button>
                        <button onclick="filterSellers('approved')" class="seller-filter-btn px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-700">Approved</button>
                        <button onclick="filterSellers('rejected')" class="seller-filter-btn px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-700">Rejected</button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tribe</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sellers-table" class="divide-y divide-gray-200">
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Loading sellers...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div id="products-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Product Management</h3>
                    <div class="flex gap-2">
                        <button onclick="filterProducts('all')" class="product-filter-btn active px-4 py-2 text-sm rounded-lg bg-[#5B5843] text-white">All</button>
                        <button onclick="filterProducts('pending')" class="product-filter-btn px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-700">Pending</button>
                        <button onclick="filterProducts('approved')" class="product-filter-btn px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-700">Approved</button>
                        <button onclick="filterProducts('rejected')" class="product-filter-btn px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-700">Rejected</button>
                    </div>
                </div>
                <div class="p-6">
                    <div id="products-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Products will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Stories Tab -->
        <div id="stories-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Story Management</h3>
                    <button onclick="openStoryModal()" class="bg-[#5B5843] text-white px-6 py-2 rounded-lg hover:bg-[#4a4735]">
                        + Add Story
                    </button>
                </div>
                <div class="p-6">
                    <div id="stories-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Stories will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Artists Tab -->
        <div id="featured-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Featured Artists <span class="text-sm text-gray-500">(Limit: 3 Active)</span></h3>
                    <button onclick="openFeaturedArtistModal()" class="bg-[#5B5843] text-white px-6 py-2 rounded-lg hover:bg-[#4a4735]">
                        + Add Featured Artist
                    </button>
                </div>
                <div class="p-6">
                    <div id="featured-artists-list" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Featured artists will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Communities Tab -->
        <div id="communities-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Featured Communities</h3>
                    <button onclick="openFeaturedCommunityModal()" class="bg-[#5B5843] text-white px-6 py-2 rounded-lg hover:bg-[#4a4735]">
                        + Add Featured Community
                    </button>
                </div>
                <div class="p-6">
                    <div id="featured-communities-list" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Featured communities will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Story Modal -->
<div id="story-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50" onclick="closeStoryModal()"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl p-8">
            <h3 class="text-2xl font-bold mb-6">Add New Story</h3>
            <form id="story-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Title</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Author Name</label>
                    <input type="text" name="author_name" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Tribe</label>
                    <input type="text" name="tribe" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Excerpt</label>
                    <textarea name="excerpt" required rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Content</label>
                    <textarea name="content" required rows="6" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="published" id="story-published" class="rounded">
                    <label for="story-published" class="ml-2 text-sm">Publish immediately</label>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-[#5B5843] text-white py-2 rounded-lg hover:bg-[#4a4735]">Save Story</button>
                    <button type="button" onclick="closeStoryModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Donation Modal -->
<div id="donation-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50" onclick="closeDonationModal()"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl p-8">
            <h3 class="text-2xl font-bold mb-6">Add Donation Initiative</h3>
            <form id="donation-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Title</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" required rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Tribe</label>
                    <input type="text" name="tribe" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Target Amount (Optional)</label>
                        <input type="number" name="target_amount" step="0.01" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Current Amount</label>
                        <input type="number" name="current_amount" step="0.01" value="0" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg">
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-[#5B5843] text-white py-2 rounded-lg hover:bg-[#4a4735]">Save Initiative</button>
                    <button type="button" onclick="closeDonationModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Featured Artist Modal -->
<div id="featured-artist-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50" onclick="closeFeaturedArtistModal()"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl p-8">
            <h3 class="text-2xl font-bold mb-6">Add Featured Artist</h3>
            <form id="featured-artist-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Tribe</label>
                    <input type="text" name="tribe" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Craft</label>
                    <input type="text" name="craft" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Display Order</label>
                    <input type="number" name="display_order" value="0" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-[#5B5843] text-white py-2 rounded-lg hover:bg-[#4a4735]">Save Artist</button>
                    <button type="button" onclick="closeFeaturedArtistModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Featured Community Modal -->
<div id="featured-community-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50" onclick="closeFeaturedCommunityModal()"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl p-8">
            <h3 class="text-2xl font-bold mb-6">Add Featured Community</h3>
            <form id="community-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Community Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Region</label>
                    <input type="text" name="region" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Display Order</label>
                    <input type="number" name="display_order" value="0" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-[#5B5843] text-white py-2 rounded-lg hover:bg-[#4a4735]">Save Community</button>
                    <button type="button" onclick="closeFeaturedCommunityModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
let currentSellerFilter = 'all';
let currentProductFilter = 'all';

document.addEventListener('DOMContentLoaded', function() {
    loadAnalytics();
    loadUsers();
    loadSellers();
    loadProducts();
    loadStories();
    loadDonations();
    loadFeaturedArtists();
});

// Tab Switching
function switchAdminTab(tab) {
    document.querySelectorAll('.admin-tab').forEach(t => {
        t.classList.remove('active', 'border-[#5B5843]', 'text-[#5B5843]');
        t.classList.add('border-transparent', 'text-gray-500');
    });
    
    document.querySelectorAll('.admin-content').forEach(c => {
        c.classList.add('hidden');
    });
    
    event.target.classList.add('active', 'border-[#5B5843]', 'text-[#5B5843]');
    event.target.classList.remove('border-transparent', 'text-gray-500');
    
    document.getElementById(`${tab}-tab`).classList.remove('hidden');
    
    // Load data for specific tabs
    if (tab === 'communities') {
        loadFeaturedCommunities();
    }
}

// Load Analytics
async function loadAnalytics() {
    try {
        console.log('Loading analytics...');
        const response = await fetch('/admin/api/analytics');
        if (!response.ok) {
            console.error('API Error:', response.status, response.statusText);
            return;
        }
        const analytics = await response.json();
        console.log('Analytics data:', analytics);
        
        document.getElementById('stat-users').textContent = analytics.total_users;
        document.getElementById('stat-sellers').textContent = analytics.verified_sellers;
        document.getElementById('stat-products').textContent = analytics.total_products;
        document.getElementById('stat-revenue').textContent = '₱' + parseFloat(analytics.total_revenue).toLocaleString('en-PH', { minimumFractionDigits: 2 });
        
        console.log('Updated stat boxes:', {
            users: analytics.total_users,
            sellers: analytics.verified_sellers,
            products: analytics.total_products,
            revenue: analytics.total_revenue
        });
        
        document.getElementById('homepage-artisans').textContent = analytics.artisans_supported;
        document.getElementById('homepage-products-sold').textContent = analytics.products_sold;
        document.getElementById('homepage-income').textContent = '₱' + parseFloat(analytics.income_provided).toLocaleString('en-PH', { minimumFractionDigits: 2 });
        document.getElementById('homepage-orders').textContent = analytics.orders_count;
        
        console.log('Updated homepage stats:', {
            artisans: analytics.artisans_supported,
            productsSold: analytics.products_sold,
            income: analytics.income_provided,
            orders: analytics.orders_count
        });
        
        document.getElementById('pending-sellers-count').textContent = analytics.pending_sellers;
        document.getElementById('pending-products-count').textContent = analytics.pending_products;
        
        console.log('Updated pending approvals:', {
            sellers: analytics.pending_sellers,
            products: analytics.pending_products
        });
        
        // Sellers by tribe
        const tribeContainer = document.getElementById('sellers-by-tribe');
        tribeContainer.innerHTML = analytics.sellers_by_tribe.map(tribe => `
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">${tribe.indigenous_tribe}</p>
                <p class="text-2xl font-bold text-[#5B5843] mt-1">${tribe.count}</p>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading analytics:', error);
    }
}

// Load Users
async function loadUsers() {
    try {
        const response = await fetch('/admin/api/users');
        if (!response.ok) {
            console.error('Users API Error:', response.status);
            return;
        }
        const users = await response.json();
        
        const tbody = document.getElementById('users-table');
        tbody.innerHTML = users.map(user => `
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900">${user.full_name || user.name || 'N/A'}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${user.email}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${user.phone_number || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${new Date(user.created_at).toLocaleDateString()}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    <button class="text-red-600 hover:underline" onclick="deleteUser(${user.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error('Error loading users:', error);
    }
}

// Load Sellers
async function loadSellers() {
    try {
        const response = await fetch('/admin/api/sellers');
        if (!response.ok) {
            console.error('Sellers API Error:', response.status);
            return;
        }
        const sellers = await response.json();
        
        const tbody = document.getElementById('sellers-table');
        tbody.innerHTML = sellers.map(seller => `
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.artisan_name || seller.shop_name}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.email}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.indigenous_tribe || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.seller_type || 'Artisan'}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.verification_status}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    <button class="text-blue-600 hover:underline" onclick="viewSeller(${seller.id})">View</button>
                    <button class="text-green-600 hover:underline ml-2" onclick="approveSeller(${seller.id})">Approve</button>
                    <button class="text-red-600 hover:underline ml-2" onclick="rejectSeller(${seller.id})">Reject</button>
                    <button class="text-red-600 hover:underline ml-2" onclick="deleteSeller(${seller.id})">Delete</button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error('Error loading sellers:', error);
    }
}

// Load Products
async function loadProducts() {
    try {
        const response = await fetch('/admin/api/products');
        if (!response.ok) {
            console.error('Products API Error:', response.status);
            return;
        }
        const products = await response.json();

        const grid = document.getElementById('products-grid');
        grid.innerHTML = products.map(product => `
            <div class="bg-white rounded-lg shadow p-4">
                <img src="/assets/products/${product.image || 'default.jpg'}" class="w-full h-48 object-cover rounded-lg mb-2" onerror="this.src='/assets/logo/dark-green-logo.png'">
                <h4 class="text-lg font-semibold text-gray-900">${product.name}</h4>
                <p class="text-gray-600">${product.category}</p>
                <p class="text-gray-800 font-bold mt-2">₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                <p class="text-gray-500 mt-1 text-sm">Status: <span class="font-medium capitalize ${product.approval_status === 'approved' ? 'text-green-600' : product.approval_status === 'pending' ? 'text-yellow-600' : 'text-red-600'}">${product.approval_status}</span></p>
                <p class="text-gray-500 text-sm">By: ${product.seller?.artisan_name || 'Unknown'}</p>
                <div class="flex gap-2 mt-3">
                    ${product.approval_status === 'approved' 
                        ? `<span class="flex-1 text-center py-2 px-3 bg-green-50 text-green-700 rounded text-sm font-medium">✓ Approved</span>` 
                        : `<button class="flex-1 text-blue-600 hover:bg-blue-50 py-2 px-3 rounded text-sm font-medium transition-colors" onclick="approveProduct(${product.id})">Approve</button>
                           <button class="flex-1 text-yellow-600 hover:bg-yellow-50 py-2 px-3 rounded text-sm font-medium transition-colors" onclick="rejectProduct(${product.id})">Reject</button>`
                    }
                    <button class="flex-1 text-red-600 hover:bg-red-50 py-2 px-3 rounded text-sm font-medium transition-colors" onclick="deleteProduct(${product.id})">Delete</button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

// Load Stories
async function loadStories() {
    try {
        const response = await fetch('/admin/api/stories');
        if (!response.ok) {
            console.error('Stories API Error:', response.status);
            return;
        }
        const stories = await response.json();

        const container = document.getElementById('stories-list');
        if (stories.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No stories yet. Click "Add Story" to create one.</div>';
            return;
        }
        container.innerHTML = stories.map(story => `
            <div class="bg-white rounded-lg shadow overflow-hidden">
                ${story.image ? `<img src="/assets/stories/${story.image}" class="w-full h-48 object-cover" onerror="this.src='/assets/logo/dark-green-logo.png'">` : '<div class="w-full h-48 bg-gray-200 flex items-center justify-center"><span class="text-gray-400">No Image</span></div>'}
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="text-lg font-semibold text-gray-900">${story.title}</h4>
                        <span class="px-2 py-1 text-xs rounded ${story.published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${story.published ? 'Published' : 'Draft'}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">By ${story.author_name}</p>
                    <p class="text-sm text-gray-500 mb-2">${story.tribe || 'No tribe specified'}</p>
                    <p class="text-gray-700 text-sm line-clamp-3 mb-4">${story.excerpt}</p>
                    <div class="flex gap-2">
                        <button onclick="editStory(${story.id})" class="flex-1 text-blue-600 hover:bg-blue-50 py-2 px-3 rounded text-sm font-medium transition-colors">Edit</button>
                        <button onclick="deleteStory(${story.id})" class="flex-1 text-red-600 hover:bg-red-50 py-2 px-3 rounded text-sm font-medium transition-colors">Delete</button>
                        <button onclick="togglePublishStory(${story.id}, ${story.published})" class="flex-1 text-green-600 hover:bg-green-50 py-2 px-3 rounded text-sm font-medium transition-colors">
                            ${story.published ? 'Unpublish' : 'Publish'}
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading stories:', error);
    }
}

// Load Donations
async function loadDonations() {
    try {
        const response = await fetch('/admin/api/donations');
        if (!response.ok) {
            console.error('Donations API Error:', response.status);
            return;
        }
        const donations = await response.json();

        const container = document.getElementById('donations-list');
        if (donations.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No donation initiatives yet. Click "Add Initiative" to create one.</div>';
            return;
        }
        container.innerHTML = donations.map(donation => {
            const progress = donation.target_amount > 0 ? ((donation.current_amount || 0) / donation.target_amount * 100) : 0;
            return `
            <div class="bg-white rounded-lg shadow overflow-hidden">
                ${donation.image ? `<img src="/assets/donations/${donation.image}" class="w-full h-48 object-cover" onerror="this.src='/assets/logo/dark-green-logo.png'">` : '<div class="w-full h-48 bg-gray-200 flex items-center justify-center"><span class="text-gray-400">No Image</span></div>'}
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="text-lg font-semibold text-gray-900">${donation.title}</h4>
                        <span class="px-2 py-1 text-xs rounded ${donation.status === 'active' ? 'bg-green-100 text-green-800' : donation.status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'}">
                            ${donation.status || 'active'}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">${donation.tribe || 'No tribe specified'}</p>
                    <p class="text-gray-700 text-sm mb-3 line-clamp-2">${donation.description}</p>
                    ${donation.target_amount ? `
                        <div class="mb-3">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Progress</span>
                                <span class="font-semibold text-gray-900">${progress.toFixed(1)}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-[#5B5843] h-2 rounded-full" style="width: ${Math.min(progress, 100)}%"></div>
                            </div>
                            <div class="flex justify-between text-xs mt-1">
                                <span class="text-gray-600">₱${parseFloat(donation.current_amount || 0).toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                                <span class="text-gray-600">₱${parseFloat(donation.target_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                            </div>
                        </div>
                    ` : ''}
                    <div class="flex gap-2">
                        <button onclick="updateDonationProgress(${donation.id})" class="flex-1 text-green-600 hover:bg-green-50 py-2 px-3 rounded text-sm font-medium transition-colors">Update</button>
                        <button onclick="editDonation(${donation.id})" class="flex-1 text-blue-600 hover:bg-blue-50 py-2 px-3 rounded text-sm font-medium transition-colors">Edit</button>
                        <button onclick="deleteDonation(${donation.id})" class="flex-1 text-red-600 hover:bg-red-50 py-2 px-3 rounded text-sm font-medium transition-colors">Delete</button>
                    </div>
                </div>
            </div>
        `;
        }).join('');
    } catch (error) {
        console.error('Error loading donations:', error);
    }
}

// Load Featured Artists
async function loadFeaturedArtists() {
    try {
        const response = await fetch('/admin/api/featured-artists');
        if (!response.ok) {
            console.error('Featured Artists API Error:', response.status);
            return;
        }
        const artists = await response.json();

        const container = document.getElementById('featured-artists-list');
        if (artists.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No featured artists yet. Click "Add Featured Artist" to create one.</div>';
            return;
        }
        container.innerHTML = artists.map(artist => `
            <div class="bg-white rounded-lg shadow overflow-hidden">
                ${artist.image ? `<img src="/assets/artisans/${artist.image}" class="w-full h-48 object-cover" onerror="this.src='/assets/logo/dark-green-logo.png'">` : '<div class="w-full h-48 bg-gray-200 flex items-center justify-center"><span class="text-gray-400">No Image</span></div>'}
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="text-lg font-semibold text-gray-900">${artist.name}</h4>
                        <span class="px-2 py-1 text-xs rounded ${artist.active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                            ${artist.active ? 'Active' : 'Inactive'}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-1">${artist.tribe}</p>
                    <p class="text-sm text-[#5B5843] font-medium mb-2">${artist.craft}</p>
                    <p class="text-gray-700 text-sm mb-3 line-clamp-3">${artist.description || 'No description'}</p>
                    <p class="text-xs text-gray-500 mb-3">Display Order: ${artist.display_order}</p>
                    <div class="flex gap-2">
                        <button onclick="toggleActiveArtist(${artist.id}, ${artist.active})" class="flex-1 text-green-600 hover:bg-green-50 py-2 px-3 rounded text-sm font-medium transition-colors">
                            ${artist.active ? 'Deactivate' : 'Activate'}
                        </button>
                        <button onclick="editFeaturedArtist(${artist.id})" class="flex-1 text-blue-600 hover:bg-blue-50 py-2 px-3 rounded text-sm font-medium transition-colors">Edit</button>
                        <button onclick="deleteFeaturedArtist(${artist.id})" class="flex-1 text-red-600 hover:bg-red-50 py-2 px-3 rounded text-sm font-medium transition-colors">Delete</button>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading featured artists:', error);
    }
}

// Action Functions
function approveSeller(sellerId) {
    if (!confirm('Approve this seller?')) return;
    
    fetch(`/admin/api/sellers/${sellerId}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ verification_status: 'approved' })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Seller approved!');
            loadSellers();
        }
    });
}

function rejectSeller(sellerId) {
    if (!confirm('Reject this seller?')) return;
    
    fetch(`/admin/api/sellers/${sellerId}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ verification_status: 'rejected' })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Seller rejected!');
            loadSellers();
        }
    });
}

function deleteSeller(sellerId) {
    if (!confirm('Delete this seller? This action cannot be undone.')) return;
    
    fetch(`/admin/api/sellers/${sellerId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Seller deleted successfully!');
            loadSellers();
            loadAnalytics();
        } else {
            alert('Error deleting seller');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Error deleting seller');
    });
}

function deleteUser(userId) {
    if (!confirm('Delete this user? This action cannot be undone.')) return;
    
    fetch(`/admin/api/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('User deleted!');
            loadUsers();
        }
    });
}

function approveProduct(productId) {
    if (!confirm('Approve this product?')) return;
    
    fetch(`/admin/api/products/${productId}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ approval_status: 'approved' })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Product approved!');
            loadProducts();
            loadAnalytics();
        }
    });
}

function rejectProduct(productId) {
    if (!confirm('Reject this product?')) return;
    
    fetch(`/admin/api/products/${productId}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ approval_status: 'rejected' })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Product rejected!');
            loadProducts();
            loadAnalytics();
        }
    });
}

function deleteProduct(productId) {
    if (!confirm('Delete this product? This action cannot be undone.')) return;
    
    fetch(`/admin/api/products/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            if (data.archived) {
                alert('Product archived (has order history and cannot be permanently deleted)');
            } else {
                alert('Product deleted successfully!');
            }
            loadProducts();
            loadAnalytics();
        } else {
            alert('Error deleting product: ' + (data.message || 'Unknown error'));
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Error deleting product');
    });
}

function logoutAdmin() {
    if (!confirm('Logout?')) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/auth/logout';
    
    const token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_token';
    token.value = document.querySelector('meta[name="csrf-token"]').content;
    
    form.appendChild(token);
    document.body.appendChild(form);
    form.submit();
}

// Modal Functions
function openStoryModal(storyId = null) {
    const modal = document.getElementById('story-modal');
    const form = document.getElementById('story-form');
    const title = modal.querySelector('h3');
    
    if (storyId) {
        title.textContent = 'Edit Story';
        // Load story data
        fetch(`/admin/api/stories`)
            .then(res => res.json())
            .then(stories => {
                const story = stories.find(s => s.id == storyId);
                if (story) {
                    form.querySelector('[name="title"]').value = story.title;
                    form.querySelector('[name="author_name"]').value = story.author_name;
                    form.querySelector('[name="tribe"]').value = story.tribe || '';
                    form.querySelector('[name="excerpt"]').value = story.excerpt;
                    form.querySelector('[name="content"]').value = story.content;
                    form.querySelector('[name="published"]').checked = story.published;
                    form.dataset.storyId = storyId;
                }
            });
    } else {
        title.textContent = 'Add New Story';
        form.reset();
        delete form.dataset.storyId;
    }
    
    modal.classList.remove('hidden');
}

function closeStoryModal() {
    document.getElementById('story-modal').classList.add('hidden');
    document.getElementById('story-form').reset();
}

function openDonationModal(donationId = null) {
    const modal = document.getElementById('donation-modal');
    const form = document.getElementById('donation-form');
    const title = modal.querySelector('h3');
    
    if (donationId) {
        title.textContent = 'Edit Donation Initiative';
        fetch(`/admin/api/donations`)
            .then(res => res.json())
            .then(donations => {
                const donation = donations.find(d => d.id == donationId);
                if (donation) {
                    form.querySelector('[name="title"]').value = donation.title;
                    form.querySelector('[name="description"]').value = donation.description;
                    form.querySelector('[name="tribe"]').value = donation.tribe || '';
                    form.querySelector('[name="target_amount"]').value = donation.target_amount || '';
                    if (form.querySelector('[name="current_amount"]')) {
                        form.querySelector('[name="current_amount"]').value = donation.current_amount || 0;
                    }
                    if (form.querySelector('[name="status"]')) {
                        form.querySelector('[name="status"]').value = donation.status || 'active';
                    }
                    form.dataset.donationId = donationId;
                }
            });
    } else {
        title.textContent = 'Add Donation Initiative';
        form.reset();
        delete form.dataset.donationId;
    }
    
    modal.classList.remove('hidden');
}

function closeDonationModal() {
    document.getElementById('donation-modal').classList.add('hidden');
    document.getElementById('donation-form').reset();
}

function openFeaturedArtistModal(artistId = null) {
    const modal = document.getElementById('featured-artist-modal');
    const form = document.getElementById('featured-artist-form');
    const title = modal.querySelector('h3');
    
    if (artistId) {
        title.textContent = 'Edit Featured Artist';
        fetch(`/admin/api/featured-artists`)
            .then(res => res.json())
            .then(artists => {
                const artist = artists.find(a => a.id == artistId);
                if (artist) {
                    form.querySelector('[name="name"]').value = artist.name;
                    form.querySelector('[name="tribe"]').value = artist.tribe;
                    form.querySelector('[name="craft"]').value = artist.craft;
                    form.querySelector('[name="description"]').value = artist.description || '';
                    form.querySelector('[name="display_order"]').value = artist.display_order || 0;
                    form.dataset.artistId = artistId;
                }
            });
    } else {
        title.textContent = 'Add Featured Artist';
        form.reset();
        delete form.dataset.artistId;
    }
    
    modal.classList.remove('hidden');
}

function closeFeaturedArtistModal() {
    document.getElementById('featured-artist-modal').classList.add('hidden');
    document.getElementById('featured-artist-form').reset();
}

// Load Featured Communities
async function loadFeaturedCommunities() {
    try {
        const response = await fetch('/admin/api/featured-communities');
        if (!response.ok) {
            console.error('Featured Communities API Error:', response.status);
            return;
        }
        const communities = await response.json();

        const container = document.getElementById('featured-communities-list');
        if (communities.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No featured communities yet. Click "Add Featured Community" to create one.</div>';
            return;
        }
        container.innerHTML = communities.map(community => `
            <div class="bg-white rounded-lg shadow overflow-hidden">
                ${community.image ? `<img src="/assets/tribes/${community.image}" class="w-full h-48 object-cover" onerror="this.src='/assets/logo/dark-green-logo.png'">` : '<div class="w-full h-48 bg-gray-200 flex items-center justify-center"><span class="text-gray-400">No Image</span></div>'}
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="text-lg font-semibold text-gray-900">${community.name}</h4>
                        <span class="px-2 py-1 text-xs rounded ${community.active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                            ${community.active ? 'Active' : 'Inactive'}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">${community.region}</p>
                    <p class="text-gray-700 text-sm mb-3 line-clamp-3">${community.description || 'No description'}</p>
                    <p class="text-xs text-gray-500 mb-3">Display Order: ${community.display_order}</p>
                    <div class="flex gap-2">
                        <button onclick="toggleActiveCommunity(${community.id}, ${community.active})" class="flex-1 text-green-600 hover:bg-green-50 py-2 px-3 rounded text-sm font-medium transition-colors">
                            ${community.active ? 'Deactivate' : 'Activate'}
                        </button>
                        <button onclick="editFeaturedCommunity(${community.id})" class="flex-1 text-blue-600 hover:bg-blue-50 py-2 px-3 rounded text-sm font-medium transition-colors">Edit</button>
                        <button onclick="deleteFeaturedCommunity(${community.id})" class="flex-1 text-red-600 hover:bg-red-50 py-2 px-3 rounded text-sm font-medium transition-colors">Delete</button>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading featured communities:', error);
    }
}

function openFeaturedCommunityModal(communityId = null) {
    const modal = document.getElementById('featured-community-modal');
    const form = document.getElementById('community-form');
    const title = modal.querySelector('h3');
    
    if (communityId) {
        title.textContent = 'Edit Featured Community';
        fetch('/admin/api/featured-communities')
            .then(res => res.json())
            .then(communities => {
                const community = communities.find(c => c.id == communityId);
                if (community) {
                    form.querySelector('[name="name"]').value = community.name;
                    form.querySelector('[name="region"]').value = community.region;
                    form.querySelector('[name="description"]').value = community.description || '';
                    form.querySelector('[name="display_order"]').value = community.display_order;
                    form.dataset.communityId = communityId;
                }
            });
    } else {
        title.textContent = 'Add Featured Community';
        form.reset();
        delete form.dataset.communityId;
    }
    
    modal.classList.remove('hidden');
}

function closeFeaturedCommunityModal() {
    document.getElementById('featured-community-modal').classList.add('hidden');
    document.getElementById('community-form').reset();
}

function editFeaturedCommunity(communityId) {
    openFeaturedCommunityModal(communityId);
}

function toggleActiveCommunity(communityId, currentStatus) {
    const newStatus = !currentStatus;
    
    fetch(`/admin/api/featured-communities/${communityId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ active: newStatus })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            loadFeaturedCommunities();
        }
    });
}

function deleteFeaturedCommunity(communityId) {
    if (!confirm('Delete this community? This action cannot be undone.')) return;
    
    fetch(`/admin/api/featured-communities/${communityId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Community deleted!');
            loadFeaturedCommunities();
        }
    });
}

// Handle community form submission
document.getElementById('community-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const communityId = this.dataset.communityId;
    const url = communityId ? `/admin/api/featured-communities/${communityId}` : '/admin/api/featured-communities';
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert(communityId ? 'Community updated!' : 'Community created!');
            closeFeaturedCommunityModal();
            loadFeaturedCommunities();
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while saving the community');
    }
});

function viewSeller(sellerId) {
    alert('Seller details view to be implemented');
}

function filterSellers(status) {
    // Update active button
    document.querySelectorAll('.seller-filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-[#5B5843]', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    event.target.classList.add('active', 'bg-[#5B5843]', 'text-white');
    event.target.classList.remove('bg-gray-200', 'text-gray-700');
    
    // Load filtered sellers
    fetch(`/admin/api/sellers?status=${status}`)
        .then(res => res.json())
        .then(sellers => {
            const tbody = document.getElementById('sellers-table');
            tbody.innerHTML = sellers.map(seller => `
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">${seller.artisan_name || seller.shop_name}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${seller.email}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${seller.indigenous_tribe || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${seller.seller_type || 'Artisan'}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${seller.verification_status}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <button class="text-blue-600 hover:underline" onclick="viewSeller(${seller.id})">View</button>
                        <button class="text-green-600 hover:underline ml-2" onclick="approveSeller(${seller.id})">Approve</button>
                        <button class="text-red-600 hover:underline ml-2" onclick="rejectSeller(${seller.id})">Reject</button>
                    </td>
                </tr>
            `).join('');
        });
}

function filterProducts(status) {
    // Update active button
    document.querySelectorAll('.product-filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-[#5B5843]', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    event.target.classList.add('active', 'bg-[#5B5843]', 'text-white');
    event.target.classList.remove('bg-gray-200', 'text-gray-700');
    
    // Load filtered products
    const url = status === 'all' ? '/admin/api/products' : `/admin/api/products?status=${status}`;
    fetch(url)
        .then(res => res.json())
        .then(products => {
            const grid = document.getElementById('products-grid');
            grid.innerHTML = products.map(product => `
                <div class="bg-white rounded-lg shadow p-4">
                    <img src="/assets/products/${product.image || 'default.jpg'}" class="w-full h-48 object-cover rounded-lg mb-2" onerror="this.src='/assets/logo/dark-green-logo.png'">
                    <h4 class="text-lg font-semibold text-gray-900">${product.name}</h4>
                    <p class="text-gray-600">${product.category}</p>
                    <p class="text-gray-800 font-bold mt-2">₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                    <p class="text-gray-500 mt-1 text-sm">Status: <span class="font-medium">${product.approval_status}</span></p>
                    <p class="text-gray-500 text-sm">By: ${product.seller?.artisan_name || 'Unknown'}</p>
                    <div class="flex gap-2 mt-3">
                        <button class="flex-1 text-blue-600 hover:underline text-sm" onclick="approveProduct(${product.id})">Approve</button>
                        <button class="flex-1 text-red-600 hover:underline text-sm" onclick="deleteProduct(${product.id})">Delete</button>
                    </div>
                </div>
            `).join('');
        });
}

// Story CRUD Functions
function editStory(storyId) {
    openStoryModal(storyId);
}

function deleteStory(storyId) {
    if (!confirm('Delete this story? This action cannot be undone.')) return;
    
    fetch(`/admin/api/stories/${storyId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Story deleted successfully!');
            loadStories();
        } else {
            alert('Error deleting story');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Error deleting story');
    });
}

function togglePublishStory(storyId, currentStatus) {
    const action = currentStatus ? 'unpublish' : 'publish';
    if (!confirm(`${action.charAt(0).toUpperCase() + action.slice(1)} this story?`)) return;
    
    fetch(`/admin/api/stories`)
        .then(res => res.json())
        .then(stories => {
            const story = stories.find(s => s.id == storyId);
            if (story) {
                const formData = new FormData();
                formData.append('title', story.title);
                formData.append('author_name', story.author_name);
                formData.append('excerpt', story.excerpt);
                formData.append('content', story.content);
                formData.append('tribe', story.tribe || '');
                formData.append('published', !currentStatus ? '1' : '0');
                
                fetch(`/admin/api/stories/${storyId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        alert(`Story ${action}ed successfully!`);
                        loadStories();
                    }
                });
            }
        });
}

// Donation CRUD Functions
function editDonation(donationId) {
    openDonationModal(donationId);
}

function deleteDonation(donationId) {
    if (!confirm('Delete this donation initiative? This action cannot be undone.')) return;
    
    fetch(`/admin/api/donations/${donationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Donation initiative deleted successfully!');
            loadDonations();
        } else {
            alert('Error deleting donation initiative');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Error deleting donation initiative');
    });
}

function updateDonationProgress(donationId) {
    const newAmount = prompt('Enter the current donation amount:');
    if (newAmount === null) return;
    
    const amount = parseFloat(newAmount);
    if (isNaN(amount) || amount < 0) {
        alert('Please enter a valid amount');
        return;
    }
    
    fetch(`/admin/api/donations`)
        .then(res => res.json())
        .then(donations => {
            const donation = donations.find(d => d.id == donationId);
            if (donation) {
                const formData = new FormData();
                formData.append('title', donation.title);
                formData.append('description', donation.description);
                formData.append('target_amount', donation.target_amount || 0);
                formData.append('current_amount', amount);
                formData.append('tribe', donation.tribe || '');
                formData.append('status', donation.status || 'active');
                
                fetch(`/admin/api/donations/${donationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        alert('Donation progress updated successfully!');
                        loadDonations();
                    }
                });
            }
        });
}

// Featured Artist CRUD Functions
function editFeaturedArtist(artistId) {
    openFeaturedArtistModal(artistId);
}

function deleteFeaturedArtist(artistId) {
    if (!confirm('Delete this featured artist? This action cannot be undone.')) return;
    
    fetch(`/admin/api/featured-artists/${artistId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Featured artist deleted successfully!');
            loadFeaturedArtists();
        } else {
            alert('Error deleting featured artist');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Error deleting featured artist');
    });
}

function toggleActiveArtist(artistId, currentStatus) {
    const action = currentStatus ? 'deactivate' : 'activate';
    if (!confirm(`${action.charAt(0).toUpperCase() + action.slice(1)} this featured artist?`)) return;
    
    fetch(`/admin/api/featured-artists`)
        .then(res => res.json())
        .then(artists => {
            const artist = artists.find(a => a.id == artistId);
            if (artist) {
                const formData = new FormData();
                formData.append('name', artist.name);
                formData.append('tribe', artist.tribe);
                formData.append('craft', artist.craft);
                formData.append('description', artist.description || '');
                formData.append('display_order', artist.display_order || 0);
                formData.append('active', !currentStatus ? '1' : '0');
                if (artist.seller_id) formData.append('seller_id', artist.seller_id);
                
                fetch(`/admin/api/featured-artists/${artistId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        alert(`Featured artist ${action}d successfully!`);
                        loadFeaturedArtists();
                    }
                });
            }
        });
}

// Form Submit Handlers
document.addEventListener('DOMContentLoaded', function() {
    // Story Form
    const storyForm = document.getElementById('story-form');
    if (storyForm) {
        storyForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(storyForm);
            const storyId = storyForm.dataset.storyId;
            
            try {
                const url = storyId ? `/admin/api/stories/${storyId}` : '/admin/api/stories';
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    alert(storyId ? 'Story updated successfully!' : 'Story created successfully!');
                    storyForm.reset();
                    closeStoryModal();
                    loadStories();
                } else {
                    alert('Error saving story');
                }
            } catch (error) {
                console.error('Error creating/updating story:', error);
                alert('Error saving story');
            }
        });
    }
    
    // Donation Form
    const donationForm = document.getElementById('donation-form');
    if (donationForm) {
        donationForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(donationForm);
            const donationId = donationForm.dataset.donationId;
            
            try {
                const url = donationId ? `/admin/api/donations/${donationId}` : '/admin/api/donations';
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    alert(donationId ? 'Donation initiative updated successfully!' : 'Donation initiative created successfully!');
                    donationForm.reset();
                    closeDonationModal();
                    loadDonations();
                } else {
                    alert('Error saving donation initiative');
                }
            } catch (error) {
                console.error('Error creating/updating donation:', error);
                alert('Error saving donation initiative');
            }
        });
    }
    
    // Featured Artist Form
    const artistForm = document.getElementById('featured-artist-form');
    if (artistForm) {
        artistForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(artistForm);
            const artistId = artistForm.dataset.artistId;
            
            try {
                const url = artistId ? `/admin/api/featured-artists/${artistId}` : '/admin/api/featured-artists';
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    alert(artistId ? 'Featured artist updated successfully!' : 'Featured artist added successfully!');
                    artistForm.reset();
                    closeFeaturedArtistModal();
                    loadFeaturedArtists();
                } else {
                    alert('Error saving featured artist');
                }
            } catch (error) {
                console.error('Error creating/updating featured artist:', error);
                alert('Error saving featured artist');
            }
        });
    }
});
</script>
@endsection