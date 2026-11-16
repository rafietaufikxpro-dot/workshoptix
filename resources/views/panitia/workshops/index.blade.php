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
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $workshop->title }}</td>
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
