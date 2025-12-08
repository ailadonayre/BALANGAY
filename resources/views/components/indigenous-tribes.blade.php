<section class="py-16 md:py-20 lg:py-24 bg-white" id="discover">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl mb-4 md:mb-6">Indigenous Heritage</h2>
            <p class="text-sm md:text-base lg:text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Explore the rich cultural traditions of Filipino indigenous communities
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @php
            $tribes = [
                ['name' => 'Ati', 'region' => 'Panay Island', 'image' => 'ati.png'],
                ['name' => 'Igorot', 'region' => 'Cordillera', 'image' => 'igorot.png'],
                ['name' => 'Lumad', 'region' => 'Mindanao', 'image' => 'lumad.png'],
                ['name' => 'Mangyan', 'region' => 'Mindoro', 'image' => 'mangyan.png']
            ];
            @endphp

            @foreach($tribes as $index => $tribe)
            <div class="group cursor-pointer loading tribe-card" data-tribe-id="{{ $index + 1 }}" style="animation-delay: {{ $index * 0.15 }}s">
                <div class="relative overflow-hidden rounded-xl aspect-[3/4] mb-4">
                    <img src="{{ asset('assets/tribes/' . $tribe['image']) }}" 
                         alt="{{ $tribe['name'] }}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white">
                        <h3 class="text-xl lg:text-2xl mb-1 futura-500">{{ $tribe['name'] }}</h3>
                        <p class="text-xs lg:text-sm futura-100 text-white/80">{{ $tribe['region'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="/communities" class="inline-block bg-[#252525] text-white px-10 py-4 rounded-full text-sm tracking-widest uppercase futura-500 hover:bg-[#5B5843] transition-all duration-300 transform hover:scale-105">
                Show All Communities
            </a>
        </div>
    </div>
</section>

<script>
// Setup tribe card handlers for modal
function setupTribeCardHandlers() {
    const tribeCards = document.querySelectorAll('.tribe-card');
    tribeCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const communityId = this.getAttribute('data-tribe-id');
            openCommunityModal(communityId);
        });
    });
}

// Setup when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupTribeCardHandlers);
} else {
    setupTribeCardHandlers();
}
</script>