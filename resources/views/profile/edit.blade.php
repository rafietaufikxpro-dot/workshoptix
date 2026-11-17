<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900">Profil</h2>
        <p class="mt-1 text-sm text-gray-500">Kelola informasi akun dan kata sandi.</p>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
