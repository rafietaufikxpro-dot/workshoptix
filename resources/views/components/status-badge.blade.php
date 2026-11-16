@props(['status'])

@php
    $map = [
        'pending' => ['label' => 'Menunggu', 'class' => 'bg-yellow-100 text-yellow-800'],
        'paid' => ['label' => 'Lunas', 'class' => 'bg-green-100 text-green-800'],
        'failed' => ['label' => 'Gagal', 'class' => 'bg-red-100 text-red-800'],
        'expired' => ['label' => 'Kedaluwarsa', 'class' => 'bg-gray-100 text-gray-800'],
    ];

    $item = $map[$status] ?? ['label' => ucfirst((string) $status), 'class' => 'bg-gray-100 text-gray-800'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium '.$item['class']]) }}>
    {{ $item['label'] }}
</span>
