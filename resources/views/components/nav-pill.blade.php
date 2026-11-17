@props(['href', 'active' => false])

@php
    $classes = $active
        ? 'bg-indigo-50 text-indigo-700'
        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center rounded-lg px-3 py-1.5 text-sm font-medium transition duration-150 '.$classes]) }}>
    {{ $slot }}
</a>
