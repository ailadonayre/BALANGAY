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
    </style>

    @stack('styles')
</head>
<body class="bg-[#F8F4EE] text-[#252525] font-[Futura] overflow-x-hidden">

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