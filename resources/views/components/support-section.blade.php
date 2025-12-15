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
            <button id="donate-button" class="inline-block bg-transparent border-2 border-white text-white px-10 md:px-12 py-3.5 md:py-4 rounded-full text-xs md:text-sm tracking-widest uppercase futura-500 hover:bg-white hover:text-[#252525] transition-all duration-300 transform hover:scale-105 w-full sm:w-auto text-center">
                Make a Donation
            </button>
        </div>

        <!-- Impact Statement -->
        <div class="mt-16 lg:mt-20 text-center loading" style="animation-delay: 0.8s">
            <blockquote class="text-lg md:text-xl lg:text-2xl xl:text-3xl italic text-white/90 max-w-4xl mx-auto leading-relaxed px-4">
                "When you support indigenous artisans, you're not just buying a product — 
                you're preserving a culture, empowering a community, and celebrating centuries of tradition."
            </blockquote>
        </div>
    </div>

    {{-- Donation Modal - Embedded directly in support section --}}
    <div id="donation-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 overflow-hidden">
                <button id="close-donation-modal-btn" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
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
                                <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] hover:bg-[#5B5843] hover:text-white transition-all duration-300 text-sm font-medium text-gray-800" data-amount="500">₱500</button>
                                <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] hover:bg-[#5B5843] hover:text-white transition-all duration-300 text-sm font-medium text-gray-800" data-amount="1000">₱1,000</button>
                                <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] hover:bg-[#5B5843] hover:text-white transition-all duration-300 text-sm font-medium text-gray-800" data-amount="2500">₱2,500</button>
                                <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] hover:bg-[#5B5843] hover:text-white transition-all duration-300 text-sm font-medium text-gray-800" data-amount="5000">₱5,000</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Or enter custom amount (₱)</label>
                            <input type="number" id="custom-donation-amount" placeholder="Enter amount" min="100" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B5843] focus:border-transparent transition-all duration-300 text-gray-900 placeholder-gray-400">
                        </div>
                    </div>
                    <div class="space-y-3">
                        <button id="process-donation-btn" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#252525] transition-all duration-300 font-medium tracking-wide">Donate Now</button>
                        <button id="cancel-donation-btn" class="w-full bg-gray-200 text-gray-800 py-3 rounded-full hover:bg-gray-300 transition-all duration-300 font-medium">Cancel</button>
                    </div>
                    <p class="text-center text-xs text-gray-500 mt-4">Your donation is secure and will be processed safely.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Initialize donation modal functionality immediately
    (function() {
        const modal = document.getElementById('donation-modal');
        const donateBtn = document.getElementById('donate-button');
        const closeBtn = document.getElementById('close-donation-modal-btn');
        const cancelBtn = document.getElementById('cancel-donation-btn');
        const processBtn = document.getElementById('process-donation-btn');
        const customInput = document.getElementById('custom-donation-amount');
        const donationBtns = document.querySelectorAll('.donation-btn');

        console.log('Modal initialized:', modal ? 'YES' : 'NO');

        // Open modal
        if (donateBtn && modal) {
            donateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }

        // Close modal handlers
        [closeBtn, cancelBtn].forEach(btn => {
            if (btn && modal) {
                btn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                    if (customInput) customInput.value = '';
                });
            }
        });

        // Amount selection
        donationBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const amount = this.getAttribute('data-amount');
                if (customInput) customInput.value = amount;
                donationBtns.forEach(b => {
                    b.classList.remove('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
                    b.classList.add('text-gray-800');
                });
                this.classList.add('border-[#5B5843]', 'bg-[#5B5843]', 'text-white');
                this.classList.remove('text-gray-800');
            });
        });

        // Process donation
        if (processBtn && modal) {
            processBtn.addEventListener('click', function() {
                const amount = customInput?.value;
                if (!amount || amount < 100) {
                    alert('Please enter a donation amount of at least ₱100');
                    return;
                }
                alert(`Thank you for your donation of ₱${amount}!`);
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                if (customInput) customInput.value = '';
            });
        }
    })();
    </script>
</section>