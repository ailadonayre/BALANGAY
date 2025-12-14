<!-- CHECKOUT PAGE (resources/views/checkout.blade.php) -->
@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-[#F8F4EE] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h1 class="text-4xl mb-8" style="font-family: 'Elinga', serif;">Checkout</h1>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <form id="checkout-form" class="space-y-6">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <h2 class="text-2xl mb-6" style="font-family: 'Elinga', serif;">Shipping Information</h2>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" name="first_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" name="last_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                            <input type="text" name="address" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        </div>
                        
                        <div class="grid md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <input type="text" name="city" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                                <input type="text" name="province" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                                <input type="text" name="postal_code" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <h2 class="text-2xl mb-6" style="font-family: 'Elinga', serif;">Payment Method</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#5B5843] transition-colors">
                                <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-[#5B5843] focus:ring-[#5B5843]">
                                <span class="ml-3 flex-1">Cash on Delivery</span>
                            </label>
                            
                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#5B5843] transition-colors">
                                <input type="radio" name="payment_method" value="gcash" class="w-5 h-5 text-[#5B5843] focus:ring-[#5B5843]">
                                <span class="ml-3 flex-1">GCash</span>
                            </label>
                            
                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-[#5B5843] transition-colors">
                                <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-[#5B5843] focus:ring-[#5B5843]">
                                <span class="ml-3 flex-1">Bank Transfer</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl p-6 shadow-lg sticky top-24">
                    <h2 class="text-2xl mb-6" style="font-family: 'Elinga', serif;">Order Summary</h2>
                    
                    <div id="checkout-items" class="space-y-3 mb-6 pb-6 border-b border-gray-200 max-h-64 overflow-y-auto">
                        <!-- Order items will be loaded here -->
                    </div>
                    
                    <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span id="checkout-subtotal">₱0.00</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between text-xl font-bold mb-6">
                        <span>Total</span>
                        <span id="checkout-total">₱0.00</span>
                    </div>
                    
                    <button type="submit" form="checkout-form" class="w-full bg-[#5B5843] text-white py-4 rounded-full hover:bg-[#5B5843] transition-all duration-300 font-medium tracking-wide">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Confirmation Modal -->
<div id="order-success-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 text-center">
        <div class="mb-4">
            <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold mb-2" style="font-family: 'Elinga', serif;">Order Confirmed!</h2>
        <p class="text-gray-600 mb-2">Thank you for your order.</p>
        <p class="text-sm text-gray-500 mb-6">Order ID: <span id="success-order-id" class="font-mono font-bold"></span></p>
        <p class="text-gray-600 mb-6">We've received your order and will process it shortly. You'll receive an email confirmation with tracking information.</p>
        <button onclick="window.location.href='/orders'" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#5B5843] transition-all duration-300 font-medium">
            View My Orders
        </button>
    </div>
</div>

<script>
async function loadCheckoutSummary() {
    try {
        const response = await fetch('/api/cart');
        const data = await response.json();
        
        const container = document.getElementById('checkout-items');
        container.innerHTML = data.items.map(item => `
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">${item.product.name} × ${item.quantity}</span>
                <span class="font-medium">₱${(parseFloat(item.product.price) * item.quantity).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</span>
            </div>
        `).join('');
        
        const formatted = `₱${parseFloat(data.total).toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
        document.getElementById('checkout-subtotal').textContent = formatted;
        document.getElementById('checkout-total').textContent = formatted;
        
    } catch (error) {
        console.error('Error loading checkout summary:', error);
    }
}

document.getElementById('checkout-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    // Combine address fields
    const shipping_address = `${data.address}, ${data.city}, ${data.province} ${data.postal_code}`;
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';
    
    try {
        const response = await fetch('/api/orders/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                customer_name: `${data.first_name} ${data.last_name}`,
                customer_email: data.email,
                customer_phone: data.phone,
                shipping_address: shipping_address,
                payment_method: data.payment_method
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show success modal
            document.getElementById('success-order-id').textContent = `#${result.order_id}`;
            document.getElementById('order-success-modal').classList.remove('hidden');
            
            // Redirect after 3 seconds
            setTimeout(() => {
                window.location.href = '/orders';
            }, 3000);
        } else {
            alert(result.message || 'Order failed. Please try again.');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    } catch (error) {
        alert('Order failed. Please try again.');
        console.error('Error placing order:', error);
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

document.addEventListener('DOMContentLoaded', loadCheckoutSummary);
</script>
@endsection