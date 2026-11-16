<x-app-layout>
    <x-slot name="title">Tiket Digital</x-slot>
    <x-slot name="header">Tiket Digital</x-slot>

    <div class="mx-auto max-w-xl">
        <x-ticket-card :registration="$registration" />

        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
            <x-button href="{{ route('registrations.show', $registration->id) }}" variant="secondary" class="flex-1">
                Status Pendaftaran
            </x-button>
            <x-button href="{{ route('registrations.index') }}" variant="secondary" class="flex-1">
                Pendaftaran Saya
            </x-button>
        </div>
    </div>
</x-app-layout>
