<section class="py-16 md:py-20 lg:py-24 bg-[#E4DDCC]" id="shop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl mb-4 md:mb-6">Shop Authentic Crafts</h2>
            <p class="text-sm md:text-base lg:text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Each purchase directly supports indigenous artisans and their communities
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @php
                $products = [
                    ['id' => 1, 'name' => 'Margarita Beaded Earrings', 'price' => '₱890', 'image' => 'Margarita-Beaded-Earrings.webp'],
                    ['id' => 2, 'name' => 'Itneg Embroidered Jacket', 'price' => '₱3,200', 'image' => 'Itneg-Hand-Embroidered-Cropped-Jacket.webp'],
                    ['id' => 3, 'name' => 'Mother of Pearl Plate', 'price' => '₱1,450', 'image' => 'Mother-of-Pearl-Plate.webp'],
                    ['id' => 4, 'name' => 'Jusi Fan', 'price' => '₱750', 'image' => 'Jusi-Fan.webp'],
                    ['id' => 5, 'name' => 'Bagobo Slip-on', 'price' => '₱2,100', 'image' => 'Bagobo-Slip-on.jpg'],
                    ['id' => 6, 'name' => 'Abaca Handbag', 'price' => '₱2,850', 'image' => 'Abaca-Handbag.webp'],
                    ['id' => 7, 'name' => 'Capiz Jewelry Box', 'price' => '₱1,650', 'image' => 'Capiz-Square-Diamond-Jewelry-Box.webp'],
                    ['id' => 8, 'name' => 'Pearl Necklace', 'price' => '₱4,200', 'image' => 'Fresh-Water-Pearl-Necklace.webp']
                ];
            @endphp

            @foreach($products as $index => $product)
                <div class="group cursor-pointer loading product-card shop-product-hero" data-product-id="{{ $product['id'] }}" style="animation-delay: {{ $index * 0.1 }}s">

                    <div class="relative overflow-hidden rounded-lg bg-white aspect-square mb-4 shadow-md">
                        <img 
                            src="{{ asset('assets/products/' . $product['image']) }}"
                            alt="{{ $product['name'] }}"
                            class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110"
                        >

                        <!-- Quick Add Button -->
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <button class="view-product-btn bg-white text-[#252525] px-5 py-2.5 rounded-full text-[10px] sm:text-xs tracking-wider uppercase futura-500 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 flex items-center gap-2">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" 
                                    />
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" 
                                    />
                                </svg>
                                <span class="hidden sm:inline">View</span>
                            </button>
                        </div>

                        <!-- Wishlist Icon -->
                        <button class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm p-1.5 sm:p-2 rounded-full hover:bg-white transition-colors duration-300">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path 
                                    stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    stroke-width="1.5" 
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 
                                       20.364l7.682-7.682a4.5 4.5 0 
                                       00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                                       4.5 0 00-6.364 0z" 
                                />
                            </svg>
                        </button>
                    </div>

                    <div class="px-1">
                        <h3 class="text-sm md:text-base mb-1.5 futura-500 group-hover:text-[#5B5843] transition-colors duration-300 line-clamp-2">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-[#252525] text-base md:text-lg futura-700">
                            {{ $product['price'] }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="text-center mt-16">
            <a href="/shop" class="inline-block bg-[#252525] text-white px-12 py-4 rounded-full text-sm tracking-widest uppercase futura-500 hover:bg-[#5B5843] transition-all duration-300 transform hover:scale-105">
                View All Products
            </a>
        </div>
    </div>
</section>

<script>
// Initialize shop section product modals
document.addEventListener('DOMContentLoaded', function() {
    initializeShopSectionProducts();
});

function initializeShopSectionProducts() {
    const productCards = document.querySelectorAll('.product-card.shop-product-hero');
    productCards.forEach(card => {
        card.removeEventListener('click', handleShopProductCardClick);
        card.addEventListener('click', handleShopProductCardClick);
    });
}

function handleShopProductCardClick(e) {
    if (e.target.closest('button')) return; // Don't trigger if button clicked
    const productId = this.getAttribute('data-product-id');
    if (productId) {
        openShopProductModal(productId);
    }
}

// Re-initialize after page content loads
window.addEventListener('load', initializeShopSectionProducts);
</script>