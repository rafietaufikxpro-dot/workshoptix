<x-app-layout>
    <x-slot name="title">Status Pendaftaran</x-slot>
    <x-slot name="header">Status Pendaftaran</x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">{{ $registration->workshop->title }}</h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $registration->workshop->speaker }} &middot; {{ $registration->workshop->venue }}
                </p>

                <dl class="mt-4 space-y-3 border-t border-gray-100 pt-4 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-500">Order ID</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->order_id ?? '-' }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-500">Nominal</dt>
                        <dd class="font-semibold text-gray-900">Rp {{ number_format($registration->amount, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd><x-status-badge :status="$registration->payment_status" /></dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-500">Jadwal</dt>
                        <dd class="text-right font-medium text-gray-900">
                            {{ $registration->workshop->starts_at->translatedFormat('l, d M Y') }},
                            {{ $registration->workshop->starts_at->format('H:i') }} WIB
                        </dd>
                    </div>
                </dl>
            </section>

            @if ($registration->payment_status === 'paid')
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    Pembayaran sudah lunas. Silakan buka tiket digital kamu.
                </div>
            @endif
        </div>

        <aside>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm lg:sticky lg:top-6 space-y-3">
                @if ($registration->payment_status !== 'paid')
                    <form method="POST" action="{{ route('registrations.pay', $registration->id) }}">
                        @csrf
                        <x-button type="submit" class="w-full">Bayar Sekarang</x-button>
                    </form>

                    <form method="POST" action="{{ route('registrations.check', $registration->id) }}">
                        @csrf
                        <x-button type="submit" variant="secondary" class="w-full">Cek Status</x-button>
                    </form>
                @endif

                @if ($registration->payment_status === 'paid')
                    <x-button href="{{ route('registrations.ticket', $registration->id) }}" class="w-full">
                        Lihat Tiket
                    </x-button>
                @endif

                <x-button href="{{ route('registrations.index') }}" variant="secondary" class="w-full">
                    Kembali
                </x-button>
            </div>
        </aside>
    </div>
</x-app-layout>
