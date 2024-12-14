<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" /> --}}

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/fonts-family.css') }}" /> --}}

    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=El+Messiri:wght@400..700&display=swap"
        rel="stylesheet">

    @laravelPWA
    <style>
        body {
            font-family: "El Messiri", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
    @stack('styles')
    <!-- Styles -->
    @livewireStyles
</head>

<body dir="rtl" x-data="data()" id="app" :class="{ 'dark': dark }" class="dark  overflow-hidden  ">
    <div class="flex bg-purple-300 dark:bg-c-gray-900  dark:bg-purple-400">

        {{-- DesktopSidebar --}}
        @include('layouts.app.sidebar')
        {{-- /DesktopSidebar --}}

        {{-- MobileSidebar --}}
        @include('layouts.app.sidebar_mobile')
        {{-- /MobileSidebar --}}
        <div
            class="flex flex-col flex-1 h-screen overflow-y-auto overflow-x-hidden scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800 min-h-[80vh] max-w-[100vw] ">

            {{-- Header --}}
            @include('layouts.app.header')
            {{-- /Header --}}

            <main>
                <div class="min-h-[82vh]">
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
</body>

</html>
