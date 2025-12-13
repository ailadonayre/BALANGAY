@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-[#F8F4EE]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 text-sm">
            <ol class="flex items-center space-x-2">
                <li><a href="/" class="text-gray-600 hover:text-[#5B5843]">Home</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="/shop" class="text-gray-600 hover:text-[#5B5843]">Shop</a></li>
                <li class="text-gray-400">/</li>
                <li id="product-category" class="text-gray-600"></li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 bg-white rounded-2xl p-8 shadow-lg">
            <!-- Product Image -->
            <div class="space-y-4">
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                    <img id="product-image" src="" alt="" class="w-full h-full object-cover">
                </div>
                
                <!-- Thumbnail Gallery (Optional) -->
                <div class="grid grid-cols-4 gap-4">
                    <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 cursor-pointer hover:opacity-75 transition-opacity">
                        <img id="product-thumb-1" src="" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <div class="mb-4">
                    <p id="product-community" class="text-[#5B5843] text-sm mb-2 uppercase tracking-wide"></p>
                    <h1 id="product-name" class="text-4xl mb-4" style="font-family: 'Elinga', serif;"></h1>
                    <p id="product-price" class="text-3xl text-[#252525] font-bold mb-6"></p>
                </div>

                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-3">Description</h3>
                    <p id="product-description" class="text-gray-600 leading-relaxed"></p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-3">Artisan Details</h3>
                    <p id="seller-name" class="text-gray-600"></p>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Quantity</label>
                    <div class="flex items-center space-x-4">
                        <button id="decrease-qty" class="w-10 h-10 rounded-full border border-gray-300 hover:border-[#5B5843] flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="10" class="w-20 text-center border border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        <button id="increase-qty" class="w-10 h-10 rounded-full border border-gray-300 hover:border-[#5B5843] flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <p id="stock-info" class="text-sm text-gray-500 mt-2"></p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 mb-6">
                    <button id="add-to-cart-btn" class="flex-1 bg-[#5B5843] text-white py-4 rounded-full hover:bg-[#252525] transition-all duration-300 font-medium tracking-wide">
                        Add to Cart
                    </button>
                    <button class="w-14 h-14 border-2 border-gray-300 rounded-full hover:border-[#5B5843] flex items-center justify-center transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Product Features -->
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#5B5843]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>100% Handcrafted</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#5B5843]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Fair Trade Certified</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#5B5843]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Supports Indigenous Communities</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-16">
            <h2 class="text-3xl mb-8" style="font-family: 'Elinga', serif;">Related Products</h2>
            <div id="related-products" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Related products will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div id="notification" class="fixed bottom-4 right-4 bg-[#5B5843] text-white px-6 py-4 rounded-lg shadow-lg transform translate-y-24 transition-transform duration-300 z-50">
    <p id="notification-text"></p>
</div>

<script>
// Get product ID from URL
const productId = window.location.pathname.split('/').pop();

// Fetch product details
async function loadProduct() {
    try {
        const response = await fetch(`/api/products/${productId}`);
        const product = await response.json();
        
        // Update page content
        document.getElementById('product-name').textContent = product.name;
        document.getElementById('product-price').textContent = `₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
        document.getElementById('product-description').textContent = product.description;
        document.getElementById('product-community').textContent = product.community;
        document.getElementById('product-category').textContent = product.category;
        document.getElementById('product-image').src = `/assets/products/${product.image}`;
        document.getElementById('product-image').alt = product.name;
        document.getElementById('product-thumb-1').src = `/assets/products/${product.image}`;
        document.getElementById('seller-name').textContent = `By ${product.seller.artisan_name}`;
        document.getElementById('stock-info').textContent = `${product.stock} items available`;
        
        // Update max quantity
        document.getElementById('quantity').max = product.stock;
        
        // Load related products
        loadRelatedProducts(product.category, product.id);
        
    } catch (error) {
        console.error('Error loading product:', error);
    }
}

// Load related products
async function loadRelatedProducts(category, currentProductId) {
    try {
        const response = await fetch(`/api/products/category/${category}`);
        const data = await response.json();
        
        const relatedProducts = data.data.filter(p => p.id !== parseInt(currentProductId)).slice(0, 4);
        const container = document.getElementById('related-products');
        
        container.innerHTML = relatedProducts.map(product => `
            <a href="/product/${product.id}" class="group">
                <div class="relative overflow-hidden rounded-xl bg-white aspect-square mb-4 shadow-md">
                    <img src="/assets/products/${product.image}" alt="${product.name}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </div>
                <h3 class="text-base mb-2 group-hover:text-[#5B5843] transition-colors">${product.name}</h3>
                <p class="text-[#252525] text-lg font-bold">₱${parseFloat(product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
            </a>
        `).join('');
    } catch (error) {
        console.error('Error loading related products:', error);
    }
}

// Quantity controls
document.getElementById('decrease-qty').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    if (input.value > 1) input.value = parseInt(input.value) - 1;
});

document.getElementById('increase-qty').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    if (input.value < max) input.value = parseInt(input.value) + 1;
});

// Add to cart
document.getElementById('add-to-cart-btn').addEventListener('click', async () => {
    const quantity = parseInt(document.getElementById('quantity').value);
    
    try {
        const response = await fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('Product added to cart!');
            updateCartCount();
        } else {
            showNotification(data.message, 'error');
        }
    } catch (error) {
        showNotification('Please sign in to add items to cart', 'error');
    }
});

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    const notificationText = document.getElementById('notification-text');
    
    notificationText.textContent = message;
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
            const countElement = document.getElementById('cart-count');
            if (countElement) {
                countElement.textContent = data.count || 0;
            }
        }
    } catch (error) {
        console.error('Error updating cart count:', error);
    }
}

// Load product on page load
document.addEventListener('DOMContentLoaded', () => {
    loadProduct();
    updateCartCount();
});
</script>
@endsection