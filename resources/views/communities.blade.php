@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="py-16 md:py-20 lg:py-24 bg-gradient-to-b from-[#F8F4EE] to-white reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl mb-6" style="font-family: 'Elinga', serif;">Indigenous Communities</h1>
                <p class="text-lg text-gray-600 futura-400 max-w-3xl mx-auto">
                    Explore the rich cultural heritage and traditions of Philippine indigenous communities. 
                    Each community has preserved unique knowledge systems and artistic traditions that reflect 
                    centuries of cultural resilience and innovation.
                </p>
            </div>
        </div>
    </section>

    <!-- Communities Grid -->
    <section class="py-16 md:py-20 lg:py-24 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="communities-container" class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <!-- Communities will be loaded here -->
            </div>
        </div>
    </section>
</div>


<script>
// Load communities
async function loadCommunities() {
    try {
        const response = await fetch('/api/communities/all');
        const communities = await response.json();
        
        const container = document.getElementById('communities-container');
        container.innerHTML = communities.map(community => `
            <div class="group cursor-pointer loading" onclick="openCommunityModal(${community.id})">
                <div class="relative overflow-hidden rounded-xl aspect-[3/4] mb-4">
                    <img data-src="/assets/tribes/${community.image}" loading="lazy" decoding="async" src="/assets/logo/dark-green-logo.png" 
                         alt="${community.name}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110 lazy" onerror="this.src='/assets/logo/dark-green-logo.png'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white">
                        <h3 class="text-2xl font-bold mb-1" style="font-family: 'Elinga', serif;">${community.name}</h3>
                        <p class="text-xs lg:text-sm futura-100 text-white/80">${community.region}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 group-hover:text-[#5B5843] transition-colors">Click to learn more</p>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading communities:', error);
    }
}

// Load communities on page load
document.addEventListener('DOMContentLoaded', loadCommunities);
</script>
@endsection
