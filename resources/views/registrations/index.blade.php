<x-app-layout>
    <x-slot name="title">Pendaftaran Saya</x-slot>
    <x-slot name="header">Pendaftaran Saya</x-slot>

    @if (count($registrations) > 0)
        <div class="space-y-4">
            @foreach ($registrations as $registration)
                <article class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $registration->workshop->title }}</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Didaftarkan {{ $registration->created_at->translatedFormat('d M Y, H:i') }} WIB
                        </p>
                        <div class="mt-2">
                            <x-status-badge :status="$registration->payment_status" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-900">
                            Rp {{ number_format($registration->amount, 0, ',', '.') }}
                        </span>
                        <x-button href="{{ route('registrations.show', $registration->id) }}">Lihat Status</x-button>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <x-empty-state
            title="Kamu belum punya pendaftaran"
            description="Pilih workshop dulu, lalu daftar."
        >
            <x-button href="{{ route('workshops.index') }}">Lihat Workshop</x-button>
        </x-empty-state>
    @endif
</x-app-layout>
