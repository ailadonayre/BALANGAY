<section class="py-24 bg-[#5B5843] text-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
            @php
            $stats = [
                ['number' => '249', 'label' => 'Artisans Supported'],
                ['number' => '39', 'label' => 'Artists Onboarded'],
                ['number' => '514k', 'label' => 'Income Provided'],
                ['number' => '430', 'label' => 'Products Sold']
            ];
            @endphp

            @foreach($stats as $index => $stat)
            <div class="text-center loading" style="animation-delay: {{ $index * 0.15 }}s">
                <div class="text-5xl md:text-6xl lg:text-7xl mb-4 futura-700 counter" data-target="{{ $stat['number'] }}">0</div>
                <div class="text-sm md:text-base tracking-widest uppercase futura-400 text-white/80">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    // Animated counter
    function animateCounter(element) {
        const target = element.getAttribute('data-target');
        const isK = target.includes('k');
        const numericTarget = parseInt(target.replace('k', ''));
        const duration = 2000;
        const increment = numericTarget / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= numericTarget) {
                current = numericTarget;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + (isK ? 'k' : '');
        }, 16);
    }

    // Trigger counters when section is visible
    const observerStats = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => animateCounter(counter));
                observerStats.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.addEventListener('DOMContentLoaded', function() {
        const statsSection = document.querySelector('.py-24.bg-\\[\\#5B5843\\]');
        if (statsSection) observerStats.observe(statsSection);
    });
</script>