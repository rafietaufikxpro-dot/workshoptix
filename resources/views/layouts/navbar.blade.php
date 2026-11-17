@php
    // Kolom `role` belum ada sebelum migration item 5; getAttributes() agar navbar tidak error saat tampilan dummy.
    $role = auth()->check() ? (auth()->user()->getAttributes()['role'] ?? null) : null;
@endphp

<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 4" :class="scrolled ? 'shadow-sm' : ''" class="sticky top-0 z-40 bg-white/95 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-2 shrink-0">
                    <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                    </svg>
                    <span class="text-lg font-semibold text-gray-900">WorkshopTIX</span>
                </a>

                <!-- Menu utama -->
                <div class="hidden md:flex items-center gap-1">
                    @guest
                        {{-- Tamu cukup memakai tombol Masuk/Daftar di kanan. --}}
                    @elseif ($role === 'panitia')
                        <x-nav-link :href="route('panitia.dashboard')" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-link>
                        <x-nav-link :href="route('panitia.workshops.index')" :active="request()->routeIs('panitia.workshops.*')">Kelola Workshop</x-nav-link>
                        <x-nav-link :href="route('panitia.registrations.index')" :active="request()->routeIs('panitia.registrations.*')">Pendaftar</x-nav-link>
                    @else
                        <x-nav-link :href="route('workshops.index')" :active="request()->routeIs('workshops.*')">Workshop</x-nav-link>
                        <x-nav-link :href="route('registrations.index')" :active="request()->routeIs('registrations.*')">Pendaftaran Saya</x-nav-link>
                    @endguest
                </div>
            </div>

            <!-- Kanan -->
            <div class="hidden md:flex items-center gap-3">
                @guest
                    @unless (request()->routeIs('login'))
                        <x-button href="{{ route('login') }}" variant="secondary">Masuk</x-button>
                    @endunless
                    @unless (request()->routeIs('register'))
                        <x-button href="{{ route('register') }}">Daftar</x-button>
                    @endunless
                @else
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-gray-600 bg-white hover:text-gray-900 focus:outline-none transition">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs text-gray-400">{{ auth()->user()->email }}</div>
                            <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @guest
                @unless (request()->routeIs('login'))
                    <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">Masuk</x-responsive-nav-link>
                @endunless
                @unless (request()->routeIs('register'))
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">Daftar</x-responsive-nav-link>
                @endunless
            @elseif ($role === 'panitia')
                <x-responsive-nav-link :href="route('panitia.dashboard')" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('panitia.workshops.index')" :active="request()->routeIs('panitia.workshops.*')">Kelola Workshop</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('panitia.registrations.index')" :active="request()->routeIs('panitia.registrations.*')">Pendaftar</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('workshops.index')" :active="request()->routeIs('workshops.*')">Workshop</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('registrations.index')" :active="request()->routeIs('registrations.*')">Pendaftaran Saya</x-responsive-nav-link>
            @endguest
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Keluar
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
