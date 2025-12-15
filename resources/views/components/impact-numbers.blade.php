<section class="py-16 md:py-20 lg:py-24 bg-[#5B5843] text-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
            <div class="text-center loading" style="animation-delay: 0s">
                <div class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl mb-3 md:mb-4 futura-700 counter" data-target="0" id="stat-artisans">0</div>
                <div class="text-xs md:text-sm lg:text-base tracking-wider uppercase futura-400 text-white/80">Artisans Supported</div>
            </div>
            
            <div class="text-center loading" style="animation-delay: 0.15s">
                <div class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl mb-3 md:mb-4 futura-700 counter" data-target="0" id="stat-onboarded">0</div>
                <div class="text-xs md:text-sm lg:text-base tracking-wider uppercase futura-400 text-white/80">Artists Onboarded</div>
            </div>
            
            <div class="text-center loading" style="animation-delay: 0.3s">
                <div class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl mb-3 md:mb-4 futura-700 counter" data-target="0" data-is-currency="true" id="stat-income">₱0</div>
                <div class="text-xs md:text-sm lg:text-base tracking-wider uppercase futura-400 text-white/80">Income Provided</div>
            </div>
            
            <div class="text-center loading" style="animation-delay: 0.45s">
                <div class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl mb-3 md:mb-4 futura-700 counter" data-target="0" id="stat-products">0</div>
                <div class="text-xs md:text-sm lg:text-base tracking-wider uppercase futura-400 text-white/80">Products Sold</div>
            </div>
        </div>
    </div>
</section>

<script>
    // Load real analytics data
    async function loadImpactNumbers() {
        try {
            const response = await fetch('/api/public/analytics');
            const data = await response.json();
            
            // Update counter targets with real data
            document.getElementById('stat-artisans').setAttribute('data-target', data.artisans_supported || 0);
            document.getElementById('stat-onboarded').setAttribute('data-target', data.artists_onboarded || 0);
            
            // Format income (convert to k if over 1000)
            const income = data.income_provided || 0;
            const incomeDisplay = income >= 1000 ? Math.floor(income / 1000) + 'k' : income;
            document.getElementById('stat-income').setAttribute('data-target', incomeDisplay);
            document.getElementById('stat-income').setAttribute('data-raw-value', income);
            
            document.getElementById('stat-products').setAttribute('data-target', data.products_sold || 0);
            
        } catch (error) {
            console.error('Error loading analytics:', error);
        }
    }

    // Animated counter
    function animateCounter(element) {
        const target = element.getAttribute('data-target');
        const isCurrency = element.getAttribute('data-is-currency') === 'true';
        const isK = target.toString().includes('k');
        const numericTarget = parseInt(target.toString().replace('k', '').replace('₱', ''));
        const duration = 2000;
        const increment = numericTarget / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= numericTarget) {
                current = numericTarget;
                clearInterval(timer);
            }
            
            const displayValue = Math.floor(current);
            if (isCurrency) {
                element.textContent = '₱' + displayValue + (isK ? 'k' : '');
            } else {
                element.textContent = displayValue + (isK ? 'k' : '');
            }
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
        // Load real data first
        loadImpactNumbers().then(() => {
            // Then observe for animation
            const statsSection = document.querySelector('.py-16.bg-\\[\\#5B5843\\]');
            if (statsSection) observerStats.observe(statsSection);
        });
    });
</script>