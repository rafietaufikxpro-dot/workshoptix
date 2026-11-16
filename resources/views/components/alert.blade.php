@php
    $message = session('success') ?? session('error') ?? session('status');
    $type = session('success') ? 'success' : (session('error') ? 'error' : 'status');
@endphp

@if ($message)
    @php
        $styles = [
            'success' => 'border-green-200 bg-green-50 text-green-800',
            'error' => 'border-red-200 bg-red-50 text-red-800',
            'status' => 'border-indigo-200 bg-indigo-50 text-indigo-800',
        ];
    @endphp

    <div class="mb-6 flex items-start gap-3 rounded-xl border px-4 py-3 text-sm {{ $styles[$type] }}" role="alert">
        <svg class="mt-0.5 h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            @if ($type === 'error')
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
            @else
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            @endif
        </svg>
        <p>{{ $message }}</p>
    </div>
@endif
