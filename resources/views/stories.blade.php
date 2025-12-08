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
// All stories with full content
const allStories = [
    {
        id: 1,
        title: "Preserving T'nalak Traditions",
        author: "Amparo Balansi Mabanag",
        excerpt: "How T'boli dreamweavers keep ancient textile art alive",
        image: "Amparo-Balansi-Mabanag.jpg",
        content: "Amparo Balansi Mabanag is a master T'boli weaver who has dedicated her life to preserving the ancient art of t'nalak weaving. For over forty years, she has created intricate patterns that tell stories of her ancestors and spiritual beliefs. Each piece takes months to complete, using traditional tie-dyeing techniques passed down through generations. Amparo's work has gained international recognition, yet she remains committed to teaching younger generations the sacred knowledge embedded in every thread. Her t'nalak pieces are not merely fabric—they are living records of T'boli history, spirituality, and artistic excellence. Through her dedication, the world has come to recognize the T'boli people as master artists and guardians of an irreplaceable cultural heritage."
    },
    {
        id: 2,
        title: "The Art of Metal Smithing",
        author: "Eduardo Mutuc",
        excerpt: "Eduardo Mutuc's journey to becoming a National Living Treasure",
        image: "Eduardo-Mutuc.jpg",
        content: "Eduardo Mutuc is a legendary Ifugao metal smith who was recognized as a National Living Treasure by the Philippine government. His mastery of traditional metalworking techniques, passed down through his family for countless generations, has made him one of the most respected artisans in the Philippines. Eduardo's creations range from traditional ceremonial items to contemporary artistic pieces, all crafted using age-old methods. Despite the availability of modern tools and materials, he continues to work with handforged techniques, believing that the soul of the craft lies in the direct contact between artisan and material. His workshop has become a gathering place for young artisans eager to learn the secrets of Ifugao metalwork. Eduardo's legacy extends beyond his creations; he is a living link to an ancient tradition that continues to inspire artists worldwide."
    },
    {
        id: 3,
        title: "Weaving Community Together",
        author: "Magdalena Gamayo",
        excerpt: "Inabel weavers creating economic opportunities in Ilocos",
        image: "Magdalena-Gamayo.jpeg",
        content: "Magdalena Gamayo is an Inabel weaver from Ilocos who has transformed the traditional weaving practice into a thriving economic enterprise that benefits her entire community. By combining traditional techniques with contemporary designs, she has created a market for inabel products that reaches far beyond the Philippines. Magdalena's cooperative has provided employment to hundreds of weavers, allowing them to sustain their families while preserving their cultural heritage. Her vision extends beyond commerce—she sees weaving as a spiritual practice and a means of maintaining cultural identity in an increasingly globalized world. Through her leadership, the Inabel weavers of Ilocos have gained international recognition for their exceptional craftsmanship. Magdalena's story demonstrates how indigenous traditions can be economically sustainable while remaining spiritually and culturally authentic."
    },
    {
        id: 4,
        title: "Bead by Bead: The Art of Isnag Beadwork",
        author: "Maria Santos",
        excerpt: "The intricate world of traditional bead crafting",
        image: "Amparo-Balansi-Mabanag.jpg",
        content: "Maria Santos of the Isnag community creates some of the most intricate beadwork in the Philippines. Using beads sourced locally and internationally, she creates patterns that represent her community's stories, spiritual beliefs, and connection to nature. Each piece requires hundreds of hours of meticulous work, with Maria working bead by bead to ensure perfect placement and harmony. Her beadwork has been featured in museums and worn by collectors worldwide, yet Maria remains grounded in her community values. She teaches beadwork to schoolchildren in her village, ensuring that this ancient art form continues to thrive. Maria's work is a testament to the beauty of patience, precision, and cultural pride."
    },
    {
        id: 5,
        title: "Carving Stories in Wood",
        author: "Jose Lumot",
        excerpt: "A woodcarver's journey preserving Bukilnon traditions",
        image: "Eduardo-Mutuc.jpg",
        content: "Jose Lumot is a master woodcarver from Bukilnon whose detailed carvings tell stories of his Manobo heritage. Working with local hardwoods, he creates sculptures, decorative panels, and functional pieces that showcase the spiritual and practical knowledge of his people. Jose learned woodcarving from his grandfather and has spent decades perfecting his technique. His work is characterized by intricate detail, deep respect for the natural grain of the wood, and incorporation of indigenous symbols and patterns. Jose's studio is a hub of cultural learning where young artisans come to study traditional techniques. His commitment to maintaining authentic methods while adapting to contemporary aesthetic preferences has made his work relevant to both cultural preservation efforts and the modern art market."
    },
    {
        id: 6,
        title: "Dyeing Dreams: The Palimoot Weaving Legacy",
        author: "Rosa Valenzuela",
        excerpt: "How natural dyes create vibrant stories in fabric",
        image: "Magdalena-Gamayo.jpeg",
        content: "Rosa Valenzuela is a Tagalog weaver specializing in palimoot—traditionally tie-dyed fabrics created using natural plant-based dyes. Her knowledge of local plants and their dyeing properties allows her to create a stunning palette of colors without relying on chemical dyes. Each plant used—from indigo to marigolds to bark extracts—is carefully cultivated and processed according to ancestral knowledge. Rosa's weaving represents a sustainable approach to textile production that honors both cultural heritage and environmental responsibility. She works closely with farmers to ensure sustainable sourcing of dye plants, creating economic opportunities that support her entire ecosystem. Rosa's vision extends beyond weaving; she advocates for the recognition of indigenous knowledge as a foundation for sustainable practices in the modern world."
    },
    {
        id: 7,
        title: "Sacred Silence: The Art of Baybayin Carving",
        author: "Leonardo Fabro",
        excerpt: "Preserving the ancient Filipino script through artistic expression",
        image: "Amparo-Balansi-Mabanag.jpg",
        content: "Leonardo Fabro is a Mangyan artist dedicated to preserving baybayin, the pre-colonial Filipino script. Rather than simply documenting the script, he creates artistic pieces that incorporate baybayin into contemporary art forms—carvings, paintings, and installations. His work celebrates the sophistication of pre-colonial Filipino culture and challenges the narrative that indigenous peoples lacked advanced systems of writing. Through his artistic practice, Leonardo educates both indigenous and non-indigenous audiences about the linguistic heritage of the Philippines. He conducts workshops teaching baybayin to children and adults, ensuring that this ancient knowledge remains living rather than merely historical. His work stands at the intersection of art, cultural activism, and spiritual practice."
    },
    {
        id: 8,
        title: "Footprints of Tradition: Shoemaking in Mindanao",
        author: "Antonio Cruz",
        excerpt: "Traditional Bagobo footwear crafting in the modern age",
        image: "Eduardo-Mutuc.jpg",
        content: "Antonio Cruz represents the next generation of Bagobo shoemakers, continuing a tradition that has deep roots in his community's identity. Traditional Bagobo shoes, or slip-ons, are crafted using local materials and techniques that reflect the community's connection to their environment. Antonio sources his materials sustainably and employs traditional hand-stitching techniques that create durable, beautiful footwear. His innovation lies in maintaining the authenticity of traditional design while creating pieces that appeal to contemporary consumers. Antonio has expanded his market beyond his local community through online platforms and collaborations with ethical fashion brands. His work demonstrates how indigenous artisans can thrive in the global marketplace while maintaining their cultural integrity and sustainable practices."
    }
];

