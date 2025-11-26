<section class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image with Parallax Effect -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('assets/hero/hero.png') }}" alt="BALANGAY Heritage" class="w-full h-full object-cover" id="hero-image">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/50"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto fade-in">
        <h1 class="text-5xl md:text-7xl lg:text-8xl text-white mb-6 tracking-tight leading-tight">
            Where every craft<br>tells a story.
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-12 futura-400 max-w-2xl mx-auto leading-relaxed">
            An ethical e-commerce platform empowering indigenous communities by connecting their crafts and heritage to socially conscious consumers
        </p>
        <a href="#discover" class="inline-block bg-white text-[#252525] px-10 py-4 rounded-full text-sm tracking-widest uppercase futura-500 hover:bg-[#E4DDCC] transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            Explore
        </a>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>

<script>
    // Parallax effect for hero image
    window.addEventListener('scroll', function() {
        const heroImage = document.getElementById('hero-image');
        const scrolled = window.pageYOffset;
        heroImage.style.transform = 'translateY(' + (scrolled * 0.5) + 'px)';
    });
</script>