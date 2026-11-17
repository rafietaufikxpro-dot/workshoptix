@php
    $role = auth()->check() ? (auth()->user()->getAttributes()['role'] ?? null) : null;
@endphp

<div class="sticky top-0 z-40 border-b border-transparent bg-gray-50/85 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
        <nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 4" :class="scrolled ? 'shadow-md' : 'shadow-sm'" class="flex h-12 items-center justify-between gap-4 rounded-2xl border border-gray-200 bg-white px-3 transition-shadow duration-200 sm:px-4">
            <!-- Logo -->
            <a href="{{ route('landing') }}" class="flex shrink-0 items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-white">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                </span>
                <span class="text-base font-semibold tracking-tight text-gray-900">WorkshopTIX</span>
            </a>

            <!-- Menu desktop (tamu memakai tombol di kanan) -->
            <div class="hidden items-center gap-1 md:flex">
                @auth
                    @if ($role === 'panitia')
                        <x-nav-pill :href="route('panitia.dashboard')" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-pill>
                        <x-nav-pill :href="route('panitia.workshops.index')" :active="request()->routeIs('panitia.workshops.*')">Kelola Workshop</x-nav-pill>
                        <x-nav-pill :href="route('panitia.registrations.index')" :active="request()->routeIs('panitia.registrations.*')">Pendaftar</x-nav-pill>
                    @else
                        <x-nav-pill :href="route('workshops.index')" :active="request()->routeIs('workshops.*')">Workshop</x-nav-pill>
                        <x-nav-pill :href="route('registrations.index')" :active="request()->routeIs('registrations.*')">Pendaftaran Saya</x-nav-pill>
                    @endif
                @endauth
            </div>

            <!-- Kanan desktop -->
            <div class="hidden items-center gap-2 md:flex">
                @guest
                    @unless (request()->routeIs('login'))
                        <x-button href="{{ route('login') }}" variant="secondary">Masuk</x-button>
                    @endunless
                    @unless (request()->routeIs('register'))
                        <x-button href="{{ route('register') }}">Daftar</x-button>
                    @endunless
                @else
                    <x-dropdown align="right" width="56" contentClasses="bg-white p-1">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-xs font-semibold text-white">
                                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="border-b border-gray-100 px-3 py-3">
                                <p class="truncate text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="truncate text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                <span class="mt-2 inline-flex rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700">
                                    {{ $role === 'panitia' ? 'Panitia' : 'Peserta' }}
                                </span>
                            </div>
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
            <div class="flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </nav>

        <!-- Panel mobile -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" class="mt-2 rounded-2xl border border-gray-200 bg-white p-2 shadow-sm md:hidden" style="display: none;">
            @guest
                @unless (request()->routeIs('login'))
                    <x-nav-pill :href="route('login')" :active="request()->routeIs('login')">Masuk</x-nav-pill>
                @endunless
                @unless (request()->routeIs('register'))
                    <x-nav-pill :href="route('register')" :active="request()->routeIs('register')">Daftar</x-nav-pill>
                @endunless
            @elseif ($role === 'panitia')
                <x-nav-pill :href="route('panitia.dashboard')" :active="request()->routeIs('panitia.dashboard')">Dashboard</x-nav-pill>
                <x-nav-pill :href="route('panitia.workshops.index')" :active="request()->routeIs('panitia.workshops.*')">Kelola Workshop</x-nav-pill>
                <x-nav-pill :href="route('panitia.registrations.index')" :active="request()->routeIs('panitia.registrations.*')">Pendaftar</x-nav-pill>
            @else
                <x-nav-pill :href="route('workshops.index')" :active="request()->routeIs('workshops.*')">Workshop</x-nav-pill>
                <x-nav-pill :href="route('registrations.index')" :active="request()->routeIs('registrations.*')">Pendaftaran Saya</x-nav-pill>
            @endguest

            @auth
                <div class="mt-2 border-t border-gray-100 pt-2">
                    <div class="flex items-center gap-2 px-2 py-1.5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-xs font-semibold text-white">
                            {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-gray-500">{{ $role === 'panitia' ? 'Panitia' : 'Peserta' }}</p>
                        </div>
                    </div>
                    <x-nav-pill :href="route('profile.edit')" :active="request()->routeIs('profile.*')">Profil</x-nav-pill>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-nav-pill :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-nav-pill>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</div>
