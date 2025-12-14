<section class="py-16 md:py-20 lg:py-24 bg-[#5B5843] text-white" id="support">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl mb-4 md:mb-6 text-white">Support Our Mission</h2>
            <p class="text-sm md:text-base lg:text-lg text-white/80 futura-400 max-w-3xl mx-auto leading-relaxed">
                Every purchase, donation, and share helps preserve indigenous heritage and 
                creates sustainable livelihoods for artisan communities across the Philippines
            </p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 lg:gap-10 mb-12 lg:mb-16">
            @php
            $supportWays = [
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />',
                    'title' => 'Shop With Purpose',
                    'description' => '100% of profits go directly to artisans. Every purchase creates fair-wage employment and supports cultural preservation.'
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />',
                    'title' => 'Donate Directly',
                    'description' => 'Support community development programs, skills training, and sustainable livelihood initiatives.'
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />',
                    'title' => 'Spread the Word',
                    'description' => 'Share our mission and help more people discover authentic Filipino craftsmanship and heritage.'
                ]
            ];
            @endphp

            @foreach($supportWays as $index => $way)
            <div class="text-center loading" style="animation-delay: {{ $index * 0.2 }}s">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-5 md:mb-6 backdrop-blur-sm">
                    <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $way['icon'] !!}
                    </svg>
                </div>
                <h3 class="text-xl md:text-2xl mb-3 md:mb-4 futura-500 text-white">{{ $way['title'] }}</h3>
                <p class="text-sm md:text-base text-white/70 futura-400 leading-relaxed">{{ $way['description'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 lg:gap-6 justify-center items-center loading" style="animation-delay: 0.6s">
            <a href="/shop" class="inline-block bg-white text-[#252525] px-10 md:px-12 py-3.5 md:py-4 rounded-full text-xs md:text-sm tracking-widest uppercase futura-500 hover:bg-[#E4DDCC] transition-all duration-300 transform hover:scale-105 w-full sm:w-auto text-center">
                Start Shopping
            </a>
            <a href="#" onclick="openDonationModal(event)" class="inline-block bg-transparent border-2 border-white text-white px-10 md:px-12 py-3.5 md:py-4 rounded-full text-xs md:text-sm tracking-widest uppercase futura-500 hover:bg-white hover:text-[#252525] transition-all duration-300 transform hover:scale-105 w-full sm:w-auto text-center">
                Make a Donation
            </a>
        </div>

        <!-- Impact Statement -->
        <div class="mt-16 lg:mt-20 text-center loading" style="animation-delay: 0.8s">
            <blockquote class="text-lg md:text-xl lg:text-2xl xl:text-3xl italic text-white/90 max-w-4xl mx-auto leading-relaxed px-4">
                "When you support indigenous artisans, you're not just buying a product — 
                you're preserving a culture, empowering a community, and celebrating centuries of tradition."
            </blockquote>
        </div>
    </div>
</section>