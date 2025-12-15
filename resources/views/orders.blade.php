@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-[#F8F4EE] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h1 class="text-4xl mb-8" style="font-family: 'Elinga', serif;">My Orders</h1>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div id="orders-container" class="divide-y divide-gray-200">
                <!-- Orders will be loaded here -->
            </div>
            
            <div id="empty-orders" class="hidden p-12 text-center">
                <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h2 class="text-2xl mb-2 text-gray-900">No orders yet</h2>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                <a href="/shop" class="inline-block bg-[#5B5843] text-white px-8 py-3 rounded-full hover:bg-[#252525] transition-all duration-300">
                    Start Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<script>
async function loadOrders() {
    try {
        const response = await fetch('/api/orders');
        const orders = await response.json();
        
        const container = document.getElementById('orders-container');
        const emptyOrders = document.getElementById('empty-orders');
        
        if (orders.length === 0) {
            container.classList.add('hidden');
            emptyOrders.classList.remove('hidden');
            return;
        }
        
        container.innerHTML = orders.map(order => `
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="grid lg:grid-cols-4 gap-6 items-start">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Order ID</p>
                        <p class="text-lg font-bold">#${order.id}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Date</p>
                        <p class="text-lg">${new Date(order.created_at).toLocaleDateString()}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium inline-block ${
                            order.status === 'completed' ? 'bg-green-100 text-green-800' :
                            order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                            order.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                            'bg-blue-100 text-blue-800'
                        }">
                            ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600 mb-1">Total</p>
                        <p class="text-2xl font-bold text-[#5B5843]">₱${parseFloat(order.total_amount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                        <a href="#order-${order.id}" class="text-sm text-[#5B5843] hover:text-[#252525] transition-colors mt-2 inline-block">View Details →</a>
                    </div>
                </div>
                
                <div id="order-${order.id}" class="hidden mt-4 pt-4 border-t border-gray-200 space-y-2">
                    <h4 class="font-medium mb-3">Order Items</h4>
                    ${order.items.map(item => `
                        <div class="flex gap-4 p-3 bg-gray-50 rounded-lg">
                            <img src="/assets/products/${item.product.image}" alt="${item.product.name}" class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <p class="font-medium">${item.product.name}</p>
                                <p class="text-sm text-gray-600">Qty: ${item.quantity}</p>
                                <p class="font-medium">₱${parseFloat(item.unit_price).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                            </div>
                        </div>
                    `).join('')}
                    <p class="text-sm text-gray-600 mt-3"><strong>Shipping Address:</strong> ${order.shipping_address}</p>
                </div>
            </div>
        `).join('');
        
        // Add click handlers for expanding order details
        document.querySelectorAll('a[href^="#order-"]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const orderId = link.href.split('#')[1];
                const details = document.getElementById(orderId);
                details.classList.toggle('hidden');
                link.textContent = details.classList.contains('hidden') ? 'View Details →' : 'Hide Details ↓';
            });
        });
        
    } catch (error) {
        console.error('Error loading orders:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadOrders);
</script>
@endsection
