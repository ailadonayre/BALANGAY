<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BALANGAY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Custom Fonts -->
    <style>
        /* ELINGA FONT */
        @font-face {
            font-family: 'Elinga';
            src: url('{{ asset('assets/fonts/Elinga.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Elinga';
            src: url('{{ asset('assets/fonts/Elinga Italic.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: italic;
            font-display: swap;
        }
        @font-face {
            font-family: 'Elinga Outline';
            src: url('{{ asset('assets/fonts/Elinga Outline.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Elinga Outline';
            src: url('{{ asset('assets/fonts/Elinga Outline Italic.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: italic;
            font-display: swap;
        }

        /* FUTURA FONT */
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaLight.ttf') }}') format('truetype');
            font-weight: 100;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaTMed.ttf') }}') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaMedium.ttf') }}') format('truetype');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaT_Bold.ttf') }}') format('truetype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaHeavy.ttf') }}') format('truetype');
            font-weight: 900;
            font-style: normal;
            font-display: swap;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#F8F4EE] text-[#252525] font-[Futura] overflow-x-hidden">

    {{-- Navigation --}}
    @include('components.navigation')

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Auth Modal for Sign In / Sign Up --}}
    @include('components.auth-modal')

    {{-- Community Modal --}}
    @include('components.community-modal')

    {{-- Shop Product Modal --}}
    @include('components.shop-product-modal')

    @stack('scripts')

    {{-- Master initialization script for all modals and handlers --}}
    <script>
    // Wait for all DOM elements and modals to be loaded
    function initializeAllHandlers() {
        // Setup featured crafts handlers
        const craftCards = document.querySelectorAll('.featured-craft');
        craftCards.forEach(craft => {
            craft.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                const craftName = this.getAttribute('data-craft-name');
                
                try {
                    const response = await fetch(`/api/products/search?q=${encodeURIComponent(craftName)}`);
                    const data = await response.json();
                    
                    if (data.data && data.data.length > 0) {
                        openShopProductModal(data.data[0].id);
                    }
                } catch (error) {
                    console.error('Error finding product:', error);
                }
            });
        });

        // Setup shop product card handlers
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                const productName = this.getAttribute('data-product-name');
                
                try {
                    const response = await fetch(`/api/products/search?q=${encodeURIComponent(productName)}`);
                    const data = await response.json();
                    
                    if (data.data && data.data.length > 0) {
                        openShopProductModal(data.data[0].id);
                    }
                } catch (error) {
                    console.error('Error finding product:', error);
                }
            });
        });

        // Setup tribe card handlers for modal
        const tribeCards = document.querySelectorAll('.tribe-card');
        tribeCards.forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const communityId = this.getAttribute('data-tribe-id');
                openCommunityModal(communityId);
            });
        });

        // Setup shop product card handlers from shop page
        const shopCards = document.querySelectorAll('.product-shop-card');
        shopCards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('button')) {
                    const productId = this.getAttribute('data-product-id');
                    openShopProductModal(productId);
                }
            });
        });
    }

    // Initialize when DOM is fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeAllHandlers);
    } else {
        initializeAllHandlers();
    }

    // Re-initialize after any dynamic content changes
    const originalFetch = window.fetch;
    window.fetch = function(...args) {
        return originalFetch.apply(this, args).then(response => {
            response.clone().json().then(() => {
                // Re-initialize handlers after API calls
                setTimeout(initializeAllHandlers, 100);
            }).catch(() => {});
            return response;
        });
    };
    </script>
</body>
</html>