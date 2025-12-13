<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/50 transition-all duration-300" id="main-nav">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#discover" class="nav-link text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Discover</a>
                <a href="#shop" class="nav-link text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Shop</a>
                <a href="#stories" class="nav-link text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Stories</a>
                <a href="#support" class="nav-link text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Support</a>
            </div>

            <!-- Center Logo -->
            <div class="flex-1 flex justify-center px-6">
                <a href="/" class="block">
                    <img src="{{ asset('assets/logo/dark-green-logo.png') }}" alt="BALANGAY" class="h-10 w-auto transition-transform duration-300 hover:scale-105">
                </a>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-6">
                @auth('admin')
                    <!-- Admin Dashboard Link - No Profile/Cart Icons -->
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300 text-sm font-medium">
                        Admin Dashboard
                    </a>
                @endauth
                
                @auth('seller')
                    <!-- Seller Dashboard Link -->
                    <a href="{{ route('seller.dashboard') }}" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300 text-sm font-medium">
                        Dashboard
                    </a>
                @endauth
                
                @if(!auth('admin')->check() && !auth('seller')->check())
                    @auth
                        <!-- Logged In User - Profile Icon Links to Profile -->
                        <a href="{{ route('profile') }}" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300" aria-label="Profile">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @else
                        <!-- Not Logged In - Profile Icon Opens Auth Modal -->
                        <button onclick="openAuthModal()" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300" aria-label="Account">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                    @endauth
                @endif

                <!-- Cart Icon - Only for Regular Users (Not Sellers or Admins) -->
                @if (!auth('seller')->check() && !auth('admin')->check())
                    @auth
                        <!-- Logged In User - Cart Icon Links to Cart -->
                        <a href="{{ route('cart') }}" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300 relative" aria-label="Cart">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span id="cart-count" class="absolute -top-2 -right-2 bg-[#5B5843] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>
                    @else
                        <!-- Not Logged In - Cart Icon Opens Auth Modal -->
                        <button onclick="openAuthModal()" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300 relative" aria-label="Cart">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span id="cart-count" class="absolute -top-2 -right-2 bg-[#5B5843] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </button>
                    @endauth
                @endif

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden hidden bg-white border-t border-gray-200" id="mobile-menu">
        <div class="px-6 py-4 space-y-3">
            <a href="#discover" class="nav-link block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Discover</a>
            <a href="#shop" class="nav-link block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Shop</a>
            <a href="#stories" class="nav-link block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Stories</a>
            <a href="#support" class="nav-link block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Support</a>
        </div>
    </div>
</nav>

<script>
// Handle navigation links - all redirect to home with anchor
function setupNavLinks() {
    document.querySelectorAll('a.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Always navigate to home with the anchor
            if (window.location.pathname === '/' || window.location.pathname === '') {
                // Already on home - smooth scroll to section
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    document.getElementById('mobile-menu')?.classList.add('hidden');
                }
            } else {
                // Not on home - redirect to home with anchor
                e.preventDefault();
                window.location.href = '/' + href;
            }
        });
    });
}

// Open auth modal
function openAuthModal() {
    const modal = document.getElementById('auth-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

// Handle cart click with auth check
function handleCartClick() {
    @auth
        window.location.href = '{{ route('cart') }}';
    @else
        document.getElementById('auth-modal').classList.remove('hidden');
    @endauth
}

// Mobile menu toggle
document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});

// Navbar scroll effect
window.addEventListener('scroll', function() {
    const nav = document.getElementById('main-nav');
    if (window.scrollY > 50) {
        nav.classList.add('shadow-md');
    } else {
        nav.classList.remove('shadow-md');
    }
});

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function() {
    setupNavLinks();
    updateCartCount();
});

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
</script>