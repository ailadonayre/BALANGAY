<!-- Community Detail Modal for Homepage -->
<div id="community-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" onclick="closeCommunityModal()"></div>

    <!-- Modal Content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 overflow-hidden">
            <!-- Close Button -->
            <button onclick="closeCommunityModal()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div class="p-8">
                <div class="mb-6">
                    <img id="modal-community-image" src="" alt="" class="w-full h-64 object-cover rounded-xl mb-6">
                    <h2 id="modal-community-name" class="text-3xl font-bold mb-2" style="font-family: 'Elinga', serif;"></h2>
                    <p id="modal-community-region" class="text-lg text-[#5B5843] futura-500 mb-4"></p>
                </div>
                <div id="modal-community-history" class="text-gray-600 leading-relaxed space-y-4"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Community modal functions
async function openCommunityModal(communityId) {
    try {
        const response = await fetch(`/api/communities/${communityId}`);
        const community = await response.json();
        
        document.getElementById('modal-community-name').textContent = community.name;
        document.getElementById('modal-community-region').textContent = community.region;
        document.getElementById('modal-community-image').src = `/assets/tribes/${community.image}`;
        document.getElementById('modal-community-image').alt = community.name;
        document.getElementById('modal-community-history').innerHTML = `<p>${community.history}</p>`;
        
        document.getElementById('community-modal').classList.remove('hidden');
    } catch (error) {
        console.error('Error loading community:', error);
    }
}

function closeCommunityModal() {
    document.getElementById('community-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('community-modal');
    if (event.target === modal) {
        closeCommunityModal();
    }
});
</script>
