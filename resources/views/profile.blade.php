@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-[#F8F4EE] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h1 class="text-4xl mb-8" style="font-family: 'Elinga', serif;">My Profile</h1>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Profile Tabs -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-24">
                    <nav class="flex flex-col">
                        <button data-tab="info" class="profile-tab active px-6 py-4 text-left border-l-4 border-[#5B5843] bg-gray-50 font-medium text-[#5B5843] transition-colors">
                            Personal Information
                        </button>
                        <button data-tab="password" class="profile-tab px-6 py-4 text-left border-l-4 border-transparent text-gray-600 hover:bg-gray-50 transition-colors">
                            Change Password
                        </button>
                        <button data-tab="orders" class="profile-tab px-6 py-4 text-left border-l-4 border-transparent text-gray-600 hover:bg-gray-50 transition-colors">
                            Order History
                        </button>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200">
                            @csrf
                            <button type="submit" class="w-full px-6 py-4 text-left text-red-600 hover:bg-red-50 transition-colors">
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information Tab -->
                <div id="info-tab" class="profile-content bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl mb-6" style="font-family: 'Elinga', serif;">Personal Information</h2>
                    
                    <form id="profile-form" class="space-y-5">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" id="full_name" name="full_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="phone_number" name="phone_number" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <input type="text" id="address" name="address" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        </div>

                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <input type="text" id="city" name="city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Province</label>
                                <input type="text" id="province" name="province" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            </div>
                        </div>

                        <button type="submit" class="bg-[#5B5843] text-white px-8 py-3 rounded-lg hover:bg-[#252525] transition-all duration-300 font-medium">
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Change Password Tab -->
                <div id="password-tab" class="profile-content hidden bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl mb-6" style="font-family: 'Elinga', serif;">Change Password</h2>
                    
                    <form id="password-form" class="space-y-5 max-w-md">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" id="new_password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent">
                        </div>

                        <button type="submit" class="bg-[#5B5843] text-white px-8 py-3 rounded-lg hover:bg-[#252525] transition-all duration-300 font-medium">
                            Update Password
                        </button>
                    </form>
                </div>

                <!-- Order History Tab -->
                <div id="orders-tab" class="profile-content hidden bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl mb-6" style="font-family: 'Elinga', serif;">Order History</h2>
                    
                    <div id="orders-list" class="space-y-4">
                        <!-- Orders will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div id="notification" class="fixed bottom-4 right-4 bg-[#5B5843] text-white px-6 py-4 rounded-lg shadow-lg transform translate-y-24 transition-transform duration-300 z-50">
    <p id="notification-text"></p>
</div>

<script>
// Tab switching
document.querySelectorAll('.profile-tab').forEach(tab => {
    tab.addEventListener('click', (e) => {
        const tabName = e.target.dataset.tab;
        
        document.querySelectorAll('.profile-tab').forEach(t => {
            t.classList.remove('active', 'bg-gray-50', 'border-[#5B5843]', 'text-[#5B5843]');
            t.classList.add('border-transparent', 'text-gray-600');
        });
        
        document.querySelectorAll('.profile-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        e.target.classList.add('active', 'bg-gray-50', 'border-[#5B5843]', 'text-[#5B5843]');
        e.target.classList.remove('border-transparent', 'text-gray-600');
        
        document.getElementById(`${tabName}-tab`).classList.remove('hidden');
        
        if (tabName === 'orders') {
            loadOrders();
        }
    });
});

// Load profile info
async function loadProfile() {
    try {
        const response = await fetch('/api/user/profile');
        const user = await response.json();
        
        document.getElementById('full_name').value = user.full_name;
        document.getElementById('email').value = user.email;
        document.getElementById('phone_number').value = user.phone_number;
        document.getElementById('address').value = user.address || '';
        document.getElementById('city').value = user.city || '';
        document.getElementById('province').value = user.province || '';
        document.getElementById('postal_code').value = user.postal_code || '';
    } catch (error) {
        console.error('Error loading profile:', error);
    }
}

// Update profile
document.getElementById('profile-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    try {
        const response = await fetch('/api/user/profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        if (result.success) {
            showNotification('Profile updated successfully!');
        }
    } catch (error) {
        showNotification('Failed to update profile', 'error');
    }
});

// Change password
document.getElementById('password-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    try {
        const response = await fetch('/api/user/password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        if (result.success) {
            showNotification('Password changed successfully!');
            e.target.reset();
        } else {
            showNotification(result.message, 'error');
        }
    } catch (error) {
        showNotification('Failed to change password', 'error');
    }
});

// Load orders
async function loadOrders() {
    try {
        const response = await fetch('/api/orders');
        const orders = await response.json();
        
        const container = document.getElementById('orders-list');
        
        if (orders.length === 0) {
            container.innerHTML = '<p class="text-gray-600">No orders yet</p>';
            return;
        }
        
        container.innerHTML = orders.map(order => {
            const statusMap = {
                'pending': { label: 'Pending', class: 'bg-yellow-100 text-yellow-800' },
                'to_ship': { label: 'To Ship', class: 'bg-blue-100 text-blue-800' },
                'shipped': { label: 'Shipped', class: 'bg-purple-100 text-purple-800' },
                'to_receive': { label: 'To Receive', class: 'bg-indigo-100 text-indigo-800' },
                'completed': { label: 'Completed', class: 'bg-green-100 text-green-800' },
                'cancelled': { label: 'Cancelled', class: 'bg-red-100 text-red-800' }
            };
            const status = statusMap[order.status] || statusMap['pending'];
            
            return `
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-gray-900">Order #${order.id}</h3>
                                <p class="text-sm text-gray-600">${new Date(order.created_at).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                })}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium ${status.class}">
                                ${status.label}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2 mb-3">
                            ${order.items.slice(0, 2).map(item => `
                                <div class="flex items-center gap-3">
                                    <img src="/assets/products/${item.product.image}" alt="${item.product.name}" class="w-12 h-12 object-cover rounded">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate">${item.product.name}</p>
                                        <p class="text-xs text-gray-500">Qty: ${item.quantity}</p>
                                    </div>
                                </div>
                            `).join('')}
                            ${order.items.length > 2 ? `<p class="text-xs text-gray-500">+${order.items.length - 2} more items</p>` : ''}
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <p class="text-lg font-bold text-[#5B5843]">₱${parseFloat(order.total_amount).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
                            <a href="/order-invoice?order=${order.id}" class="text-sm text-[#5B5843] hover:text-[#252525] font-medium">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    } catch (error) {
        console.error('Error loading orders:', error);
    }
}

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

// Handle URL hash for direct tab access
function handleHashNav() {
    const hash = window.location.hash.substring(1);
    if (hash) {
        const tab = document.querySelector(`[data-tab="${hash}"]`);
        if (tab) {
            tab.click();
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
    handleHashNav();
});

window.addEventListener('hashchange', handleHashNav);
</script>
@endsection
