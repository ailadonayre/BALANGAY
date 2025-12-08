<section class="py-16 md:py-20 lg:py-24 bg-[#F8F4EE]" id="crafts">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl mb-4 md:mb-6">Featured Crafts</h2>
            <p class="text-sm md:text-base lg:text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Discover authentic handcrafted pieces rooted in Filipino heritage
            </p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 lg:gap-10">
            @php
            $crafts = [
                [
                    'name' => 'Abaca Handbag',
                    'community' => 'Mindanao Weavers',
                    'price' => '₱2,850',
                    'image' => 'Abaca-Handbag.webp'
                ],
                [
                    'name' => 'Fresh Water Pearl Necklace',
                    'community' => 'Coastal Artisans',
                    'price' => '₱4,200',
                    'image' => 'Fresh-Water-Pearl-Necklace.webp'
                ],
                [
                    'name' => 'Capiz Jewelry Box',
                    'community' => 'Visayan Craftsmen',
                    'price' => '₱1,650',
                    'image' => 'Capiz-Square-Diamond-Jewelry-Box.webp'
                ]
            ];
            @endphp

            @foreach($crafts as $index => $craft)
            <div class="group loading" style="animation-delay: {{ $index * 0.2 }}s">
                <div class="relative overflow-hidden rounded-xl bg-white aspect-square mb-5 shadow-md">
                    <img src="{{ asset('assets/products/' . $craft['image']) }}" 
                         alt="{{ $craft['name'] }}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110">
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                        <button class="bg-white text-[#252525] px-8 py-3 rounded-full text-xs tracking-wider uppercase futura-500 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            View Details
                        </button>
                    </div>
                </div>
                <div class="px-1">
                    <h3 class="text-lg md:text-xl mb-2 futura-500">{{ $craft['name'] }}</h3>
                    <p class="text-[#5B5843] mb-2 text-xs futura-400">{{ $craft['community'] }}</p>
                    <p class="text-[#252525] text-base md:text-lg futura-700">{{ $craft['price'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>