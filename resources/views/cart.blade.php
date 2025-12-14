<!-- CART PAGE (resources/views/cart.blade.php) -->
@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-[#F8F4EE] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h1 class="text-4xl mb-8" style="font-family: 'Elinga', serif;">Shopping Cart</h1>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <div id="cart-items" class="space-y-4">
                    <!-- Cart items will be loaded here -->
                </div>
                
                <div id="empty-cart" class="hidden bg-white rounded-xl p-12 text-center">
                    <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h2 class="text-2xl mb-2">Your cart is empty</h2>
                    <p class="text-gray-600 mb-6">Add some beautiful handcrafted items to get started</p>
                    <a href="/shop" class="inline-block bg-[#5B5843] text-white px-8 py-3 rounded-full hover:bg-[#5B5843] transition-all duration-300">
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl p-6 shadow-lg sticky top-24">
                    <h2 class="text-2xl mb-6" style="font-family: 'Elinga', serif;">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span id="subtotal">₱0.00</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between text-xl font-bold mb-6">
                        <span>Total</span>
                        <span id="total">₱0.00</span>
                    </div>
                    
                    <button id="checkout-btn" class="w-full bg-[#5B5843] text-white py-4 rounded-full hover:bg-[#5B5843] transition-all duration-300 font-medium tracking-wide mb-3">
                        Proceed to Checkout
                    </button>
                    
                    <a href="/shop" class="block text-center text-[#5B5843] hover:text-[#5B5843] transition-colors">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load cart
async function loadCart() {
    try {
        const response = await fetch('/api/cart');
        const data = await response.json();
        
        if (data.items.length === 0) {
            document.getElementById('cart-items').classList.add('hidden');
            document.getElementById('empty-cart').classList.remove('hidden');
            return;
        }
        
        document.getElementById('cart-items').classList.remove('hidden');
        document.getElementById('empty-cart').classList.add('hidden');
        
        const container = document.getElementById('cart-items');
        container.innerHTML = data.items.map(item => `
            <div class="bg-white rounded-xl p-6 shadow-md flex gap-6" data-cart-id="${item.id}">
                <img data-src="/assets/products/${item.product.image}" loading="lazy" decoding="async" src="/assets/logo/dark-green-logo.png" alt="${item.product.name}" class="w-24 h-24 object-cover rounded-lg lazy" onerror="this.src='/assets/logo/dark-green-logo.png'">
                
                <div class="flex-1">
                    <h3 class="text-lg font-medium mb-2">${item.product.name}</h3>
                    <p class="text-gray-600 text-sm mb-3">${item.product.community}</p>
                    <p class="text-xl font-bold text-[#5B5843]">₱${parseFloat(item.product.price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                </div>
                
                <div class="flex flex-col items-end justify-between">
                    <button class="text-gray-400 hover:text-red-600 transition-colors" onclick="removeFromCart(${item.id})">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    
                    <div class="flex items-center gap-3">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="w-8 h-8 rounded-full border border-gray-300 hover:border-[#5B5843] flex items-center justify-center transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <span class="w-8 text-center font-medium">${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="w-8 h-8 rounded-full border border-gray-300 hover:border-[#5B5843] flex items-center justify-center transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
        
        updateTotals(data.total);
        
    } catch (error) {
        console.error('Error loading cart:', error);
    }
}

function updateTotals(total) {
    const formatted = `₱${parseFloat(total).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
    document.getElementById('subtotal').textContent = formatted;
    document.getElementById('total').textContent = formatted;
}

async function updateQuantity(cartId, quantity) {
    if (quantity < 1) return;
    
    try {
        const response = await fetch(`/api/cart/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity })
        });
        
        if (response.ok) {
            loadCart();
        }
    } catch (error) {
        console.error('Error updating cart:', error);
    }
}

async function removeFromCart(cartId) {
    if (!confirm('Remove this item from cart?')) return;
    
    try {
        const response = await fetch(`/api/cart/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            loadCart();
            updateCartCount();
        }
    } catch (error) {
        console.error('Error removing from cart:', error);
    }
}

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

document.getElementById('checkout-btn').addEventListener('click', () => {
    window.location.href = '/checkout';
});

document.addEventListener('DOMContentLoaded', loadCart);
</script>
@endsection

