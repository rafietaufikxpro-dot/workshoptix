@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border-gray-300 px-3.5 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) }}>
