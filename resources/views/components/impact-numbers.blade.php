<section class="py-16 md:py-20 lg:py-24 bg-[#5B5843] text-white reveal">
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
                <div class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl mb-3 md:mb-4 futura-700 counter" data-target="0">0</div>
                <div class="text-xs md:text-sm lg:text-base tracking-wider uppercase futura-400 text-white/80">{{ $stat['label'] }}</div>
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
            // Fetch public analytics and update counters
            fetch('/api/public/analytics')
                .then(resp => resp.json())
                .then(data => {
                    const counters = statsSection.querySelectorAll('.counter');
                    if (counters && counters.length >= 4) {
                        counters[0].setAttribute('data-target', data.artisans_supported || 0);
                        counters[1].setAttribute('data-target', data.artists_onboarded || 0);
                        counters[2].setAttribute('data-target', Math.round(data.income_provided) + '');
                        counters[3].setAttribute('data-target', data.products_sold || 0);
                    }
                }).catch(() => {});
    });
</script>