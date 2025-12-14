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
    console.log('Shop page DOMContentLoaded');
    console.log('openShopProductModal available?', typeof window.openShopProductModal);
    loadProducts();
    loadFilters();
    setupEventListeners();
    setupFilterModal();
});

function loadProducts(params = {}) {
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
                
                // Add click handler to card (with retry logic for modal function)
                productCard.addEventListener('click', (e) => {
                    console.log('Product card clicked, ID:', product.id);
                    console.log('openShopProductModal exists?', typeof window.openShopProductModal);
                    
                    // Retry mechanism if function not ready yet
                    let attempts = 0;
                    const tryOpenModal = () => {
                        if (typeof window.openShopProductModal === 'function') {
                            window.openShopProductModal(product.id);
                        } else if (attempts < 10) {
                            attempts++;
                            setTimeout(tryOpenModal, 100);
                        } else {
                            console.error('openShopProductModal is not available after retries');
                        }
                    };
                    tryOpenModal();
                });
                
                // Add specific click handler to view button
                const viewBtn = productCard.querySelector('.view-product-btn');
                if (viewBtn) {
                    viewBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('View button clicked, ID:', product.id);
                        
                        // Retry mechanism if function not ready yet
                        let attempts = 0;
                        const tryOpenModal = () => {
                            if (typeof window.openShopProductModal === 'function') {
                                window.openShopProductModal(product.id);
                            } else if (attempts < 10) {
                                attempts++;
                                setTimeout(tryOpenModal, 100);
                            } else {
                                console.error('openShopProductModal is not available after retries');
                            }
                        };
                        tryOpenModal();
                    });
                }
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

// Define modal functions BEFORE DOMContentLoaded
window.openShopProductModal = async function(productId) {
    console.log('Opening modal for product:', productId);
    try {
        const response = await fetch(`/api/products/${productId}`);
        const product = await response.json();
        
        document.getElementById('modal-product-name').textContent = product.name;
        document.getElementById('modal-product-price').textContent = `₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
        document.getElementById('modal-product-description').textContent = product.description;
        document.getElementById('modal-product-community').textContent = product.community;
        document.getElementById('modal-product-category').textContent = `Category: ${product.category}`;
        document.getElementById('modal-product-image').src = `/assets/products/${product.image}`;
        document.getElementById('modal-product-image').alt = product.name;
        document.getElementById('modal-product-seller').textContent = `By ${product.seller.artisan_name}`;
        document.getElementById('modal-product-stock').textContent = `${product.stock} items available`;
        
        const quantityInput = document.getElementById('modal-quantity');
        quantityInput.value = 1;
        quantityInput.max = product.stock;
        quantityInput.setAttribute('data-product-id', productId);
        
        document.getElementById('shop-product-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
    } catch (error) {
        console.error('Error loading product:', error);
        alert('Failed to load product details');
    }
};

window.closeShopProductModal = function() {
    document.getElementById('shop-product-modal').classList.add('hidden');
    document.body.style.overflow = '';
};

console.log('Modal functions defined:', typeof window.openShopProductModal);
</script>

<!-- Product Modal HTML -->
<div id="shop-product-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" onclick="closeShopProductModal()"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 overflow-hidden">
            <button onclick="closeShopProductModal()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-8 mb-6">
                    <div>
                        <img id="modal-product-image" src="" alt="" class="w-full rounded-xl mb-4">
                    </div>
                    <div>
                        <h2 id="modal-product-name" class="text-3xl font-bold mb-2" style="font-family: 'Elinga', serif;"></h2>
                        <p id="modal-product-community" class="text-lg text-[#5B5843] futura-500 mb-2"></p>
                        <p id="modal-product-category" class="text-sm text-gray-600 mb-4"></p>
                        <p id="modal-product-price" class="text-2xl font-bold text-[#252525] mb-6"></p>
                        <p id="modal-product-description" class="text-gray-600 leading-relaxed mb-6"></p>
                        <div class="mb-6">
                            <p id="modal-product-stock" class="text-sm text-gray-600 mb-4"></p>
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-sm font-medium">Quantity:</span>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" id="modal-decrease-qty" class="px-3 py-2 text-gray-600 hover:bg-gray-100">−</button>
                                    <input id="modal-quantity" type="number" min="1" value="1" class="w-12 text-center border-l border-r border-gray-300 py-2" readonly>
                                    <button type="button" id="modal-increase-qty" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                                </div>
                            </div>
                            <button type="button" id="modal-add-to-cart-btn" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#252525] transition-all duration-300 tracking-wide font-medium">
                                Add to Cart
                            </button>
                        </div>
                        <div class="pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-1">Sold by:</p>
                            <p id="modal-product-seller" class="text-lg font-semibold text-[#252525]"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal event listeners
document.addEventListener('DOMContentLoaded', function() {
    const decreaseBtn = document.getElementById('modal-decrease-qty');
    const increaseBtn = document.getElementById('modal-increase-qty');
    const quantityInput = document.getElementById('modal-quantity');
    const addToCartBtn = document.getElementById('modal-add-to-cart-btn');
    
    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const currentVal = parseInt(quantityInput.value);
            if (currentVal > 1) {
                quantityInput.value = currentVal - 1;
            }
        });
    }
    
    if (increaseBtn) {
        increaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const currentVal = parseInt(quantityInput.value);
            const maxVal = parseInt(quantityInput.max);
            if (currentVal < maxVal) {
                quantityInput.value = currentVal + 1;
            }
        });
    }
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const quantity = parseInt(quantityInput.value);
            const productName = document.getElementById('modal-product-name').textContent;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('Please sign in to add items to cart');
                document.getElementById('auth-modal')?.classList.remove('hidden');
                return;
            }
            
            // Get product ID from the last opened modal
            const productId = quantityInput.getAttribute('data-product-id');
            if (!productId) {
                console.error('No product ID found');
                return;
            }
            
            try {
                const response = await fetch('/api/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        quantity: quantity
                    })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    alert('Product added to cart!');
                    if (typeof window.updateCartCount === 'function') {
                        window.updateCartCount();
                    }
                    setTimeout(() => window.closeShopProductModal(), 500);
                } else if (response.status === 401 || response.status === 419) {
                    alert('Please sign in to add items to cart');
                    document.getElementById('auth-modal')?.classList.remove('hidden');
                } else {
                    alert(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert('Error adding to cart');
            }
        });
    }
});
</script>

@endsection
