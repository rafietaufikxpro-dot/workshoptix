<x-app-layout>
    <x-slot name="title">Daftar Pendaftar</x-slot>
    <x-slot name="header">Daftar Pendaftar</x-slot>

    <p class="mb-6 text-sm text-gray-500">{{ count($pendaftar) }} pendaftaran</p>

    @if (count($pendaftar) > 0)
        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Peserta</th>
                        <th class="px-4 py-3">Workshop</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($pendaftar as $registration)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $registration->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $registration->user->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $registration->workshop->title }}</td>
                            <td class="px-4 py-3"><x-status-badge :status="$registration->payment_status" /></td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $registration->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-empty-state title="Belum ada pendaftar" description="Pendaftaran akan muncul di sini." />
    @endif
</x-app-layout>
