<x-app-layout>
    <x-slot name="title">Dashboard Panitia</x-slot>
    <x-slot name="header">Dashboard Panitia</x-slot>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Workshop</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ count($workshops) }}</p>
            <x-button href="{{ route('panitia.workshops.index') }}" variant="secondary" class="mt-4 w-full">
                Kelola Workshop
            </x-button>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Pendaftar</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ count($pendaftar) }}</p>
            <x-button href="{{ route('panitia.registrations.index') }}" variant="secondary" class="mt-4 w-full">
                Daftar Pendaftar
            </x-button>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Lunas</p>
            <p class="mt-2 text-3xl font-bold text-green-600">
                {{ collect($pendaftar)->where('payment_status', 'paid')->count() }}
            </p>
            <p class="mt-4 text-xs text-gray-400">Pembayaran terverifikasi</p>
        </div>
    </div>
</x-app-layout>
