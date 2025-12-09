<section class="py-16 md:py-20 lg:py-24 bg-white" id="stories">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <!-- Left Content -->
            <div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl mb-6 md:mb-8">Stories of Heritage</h2>
                <p class="text-lg text-gray-600 futura-400 leading-relaxed mb-8">
                    Behind every craft is a story of tradition, resilience, and cultural pride. 
                    Our artisans carry forward centuries-old techniques passed down through generations, 
                    weaving history into every piece they create.
                </p>
                <p class="text-lg text-gray-600 futura-400 leading-relaxed mb-12">
                    From the mountains of Cordillera to the shores of Mindanao, each community brings 
                    unique artistry that reflects their deep connection to the land and their ancestors.
                </p>
                <a href="/stories" class="inline-block bg-[#5B5843] text-white px-10 py-4 rounded-full text-sm tracking-widest uppercase futura-500 hover:bg-[#252525] transition-all duration-300 transform hover:scale-105">
                    Read Their Stories
                </a>
            </div>

            <!-- Right Image Grid -->
            <div class="grid grid-cols-2 gap-4 lg:gap-6 loading" style="animation-delay: 0.3s">
                <div class="space-y-4 lg:space-y-6">
                    <div class="overflow-hidden rounded-xl aspect-[4/5]">
                        <img src="{{ asset('assets/artisans/Amparo-Balansi-Mabanag.jpg') }}" alt="Artisan Story" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="overflow-hidden rounded-xl aspect-square">
                        <img src="{{ asset('assets/products/Itneg-Hand-Embroidered-Cropped-Jacket.webp') }}" alt="Craft Detail" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700">
                    </div>
                </div>
                <div class="space-y-4 lg:space-y-6 pt-8 lg:pt-12">
                    <div class="overflow-hidden rounded-xl aspect-square">
                        <img src="{{ asset('assets/products/Fresh-Water-Pearl-Necklace.webp') }}" alt="Heritage Craft" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="overflow-hidden rounded-xl aspect-[4/5]">
                        <img src="{{ asset('assets/artisans/Magdalena-Gamayo.jpeg') }}" alt="Master Artisan" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700">
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Story Cards -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 lg:gap-10 mt-20 lg:mt-24">
            @php
            $stories = [
                [
                    'title' => 'Preserving T\'nalak Traditions',
                    'excerpt' => 'How T\'boli dreamweavers keep ancient textile art alive',
                    'image' => 'Amparo-Balansi-Mabanag.jpg'
                ],
                [
                    'title' => 'The Art of Metal Smithing',
                    'excerpt' => 'Eduardo Mutuc\'s journey to becoming a National Living Treasure',
                    'image' => 'Eduardo-Mutuc.jpg'
                ],
                [
                    'title' => 'Weaving Community Together',
                    'excerpt' => 'Inabel weavers creating economic opportunities in Ilocos',
                    'image' => 'Magdalena-Gamayo.jpeg'
                ]
            ];
            @endphp

            @foreach($stories as $index => $story)
            <article class="group cursor-pointer loading story-card" data-story-index="{{ $index }}" style="animation-delay: {{ $index * 0.2 }}s">
                <div class="overflow-hidden rounded-xl aspect-[4/3] mb-5">
                    <img src="{{ asset('assets/artisans/' . $story['image']) }}" 
                         alt="{{ $story['title'] }}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110">
                </div>
                <h3 class="text-xl md:text-2xl mb-3 futura-500 group-hover:text-[#5B5843] transition-colors duration-300">{{ $story['title'] }}</h3>
                <p class="text-sm md:text-base text-gray-600 futura-400 mb-4">{{ $story['excerpt'] }}</p>
                <a href="#" onclick="openHeroStoryModal(event, {{ $index }})" class="inline-flex items-center gap-2 text-[#5B5843] futura-500 text-sm tracking-wide uppercase hover:gap-4 transition-all duration-300">
                    Read More
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>