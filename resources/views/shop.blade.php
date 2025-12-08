@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shop Crafts</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>
                    
                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" id="search-input" placeholder="Search products..." 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select id="category-filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            <option value="">All Categories</option>
                        </select>
                    </div>
                    
                    <!-- Community Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Community</label>
                        <select id="community-filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            <option value="">All Communities</option>
                        </select>
                    </div>
                    
                    <!-- Sort -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select id="sort-filter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            <option value="">Newest</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="popular">Most Popular</option>
                        </select>
                    </div>
                    
                    <button id="clear-filters" class="w-full bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                        Clear Filters
                    </button>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Products will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    loadFilters();
    setupEventListeners();
});

function loadProducts(params = {}) {
    const queryString = new URLSearchParams(params).toString();
    fetch(`/api/products/search?${queryString}`)
        .then(response => response.json())
        .then(data => {
            const grid = document.getElementById('products-grid');
            grid.innerHTML = '';
            
            if (!data.data || data.data.length === 0) {
                grid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No products found</div>';
                return;
            }
            
            data.data.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer product-shop-card';
                productCard.setAttribute('data-product-id', product.id);
                productCard.innerHTML = `
                    <div class="relative">
                        <img src="/assets/products/${product.image}" alt="${product.name}" class="w-full h-48 object-cover hover:opacity-90 transition-opacity">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">${product.name}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">${product.description || ''}</p>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-[#5B5843] font-bold text-lg">₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</span>
                            <span class="text-sm ${product.stock > 0 ? 'text-green-600' : 'text-red-600'}">
                                ${product.stock > 0 ? `${product.stock} in stock` : 'Out of stock'}
                            </span>
                        </div>
                        <button class="w-full bg-[#5B5843] text-white py-2 rounded-lg hover:bg-[#4a4735] transition-colors" 
                            onclick="if(${product.stock} > 0) openShopProductModal(${product.id}); event.stopPropagation();">
                            View Details
                        </button>
                    </div>
                `;
                grid.appendChild(productCard);
                
                // Add click handler to open modal
                productCard.addEventListener('click', () => {
                    if (productCard.getAttribute('data-product-id')) {
                        openShopProductModal(product.id);
                    }
                });
            });
        })
        .catch(error => console.error('Error loading products:', error));
}

function loadFilters() {
    fetch('/api/categories')
        .then(response => response.json())
        .then(categories => {
            const select = document.getElementById('category-filter');
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat;
                option.textContent = cat;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading categories:', error));

    fetch('/api/products-communities')
        .then(response => response.json())
        .then(communities => {
            const select = document.getElementById('community-filter');
            communities.forEach(comm => {
                const option = document.createElement('option');
                option.value = comm;
                option.textContent = comm;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading communities:', error));
}

function setupEventListeners() {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const communityFilter = document.getElementById('community-filter');
    const sortFilter = document.getElementById('sort-filter');
    const clearBtn = document.getElementById('clear-filters');

    function getFilterParams() {
        return {
            q: searchInput.value,
            category: categoryFilter.value,
            community: communityFilter.value,
            sort: sortFilter.value
        };
    }

    searchInput.addEventListener('input', () => loadProducts(getFilterParams()));
    categoryFilter.addEventListener('change', () => loadProducts(getFilterParams()));
    communityFilter.addEventListener('change', () => loadProducts(getFilterParams()));
    sortFilter.addEventListener('change', () => loadProducts(getFilterParams()));

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        categoryFilter.value = '';
        communityFilter.value = '';
        sortFilter.value = '';
        loadProducts();
    });
}

function addToCart(productId) {
    @auth
        const quantity = 1;
        fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ product_id: productId, quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product added to cart!');
            } else {
                alert(data.message || 'Failed to add product to cart');
            }
        })
        .catch(error => console.error('Error:', error));
    @else
        alert('Please log in to add items to cart');
        document.getElementById('auth-modal').classList.remove('hidden');
    @endauth
}
</script>
@endsection
