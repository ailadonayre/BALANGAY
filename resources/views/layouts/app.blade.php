<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BALANGAY - Ethical e-commerce platform empowering indigenous communities">

    <title>{{ config('app.name', 'BALANGAY') }}</title>

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Fonts -->
    <style>
        /* ELINGA FONT */
        @font-face {
            font-family: 'Elinga';
            src: url('{{ asset('assets/fonts/Elinga.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Elinga';
            src: url('{{ asset('assets/fonts/Elinga Italic.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: italic;
            font-display: swap;
        }
        @font-face {
            font-family: 'Elinga Outline';
            src: url('{{ asset('assets/fonts/Elinga Outline.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Elinga Outline';
            src: url('{{ asset('assets/fonts/Elinga Outline Italic.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: italic;
            font-display: swap;
        }

        /* FUTURA FONT */
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaLight.ttf') }}') format('truetype');
            font-weight: 100;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaTMed.ttf') }}') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaMedium.ttf') }}') format('truetype');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaT_Bold.ttf') }}') format('truetype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Futura';
            src: url('{{ asset('assets/fonts/FuturaHeavy.ttf') }}') format('truetype');
            font-weight: 900;
            font-style: normal;
            font-display: swap;
        }

        /* Root colors */
        :root {
            --color-cream: #F8F4EE;
            --color-olive: #5B5843;
            --color-charcoal: #252525;
            --color-sand: #E4DDCC;
        }

        /* Global resets */
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
        .futura-900 { font-weight: 900; }

        /* Animations */
        .fade-in { animation: fadeIn 0.8s ease-in; }
        .slide-up { animation: slideUp 0.8s ease-out; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Loading */
        .loading {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .loading.visible {
            opacity: 1;
            transform: translateY(0);
        }

        html { scroll-behavior: smooth; }
    </style>

    @stack('styles')
</head>
<body>
    {{-- Navigation --}}
    @include('components.navigation')

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Auth Modal for Sign In / Sign Up --}}
    @include('components.auth-modal')

    @stack('scripts')

    {{-- Optional: trigger auth modal after 10 seconds --}}
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const modal = document.getElementById('auth-modal');
                if(modal) modal.classList.add('visible');
            }, 10000);
        });
    </script>
</body>
</html>