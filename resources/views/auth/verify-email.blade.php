<x-auth-layout>
    <x-slot name="title">Verifikasi Email — WorkshopTIX</x-slot>
    <x-slot name="intro">
        <h2 class="text-3xl font-semibold leading-tight tracking-tight">Verifikasi email kamu.</h2>
        <p class="mt-4 text-sm leading-relaxed text-indigo-50">Klik tautan di email untuk mengaktifkan akun. Belum menerima email? Kirim ulang.</p>
    </x-slot>

    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Verifikasi email</h1>
    <p class="mt-1 text-sm text-gray-600">Satu langkah terakhir sebelum mendaftar workshop.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            Tautan verifikasi baru sudah dikirim ke email kamu.
        </div>
    @endif

    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="px-5 py-2.5">Kirim Ulang Tautan</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Keluar</button>
        </form>
    </div>
</x-auth-layout>
