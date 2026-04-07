<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustakaan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-blue-50/40 relative overflow-x-hidden min-h-screen">
        {{-- Soft Background blobs --}}
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] sm:w-[600px] sm:h-[600px] rounded-full bg-blue-100/60 blur-3xl"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-[300px] h-[300px] sm:w-[500px] sm:h-[500px] rounded-full bg-indigo-100/60 blur-3xl"></div>
        </div>

        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6">

            <div class="w-full {{ $attributes->get('maxWidth', 'sm:max-w-lg') }} px-8 py-10 bg-white/90 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-white/50 sm:rounded-[2rem] relative z-10 backdrop-blur-xl">
                {{ $slot }}
            </div>
            
        </div>
    </body>
</html>
