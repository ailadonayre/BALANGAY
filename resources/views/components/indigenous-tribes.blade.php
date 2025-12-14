<section class="py-16 md:py-20 lg:py-24 bg-white reveal" id="discover">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl mb-4 md:mb-6">Indigenous Heritage</h2>
            <p class="text-sm md:text-base lg:text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Explore the rich cultural traditions of Filipino indigenous communities
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8" id="hero-communities-grid">
            <!-- Loading indicator -->
            <div class="col-span-full text-center py-8 text-gray-400">
                <div class="animate-pulse">Loading communities...</div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="/communities" class="inline-block bg-[#5B5843] text-white px-10 py-4 rounded-full text-sm tracking-widest uppercase futura-500 hover:bg-[#5B5843] transition-all duration-300 transform hover:scale-105">
                Show All Communities
            </a>
        </div>
    </div>
</section>

<script>
// Load active featured communities from database
async function loadHeroCommunities() {
    try {
        const response = await fetch('/api/public/featured-communities');
        const communities = await response.json();
        
        const grid = document.getElementById('hero-communities-grid');
        
        if (!communities || communities.length === 0) {
            grid.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No featured communities at the moment.</div>';
            return;
        }
        
        grid.innerHTML = communities.map((community, index) => `
            <div class="group cursor-pointer loading tribe-card" data-community-id="${community.id}" style="animation-delay: ${index * 0.15}s">
                <div class="relative overflow-hidden rounded-xl aspect-[3/4] mb-4">
                    <img data-src="/assets/tribes/${community.image || 'default.png'}" loading="lazy" decoding="async" src="/assets/logo/dark-green-logo.png" 
                         alt="${community.name}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110 lazy" onerror="this.src='/assets/logo/dark-green-logo.png'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white">
                        <h3 class="text-xl lg:text-2xl mb-1 futura-500">${community.name}</h3>
                        <p class="text-xs lg:text-sm futura-100 text-white/80">${community.region}</p>
                    </div>
                </div>
            </div>
        `).join('');
        
        // Setup click handlers after rendering
        setupTribeCardHandlers();
    } catch (error) {
        console.error('Error loading hero communities:', error);
        document.getElementById('hero-communities-grid').innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">Error loading communities.</div>';
    }
}

// Setup tribe card handlers for modal
function setupTribeCardHandlers() {
    const tribeCards = document.querySelectorAll('.tribe-card');
    tribeCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const communityId = this.getAttribute('data-community-id');
            if (communityId) {
                openCommunityModal(communityId);
            }
        });
    });
}

// Load communities when page loads
document.addEventListener('DOMContentLoaded', loadHeroCommunities);
</script>