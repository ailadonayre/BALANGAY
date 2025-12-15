@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-[70vh] md:h-[80vh] lg:h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('assets/hero/hero.png') }}" alt="BALANGAY Heritage" class="w-full h-full object-cover object-center" id="hero-image">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/50"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 text-center px-4 sm:px-6 max-w-4xl mx-auto pt-20">
        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl text-white mb-6 tracking-tight leading-tight font-normal">
            Where every craft<br>tells a story.
        </h1>
        <p class="text-sm sm:text-base md:text-lg text-white/90 mb-8 futura-400 max-w-2xl mx-auto leading-relaxed">
            An ethical e-commerce platform empowering indigenous communities by connecting their crafts and heritage to socially conscious consumers
        </p>
        <a href="#discover" class="inline-block bg-white text-[#252525] px-8 md:px-12 py-3 md:py-4 rounded-full text-xs md:text-sm tracking-widest uppercase futura-500 hover:bg-[#E4DDCC] transition-all duration-300 transform hover:scale-105">
            Explore
        </a>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce hidden md:block">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>

@include('components.impact-numbers')
@include('components.featured-artisans')
@include('components.indigenous-tribes')
@include('components.shop-section')
@include('components.stories-section')
@include('components.support-section')
@endsection

@push('scripts')
<script>
    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all loading elements
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.loading').forEach(el => {
            observer.observe(el);
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush