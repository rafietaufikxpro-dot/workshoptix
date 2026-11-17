<x-app-layout>
    <x-slot name="title">Kelola Workshop</x-slot>
    <x-slot name="header">Kelola Workshop</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ count($workshops) }} workshop terdaftar</p>
        <x-button href="{{ route('panitia.workshops.create') }}">Tambah Workshop</x-button>
    </div>

    @if (count($workshops) > 0)
        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Jadwal</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Kuota</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($workshops as $workshop)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-lg bg-indigo-50">
                                        @if ($workshop->image_url)
                                            <img src="{{ $workshop->image_url }}" alt="{{ $workshop->title }}" class="h-full w-full object-cover">
                                        @else
                                            <svg class="h-full w-full text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $workshop->title }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $workshop->starts_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                Rp {{ number_format($workshop->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $workshop->quota }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <x-button href="{{ route('panitia.workshops.edit', $workshop->id) }}" variant="secondary">
                                        Ubah
                                    </x-button>
                                    <form method="POST" action="{{ route('panitia.workshops.destroy', $workshop->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger">Hapus</x-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-empty-state title="Belum ada workshop" description="Tambahkan workshop pertama kamu.">
            <x-button href="{{ route('panitia.workshops.create') }}">Tambah Workshop</x-button>
        </x-empty-state>
    @endif
</x-app-layout>
