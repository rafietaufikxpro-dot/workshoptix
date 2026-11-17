<x-auth-layout>
    <x-slot name="title">Daftar — WorkshopTIX</x-slot>

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
                <h2 class="text-3xl font-semibold leading-tight tracking-tight">Daftar sebagai peserta, langsung pilih workshop.</h2>
                <ul class="mt-8 space-y-4 text-sm text-indigo-100">
                    <li class="flex gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Akun peserta dibuat otomatis oleh server.</span>
                    </li>
                    <li class="flex gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Satu pendaftaran untuk tiap workshop, tanpa duplikasi.</span>
                    </li>
                    <li class="flex gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Tiket digital dengan kode unik setelah lunas.</span>
                    </li>
                </ul>
            </div>

            <p class="text-xs text-indigo-100">SMK Pesat &middot; LKPD Drill Pra-Sertifikasi</p>
        </aside>

        <!-- Form -->
        <div class="flex items-center justify-center px-6 py-12 sm:px-10">
            <div class="w-full max-w-md">
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Daftar akun peserta</h1>
                <p class="mt-1 text-sm text-gray-600">Isi data di bawah ini. Peran peserta ditetapkan server.</p>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nama" />
                        <x-text-input id="name" class="mt-1.5 block w-full" type="text" name="name" :value="old('name')" placeholder="Nama lengkap" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" placeholder="nama@email.com" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Kata sandi" />
                        <x-text-input id="password" class="mt-1.5 block w-full" type="password" name="password" placeholder="Buat kata sandi" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi kata sandi" />
                        <x-text-input id="password_confirmation" class="mt-1.5 block w-full" type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full px-5 py-2.5">Daftar</x-primary-button>
                </form>

                <p class="mt-6 text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</x-auth-layout>
