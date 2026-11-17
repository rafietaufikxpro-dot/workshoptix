@props(['workshop'])

<article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
    <div class="-mx-6 -mt-6 mb-5 h-40 overflow-hidden rounded-t-xl bg-indigo-50">
        @if ($workshop->image_url)
            <img src="{{ $workshop->image_url }}" alt="{{ $workshop->title }}" class="h-full w-full object-cover" loading="lazy">
        @else
            <div class="flex h-full w-full items-center justify-center text-indigo-200">
                <svg class="h-9 w-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </div>
        @endif
    </div>

    <div class="flex items-start justify-between gap-4">
        <h3 class="text-lg font-semibold text-gray-900">{{ $workshop->title }}</h3>
        <span class="shrink-0 text-sm font-semibold text-indigo-600">
            Rp {{ number_format($workshop->price, 0, ',', '.') }}
        </span>
    </div>

    <dl class="mt-4 space-y-2 text-sm text-gray-600">
        <div class="flex items-center gap-2">
            <svg class="h-4 w-4 shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            <dd class="font-medium text-gray-900">{{ $workshop->speaker }}</dd>
        </div>
        <div class="flex items-center gap-2">
            <svg class="h-4 w-4 shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            <dd>{{ $workshop->starts_at->translatedFormat('l, d M Y &middot; H:i') }} WIB</dd>
        </div>
        <div class="flex items-center gap-2">
            <svg class="h-4 w-4 shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
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
