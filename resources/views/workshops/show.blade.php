<x-app-layout>
    <x-slot name="title">{{ $workshop->title }}</x-slot>
    <x-slot name="header">{{ $workshop->title }}</x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Deskripsi</h2>
                <p class="mt-3 leading-relaxed text-gray-600">{{ $workshop->description }}</p>
            </section>

            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Detail Workshop</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2 text-sm">
                    <div>
                        <dt class="text-gray-500">Pemateri</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $workshop->speaker }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Lokasi</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $workshop->venue }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Mulai</dt>
                        <dd class="mt-1 font-medium text-gray-900">
                            {{ $workshop->starts_at->translatedFormat('l, d M Y') }}, {{ $workshop->starts_at->format('H:i') }} WIB
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Selesai</dt>
                        <dd class="mt-1 font-medium text-gray-900">
                            {{ $workshop->ends_at->translatedFormat('l, d M Y') }}, {{ $workshop->ends_at->format('H:i') }} WIB
                        </dd>
                    </div>
                </dl>
            </section>
        </div>

        <aside>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm lg:sticky lg:top-6">
                <p class="text-sm text-gray-500">Harga</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">
                    Rp {{ number_format($workshop->price, 0, ',', '.') }}
                </p>

                <div class="mt-4 border-t border-gray-100 pt-4 text-sm">
                    <span class="{{ $workshop->seats_left > 0 ? 'text-gray-600' : 'text-red-600 font-medium' }}">
                        Sisa kuota: {{ $workshop->seats_left }} / {{ $workshop->quota }}
                    </span>
                </div>

                <div class="mt-6">
                    @if ($workshop->seats_left > 0)
                        <form method="POST" action="{{ route('workshops.register', $workshop->id) }}">
                            @csrf
                            <x-button type="submit" class="w-full">Daftar</x-button>
                        </form>
                    @else
                        <x-button type="button" class="w-full" disabled>Kuota Penuh</x-button>
                    @endif

                    <x-button href="{{ route('workshops.index') }}" variant="secondary" class="mt-3 w-full">
                        Kembali
                    </x-button>
                </div>
            </div>
        </aside>
    </div>
</x-app-layout>
