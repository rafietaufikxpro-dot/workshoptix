# WorkshopTIX

Pendaftaran dan tiket digital workshop IT.
LKPD Drill Pra-Sertifikasi · Kelas XI RPL · SMK PESAT

| | |
|---|---|
| Kelompok | Individu |
| Maintainer | `<nama kamu>` |
| Anggota | `<nama kamu>` |
| Tautan repo | `<url repo>` |

## Cara menjalankan

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
```

Isi `.env`:

```ini
DB_DATABASE=workshoptix
DB_USERNAME=root
DB_PASSWORD=
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
MIDTRANS_SERVER_KEY=<Server Key Sandbox>
MIDTRANS_CLIENT_KEY=<Client Key Sandbox>
MIDTRANS_IS_PRODUCTION=false
```

```bash
php artisan migrate --seed
npm run dev            # terminal 1
php artisan serve      # terminal 2
```

Buka `http://localhost:8000`.

> Catatan lokal (Laragon): di laptop ini port MySQL dipakai `3520` karena port
> 3306/3307 diblokir Windows (excluded TCP port range). Di komputer lain,
> `DB_PORT=3306` (default Laragon) sudah benar. Server Key **hanya** dipakai
> di backend lewat `config/services.php`; Client Key yang dipakai di Snap.

## Akun uji

| Peran | Email | Password |
|---|---|---|
| Panitia | `panitia@workshoptix.test` | `password` |
| Peserta | `peserta1@workshoptix.test` … `peserta8@workshoptix.test` | `password` |

## Fitur

- Autentikasi Breeze dengan peran `panitia` dan `peserta` (role peserta dari server).
- Katalog dan detail workshop, pendaftaran (tanpa ganda, kuota, workshop belum mulai).
- Pembayaran Midtrans Sandbox: Snap token dari server, `gross_amount` dari `registrations.amount`.
- Cek status lewat backend (mapping status Midtrans), tiket digital dengan kode unik.
- CRUD workshop untuk panitia, blokir hapus workshop yang sudah punya pendaftar.
- Dashboard panitia dan daftar pendaftar (eager loading).

## Struktur penting

- `app/Models`: `User`, `Workshop`, `Registration` (+ relasi dan kuota).
- `app/Http/Controllers/Panitia`: `WorkshopController`, `RegistrationController`, `DashboardController`.
- `app/Http/Controllers`: `WorkshopController`, `RegistrationController`, `PaymentController`, `TicketController`.
- `app/Http/Requests`: `WorkshopRequest`, `RegistrationRequest`.
- `app/Services/MidtransService.php`: Snap token + cek status + pemetaan status.
- `app/Policies/RegistrationPolicy.php`: peserta hanya membuka pendaftaran/tiket miliknya.
- `app/Http/Middleware/EnsureRole.php`: alias middleware `role` (daftar di `bootstrap/app.php`).
- `resources/views`: `layouts`, `components`, `workshops`, `registrations`, `panitia`.
- `docs/`: `backlog.md`, `query-comparison.md`, `test-checklist.md`.

## Dokumentasi

- `PRD.md` — spesifikasi (FR-xx, T-xx).
- `AGENTS.md` — panduan kerja.
- `docs/backlog.md` — status item backlog.
- `docs/query-comparison.md` — perbandingan query lazy vs eager.
- `docs/test-checklist.md` — checklist skenario uji T-01 s.d. T-13.
