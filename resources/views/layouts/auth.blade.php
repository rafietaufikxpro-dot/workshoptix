<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'WorkshopTIX') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navbar')

            <main class="flex-1 flex flex-col">
                <div class="grid flex-1 lg:grid-cols-[1.05fr_1fr]">
                    <!-- Panel brand -->
                    <aside class="hidden lg:flex flex-col justify-between bg-indigo-600 p-12 text-white">
                        <a href="{{ route('landing') }}" class="flex items-center gap-2">
                            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                            </svg>
                            <span class="text-lg font-semibold">WorkshopTIX</span>
                        </a>

                        <div>
                            @isset ($intro)
                                {{ $intro }}
                            @else
                                <h2 class="text-3xl font-semibold leading-tight tracking-tight">Satu akun untuk semua workshop IT.</h2>
                            @endisset
                        </div>

                        <p class="text-xs text-indigo-50">SMK Pesat &middot; LKPD Drill Pra-Sertifikasi</p>
                    </aside>

                    <!-- Form -->
                    <div class="flex items-center justify-center px-6 py-12 sm:px-10">
                        <div class="w-full max-w-md">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
