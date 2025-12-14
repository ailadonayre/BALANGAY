@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="py-16 md:py-20 lg:py-24 bg-gradient-to-b from-[#F8F4EE] to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl mb-6" style="font-family: 'Elinga', serif;">Stories of Heritage</h1>
                <p class="text-lg text-gray-600 futura-400 max-w-3xl mx-auto">
                    Behind every craft is a story of tradition, resilience, and cultural pride. 
                    Discover the journeys of master artisans who keep ancient traditions alive.
                </p>
            </div>
        </div>
    </section>

    <!-- Stories Grid -->
    <section class="py-16 md:py-20 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="stories-container" class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 lg:gap-10">
                <!-- Stories will be loaded here -->
            </div>
        </div>
    </section>
</div>

<!-- Story Detail Modal -->
<div id="story-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" onclick="closeStoryModal()"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 overflow-hidden max-h-[90vh] overflow-y-auto">
            <!-- Close Button -->
            <button onclick="closeStoryModal()" class="fixed top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300 bg-white rounded-full p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div class="p-8">
                <div class="mb-6">
                    <img id="modal-story-image" src="" alt="" class="w-full h-96 object-cover rounded-xl mb-6">
                    <h2 id="modal-story-title" class="text-3xl font-bold mb-2" style="font-family: 'Elinga', serif;"></h2>
                    <p id="modal-story-author" class="text-lg text-[#5B5843] futura-500 mb-4"></p>
                </div>
                <div id="modal-story-content" class="text-gray-600 leading-relaxed space-y-4"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Load stories from database
async function loadStories() {
    try {
        const response = await fetch('/api/public/stories');
        const stories = await response.json();
        
        const container = document.getElementById('stories-container');
        
        if (!stories || stories.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">No stories available at the moment.</div>';
            return;
        }
        
        container.innerHTML = stories.map(story => `
            <div class="group cursor-pointer transition-transform duration-300 hover:-translate-y-2" onclick="openStoryModal(${story.id})">
                <div class="relative overflow-hidden rounded-2xl aspect-[4/3] mb-6">
                    <img src="/assets/stories/${story.image || 'default.jpg'}" 
                         alt="${story.title}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         onerror="this.src='/assets/logo/dark-green-logo.png'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                </div>
                <h3 class="text-2xl font-bold mb-2" style="font-family: 'Elinga', serif;">${story.title}</h3>
                <p class="text-[#5B5843] font-medium futura-500 mb-3">${story.author_name}</p>
                <p class="text-gray-600 futura-400 leading-relaxed line-clamp-3">${story.excerpt}</p>
                <button class="mt-4 text-[#5B5843] font-medium futura-500 group-hover:underline flex items-center gap-2">
                    Read More 
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading stories:', error);
        document.getElementById('stories-container').innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">Error loading stories. Please try again later.</div>';
    }
}

// Store all stories
let allStories = [];

async function fetchAllStories() {
    try {
        const response = await fetch('/api/public/stories');
        allStories = await response.json();
    } catch (error) {
        console.error('Error fetching stories:', error);
    }
}

function openStoryModal(storyId) {
    const story = allStories.find(s => s.id === storyId);
    if (!story) return;
    
    document.getElementById('modal-story-image').src = `/assets/stories/${story.image || 'default.jpg'}`;
    document.getElementById('modal-story-title').textContent = story.title;
    document.getElementById('modal-story-author').textContent = `By ${story.author_name}${story.tribe ? ' - ' + story.tribe : ''}`;
    document.getElementById('modal-story-content').innerHTML = story.content.split('\n').map(p => `<p>${p}</p>`).join('');
    
    document.getElementById('story-modal').classList.remove('hidden');
}

function closeStoryModal() {
    document.getElementById('story-modal').classList.add('hidden');
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', async function() {
    await fetchAllStories();
    await loadStories();
});
</script>
@endsection
