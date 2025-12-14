<!-- Shop Product Modal -->
<div id="shop-product-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" onclick="closeShopProductModal()"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 overflow-hidden">
            <!-- Close Button -->
            <button onclick="closeShopProductModal()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-8 mb-6">
                    <!-- Product Image -->
                    <div>
                        <img id="modal-product-image" data-src="" loading="lazy" decoding="async" src="" alt="" class="w-full rounded-xl mb-4 lazy">
                    </div>

                    <!-- Product Info -->
                    <div>
                        <h2 id="modal-product-name" class="text-3xl font-bold mb-2" style="font-family: 'Elinga', serif;"></h2>
                        <p id="modal-product-community" class="text-lg text-[#5B5843] futura-500 mb-2"></p>
                        <p id="modal-product-category" class="text-sm text-gray-600 mb-4"></p>
                        <p id="modal-product-price" class="text-2xl font-bold text-[#5B5843] mb-6"></p>
                        
                        <p id="modal-product-description" class="text-gray-600 leading-relaxed mb-6"></p>

                        <div class="mb-6">
                            <p id="modal-product-stock" class="text-sm text-gray-600 mb-4"></p>

                            <!-- Quantity Selector -->
                            <div class="flex items-center gap-4 mb-6">
                                <span class="text-sm font-medium">Quantity:</span>
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" id="modal-decrease-qty" class="px-3 py-2 text-gray-600 hover:bg-gray-100">−</button>
                                    <input id="modal-quantity" type="number" min="1" value="1" class="w-12 text-center border-l border-r border-gray-300 py-2" readonly>
                                    <button type="button" id="modal-increase-qty" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button id="modal-add-to-cart-btn" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#5B5843] transition-all duration-300 tracking-wide font-medium">
                                Add to Cart
                            </button>
                        </div>

                        <!-- Seller Info -->
                        <div class="pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-1">Sold by:</p>
                            <p id="modal-product-seller" class="text-lg font-semibold text-[#5B5843]"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// UTILITY FUNCTIONS
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${type === 'error' ? 'bg-red-500' : 'bg-green-500'} transform transition-all duration-300`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

async function updateCartCount() {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) return;
        
        const response = await fetch('/api/cart', {
            headers: {
                'X-CSRF-TOKEN': csrfToken.content
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            const badge = document.getElementById('cart-count');
            if (badge && data.items) {
                const totalItems = data.items.reduce((sum, item) => sum + item.quantity, 0);
                badge.textContent = totalItems;
                badge.style.display = totalItems > 0 ? 'flex' : 'none';
            }
        }
    } catch (error) {
        console.error('Error updating cart count:', error);
    }
}

// GLOBAL FUNCTIONS - For external access
window.showShopNotification = showNotification;
window.updateCartCount = updateCartCount;

// Modal functionality
(function() {
    'use strict';
    
    let currentShopProductId = null;
    let currentMaxStock = 0;

    // Open shop product modal
    window.openShopProductModal = async function(productId) {
        try {
            const response = await fetch(`/api/products/${productId}`);
            const product = await response.json();
            
            currentShopProductId = productId;
            currentMaxStock = product.stock;
            
            // Update modal content
            document.getElementById('modal-product-name').textContent = product.name;
            document.getElementById('modal-product-price').textContent = `₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
            document.getElementById('modal-product-description').textContent = product.description;
            document.getElementById('modal-product-community').textContent = product.community;
            document.getElementById('modal-product-category').textContent = `Category: ${product.category}`;
            document.getElementById('modal-product-image').src = `/assets/products/${product.image}`;
            document.getElementById('modal-product-image').alt = product.name;
            document.getElementById('modal-product-seller').textContent = `By ${product.seller.artisan_name}`;
            document.getElementById('modal-product-stock').textContent = `${product.stock} items available`;
            
            // Reset quantity
            const quantityInput = document.getElementById('modal-quantity');
            quantityInput.value = 1;
            quantityInput.max = product.stock;
            
            // Show modal
            document.getElementById('shop-product-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
        } catch (error) {
            console.error('Error loading product:', error);
            showNotification('Failed to load product details', 'error');
        }
    };

    // Close shop product modal
    window.closeShopProductModal = function() {
        document.getElementById('shop-product-modal').classList.add('hidden');
        document.body.style.overflow = '';
        currentShopProductId = null;
        currentMaxStock = 0;
    };
    
    // Set up quantity controls and add to cart button
    function setupModalEventListeners() {
        const decreaseBtn = document.getElementById('modal-decrease-qty');
        const increaseBtn = document.getElementById('modal-increase-qty');
        const quantityInput = document.getElementById('modal-quantity');
        const addToCartBtn = document.getElementById('modal-add-to-cart-btn');
        
        // Decrease quantity
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const currentVal = parseInt(quantityInput.value);
                if (currentVal > 1) {
                    quantityInput.value = currentVal - 1;
                }
            });
        }
        
        // Increase quantity
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
        
        // Add to cart
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', async function(e) {
                e.preventDefault();
                
                if (!currentShopProductId) {
                    console.error('No product selected');
                    return;
                }
                
                const quantity = parseInt(quantityInput.value);
                
                // Check authentication
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    showNotification('Please sign in to add items to cart', 'error');
                    setTimeout(() => {
                        const authModal = document.getElementById('auth-modal');
                        if (authModal) authModal.classList.remove('hidden');
                    }, 1000);
                    return;
                }
                
                // Add to cart
                try {
                    const response = await fetch('/api/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.content
                        },
                        body: JSON.stringify({
                            product_id: parseInt(currentShopProductId),
                            quantity: quantity
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        showNotification('Product added to cart!');
                        updateCartCount();
                        setTimeout(() => window.closeShopProductModal(), 500);
                    } else if (response.status === 401 || response.status === 419) {
                        showNotification('Please sign in to add items to cart', 'error');
                        setTimeout(() => {
                            const authModal = document.getElementById('auth-modal');
                            if (authModal) authModal.classList.remove('hidden');
                        }, 1000);
                    } else {
                        showNotification(data.message || 'Failed to add to cart', 'error');
                    }
                } catch (error) {
                    console.error('Error adding to cart:', error);
                    showNotification('Error adding to cart', 'error');
                }
            });
        }
    }
    
    // Initialize event listeners when safe
    function initModal() {
        if (document.getElementById('modal-decrease-qty')) {
            setupModalEventListeners();
        } else {
            // Elements not ready yet, wait a bit
            setTimeout(initModal, 50);
        }
    }
    
    // Start initialization
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModal);
    } else {
        initModal();
    }
})();

