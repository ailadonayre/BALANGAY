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

        /* DM SANS (replaces Futura) - loaded via Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@100;400;500;700;900&display=swap');

        :root {
            --font-dmsans: 'DM Sans', sans-serif;
        }

        body {
            font-family: var(--font-dmsans);
            background-color: #F8F4EE;
            color: #5B5843;
        }

        /* Keep existing class names for compatibility - map to DM Sans */
        .futura-400 { font-family: 'DM Sans', sans-serif; font-weight: 400; }
        .futura-500 { font-family: 'DM Sans', sans-serif; font-weight: 500; }
        .futura-700 { font-family: 'DM Sans', sans-serif; font-weight: 700; }
        .futura-900 { font-family: 'DM Sans', sans-serif; font-weight: 900; }
    </style>

    @stack('styles')
</head>
<body class="bg-[#F8F4EE] text-[#5B5843] font-dmsans overflow-x-hidden">

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

    {{-- Donation Modal --}}
    <div id="donation-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" onclick="closeDonationModal()"></div>

        <!-- Modal Content -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 overflow-hidden">
                <!-- Close Button -->
                <button onclick="closeDonationModal()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Body -->
                <div class="p-8">
                    <div class="text-center mb-6">
                        <svg class="w-16 h-16 text-[#5B5843] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Support Our Mission</h2>
                        <p class="text-gray-600 text-sm">Help us preserve indigenous heritage and empower artisan communities</p>
                    </div>

                    <div class="space-y-4 mb-6">
                        <p class="text-gray-700 text-sm leading-relaxed">
                            Your donation directly supports community development programs, skills training, and sustainable livelihood initiatives for indigenous artisans across the Philippines.
                        </p>

                        <div class="bg-[#F8F4EE] border border-[#E4DDCC] rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Choose a donation amount:</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <button onclick="setDonationAmount(500)" class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="500">
                                    ₱500
                                </button>
                                <button onclick="setDonationAmount(1000)" class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="1000">
                                    ₱1,000
                                </button>
                                <button onclick="setDonationAmount(2500)" class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="2500">
                                    ₱2,500
                                </button>
                                <button onclick="setDonationAmount(5000)" class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="5000">
                                    ₱5,000
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Or enter custom amount (₱)</label>
                            <input type="number" id="custom-donation-amount" placeholder="Enter amount" min="100" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button onclick="processDonation()" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#5B5843] transition-all duration-300 font-medium tracking-wide">
                            Donate Now
                        </button>
                        <button onclick="closeDonationModal()" class="w-full bg-gray-200 text-gray-800 py-3 rounded-full hover:bg-gray-300 transition-all duration-300 font-medium">
                            Cancel
                        </button>
                    </div>

                    <p class="text-center text-xs text-gray-500 mt-4">
                        Your donation is secure and will be processed safely.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Story Modal for Hero Stories Section --}
    <div id="hero-story-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" onclick="closeHeroStoryModal()"></div>

        <!-- Modal Content -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 overflow-hidden max-h-[90vh] overflow-y-auto">
                <!-- Close Button -->
                <button onclick="closeHeroStoryModal()" class="fixed top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300 bg-white rounded-full p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Body -->
                <div class="p-8">
                    <div class="mb-6">
                        <img id="hero-modal-story-image" data-src="" loading="lazy" decoding="async" src="" alt="" class="w-full h-96 object-cover rounded-xl mb-6 lazy">
                        <h2 id="hero-modal-story-title" class="text-3xl font-bold mb-2" style="font-family: 'Elinga', serif;"></h2>
                        <p id="hero-modal-story-author" class="text-lg text-[#5B5843] futura-500 mb-4"></p>
                    </div>
                    <div id="hero-modal-story-content" class="text-gray-600 leading-relaxed space-y-4"></div>
                </div>
            </div>
        </div>
    </div>

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
                
                // If card has data-product-id, use it directly
                const productId = this.getAttribute('data-product-id');
                if (productId) {
                    openShopProductModal(productId);
                    return;
                }
                
                // Otherwise, search by product name
                const productName = this.getAttribute('data-product-name');
                if (productName) {
                    try {
                        const response = await fetch(`/api/products/search?q=${encodeURIComponent(productName)}`);
                        const data = await response.json();
                        
                        if (data.data && data.data.length > 0) {
                            openShopProductModal(data.data[0].id);
                        }
                    } catch (error) {
                        console.error('Error finding product:', error);
                    }
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

    // Hero Stories Modal Functions
    const heroStories = [
        {
            title: 'Preserving T\'nalak Traditions',
            excerpt: 'How T\'boli dreamweavers keep ancient textile art alive',
            image: 'Amparo-Balansi-Mabanag.jpg',
            content: 'Amparo Balansi Mabanag is a master T\'boli weaver who has dedicated her life to preserving the ancient art of t\'nalak weaving. For over forty years, she has created intricate patterns that tell stories of her ancestors and spiritual beliefs. Each piece takes months to complete, using traditional tie-dyeing techniques passed down through generations. Amparo\'s work has gained international recognition, yet she remains committed to teaching younger generations the sacred knowledge embedded in every thread. Her t\'nalak pieces are not merely fabric—they are living records of T\'boli history, spirituality, and artistic excellence. Through her dedication, the world has come to recognize the T\'boli people as master artists and guardians of an irreplaceable cultural heritage.'
        },
        {
            title: 'The Art of Metal Smithing',
            excerpt: 'Eduardo Mutuc\'s journey to becoming a National Living Treasure',
            image: 'Eduardo-Mutuc.jpg',
            content: 'Eduardo Mutuc is a legendary Ifugao metal smith who was recognized as a National Living Treasure by the Philippine government. His mastery of traditional metalworking techniques, passed down through his family for countless generations, has made him one of the most respected artisans in the Philippines. Eduardo\'s creations range from traditional ceremonial items to contemporary artistic pieces, all crafted using age-old methods. Despite the availability of modern tools and materials, he continues to work with handforged techniques, believing that the soul of the craft lies in the direct contact between artisan and material. His workshop has become a gathering place for young artisans eager to learn the secrets of Ifugao metalwork. Eduardo\'s legacy extends beyond his creations; he is a living link to an ancient tradition that continues to inspire artists worldwide.'
        },
        {
            title: 'Weaving Community Together',
            excerpt: 'Inabel weavers creating economic opportunities in Ilocos',
            image: 'Magdalena-Gamayo.jpeg',
            content: 'Magdalena Gamayo is a master Inabel weaver from the Ilocos region whose work has transformed her community\'s economic landscape. Inabel, also known as Abel Iloco, is a handwoven textile that represents the cultural heritage of the Ilocano people. Magdalena leads a cooperative of weavers, empowering women in her community to earn sustainable income while preserving their craft. Her commitment to fair wages and ethical production has made her products sought after by conscious consumers worldwide. Magdalena\'s innovative approach blends traditional patterns with contemporary designs, making Inabel relevant to modern markets. Through her leadership, she has helped establish her village as a center of textile excellence, creating opportunities for younger artisans to learn and thrive. Her work demonstrates how traditional crafts can be vehicles for economic empowerment and cultural preservation.'
        }
    ];

    // Close hero story modal - defined globally for access from all pages
    function closeHeroStoryModal() {
        const modal = document.getElementById('hero-story-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // Close modal when escape key is pressed
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeHeroStoryModal();
        }
    });

    // ===== DONATION MODAL =====
    let selectedDonationAmount = null;

    function openDonationModal(event) {
        event.preventDefault();
        event.stopPropagation();
        document.getElementById('donation-modal').classList.remove('hidden');
    }

    function closeDonationModal() {
        document.getElementById('donation-modal').classList.add('hidden');
        selectedDonationAmount = null;
        document.getElementById('custom-donation-amount').value = '';
        document.querySelectorAll('.donation-btn').forEach(btn => {
            btn.classList.remove('bg-[#5B5843]', 'text-white', 'border-[#5B5843]');
            btn.classList.add('border-gray-300');
        });
    }

    function setDonationAmount(amount) {
        selectedDonationAmount = amount;
        document.getElementById('custom-donation-amount').value = '';
        
        // Update button styling
        document.querySelectorAll('.donation-btn').forEach(btn => {
            btn.classList.remove('bg-[#5B5843]', 'text-white', 'border-[#5B5843]');
            btn.classList.add('border-gray-300');
        });
        
        event.target.classList.add('bg-[#5B5843]', 'text-white', 'border-[#5B5843]');
        event.target.classList.remove('border-gray-300');
    }

    function processDonation() {
        let amount = selectedDonationAmount || parseInt(document.getElementById('custom-donation-amount').value);
        
        if (!amount || amount < 100) {
            alert('Please enter a valid donation amount (minimum ₱100)');
            return;
        }

        // Placeholder for payment processing
        alert(`Thank you for your donation of ₱${amount.toLocaleString()}! Processing payment...`);
        closeDonationModal();
    }
    </script>
</body>
</html>