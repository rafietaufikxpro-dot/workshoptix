<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WorkshopTIX') }}@hasSection('title') — @yield('title')@endif</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navbar')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ $header }}</h1>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <x-alert />
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} WorkshopTIX &middot; Pendaftaran dan tiket digital workshop IT.</p>
                    <p class="text-sm text-gray-400">Laravel {{ app()->version() }}</p>
                </div>
            </footer>
        </div>
    </body>
</html>