// Load stories
function loadStories() {
    const container = document.getElementById('stories-container');
    container.innerHTML = allStories.map(story => `
        <article class="group cursor-pointer loading" onclick="openStoryModal(${story.id})">
            <div class="overflow-hidden rounded-xl aspect-[4/3] mb-5">
                <img src="/assets/artisans/${story.image}" 
                     alt="${story.title}" 
                     class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110">
            </div>
            <h3 class="text-xl md:text-2xl mb-3 font-bold group-hover:text-[#5B5843] transition-colors duration-300" style="font-family: 'Elinga', serif;">${story.title}</h3>
            <p class="text-sm md:text-base text-gray-600 futura-400 mb-2"><strong>By:</strong> ${story.author}</p>
            <p class="text-sm md:text-base text-gray-600 futura-400 mb-4">${story.excerpt}</p>
            <a class="inline-flex items-center gap-2 text-[#5B5843] futura-500 text-sm tracking-wide uppercase hover:gap-4 transition-all duration-300">
                Read More
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </article>
    `).join('');
}

// Open story modal
function openStoryModal(storyId) {
    const story = allStories.find(s => s.id === storyId);
    
    if (story) {
        document.getElementById('modal-story-title').textContent = story.title;
        document.getElementById('modal-story-author').textContent = `By ${story.author}`;
        document.getElementById('modal-story-image').src = `/assets/artisans/${story.image}`;
        document.getElementById('modal-story-image').alt = story.title;
        document.getElementById('modal-story-content').innerHTML = `<p>${story.content}</p>`;
        
        document.getElementById('story-modal').classList.remove('hidden');
    }
}

// Close story modal
function closeStoryModal() {
    document.getElementById('story-modal').classList.add('hidden');
}

// Load stories on page load
document.addEventListener('DOMContentLoaded', loadStories);
</script>
@endsection
