<x-app-layout>
    <x-slot name="title">Tambah Workshop</x-slot>
    <x-slot name="header">Tambah Workshop</x-slot>

    <div class="mx-auto max-w-2xl">
        <form method="POST" action="{{ route('panitia.workshops.store') }}" enctype="multipart/form-data" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            @csrf

            <div>
                <x-input-label for="title" value="Judul" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" value="Deskripsi" />
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="image" value="Foto Workshop" />
                <input id="image" name="image" type="file" accept="image/*"
                    class="mt-1 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                <p class="mt-1 text-xs text-gray-500">Opsional. JPG, PNG, atau WebP; maksimal 2 MB.</p>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <x-input-label for="speaker" value="Pemateri" />
                    <x-text-input id="speaker" name="speaker" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('speaker')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="venue" value="Lokasi" />
                    <x-text-input id="venue" name="venue" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('venue')" class="mt-2" />
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <x-input-label for="starts_at" value="Mulai" />
                    <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('starts_at')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="ends_at" value="Selesai" />
                    <x-text-input id="ends_at" name="ends_at" type="datetime-local" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('ends_at')" class="mt-2" />
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <x-input-label for="price" value="Harga (Rp)" />
                    <x-text-input id="price" name="price" type="number" min="1" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="quota" value="Kuota" />
                    <x-text-input id="quota" name="quota" type="number" min="1" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('quota')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-gray-100 pt-4">
                <x-button type="submit">Simpan</x-button>
                <x-button href="{{ route('panitia.workshops.index') }}" variant="secondary">Batal</x-button>
            </div>
        </form>
    </div>
</x-app-layout>
