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
            <div class="mb-8 text-center transform hover:scale-105 transition-transform duration-500">
                <a href="/" class="group flex flex-col items-center gap-4">
                    <div class="w-20 h-20 bg-blue-600 rounded-3xl flex items-center justify-center shadow-xl shadow-blue-500/20 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Perpustakaan <span class="text-blue-600">Digital</span></h1>
                </a>
            </div>

            <div class="w-full {{ $attributes->get('maxWidth', 'sm:max-w-lg') }} px-8 py-10 bg-white/90 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-white/50 sm:rounded-[2rem] relative z-10 backdrop-blur-xl">
                {{ $slot }}
            </div>
            
            <div class="mt-10 text-center text-sm font-medium text-gray-500">
                &copy; {{ date('Y') }} Perpustakaan USK. All rights reserved.
            </div>
        </div>
    </body>
</html>
