<x-app-layout>
    <x-slot name="title">{{ $workshop->title }}</x-slot>
    <x-slot name="header">{{ $workshop->title }}</x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="h-56 w-full bg-indigo-50 sm:h-64">
                    @if ($workshop->image_url)
                        <img src="{{ $workshop->image_url }}" alt="{{ $workshop->title }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-indigo-200">
                            <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

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
                    @if ($workshop->hasStarted())
                        <x-button type="button" class="w-full" disabled>Sudah Dimulai</x-button>
                    @elseif ($workshop->seats_left > 0)
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
