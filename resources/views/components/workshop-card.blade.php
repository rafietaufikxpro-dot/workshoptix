@props(['workshop'])

<article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">
    <div class="flex items-start justify-between gap-4">
        <h3 class="text-lg font-semibold text-gray-900">{{ $workshop->title }}</h3>
        <span class="shrink-0 text-sm font-semibold text-indigo-600">
            Rp {{ number_format($workshop->price, 0, ',', '.') }}
        </span>
    </div>

    <dl class="mt-4 space-y-2 text-sm text-gray-600">
        <div class="flex items-center gap-2">
            <dt class="sr-only">Pemateri</dt>
            <dd class="font-medium text-gray-900">{{ $workshop->speaker }}</dd>
        </div>
        <div class="flex items-center gap-2">
            <dt class="sr-only">Jadwal</dt>
            <dd>{{ $workshop->starts_at->translatedFormat('l, d M Y &middot; H:i') }} WIB</dd>
        </div>
        <div class="flex items-center gap-2">
            <dt class="sr-only">Lokasi</dt>
            <dd>{{ $workshop->venue }}</dd>
        </div>
    </dl>

    <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
        <span class="text-sm {{ $workshop->seats_left > 0 ? 'text-gray-600' : 'text-red-600 font-medium' }}">
            Sisa kuota: {{ $workshop->seats_left }} / {{ $workshop->quota }}
        </span>

        <x-button href="{{ route('workshops.show', $workshop->id) }}">Detail</x-button>
    </div>
</article>
