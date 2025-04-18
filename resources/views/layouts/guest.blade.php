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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" /> --}}

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/fonts-family.css') }}" /> --}}

    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>


    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Changa:wght@200..800&family=El+Messiri:wght@400..700&family=Kufam:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "El Messiri", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }

        /* body {
            font-family: "Cairo", sans-serif;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
        } */
    </style>

    <!-- Styles -->
    @livewireStyles
</head>

<body dir="rtl" x-data="data()" :class="{ 'dark': dark }" class="dark">
    <div class=" min-h-screen ">
        @yield('main')
    </div>

    @stack('modals')

    @livewireScripts
    @stack('scripts')

</body>

</html>
