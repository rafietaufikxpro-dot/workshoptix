<x-auth-layout>
    <x-slot name="title">Konfirmasi Kata Sandi — WorkshopTIX</x-slot>
    <x-slot name="intro">
        <h2 class="text-3xl font-semibold leading-tight tracking-tight">Konfirmasi kata sandi.</h2>
        <p class="mt-4 text-sm leading-relaxed text-indigo-50">Ini area aman aplikasi. Konfirmasi kata sandi sebelum melanjutkan.</p>
    </x-slot>

    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Konfirmasi kata sandi</h1>
    <p class="mt-1 text-sm text-gray-600">Masukkan kata sandi untuk melanjutkan.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="password" value="Kata sandi" />
            <x-text-input id="password" class="mt-1.5 block w-full" type="password" name="password" placeholder="Masukkan kata sandi" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full px-5 py-2.5">Konfirmasi</x-primary-button>
    </form>

    <p class="mt-6 text-sm text-gray-600">
        <a href="{{ route('landing') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Kembali ke beranda</a>
    </p>
</x-auth-layout>
