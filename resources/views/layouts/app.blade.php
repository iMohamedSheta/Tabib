<!DOCTYPE html>
<html   lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/fonts-family.css') }}" />

    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>

    <style>
        body {
            font-family: 'Almarai', sans-serif;
        }
    </style>

    <!-- Styles -->
    @livewireStyles
</head>

<body dir="rtl" x-data="data()" :class="{ 'theme-dark': dark }" class="theme-dark">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

        {{-- DesktopSidebar --}}
        @include('layouts.app.sidebar')
        {{-- /DesktopSidebar --}}

        {{-- MobileSidebar --}}
        @include('layouts.app.sidebar_mobile')
        {{-- /MobileSidebar --}}
        <div class="flex flex-col flex-1">

            {{-- Header --}}
            @include('layouts.app.header')
            {{-- /Header --}}

            <main class="h-full pb-16 overflow-y-auto">
                @yield('main')


                <!-- Remove everything INSIDE this div to a really blank page -->
                {{-- <div class="container py-6 mx-auto grid my-6 text-gray-700 dark:text-gray-200"> --}}
                    {{-- <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        عنوان الصفحة
                    </h2> --}}
                {{-- </div> --}}
            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
