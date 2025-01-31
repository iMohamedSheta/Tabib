<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <script type="text/javascript">
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
    </script> --}}

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

        pre,
        code {
            text-align: left !important;
            font-size: 0.8rem !important;
            direction: ltr !important;
            background-color: #1f1f1f !important;
            color: #00FF60 !important;
            padding: 1rem !important;
            border-radius: 0.5rem !important;
            overflow-x: auto !important;
            margin: 1rem !important;
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
    class="dark  overflow-hidden scroll-smooth"
    x-on:keydown.window.prevent.ctrl.k="$store.appConfig.showReceptionSearchModal = true"
    x-on:keydown.window.prevent.meta.k="$store.appConfig.showReceptionSearchModal = true">
    <div class="h-screen flex bg-purple-400 dark:bg-c-gray-900  dark:bg-purple-400">

        {{-- DesktopSidebar --}}
        @include('layouts.app.sidebar')
        {{-- /DesktopSidebar --}}

        {{-- MobileSidebar --}}
        @include('layouts.app.sidebar_mobile')
        {{-- /MobileSidebar --}}
        <div
            class=" h-full flex flex-col flex-1 overflow-y-auto  scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800 min-h-[80vh] max-w-[100vw] ">

            {{-- Header --}}
            @include('layouts.app.header')
            {{-- /Header --}}
            <main>
                <div class="h-full overflow-x-auto">
                    <x-spinners.t-spinner></x-spinners.t-spinner>

                    {{ $slot }}
                </div>
            </main>
            <div class="h-full flex items-end">
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('appConfig', {
                showReceptionSearchModal: false,
                isAppFullscreen: false,
                isAppSidebarOpen: Alpine.$persist(true),
                toggleAppFullscreen() {
                    this.isAppFullscreen = !this.isAppFullscreen;

                    if (this.isAppFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else {
                        document.exitFullscreen();
                    }
                },
                toggleAppSidebar() {
                    this.isAppSidebarOpen = !this.isAppSidebarOpen;
                },
                resetGlobalState() {
                    this.showReceptionSearchModal = false;
                }
            })
            // Listen for Livewire events and reset global state
            'livewire:load, livewire:navigate, livewire:update'.split(',').forEach(event => {
                document.addEventListener(event.trim(), () => {
                    Alpine.store('appConfig').resetGlobalState();
                });
            });
        });
    </script>
</body>

</html>
