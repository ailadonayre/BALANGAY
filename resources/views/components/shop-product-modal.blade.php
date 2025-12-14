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
                                    <button id="modal-decrease-qty" class="px-3 py-2 text-gray-600 hover:bg-gray-100">−</button>
                                    <input id="modal-quantity" type="number" min="1" value="1" class="w-12 text-center border-l border-r border-gray-300 py-2" readonly>
                                    <button id="modal-increase-qty" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
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
let currentShopProductId = null;

// Open shop product modal
async function openShopProductModal(productId) {
    try {
        const response = await fetch(`/api/products/${productId}`);
        const product = await response.json();
        
        currentShopProductId = productId;
        
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
        document.getElementById('modal-quantity').value = 1;
        document.getElementById('modal-quantity').max = product.stock;
        
        document.getElementById('shop-product-modal').classList.remove('hidden');
    } catch (error) {
        console.error('Error loading product:', error);
    }
}

// Close shop product modal
function closeShopProductModal() {
    document.getElementById('shop-product-modal').classList.add('hidden');
    currentShopProductId = null;
}

// Quantity controls for modal
document.addEventListener('DOMContentLoaded', () => {
    const decreaseBtn = document.getElementById('modal-decrease-qty');
    const increaseBtn = document.getElementById('modal-increase-qty');
    const quantityInput = document.getElementById('modal-quantity');
    const addToCartBtn = document.getElementById('modal-add-to-cart-btn');

    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', () => {
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    }

    if (increaseBtn) {
        increaseBtn.addEventListener('click', () => {
            const max = parseInt(quantityInput.max);
            if (quantityInput.value < max) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
            }
        });
    }

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async () => {
            if (!currentShopProductId) return;
            
            const quantity = parseInt(document.getElementById('modal-quantity').value);
            
            try {
                const response = await fetch('/api/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: currentShopProductId,
                        quantity: quantity
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showShopNotification('Product added to cart!');
                    updateCartCount();
                    closeShopProductModal();
                } else {
                    showShopNotification(data.message, 'error');
                }
            } catch (error) {
                showShopNotification('Please sign in to add items to cart', 'error');
            }
        });
    }
});

// Show notification for shop
function showShopNotification(message, type = 'success') {
    // Check if notification exists, if not create it
    let notification = document.getElementById('shop-notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'shop-notification';
        notification.className = 'fixed bottom-4 right-4 bg-[#5B5843] text-white px-6 py-4 rounded-lg shadow-lg transform translate-y-24 transition-transform duration-300 z-50';
        document.body.appendChild(notification);
    }
    
    notification.textContent = message;
    notification.style.transform = 'translateY(0)';
    
    if (type === 'error') {
        notification.classList.remove('bg-[#5B5843]');
        notification.classList.add('bg-red-600');
    } else {
        notification.classList.remove('bg-red-600');
        notification.classList.add('bg-[#5B5843]');
    }
    
    setTimeout(() => {
        notification.style.transform = 'translateY(8rem)';
    }, 3000);
}

// Update cart count
async function updateCartCount() {
    try {
        const response = await fetch('/api/cart');
        if (response.ok) {
            const data = await response.json();
            const cartCountEl = document.getElementById('cart-count');
            if (cartCountEl) {
                cartCountEl.textContent = data.count || 0;
            }
        }
    } catch (error) {
        console.error('Error updating cart count:', error);
    }
}
}
</script>
