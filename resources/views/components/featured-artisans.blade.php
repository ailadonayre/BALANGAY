<section class="py-16 md:py-20 lg:py-24 bg-white" id="artisans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl mb-4 md:mb-6">Featured Artisans</h2>
            <p class="text-sm md:text-base lg:text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Meet the master craftspeople preserving centuries-old traditions
            </p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 lg:gap-10" id="hero-artisans-grid">
            <!-- Loading indicator -->
            <div class="col-span-full text-center py-8 text-gray-400">
                <div class="animate-pulse">Loading artisans...</div>
            </div>
        </div>
    </div>
</section>

<script>
// Load active featured artists from database (limit 3)
async function loadHeroArtisans() {
    try {
        const response = await fetch('/api/public/featured-artists');
        const artists = await response.json();
        
        const grid = document.getElementById('hero-artisans-grid');
        
        if (!artists || artists.length === 0) {
            grid.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No featured artisans at the moment.</div>';
            return;
        }
        
        // Show only first 3 artists
        const displayArtists = artists.slice(0, 3);
        
        grid.innerHTML = displayArtists.map((artist, index) => `
            <div class="group loading" style="animation-delay: ${index * 0.2}s">
                <div class="relative overflow-hidden rounded-xl aspect-[4/5] mb-5">
                    <img src="/assets/artisans/${artist.image || 'default.jpg'}" 
                         alt="${artist.name}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110"
                         onerror="this.src='/assets/logo/dark-green-logo.png'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="text-center">
                    <h3 class="text-xl md:text-2xl mb-2 futura-500">${artist.name}</h3>
                    <p class="text-[#5B5843] mb-1 futura-400 text-sm">${artist.tribe}</p>
                    <p class="text-gray-500 text-sm futura-100">${artist.craft}</p>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading hero artisans:', error);
        document.getElementById('hero-artisans-grid').innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">Error loading artisans.</div>';
    }
}

// Load artisans when page loads
document.addEventListener('DOMContentLoaded', loadHeroArtisans);
</script>