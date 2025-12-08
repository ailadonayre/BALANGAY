<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/50 transition-all duration-300" id="main-nav">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Keep your existing nav structure, but update the account button: -->
            <button id="account-btn" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300" 
                    onclick="document.getElementById('auth-modal').classList.remove('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </button>

            
            <!-- Left Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#discover" class="text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Discover</a>
                <a href="#shop" class="text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Shop</a>
                <a href="#stories" class="text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Stories</a>
                <a href="#support" class="text-sm tracking-wide text-gray-700 hover:text-[#5B5843] transition-colors duration-300 uppercase">Support</a>
            </div>

            <!-- Center Logo -->
            <div class="flex-1 md:flex-initial flex justify-center">
                <a href="/" class="block">
                    <img src="{{ asset('assets/logo/dark-green-logo.png') }}" alt="BALANGAY" class="h-10 w-auto transition-transform duration-300 hover:scale-105">
                </a>
            </div>

            <!-- Right Icons -->
            <div class="flex items-center space-x-6">
                <button class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300" aria-label="Wishlist">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                
                @auth
                    <!-- Logged In User -->
                    <a href="{{ route('profile') }}" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300" aria-label="Profile">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                @else
                    <!-- Not Logged In -->
                    <button onclick="document.getElementById('auth-modal').classList.remove('hidden')" class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300" aria-label="Account">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                @endauth

                <a href="@auth{{ route('cart') }}@else{{ '#' }}@endauth" 
                   @guest onclick="event.preventDefault(); document.getElementById('auth-modal').classList.remove('hidden');" @endguest
                   class="text-gray-700 hover:text-[#5B5843] transition-colors duration-300 relative" aria-label="Cart">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-[#5B5843] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                </a>

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
            <a href="#discover" class="block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Discover</a>
            <a href="#shop" class="block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Shop</a>
            <a href="#stories" class="block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Stories</a>
            <a href="#support" class="block text-sm tracking-wide text-gray-700 hover:text-[#5B5843] uppercase">Support</a>
        </div>
    </div>
</nav>

<script>
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

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            // Close mobile menu if open
            document.getElementById('mobile-menu')?.classList.add('hidden');
        }
    });
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

// Update cart count on page load
document.addEventListener('DOMContentLoaded', updateCartCount);
</script>