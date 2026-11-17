<x-app-layout>
    <x-slot name="title">WorkshopTIX — Pendaftaran &amp; Tiket Digital Workshop IT</x-slot>

    <!-- Hero (Decide/Learn surface: teks + ringkasan katalog nyata) -->
    <section class="-mx-4 -mt-8 border-b border-gray-200 bg-white">
        <div class="px-4 py-14 sm:py-20">
            <div class="grid items-center gap-12 lg:grid-cols-[1.05fr_0.95fr]">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
                        Workshop IT &middot; SMK Pesat
                    </span>

                    <h1 class="mt-6 text-4xl font-semibold leading-[1.08] tracking-tight text-gray-900 sm:text-5xl">
                        Daftar workshop IT, langsung dapat tiket digital.
                    </h1>

                    <p class="mt-5 max-w-xl text-base leading-relaxed text-gray-600 sm:text-lg">
                        Pilih workshop, daftar sekali, bayar lewat Midtrans Sandbox.
                        Tiketmu terbit begitu pembayaran lunas.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <x-button href="{{ route('workshops.index') }}" class="px-5 py-2.5">Lihat Workshop</x-button>
                        <x-button href="{{ route('register') }}" variant="secondary" class="px-5 py-2.5">Daftar Sekarang</x-button>
                    </div>

                    <dl class="mt-10 grid max-w-md grid-cols-3 gap-6 border-t border-gray-200 pt-6">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Workshop</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $workshopCount }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Peserta</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $pesertaCount }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">Tiket</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $tiketCount }}</dd>
                        </div>
                    </dl>
                </div>

                <aside class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="font-semibold text-gray-900">Workshop terdekat</h2>
                        <span class="text-xs text-gray-500">{{ $workshopCount }} terdaftar</span>
                    </div>

                    <ul class="mt-5 space-y-4">
                        @foreach ($workshops->take(3) as $workshop)
                            <li class="flex items-center gap-3">
                                <div class="flex h-11 w-11 shrink-0 flex-col items-center justify-center rounded-lg bg-indigo-50 text-indigo-700">
                                    <span class="text-[10px] font-medium uppercase leading-none">{{ $workshop->starts_at->format('M') }}</span>
                                    <span class="mt-0.5 text-sm font-semibold leading-none">{{ $workshop->starts_at->format('d') }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-gray-900">{{ $workshop->title }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500">
                                        {{ $workshop->venue }} &middot; sisa {{ $workshop->seats_left }} kursi
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <x-button href="{{ route('workshops.index') }}" variant="secondary" class="mt-6 w-full">
                        Lihat semua workshop
                    </x-button>
                </aside>
            </div>
        </div>
    </section>

    <!-- Workshop unggulan -->
    <section class="border-t border-gray-200 bg-white py-16 sm:py-20">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-indigo-600">Katalog</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">Workshop yang sedang dibuka</h2>
                <p class="mt-1 text-sm text-gray-500">Tiga dari {{ $workshopCount }} workshop terdaftar.</p>
            </div>
            <x-button href="{{ route('workshops.index') }}" variant="secondary">Semua Workshop</x-button>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($workshops->take(3) as $workshop)
                <x-workshop-card :workshop="$workshop" />
            @endforeach
        </div>
    </section>

    <!-- Langkah: urutan berantai, bukan tile equal -->
    <section class="py-16 sm:py-20">
        <div class="max-w-2xl">
            <p class="text-sm font-semibold text-indigo-600">Cara kerjanya</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">Empat langkah, satu tiket.</h2>
        </div>

        <ol class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <li class="border-t-2 border-gray-200 pt-5">
                <span class="text-3xl font-semibold text-indigo-600">01</span>
                <h3 class="mt-3 font-semibold text-gray-900">Pilih workshop</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Lihat jadwal, pemateri, harga, dan sisa kuota.</p>
            </li>
            <li class="border-t-2 border-gray-200 pt-5">
                <span class="text-3xl font-semibold text-indigo-600">02</span>
                <h3 class="mt-3 font-semibold text-gray-900">Daftar</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Satu akun hanya bisa mendaftar sekali per workshop.</p>
            </li>
            <li class="border-t-2 border-gray-200 pt-5">
                <span class="text-3xl font-semibold text-indigo-600">03</span>
                <h3 class="mt-3 font-semibold text-gray-900">Bayar Sandbox</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Nominal diambil dari server, bukan dari input klien.</p>
            </li>
            <li class="border-t-2 border-gray-200 pt-5">
                <span class="text-3xl font-semibold text-indigo-600">04</span>
                <h3 class="mt-3 font-semibold text-gray-900">Tiket digital</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Setelah lunas, tiket dengan kode unik siap dipakai.</p>
            </li>
        </ol>
    </section>

    <!-- CTA -->
    <section class="py-16 sm:py-20">
        <div class="rounded-2xl bg-indigo-600 px-6 py-14 text-center sm:px-12 sm:py-20">
            <h2 class="mx-auto max-w-xl text-2xl font-semibold tracking-tight text-white sm:text-4xl">
                Siap ikut workshop berikutnya?
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-indigo-100 sm:text-base">
                Buat akun sebagai peserta, pilih workshop, dan amankan kursimu.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <x-button href="{{ route('register') }}" class="px-5 py-2.5">Buat Akun</x-button>
                <x-button href="{{ route('login') }}" variant="secondary" class="px-5 py-2.5">Masuk</x-button>
            </div>
        </div>
    </section>
</x-app-layout>
