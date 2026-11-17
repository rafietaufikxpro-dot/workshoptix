<x-auth-layout>
    <x-slot name="title">Lupa Kata Sandi — WorkshopTIX</x-slot>
    <x-slot name="intro">
        <h2 class="text-3xl font-semibold leading-tight tracking-tight">Pulihkan kata sandi.</h2>
        <p class="mt-4 text-sm leading-relaxed text-indigo-50">Masukkan email terdaftar dan kami kirim tautan untuk mengatur kata sandi baru.</p>
    </x-slot>

    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Lupa kata sandi</h1>
    <p class="mt-1 text-sm text-gray-600">Kami kirim tautan reset ke email kamu.</p>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" placeholder="nama@email.com" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full px-5 py-2.5">Kirim Tautan Reset</x-primary-button>
    </form>

    <p class="mt-6 text-sm text-gray-600">
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Kembali ke halaman masuk</a>
    </p>
</x-auth-layout>
