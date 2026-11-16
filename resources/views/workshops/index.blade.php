<x-app-layout>
    <x-slot name="title">Daftar Workshop</x-slot>
    <x-slot name="header">Daftar Workshop</x-slot>

    @if (count($workshops) > 0)
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($workshops as $workshop)
                <x-workshop-card :workshop="$workshop" />
            @endforeach
        </div>
    @else
        <x-empty-state
            title="Belum ada workshop"
            description="Workshop akan muncul di sini setelah panitia menambahkannya."
        />
    @endif
</x-app-layout>
