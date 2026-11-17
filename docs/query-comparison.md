# Perbandingan Query N+1 — Daftar Pendaftar Panitia

Halaman: `GET /panitia/registrations` (`panitia.registrations.index`).
Data: seeder, **22 registrasi** dengan relasi `user` dan `workshop` yang berbeda-beda.

## Sebelum (lazy loading)

Kode:

```php
// app/Http/Controllers/Panitia/RegistrationController.php
$pendaftar = Registration::all();
```

Blade mengakses `$registration->user->name` dan `$registration->workshop->title`
untuk tiap baris, sehingga relasi di-query satu per satu.

Pengukuran (tinker):

```php
DB::enableQueryLog();
$regs = App\Models\Registration::all();
foreach ($regs as $r) { $r->user->name; $r->workshop->title; }
echo count(DB::getQueryLog());
```

Hasil: **45 query** (1 query registrasi + 22 query user + 22 query workshop).

## Sesudah (eager loading)

Kode:

```php
// app/Http/Controllers/Panitia/RegistrationController.php
$pendaftar = Registration::with(['user', 'workshop'])->get();
```

Pengukuran (tinker):

```php
DB::enableQueryLog();
$regs = App\Models\Registration::with(['user','workshop'])->get();
foreach ($regs as $r) { $r->user->name; $r->workshop->title; }
echo count(DB::getQueryLog());
```

Hasil: **3 query** — `registrations`, `users`, `workshops`.

## Ringkasan

| Versi | Query | Keterangan |
|---|---|---|
| Lazy | 45 | 1 + N + N (N = 22) |
| Eager | 3 | 1 registrasi + 1 user + 1 workshop |

Selisih: 42 query lebih sedikit, dan penurunannya akan semakin besar saat
jumlah pendaftar bertambah.

## Bukti

- Tangkapan layar halaman daftar pendaftar: _ditambahkan saat uji T-11._
- Riwayat commit: `perf/n-plus-one` (dua commit: lazy, lalu eager).

> Catatan: angka di atas diukur dengan data yang sama (22 registrasi) menggunakan
> `DB::enableQueryLog()` / `DB::getQueryLog()`.
