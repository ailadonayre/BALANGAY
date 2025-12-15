{{-- Donation Modal --}}
<div id="donation-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 overflow-hidden">
            <!-- Close Button -->
            <button id="close-donation-modal-btn" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300">
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
                            <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="500">
                                ₱500
                            </button>
                            <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="1000">
                                ₱1,000
                            </button>
                            <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="2500">
                                ₱2,500
                            </button>
                            <button class="donation-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-[#5B5843] transition-all duration-300 text-sm font-medium" data-amount="5000">
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
                    <button id="process-donation-btn" class="w-full bg-[#5B5843] text-white py-3 rounded-full hover:bg-[#252525] transition-all duration-300 font-medium tracking-wide">
                        Donate Now
                    </button>
                    <button id="cancel-donation-btn" class="w-full bg-gray-200 text-gray-800 py-3 rounded-full hover:bg-gray-300 transition-all duration-300 font-medium">
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
