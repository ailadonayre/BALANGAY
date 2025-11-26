<section class="py-24 bg-[#E4DDCC]" id="shop">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-16 loading">
            <h2 class="text-4xl md:text-5xl lg:text-6xl mb-6">Shop Authentic Crafts</h2>
            <p class="text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Each purchase directly supports indigenous artisans and their communities
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $products = [
                    ['name' => 'Margarita Beaded Earrings', 'price' => '₱890', 'image' => 'Margarita-Beaded-Earrings.webp'],
                    ['name' => 'Itneg Embroidered Jacket', 'price' => '₱3,200', 'image' => 'Itneg-Hand-Embroidered-Cropped-Jacket.webp'],
                    ['name' => 'Mother of Pearl Plate', 'price' => '₱1,450', 'image' => 'Mother-of-Pearl-Plate.webp'],
                    ['name' => 'Jusi Fan', 'price' => '₱750', 'image' => 'Jusi-Fan.webp'],
                    ['name' => 'Bagobo Slip-on', 'price' => '₱2,100', 'image' => 'Bagobo-Slip-on.jpg'],
                    ['name' => 'Abaca Handbag', 'price' => '₱2,850', 'image' => 'Abaca-Handbag.webp'],
                    ['name' => 'Capiz Jewelry Box', 'price' => '₱1,650', 'image' => 'Capiz-Square-Diamond-Jewelry-Box.webp'],
                    ['name' => 'Pearl Necklace', 'price' => '₱4,200', 'image' => 'Fresh-Water-Pearl-Necklace.webp']
                ];
            @endphp

            @foreach($products as $index => $product)
                <div class="group cursor-pointer loading" style="animation-delay: {{ $index * 0.1 }}s">

                    <div class="relative overflow-hidden rounded-xl bg-white aspect-square mb-4 shadow-md">
                        <img 
                            src="{{ asset('assets/products/' . $product['image']) }}"
                            alt="{{ $product['name'] }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        >

                        <!-- Quick Add Button -->
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <button class="bg-white text-[#252525] px-6 py-3 rounded-full text-xs tracking-wider uppercase futura-500 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" 
                                    />
                                </svg>
                                Quick Add
                            </button>
                        </div>

                        <!-- Wishlist Icon -->
                        <button class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-full hover:bg-white transition-colors duration-300">
                            <svg class="w-5 h-5 text-gray-700 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <div>
                        <h3 class="text-base mb-2 futura-500 group-hover:text-[#5B5843] transition-colors duration-300">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-[#252525] text-lg futura-700">
                            {{ $product['price'] }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="text-center mt-16">
            <button class="inline-block bg-[#252525] text-white px-12 py-4 rounded-full text-sm tracking-widest uppercase futura-500 hover:bg-[#5B5843] transition-all duration-300 transform hover:scale-105">
                View All Products
            </button>
        </div>

    </div>
</section>