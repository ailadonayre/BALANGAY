@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shop Crafts</h1>
        
        <!-- Search Bar with Filter Button -->
        <div class="mb-8">
            <div class="flex gap-3 relative">
                <input type="text" id="search-input" placeholder="Search products..." 
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg text-base focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                <button id="filter-toggle-btn" class="px-6 py-3 bg-[#5B5843] text-white rounded-lg hover:bg-[#4a4735] transition-colors font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <span class="hidden sm:inline">Filters</span>
                </button>
            </div>
            
            <!-- Filter Popup Modal -->
            <div id="filter-modal" class="hidden mt-3 bg-white rounded-lg shadow-lg p-6 w-full sm:w-96 max-h-96 overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Filters</h2>
                    <button id="filter-close-btn" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
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
                
                <div class="flex gap-3">
                    <button id="clear-filters" class="flex-1 bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Clear
                    </button>
                    <button id="filter-apply-btn" class="flex-1 bg-[#5B5843] text-white py-2 rounded-lg hover:bg-[#4a4735] transition-colors font-medium">
                        Apply
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div id="products-grid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <!-- Products will be loaded here -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded fired');
    loadProducts();
    loadFilters();
    setupEventListeners();
    setupFilterModal();
});

function loadProducts(params = {}) {
    console.log('loadProducts called with params:', params);
    const queryString = new URLSearchParams(params).toString();
    const url = `/api/products/search?${queryString}`;
    console.log('Fetching from URL:', url);
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('API Response:', data);
            const grid = document.getElementById('products-grid');
            grid.innerHTML = '';
            
            // Handle both paginated and non-paginated responses
            let products = [];
            if (data.data) {
                // Paginated response
                products = Array.isArray(data.data) ? data.data : [];
            } else if (Array.isArray(data)) {
                // Non-paginated response
                products = data;
            }
            
            if (!products || products.length === 0) {
                grid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No products found</div>';
                return;
            }
            
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'group cursor-pointer product-shop-card';
                productCard.setAttribute('data-product-id', product.id);
                productCard.innerHTML = `
                    <div class="relative overflow-hidden rounded-lg bg-white aspect-square mb-4 shadow-md">
                        <img data-src="/assets/products/${product.image}" loading="lazy" decoding="async" alt="${product.name}" class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110 lazy">
                        
                        <!-- Quick Add Button -->
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <button class="view-product-btn bg-white text-[#5B5843] px-5 py-2.5 rounded-full text-[10px] sm:text-xs tracking-wider uppercase futura-500 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 flex items-center gap-2">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span class="hidden sm:inline">View</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="px-1">
                        <h3 class="text-sm md:text-base mb-1.5 futura-500 group-hover:text-[#5B5843] transition-colors duration-300 line-clamp-2">
                            ${product.name}
                        </h3>
                        <p class="text-[#5B5843] text-base md:text-lg futura-700">
                            ₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}
                        </p>
                    </div>
                `;
                grid.appendChild(productCard);
                
                // Add click handler to open modal
                productCard.addEventListener('click', (e) => {
                    if (!e.target.closest('button')) {
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
    const filterModal = document.getElementById('filter-modal');

    function getFilterParams() {
        return {
            q: searchInput.value,
            category: categoryFilter.value,
            community: communityFilter.value,
            sort: sortFilter.value
        };
    }

    searchInput.addEventListener('input', () => loadProducts(getFilterParams()));
    
    categoryFilter.addEventListener('change', () => {
        loadProducts(getFilterParams());
        filterModal.classList.add('hidden');
    });
    
    communityFilter.addEventListener('change', () => {
        loadProducts(getFilterParams());
        filterModal.classList.add('hidden');
    });
    
    sortFilter.addEventListener('change', () => {
        loadProducts(getFilterParams());
        filterModal.classList.add('hidden');
    });

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        categoryFilter.value = '';
        communityFilter.value = '';
        sortFilter.value = '';
        loadProducts();
        filterModal.classList.add('hidden');
    });
}

function setupFilterToggle() {
    const toggleBtn = document.getElementById('toggle-filters');
    const filtersContent = document.getElementById('filters-content');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            filtersContent.classList.toggle('hidden');
            toggleBtn.classList.toggle('rotate-45');
        });
    }
}

function setupFilterModal() {
    const filterToggleBtn = document.getElementById('filter-toggle-btn');
    const filterCloseBtn = document.getElementById('filter-close-btn');
    const filterModal = document.getElementById('filter-modal');
    const filterApplyBtn = document.getElementById('filter-apply-btn');
    
    if (filterToggleBtn && filterCloseBtn && filterModal) {
        filterToggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            filterModal.classList.toggle('hidden');
        });
        
        filterCloseBtn.addEventListener('click', () => {
            filterModal.classList.add('hidden');
        });
        
        if (filterApplyBtn) {
            filterApplyBtn.addEventListener('click', () => {
                filterModal.classList.add('hidden');
            });
        }
        
        // Close modal when clicking elsewhere on the page
        document.addEventListener('click', (e) => {
            if (!filterModal.contains(e.target) && !filterToggleBtn.contains(e.target)) {
                filterModal.classList.add('hidden');
            }
        });
    }
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
