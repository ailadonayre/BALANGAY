<section class="py-16 md:py-20 lg:py-24 bg-white" id="artisans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl mb-4 md:mb-6">Featured Artisans</h2>
            <p class="text-sm md:text-base lg:text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Meet the master craftspeople preserving centuries-old traditions
            </p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 lg:gap-10">
            @php
            $artisans = [
                [
                    'name' => 'Amparo Balansi Mabanag',
                    'community' => 'T\'boli',
                    'craft' => 'T\'nalak Weaving',
                    'image' => 'Amparo-Balansi-Mabanag.jpg'
                ],
                [
                    'name' => 'Eduardo Mutuc',
                    'community' => 'Kapampangan',
                    'craft' => 'Metal Smithing',
                    'image' => 'Eduardo-Mutuc.jpg'
                ],
                [
                    'name' => 'Magdalena Gamayo',
                    'community' => 'Ilocano',
                    'craft' => 'Inabel Weaving',
                    'image' => 'Magdalena-Gamayo.jpeg'
                ]
            ];
            @endphp

            @foreach($artisans as $index => $artisan)
            <div class="group loading" style="animation-delay: {{ $index * 0.2 }}s">
                <div class="relative overflow-hidden rounded-xl aspect-[4/5] mb-5">
                    <img src="{{ asset('assets/artisans/' . $artisan['image']) }}" 
                         alt="{{ $artisan['name'] }}" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="text-center">
                    <h3 class="text-xl md:text-2xl mb-2 futura-500">{{ $artisan['name'] }}</h3>
                    <p class="text-[#5B5843] mb-1 futura-400 text-sm">{{ $artisan['community'] }}</p>
                    <p class="text-gray-500 text-sm futura-100">{{ $artisan['craft'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>