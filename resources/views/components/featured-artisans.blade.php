<section class="py-24 bg-white" id="artisans">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 loading">
            <h2 class="text-4xl md:text-5xl lg:text-6xl mb-6">Featured Artisans</h2>
            <p class="text-lg text-gray-600 futura-400 max-w-2xl mx-auto">
                Meet the master craftspeople preserving centuries-old traditions
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
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
                <div class="relative overflow-hidden rounded-2xl aspect-[3/4] mb-6">
                    <img src="{{ asset('assets/artisans/' . $artisan['image']) }}" 
                         alt="{{ $artisan['name'] }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="text-center">
                    <h3 class="text-2xl mb-2 futura-500">{{ $artisan['name'] }}</h3>
                    <p class="text-[#5B5843] mb-1 futura-400">{{ $artisan['community'] }}</p>
                    <p class="text-gray-500 text-sm futura-100">{{ $artisan['craft'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>