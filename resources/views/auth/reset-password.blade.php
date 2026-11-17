<x-auth-layout>
    <x-slot name="title">Reset Kata Sandi — WorkshopTIX</x-slot>
    <x-slot name="intro">
        <h2 class="text-3xl font-semibold leading-tight tracking-tight">Atur kata sandi baru.</h2>
        <p class="mt-4 text-sm leading-relaxed text-indigo-50">Gunakan kata sandi yang kuat dan mudah kamu ingat.</p>
    </x-slot>

    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Reset kata sandi</h1>
    <p class="mt-1 text-sm text-gray-600">Email: <span class="font-medium text-gray-900">{{ $request->email }}</span></p>

    <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email', $request->email)" placeholder="nama@email.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata sandi" />
            <x-text-input id="password" class="mt-1.5 block w-full" type="password" name="password" placeholder="Buat kata sandi baru" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi kata sandi" />
            <x-text-input id="password_confirmation" class="mt-1.5 block w-full" type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full px-5 py-2.5">Reset Kata Sandi</x-primary-button>
    </form>
</x-auth-layout>
