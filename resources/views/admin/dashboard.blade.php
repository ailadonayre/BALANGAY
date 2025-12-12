@extends('layouts.app')

@section('content')
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
                    <button onclick="switchAdminTab('donations')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Donations
                    </button>
                    <button onclick="switchAdminTab('featured')" class="admin-tab px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Featured Artists
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
                    <div id="stories-list" class="space-y-4">
                        <!-- Stories will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Donations Tab -->
        <div id="donations-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Donation Initiatives</h3>
                    <button onclick="openDonationModal()" class="bg-[#5B5843] text-white px-6 py-2 rounded-lg hover:bg-[#4a4735]">
                        + Add Initiative
                    </button>
                </div>
                <div class="p-6">
                    <div id="donations-list" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Donations will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Artists Tab -->
        <div id="featured-tab" class="admin-content hidden">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Featured Artists</h3>
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
                <div>
                    <label class="block text-sm font-medium mb-2">Target Amount (Optional)</label>
                    <input type="number" name="target_amount" step="0.01" class="w-full px-4 py-2 border rounded-lg">
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
}

// Load Analytics
async function loadAnalytics() {
    try {
        const response = await fetch('/admin/api/analytics');
        const analytics = await response.json();
        
        document.getElementById('stat-users').textContent = analytics.total_users;
        document.getElementById('stat-sellers').textContent = analytics.verified_sellers;
        document.getElementById('stat-products').textContent = analytics.total_products;
        document.getElementById('stat-revenue').textContent = '₱' + parseFloat(analytics.total_revenue).toLocaleString('en-PH', { minimumFractionDigits: 2 });
        
        document.getElementById('homepage-artisans').textContent = analytics.artisans_supported;
        document.getElementById('homepage-products-sold').textContent = analytics.products_sold;
        document.getElementById('homepage-income').textContent = '₱' + parseFloat(analytics.income_provided).toLocaleString('en-PH', { minimumFractionDigits: 2 });
        document.getElementById('homepage-orders').textContent = analytics.orders_count;
        
        document.getElementById('pending-sellers-count').textContent = analytics.pending_sellers;
        document.getElementById('pending-products-count').textContent = analytics.pending_products;
        
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
        const users = await response.json();
        
        const tbody = document.getElementById('users-table');
        tbody.innerHTML = users.map(user => `
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900">${user.full_name}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${user.email}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${user.phone}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${new Date(user.created_at).toLocaleDateString()}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    <button class="text-blue-600 hover:underline" onclick="editUser(${user.id})">Edit</button>
                    <button class="text-red-600 hover:underline ml-2" onclick="deleteUser(${user.id})">Delete</button>
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
        const sellers = await response.json();
        
        const tbody = document.getElementById('sellers-table');
        tbody.innerHTML = sellers.map(seller => `
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.full_name}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.email}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.tribe || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.type}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${seller.status}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    <button class="text-blue-600 hover:underline" onclick="viewSeller(${seller.id})">View</button>
                    <button class="text-green-600 hover:underline ml-2" onclick="approveSeller(${seller.id})">Approve</button>
                    <button class="text-red-600 hover:underline ml-2" onclick="rejectSeller(${seller.id})">Reject</button>
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
        const products = await response.json();

        const grid = document.getElementById('products-grid');
        grid.innerHTML = products.map(product => `
            <div class="bg-white rounded-lg shadow p-4">
                <img src="/storage/products/${product.image}" class="w-full h-48 object-cover rounded-lg mb-2">
                <h4 class="text-lg font-semibold text-gray-900">${product.name}</h4>
                <p class="text-gray-600">${product.category}</p>
                <p class="text-gray-800 font-bold mt-2">₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                <p class="text-gray-500 mt-1 text-sm">Status: ${product.approval_status}</p>
                <div class="flex gap-2 mt-3">
                    <button class="flex-1 text-blue-600 hover:underline" onclick="editProduct(${product.id})">Edit</button>
                    <button class="flex-1 text-red-600 hover:underline" onclick="deleteProduct(${product.id})">Delete</button>
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
        const stories = await response.json();

        const container = document.getElementById('stories-list');
        container.innerHTML = stories.map(story => `
            <div class="p-4 bg-gray-50 rounded-lg shadow">
                <h4 class="text-lg font-semibold">${story.title}</h4>
                <p class="text-gray-600 text-sm">${story.author_name} - ${story.tribe || 'N/A'}</p>
                <p class="text-gray-800 mt-2">${story.excerpt}</p>
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
        const donations = await response.json();

        const container = document.getElementById('donations-list');
        container.innerHTML = donations.map(donation => `
            <div class="p-4 bg-gray-50 rounded-lg shadow">
                <h4 class="text-lg font-semibold">${donation.title}</h4>
                <p class="text-gray-600">${donation.tribe || 'N/A'}</p>
                <p class="text-gray-800 mt-2">${donation.description}</p>
                <p class="text-gray-700 mt-1 font-bold">Target: ${donation.target_amount ? '₱' + parseFloat(donation.target_amount).toLocaleString('en-PH') : 'N/A'}</p>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading donations:', error);
    }
}

// Load Featured Artists
async function loadFeaturedArtists() {
    try {
        const response = await fetch('/admin/api/featured-artists');
        const artists = await response.json();

        const container = document.getElementById('featured-artists-list');
        container.innerHTML = artists.map(artist => `
            <div class="p-4 bg-gray-50 rounded-lg shadow">
                <img src="/storage/featured/${artist.image}" class="w-full h-40 object-cover rounded-lg mb-2">
                <h4 class="text-lg font-semibold">${artist.name}</h4>
                <p class="text-gray-600">${artist.tribe} - ${artist.craft}</p>
                <p class="text-gray-800 mt-2">${artist.description}</p>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading featured artists:', error);
    }
}
</script>
@endsection