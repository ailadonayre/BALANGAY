<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BALANGAY - Ethical e-commerce platform empowering indigenous communities">
    
    <title>{{ config('app.name', 'BALANGAY') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Custom Fonts - Add Elinga and Futura -->
    <style>
        @font-face {
            font-family: 'Elinga';
            src: url('{{ asset('assets/fonts/elinga.woff2') }}') format('woff2');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/futura-light.woff2') }}') format('woff2');
            font-weight: 100;
            font-style: normal;
            font-display: swap;
        }
        
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/futura-book.woff2') }}') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/futura-medium.woff2') }}') format('woff2');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
        
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/futura-bold.woff2') }}') format('woff2');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --color-cream: #F8F4EE;
            --color-olive: #5B5843;
            --color-charcoal: #252525;
            --color-sand: #E4DDCC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Futura', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--color-cream);
            color: var(--color-charcoal);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Elinga', 'Futura', serif;
            font-weight: normal;
            line-height: 1.2;
        }

        .futura-100 { font-weight: 100; }
        .futura-400 { font-weight: 400; }
        .futura-500 { font-weight: 500; }
        .futura-700 { font-weight: 700; }

        /* Smooth Animations */
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        .slide-up {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .loading.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    @include('components.navigation')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')
    @include('components.auth-modal')
    
    @stack('scripts')
</body>
</html>