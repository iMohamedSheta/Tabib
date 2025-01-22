<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "pqxfuoazni");
    </script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" /> --}}

    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/fonts-family.css') }}" /> --}}

    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Changa:wght@200..800&family=El+Messiri:wght@400..700&family=Kufam:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    @laravelPWA
    <style>
        /* body {
            font-family: "El Messiri", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        } */
        body {
            font-family: "Cairo", sans-serif;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
        }

        .swal2-title {
            font-size: 1.5rem !important;
        }

        /* body {
            font-family: "Changa", sans-serif;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
        } */
    </style>
    @stack('styles')
    <!-- Styles -->
    @livewireStyles
</head>

<body dir="rtl" x-data="data()" id="app" :class="{ 'dark': dark }"
    class="dark  overflow-hidden scroll-smooth">
    <div class="flex bg-purple-300 dark:bg-c-gray-900  dark:bg-purple-400">

        {{-- DesktopSidebar --}}
        @include('layouts.app.sidebar')
        {{-- /DesktopSidebar --}}

        {{-- MobileSidebar --}}
        @include('layouts.app.sidebar_mobile')
        {{-- /MobileSidebar --}}
        <div
            class="flex flex-col flex-1 h-screen overflow-y-auto  scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800 min-h-[80vh] max-w-[100vw] ">

            {{-- Header --}}
            @include('layouts.app.header')
            {{-- /Header --}}

            <main>
                <div class="min-h-[87vh] overflow-x-auto">
                    <x-spinners.t-spinner></x-spinners.t-spinner>

                    {{ $slot }}
                </div>
            </main>
            <div class="block">
                @include('layouts.app.footer')
            </div>
        </div>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('scripts')
    <script src="{{ asset('assets/js/sweetalert.all.js') }}"></script>
    <script src="{{ asset('assets/helpers/sweetalertHelper.js') }}"></script>
    <script src="{{ asset('assets/helpers/mainHelpers.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/ripple.min.js') }}"></script>
    {{-- <script>
        // Function to initialize Ripple.js
        function initializeRipple() {
            const ripple = window.ripple; // Access ripple from the global scope
            if (ripple) ripple();
        }

        // Initialize Ripple effect on page load
        initializeRipple();

        // Reinitialize after Livewire events
        document.addEventListener('livewire:load', initializeRipple); // On Livewire load
        document.addEventListener('livewire:update', initializeRipple); // On Livewire DOM update
        document.addEventListener('livewire:navigate', initializeRipple); // On SPA navigation
    </script> --}}

</body>

</html>
