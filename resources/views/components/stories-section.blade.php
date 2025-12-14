<section class="py-16 md:py-20 lg:py-24 bg-white reveal" id="stories">
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
                <a href="/stories" class="inline-block bg-[#5B5843] text-white px-10 py-4 rounded-full text-sm tracking-widest uppercase futura-500 hover:bg-[#5B5843] transition-all duration-300 transform hover:scale-105">
                    Read Their Stories
                </a>
            </div>

            <!-- Right Image Grid -->
            <div class="grid grid-cols-2 gap-4 lg:gap-6 loading" style="animation-delay: 0.3s">
                <div class="space-y-4 lg:space-y-6">
                    <div class="overflow-hidden rounded-xl aspect-[4/5]">
                        <img data-src="{{ asset('assets/artisans/Amparo-Balansi-Mabanag.jpg') }}" loading="lazy" decoding="async" alt="Artisan Story" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700 lazy">
                    </div>
                    <div class="overflow-hidden rounded-xl aspect-square">
                        <img data-src="{{ asset('assets/products/Itneg-Hand-Embroidered-Cropped-Jacket.webp') }}" loading="lazy" decoding="async" alt="Craft Detail" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700 lazy">
                    </div>
                </div>
                <div class="space-y-4 lg:space-y-6 pt-8 lg:pt-12">
                    <div class="overflow-hidden rounded-xl aspect-square">
                        <img data-src="{{ asset('assets/products/Fresh-Water-Pearl-Necklace.webp') }}" loading="lazy" decoding="async" alt="Heritage Craft" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700 lazy">
                    </div>
                    <div class="overflow-hidden rounded-xl aspect-[4/5]">
                        <img data-src="{{ asset('assets/artisans/Magdalena-Gamayo.jpeg') }}" loading="lazy" decoding="async" alt="Master Artisan" class="w-full h-full object-cover object-center hover:scale-110 transition-transform duration-700 lazy">
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Story Cards -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 lg:gap-10 mt-20 lg:mt-24" id="hero-stories-grid">
            <!-- Stories will be loaded dynamically -->
            <div class="col-span-full text-center py-8 text-gray-400">
                <div class="animate-pulse">Loading stories...</div>
            </div>
        </div>
    </div>
</section>

<script>
// Load published stories from database for hero section
async function loadHeroStories() {
    try {
        const response = await fetch('/api/public/stories');
        const stories = await response.json();
        
        const grid = document.getElementById('hero-stories-grid');
        
        if (!stories || stories.length === 0) {
            grid.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No stories available at the moment.</div>';
            return;
        }
        
        // Show only first 3 stories
        const displayStories = stories.slice(0, 3);
        
        grid.innerHTML = displayStories.map((story, index) => `
            <article class="group cursor-pointer loading story-card" data-story-index="${index}" style="animation-delay: ${index * 0.2}s" onclick="openHeroStoryModalFromDB(${story.id})">
                <div class="overflow-hidden rounded-xl aspect-[4/3] mb-5">
                    <img data-src="/assets/stories/${story.image || 'default.jpg'}" loading="lazy" decoding="async" src="/assets/logo/dark-green-logo.png" 
                         alt="${story.title}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110 lazy" onerror="this.src='/assets/logo/dark-green-logo.png'">
                </div>
                <h3 class="text-xl md:text-2xl mb-3 futura-500 group-hover:text-[#5B5843] transition-colors duration-300">${story.title}</h3>
                <p class="text-sm md:text-base text-gray-600 futura-400 mb-4">${story.excerpt}</p>
                <a href="#" class="inline-flex items-center gap-2 text-[#5B5843] futura-500 text-sm tracking-wide uppercase hover:gap-4 transition-all duration-300">
                    Read More
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </article>
        `).join('');
        
        // Store stories globally for modal access
        window.heroStoriesFromDB = stories;
    } catch (error) {
        console.error('Error loading hero stories:', error);
        document.getElementById('hero-stories-grid').innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">Error loading stories.</div>';
    }
}

// Open modal with database story
function openHeroStoryModalFromDB(storyId) {
    event.preventDefault();
    event.stopPropagation();
    
    const story = window.heroStoriesFromDB?.find(s => s.id === storyId);
    if (story) {
        document.getElementById('hero-modal-story-title').textContent = story.title;
        document.getElementById('hero-modal-story-image').src = `/assets/stories/${story.image || 'default.jpg'}`;
        document.getElementById('hero-modal-story-image').alt = story.title;
        document.getElementById('hero-modal-story-content').innerHTML = story.content.split('\n').map(p => `<p class="mb-4">${p}</p>`).join('');
        
        document.getElementById('hero-story-modal').classList.remove('hidden');
    }
}

// Load stories when page loads
document.addEventListener('DOMContentLoaded', loadHeroStories);
</script>