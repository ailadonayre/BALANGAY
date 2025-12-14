@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-[#F8F4EE] min-h-screen">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-4">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-4xl mb-2" style="font-family: 'Elinga', serif;">Order Placed Successfully!</h1>
            <p class="text-gray-600">Thank you for supporting our artisans</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <!-- Order Header -->
            <div class="bg-[#5B5843] text-white p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Order Number</p>
                        <h2 class="text-3xl font-bold" id="order-number">#0000</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-90 mb-1">Order Date</p>
                        <p class="text-lg" id="order-date">-</p>
                    </div>
                </div>
            </div>

            <!-- Order Info -->
            <div class="p-6 border-b border-gray-200">
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status</p>
                        <span id="order-status" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                        <p class="font-medium" id="payment-method">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Payment Status</p>
                        <span id="payment-status" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Pending
                        </span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-3">Shipping Address</h3>
                <p class="text-gray-700" id="shipping-address">-</p>
            </div>

            <!-- Order Items -->
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                <div id="order-items" class="space-y-4">
                    <!-- Items will be loaded here -->
                </div>
            </div>

            <!-- Order Total -->
            <div class="bg-gray-50 p-6">
                <div class="flex justify-between items-center text-xl font-bold">
                    <span>Total Amount</span>
                    <span id="order-total" class="text-[#5B5843]">₱0.00</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="/profile#orders" class="flex-1 bg-[#5B5843] text-white text-center py-4 rounded-full hover:bg-[#252525] transition-all duration-300 font-medium tracking-wide">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                View My Orders
            </a>
            <a href="/shop" class="flex-1 bg-white text-[#5B5843] border-2 border-[#5B5843] text-center py-4 rounded-full hover:bg-[#5B5843] hover:text-white transition-all duration-300 font-medium tracking-wide">
                Continue Shopping
            </a>
        </div>

        <!-- Info Message -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-2">What's Next?</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• The seller will process your order and update the status</li>
                        <li>• You'll receive updates in your profile's order section</li>
                        <li>• Track your order status: To Ship → Shipped → To Receive → Completed</li>
                        <li>• Contact the seller if you have any questions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function loadOrderDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('order');
    
    if (!orderId) {
        window.location.href = '/shop';
        return;
    }
    
    try {
        const response = await fetch(`/api/orders/${orderId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to load order');
        }
        
        const order = await response.json();
        
        // Update order details
        document.getElementById('order-number').textContent = `#${order.id}`;
        document.getElementById('order-date').textContent = new Date(order.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Status
        const statusEl = document.getElementById('order-status');
        const statusMap = {
            'pending': { label: 'Pending', class: 'bg-yellow-100 text-yellow-800' },
            'to_ship': { label: 'To Ship', class: 'bg-blue-100 text-blue-800' },
            'shipped': { label: 'Shipped', class: 'bg-purple-100 text-purple-800' },
            'to_receive': { label: 'To Receive', class: 'bg-indigo-100 text-indigo-800' },
            'completed': { label: 'Completed', class: 'bg-green-100 text-green-800' },
            'cancelled': { label: 'Cancelled', class: 'bg-red-100 text-red-800' }
        };
        const status = statusMap[order.status] || statusMap['pending'];
        statusEl.textContent = status.label;
        statusEl.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${status.class}`;
        
        // Payment
        document.getElementById('payment-method').textContent = order.payment_method.toUpperCase();
        const paymentStatusEl = document.getElementById('payment-status');
        paymentStatusEl.textContent = order.payment_status === 'paid' ? 'Paid' : 'Pending';
        paymentStatusEl.className = order.payment_status === 'paid' 
            ? 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800'
            : 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800';
        
        document.getElementById('shipping-address').textContent = order.shipping_address;
        
        // Order items
        const itemsContainer = document.getElementById('order-items');
        itemsContainer.innerHTML = order.items.map(item => `
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                <img src="/assets/products/${item.product.image}" alt="${item.product.name}" class="w-20 h-20 object-cover rounded-lg">
                <div class="flex-1">
                    <h4 class="font-semibold">${item.product.name}</h4>
                    <p class="text-sm text-gray-600">Quantity: ${item.quantity}</p>
                </div>
                <div class="text-right">
                    <p class="font-semibold">₱${parseFloat(item.subtotal).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                    <p class="text-sm text-gray-600">₱${parseFloat(item.unit_price).toLocaleString('en-PH', { minimumFractionDigits: 2 })} each</p>
                </div>
            </div>
        `).join('');
        
        document.getElementById('order-total').textContent = `₱${parseFloat(order.total_amount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
        
    } catch (error) {
        console.error('Error loading order:', error);
        alert('Failed to load order details');
        window.location.href = '/shop';
    }
}

document.addEventListener('DOMContentLoaded', loadOrderDetails);
</script>
@endsection
