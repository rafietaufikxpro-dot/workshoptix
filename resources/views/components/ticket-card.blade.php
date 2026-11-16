@props(['registration'])

@php
    $workshop = $registration->workshop;
    $user = $registration->user;
@endphp

<div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-dashed border-gray-200 bg-indigo-50 px-6 py-4 rounded-t-xl">
        <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Kode Tiket</p>
        <p class="mt-1 text-2xl font-bold tracking-wider text-gray-900">{{ $registration->ticket_code }}</p>
    </div>

    <dl class="space-y-4 px-6 py-6 text-sm">
        <div class="flex items-start justify-between gap-4">
            <dt class="text-gray-500">Peserta</dt>
            <dd class="text-right font-medium text-gray-900">{{ $user->name }}</dd>
        </div>
        <div class="flex items-start justify-between gap-4">
            <dt class="text-gray-500">Workshop</dt>
            <dd class="text-right font-medium text-gray-900">{{ $workshop->title }}</dd>
        </div>
        <div class="flex items-start justify-between gap-4">
            <dt class="text-gray-500">Pemateri</dt>
            <dd class="text-right font-medium text-gray-900">{{ $workshop->speaker }}</dd>
        </div>
        <div class="flex items-start justify-between gap-4">
            <dt class="text-gray-500">Lokasi</dt>
            <dd class="text-right font-medium text-gray-900">{{ $workshop->venue }}</dd>
        </div>
        <div class="flex items-start justify-between gap-4">
            <dt class="text-gray-500">Jadwal</dt>
            <dd class="text-right font-medium text-gray-900">
                {{ $workshop->starts_at->translatedFormat('l, d M Y') }}<br>
                {{ $workshop->starts_at->format('H:i') }} &ndash; {{ $workshop->ends_at->format('H:i') }} WIB
            </dd>
        </div>
    </dl>

    <div class="border-t border-gray-200 px-6 py-4">
        <x-status-badge :status="$registration->payment_status" />
    </div>
</div>