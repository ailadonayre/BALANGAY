@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Seller Dashboard</h1>
                <p class="text-gray-600 mt-2">Welcome back, {{ Auth::guard('seller')->user()->artisan_name }}!</p>
            </div>
            <button onclick="logoutSeller()" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                Logout
            </button>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-3 mr-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Products</p>
                        <p id="total-products" class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-lg p-3 mr-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Sales</p>
                        <p id="total-sales" class="text-2xl font-bold text-gray-900">₱0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-lg p-3 mr-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4m8 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m8 0H8m0 0l-1-1m1 1l1-1m-1 1v3"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Orders</p>
                        <p id="total-orders" class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Community</p>
                        <p id="seller-community" class="text-2xl font-bold text-gray-900">-</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">My Products</h2>
                <button onclick="openAddProductModal()" class="bg-[#5B5843] text-white px-4 py-2 rounded-lg hover:bg-[#4a4735] transition-colors">
                    + Add Product
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Price</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Stock</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Category</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="products-table">
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Loading products...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadSellerData();
});

function loadSellerData() {
    const seller = @json(Auth::guard('seller')->user());
    
    if (!seller) {
        window.location.href = '/';
        return;
    }

    // Update community
    document.getElementById('seller-community').textContent = seller.community || 'N/A';
    
    // Fetch seller's products
    fetch(`/api/sellers/${seller.id}/products`)
        .then(response => response.json())
        .then(data => {
            console.log('Products data:', data);
            const products = data || [];
            
            let totalProducts = products.length;
            let totalSales = 0;
            let totalOrders = 0;

            const tbody = document.getElementById('products-table');
            tbody.innerHTML = '';

            if (products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No products yet. Add your first product!</td></tr>';
            } else {
                products.forEach(product => {
                    totalSales += parseFloat(product.price || 0) * (product.stock || 0);
                    const row = document.createElement('tr');
                    row.className = 'border-b border-gray-200 hover:bg-gray-50';
                    row.innerHTML = `
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">${product.name}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">₱${parseFloat(product.price).toFixed(2)}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${product.stock}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${product.category || 'N/A'}</td>
                        <td class="px-6 py-4 text-sm">
                            <button onclick="editProduct(${product.id})" class="text-blue-600 hover:text-blue-800 mr-4">Edit</button>
                            <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-800">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            document.getElementById('total-products').textContent = totalProducts;
            document.getElementById('total-sales').textContent = '₱' + totalSales.toLocaleString('en-PH', { minimumFractionDigits: 2 });
        })
        .catch(error => console.error('Error loading products:', error));
}

function openAddProductModal() {
    alert('Add Product feature coming soon!');
}

function editProduct(productId) {
    alert('Edit Product feature coming soon!');
}

function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        alert('Delete Product feature coming soon!');
    }
}

function logoutSeller() {
    if (confirm('Are you sure you want to logout?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/auth/logout';
        form.innerHTML = '<input type="hidden" name="_token" value="' + document.querySelector('meta[name="csrf-token"]').content + '">';
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection
