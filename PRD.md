# PRD — WorkshopTIX

**Pendaftaran dan Tiket Digital Workshop IT**
LKPD Drill Pra-Sertifikasi · Kelas XI RPL · SMK PESAT

| | |
|---|---|
| Versi | 2.0 |
| Format kerja | **Individu** (projek dari guru), 1 repo; kamu sekaligus maintainer |
| Alokasi waktu | 1–2 pertemuan di kelas + waktu kerja di luar kelas |
| Letak file | `PRD.md` dan `AGENTS.md` di root repo |

---

## 1. Ringkasan dan tujuan

Panitia sekolah membuka beberapa workshop IT berbayar. WorkshopTIX adalah aplikasi Laravel agar **peserta** dapat memilih workshop, mendaftar, membayar (Midtrans Sandbox), dan melihat **tiket digital** setelah pembayaran terverifikasi. **Panitia** mengelola workshop dan melihat pendaftar.

**Kompetensi yang dilatih:** kolaborasi Git (branch, PR, maintainer), backlog dan skema data, Blade + Tailwind, MVC Laravel + MySQL, autentikasi, middleware, otorisasi, validasi, integrasi payment gateway, optimasi query (N+1), pengujian dan demo.

## 2. Ruang lingkup

**Termasuk:** register/login/logout; peran panitia dan peserta; CRUD workshop; daftar dan detail workshop; pendaftaran (tanpa ganda); pembayaran Midtrans Sandbox dengan nominal dari server; cek status via backend; tiket digital setelah lunas; dashboard panitia dan daftar pendaftar; perbandingan query sebelum/sesudah eager loading; layout Blade + styling konsisten yang diuji dengan data dummy dulu.

**Tidak termasuk:** pembayaran production, refund, voucher, workshop gratis, email/WhatsApp, QR/scan check-in, keranjang, webhook Midtrans, deploy publik.

## 3. Pengguna

| Peran | Hak akses |
|---|---|
| **Tamu** | Hanya halaman login dan register. Halaman lain mengarah ke login. |
| **Peserta** | Lihat workshop, daftar, bayar, cek status, buka tiket **miliknya sendiri**. |
| **Panitia** | CRUD workshop, lihat semua pendaftar, dashboard. **Tidak** mendaftar workshop. |

## 4. Alur utama (sesuai LKPD)

```
Login → Pilih workshop → Daftar → Bayar di Sandbox → Cek status → Buka tiket
```

Rinci: Detail workshop → tombol **Daftar** → halaman **status pendaftaran** (pending) → tombol **Bayar** (Snap) → **Cek Status** → jika lunas, tombol **Lihat Tiket**.

## 5. Kebutuhan fungsional

Prioritas: **P1** wajib (inti LKPD), **P2** disarankan, selebihnya jangan dikerjakan sebelum P1 selesai.

### A. Autentikasi dan otorisasi
| ID | Kebutuhan | P |
|---|---|---|
| FR-01 | Register (nama, email, password); `role` otomatis `peserta`, **tidak** diterima dari input. | P1 |
| FR-02 | Login dan logout. Setelah login: peserta → daftar workshop, panitia → dashboard panitia. | P1 |
| FR-03 | Akun panitia dibuat lewat seeder. | P1 |
| FR-04 | Middleware `auth` dan `role:panitia` untuk rute panitia. | P1 |
| FR-05 | Policy: peserta hanya membuka pendaftaran dan tiket **miliknya**; selain itu **403**. | P1 |
| FR-06 | Semua halaman workshop dan pendaftaran wajib login (tamu → login). | P1 |

### B. Workshop (panitia)
| ID | Kebutuhan | P |
|---|---|---|
| FR-07 | CRUD workshop. | P1 |
| FR-08 | Field: judul, deskripsi, pemateri, lokasi, jadwal mulai/selesai, harga, kuota. | P1 |
| FR-09 | Validasi: semua wajib; harga ≥ 1 (bilangan bulat, rupiah); kuota ≥ 1; selesai setelah mulai. | P1 |
| FR-10 | Workshop yang sudah punya pendaftaran **tidak bisa dihapus** (tampilkan pesan). | P1 |
| FR-11 | Panitia melihat daftar pendaftar (peserta, workshop, status, tanggal). | P1 |

### C. Katalog dan pendaftaran (peserta)
| ID | Kebutuhan | P |
|---|---|---|
| FR-12 | Daftar workshop: judul, jadwal, harga, sisa kuota. | P1 |
| FR-13 | Detail workshop dengan tombol **Daftar** (hanya untuk peserta). | P1 |
| FR-14 | Daftar membuat `registrations` berstatus `pending`; `amount` disalin dari harga workshop; redirect ke halaman status pendaftaran. | P1 |
| FR-15 | Pendaftaran ganda (peserta + workshop sama) **ditolak** dengan pesan jelas, lewat validasi **dan** unique di database. | P1 |
| FR-16 | Tolak jika kuota penuh atau workshop sudah dimulai. | P2 |
| FR-17 | Halaman "Pendaftaran Saya" dengan status tiap pendaftaran. | P1 |

### D. Pembayaran (Midtrans Sandbox)
| ID | Kebutuhan | P |
|---|---|---|
| FR-18 | Transaksi dibuat dari **server**; `gross_amount` dari `registrations.amount` (berasal dari database), **bukan** dari input klien. | P1 |
| FR-19 | `order_id` unik (format `WTX-{id}-{timestamp}`), dibuat saat tombol Bayar. Jika status `pending` dan `snap_token` ada, **pakai ulang** token. Jika `failed`/`expired`, buat `order_id` dan `snap_token` **baru**. | P1 |
| FR-20 | Status awal `pending`. | P1 |
| FR-21 | Peserta membayar lewat Snap di Sandbox. Simulasi bayar memakai simulator/metode uji resmi Midtrans, **tidak** dengan tombol "anggap lunas" buatan sendiri. | P1 |
| FR-22 | Tombol **Cek Status**: backend menanyakan status ke Midtrans lalu memperbarui `payment_status`. Jika Midtrans belum punya transaksi (error/404), status tetap `pending` dan tampil pesan "Selesaikan pembayaran dulu", **tanpa error 500**. | P1 |
| FR-23 | Pemetaan status Midtrans → aplikasi (bagian 7.3). | P1 |

### E. Tiket digital
| ID | Kebutuhan | P |
|---|---|---|
| FR-24 | Tiket hanya terbuka jika `payment_status = paid` **dan** pemiliknya. Belum lunas → redirect ke halaman status dengan pesan. | P1 |
| FR-25 | Tiket memuat: **kode tiket**, **nama peserta**, **nama workshop**, **jadwal**. | P1 |
| FR-26 | `ticket_code` unik (mis. `WTX-` + 8 karakter acak), dibuat **sekali** saat status menjadi `paid` (tidak ditimpa saat cek ulang). | P1 |

### F. Dashboard dan performa query
| ID | Kebutuhan | P |
|---|---|---|
| FR-27 | Dashboard panitia: jumlah workshop, jumlah pendaftar, jumlah lunas, plus tautan ke Kelola Workshop dan Daftar Pendaftar. | P1 |
| FR-28 | Daftar pendaftar menampilkan nama peserta dan nama workshop. | P1 |
| FR-29 | Buat versi **lazy loading dulu**, ukur jumlah query dan catat, lalu perbaiki dengan `with(['user','workshop'])` dan ukur ulang **dengan data yang sama**. | P1 |

### G. Tampilan dan navigasi (Langkah 02)
| ID | Kebutuhan | P |
|---|---|---|
| FR-30 | Satu **layout induk Blade** (navbar, konten, footer, tempat pesan sukses/error). | P1 |
| FR-31 | **Styling konsisten, modern, minimalis** dengan Tailwind CSS (lihat 8.3). | P1 |
| FR-32 | Halaman di peta 8.1 tersedia dan saling terhubung. | P1 |
| FR-33 | Navigasi memakai **named route**; menu navbar menyesuaikan peran. | P1 |
| FR-34 | Halaman dibangun dan **diuji dengan data dummy** sebelum disambungkan ke database. | P1 |
| FR-35 | Status pembayaran tampil sebagai **badge berwarna** yang sama di semua halaman. | P1 |
| FR-36 | Komponen Blade dipakai ulang (kartu workshop, badge status, tombol, alert, kartu tiket). | P2 |
| FR-37 | Responsif, nyaman di layar HP. | P2 |
| FR-38 | *Empty state* dan pesan sukses/error yang jelas. | P2 |

## 6. Kebutuhan non-fungsional

| ID | Kebutuhan |
|---|---|
| NFR-01 | Laravel (MVC), MySQL, Blade, Tailwind (lihat 7.5 untuk versi). |
| NFR-02 | Kunci Midtrans hanya di `.env`; `.env` tidak di-commit; sediakan `.env.example` tanpa rahasia. |
| NFR-03 | Form dilindungi CSRF dan divalidasi di server. |
| NFR-04 | Skema lewat migration; data contoh lewat seeder. |
| NFR-05 | Aplikasi dapat dijalankan orang lain hanya dengan mengikuti README. |
| NFR-06 | `APP_TIMEZONE=Asia/Jakarta` dan `APP_LOCALE=id` agar jadwal di tiket benar. |

## 7. Desain teknis

### 7.1 Skema database

**users**: `id`, `name`, `email` (unique), `password`, `role` enum(`panitia`,`peserta`) default `peserta`, timestamps.

**workshops**: `id`, `title`, `description`, `speaker`, `venue`, `starts_at`, `ends_at`, `price` (unsigned int, ≥ 1), `quota` (unsigned int), `created_by` → users, timestamps.

**registrations**: `id`, `user_id` → users, `workshop_id` → workshops (**restrict on delete**), `amount` (unsigned int), `order_id` (string, unique, nullable), `snap_token` (nullable), `payment_status` enum(`pending`,`paid`,`failed`,`expired`) default `pending`, `paid_at` (nullable), `ticket_code` (unique, nullable), timestamps. **Unique** (`user_id`,`workshop_id`).

### 7.2 Relasi
`User` hasMany `Registration`; `Workshop` hasMany `Registration`; `Registration` belongsTo `User` dan `Workshop`.

### 7.3 Pemetaan status Midtrans

| `transaction_status` | Status aplikasi |
|---|---|
| `settlement` | `paid` |
| `capture` + `fraud_status=accept` | `paid` |
| `capture` + `fraud_status=challenge` | `pending` |
| `pending` | `pending` |
| `deny`, `cancel`, `failure` | `failed` |
| `expire` | `expired` |
| Error/404 (transaksi belum ada) | tetap `pending` |

> Verifikasi perilaku ini sekali di dokumentasi Midtrans saat mengerjakan Langkah 04.

### 7.4 Aturan bisnis singkat
- **Kuota terpakai** = pendaftaran `paid` + `pending` yang dibuat < 24 jam lalu (pending lama tidak menahan kuota). Sisa kuota = `quota` − terpakai.
- **Bayar ulang:** satu pendaftaran per peserta per workshop. Bila `failed`/`expired`, peserta menekan Bayar lagi di pendaftaran yang sama (dapat `order_id` baru, FR-19).
- **Hapus workshop** diblokir jika ada pendaftaran (FR-10). Fitur "hapus akun" bawaan Breeze dinonaktifkan.
- **Workshop yang sudah dimulai** tidak bisa didaftari (FR-16).

### 7.5 Versi dan setup
- **Laravel 13** (butuh **PHP ≥ 8.3**). Jika lab hanya punya PHP 8.2, pakai Laravel 12. Cek ulang di laravel.com/docs.
- **Laravel Breeze (stack Blade)** untuk auth + Tailwind. Pada Laravel 13 Breeze tidak ditawarkan di `laravel new`; pasang manual: `composer require laravel/breeze --dev` lalu `php artisan breeze:install blade`.
- Alias middleware `role` didaftarkan di `bootstrap/app.php`.
- Redirect setelah login per peran: ubah di controller login Breeze dan rute `/dashboard` (arahkan sesuai peran).

### 7.6 Rute

| Method | URI | Nama | Akses |
|---|---|---|---|
| GET | `/` | | Redirect: tamu → login, lainnya sesuai peran |
| GET | `/workshops` | `workshops.index` | Login |
| GET | `/workshops/{workshop}` | `workshops.show` | Login |
| POST | `/workshops/{workshop}/register` | `workshops.register` | Peserta |
| GET | `/registrations` | `registrations.index` | Peserta |
| GET | `/registrations/{registration}` | `registrations.show` | Pemilik |
| POST | `/registrations/{registration}/pay` | `registrations.pay` | Pemilik, belum lunas |
| POST | `/registrations/{registration}/check-status` | `registrations.check` | Pemilik |
| GET | `/registrations/{registration}/ticket` | `registrations.ticket` | Pemilik, lunas |
| GET | `/panitia/dashboard` | `panitia.dashboard` | Panitia |
| resource | `/panitia/workshops` | `panitia.workshops.*` | Panitia |
| GET | `/panitia/registrations` | `panitia.registrations.index` | Panitia |

### 7.7 Struktur kode
`Controllers/` (tipis), `Controllers/Panitia/`, `Http/Middleware/EnsureRole.php`, `Policies/RegistrationPolicy.php`, `Services/MidtransService.php` (Snap token + cek status), `resources/views/{layouts,components,workshops,registrations,panitia}`. Route boleh dipisah per area agar rapi: `routes/web.php`, `routes/panitia.php`, `routes/payment.php`.

### 7.8 Data seeder
- 1 akun panitia, ≥ 8 peserta, 5 workshop (harga > 0).
- **≥ 20 pendaftaran** dengan kombinasi (user, workshop) **berbeda** (karena unique), status campur; yang `paid` punya `order_id` dan `ticket_code` unik.

## 8. Rancangan tampilan (Langkah 02)

**Prinsip:** bangun semua halaman dengan **data dummy** dulu, uji navigasi, baru sambungkan ke database (Langkah 03).

### 8.1 Peta halaman

| Halaman | Nama rute | Akses | Isi utama |
|---|---|---|---|
| Login / Register | `login`, `register` | Tamu | Form |
| Daftar workshop | `workshops.index` | Login | Kartu: judul, jadwal, harga, sisa kuota, tombol Detail |
| Detail workshop | `workshops.show` | Login | Deskripsi, pemateri, lokasi, jadwal, harga, kuota, tombol Daftar (peserta) |
| Pendaftaran saya | `registrations.index` | Peserta | Daftar: workshop, tanggal, badge status, aksi |
| Status pendaftaran | `registrations.show` | Pemilik | `order_id`, nominal, badge, tombol Bayar, Cek Status, Lihat Tiket (hanya lunas) |
| Tiket digital | `registrations.ticket` | Pemilik, lunas | Kode, nama peserta, workshop, jadwal |
| Dashboard panitia | `panitia.dashboard` | Panitia | 3 kartu ringkasan + tautan |
| Kelola workshop | `panitia.workshops.*` | Panitia | Tabel dan form tambah/ubah |
| Daftar pendaftar | `panitia.registrations.index` | Panitia | Tabel: peserta, workshop, status, tanggal |

### 8.2 Menu navbar

| Kondisi | Menu |
|---|---|
| Tamu | Logo, Masuk, Daftar |
| Peserta | Logo, Workshop, Pendaftaran Saya, nama pengguna, Keluar |
| Panitia | Logo, Dashboard, Kelola Workshop, Pendaftar, Keluar |

### 8.3 Gaya (modern dan minimalis, Tailwind)

| Aspek | Ketentuan |
|---|---|
| Gaya | Banyak ruang kosong, tanpa dekorasi berlebihan, fokus pada konten dan aksi utama |
| Warna | Dasar `white`/`gray-50`, teks `gray-900`/`gray-600`, **satu warna aksen** (mis. `indigo-600`) |
| Bentuk | `rounded-xl`, border tipis atau `shadow-sm`, tanpa gradasi dan animasi mencolok |
| Tipografi | Satu font sans-serif (Figtree bawaan Breeze atau Inter) |
| Badge status | Warna lembut: `pending` kuning, `paid` hijau, `failed` merah, `expired` abu-abu |
| Komponen | `x-workshop-card`, `x-status-badge`, `x-button`, `x-alert`, `x-ticket-card` |

### 8.4 Data dummy
Bentuk **sama dengan kolom database** agar view tidak berubah saat disambungkan. Tempatkan di satu tempat, tandai `// DUMMY — hapus di Langkah 03`.

```php
Route::get('/workshops', fn () => view('workshops.index', [
    'workshops' => collect([
        (object) ['id' => 1, 'title' => 'Dasar Laravel', 'speaker' => 'Bu Rina',
                  'venue' => 'Lab RPL', 'starts_at' => now()->addDays(7),
                  'price' => 50000, 'quota' => 30],
        (object) ['id' => 2, 'title' => 'Git untuk Tim', 'speaker' => 'Pak Dimas',
                  'venue' => 'Aula', 'starts_at' => now()->addDays(14),
                  'price' => 25000, 'quota' => 40],
    ]),
]))->name('workshops.index');
```

## 9. Backlog dan urutan kerja (individu)

LKPD Langkah 01 meminta backlog dan pembagian tugas. Karena dikerjakan sendiri, "pembagian tugas" menjadi **urutan kerja per branch**: satu fitur = satu branch = satu Pull Request. Kamu berperan sebagai maintainer sekaligus pengembang.

### 9.1 Backlog (salin ke `docs/backlog.md`)

| # | Item | Branch | Langkah | Status |
|---|---|---|---|---|
| 1 | Repo, Laravel 13, Breeze Blade, migration, model + relasi, `.env.example`, `.gitignore` | `main` (commit awal) | 01 | ☐ |
| 2 | Layout induk, navbar, komponen bersama, styling Tailwind | `feat/ui-layout` | 02 | ☐ |
| 3 | Semua halaman dengan **data dummy** + uji navigasi (T-12) | `feat/ui-pages-dummy` | 02 | ☐ |
| 4 | Seeder, middleware `role`, policy, redirect login per peran, nonaktifkan hapus akun | `feat/auth-role` | 03 | ☐ |
| 5 | CRUD workshop + validasi + blokir hapus; ganti dummy ke database | `feat/workshop-crud` | 03 | ☐ |
| 6 | Daftar/detail workshop (DB), pendaftaran, validasi ganda/kuota, Pendaftaran Saya, status pendaftaran | `feat/registration` | 03 | ☐ |
| 7 | `MidtransService`, tombol Bayar, Cek Status, pemetaan status, `ticket_code`, halaman tiket | `feat/midtrans-ticket` | 04 | ☐ |
| 8 | Dashboard panitia + daftar pendaftar: **lazy → catat → eager → catat** | `perf/n-plus-one` | 05 | ☐ |
| 9 | Uji semua skenario, bukti, README, latihan demo | `docs/evidence` | 06 | ☐ |

### 9.2 Alur Git (solo, tetap sesuai LKPD)
1. Maintainer (kamu) membuat repo dan **commit awal langsung ke `main`** (item 1). Setelah itu jangan push langsung ke `main`.
2. Setiap item berikutnya dikerjakan di branch sendiri, lalu dibuka **Pull Request** ke `main` berisi: apa yang dibuat, cara menguji, tangkapan layar.
3. Sebelum merge, **tinjau sendiri diff di GitHub** (cari rahasia yang ikut ter-commit, kode sisa, dan pastikan kamu paham tiap bagian). Jika memungkinkan, minta guru atau teman meninjau.
4. Merge, lalu `git pull` di `main` sebelum membuat branch berikutnya.
5. Item 8 harus punya **dua commit terpisah** (lazy, lalu eager) agar perbandingan terlihat di riwayat.

**Kamu harus bisa menjelaskan seluruh bagian aplikasi saat demo.**

## 10. Skenario uji (bukti: checklist + tangkapan layar)

| ID | Skenario | Hasil yang diharapkan |
|---|---|---|
| T-01 | login → pilih workshop → daftar → bayar Sandbox → cek status → buka tiket | `paid`; tiket tampil (kode, nama, workshop, jadwal) |
| T-02 | Daftar workshop yang sama dua kali | Ditolak dengan pesan, tidak ada record ganda |
| T-03 | Peserta A membuka tiket/pendaftaran milik B | **403** |
| T-04 | Buka tiket saat belum lunas | Redirect ke halaman status + pesan |
| T-05 | Peserta mengakses `/panitia/*` | **403** |
| T-06 | Tamu membuka halaman workshop | Redirect ke login |
| T-07 | Ubah nominal lewat inspect/request manual | Nominal tetap dari database |
| T-08 | Form workshop tidak valid (termasuk harga 0) | Error validasi, data tidak tersimpan |
| T-09 | Hapus workshop yang sudah punya pendaftar | Ditolak dengan pesan |
| T-10 | Cek Status sebelum membayar; lalu bayar ulang setelah `failed`/`expired` | Tidak error 500; tetap `pending`; pembayaran ulang memakai `order_id` baru |
| T-11 | Daftar pendaftar (≥ 20 data) sebelum/sesudah eager loading | Jumlah query turun; angka tercatat |
| T-12 | Navigasi dengan data dummy: buka semua halaman, klik semua menu/tombol | Tidak ada 404/500; menu sesuai peran |
| T-13 | Buka halaman di lebar HP dan desktop | Layout tidak pecah, gaya konsisten |

Tes otomatis (PHPUnit) bersifat **opsional**; bila dipakai, panggilan Midtrans harus di-*mock*.

## 11. Perbandingan query N+1

- Data: seeder ≥ 20 pendaftaran.
- Ukur dengan `DB::listen`/`DB::getQueryLog()` atau Debugbar.
- **Sebelum:** `Registration::all()` lalu `$r->user->name` dan `$r->workshop->title` di Blade (≈ 1 + N + N query). **Commit terpisah** dan catat angka.
- **Sesudah:** `Registration::with(['user','workshop'])->get()` (≈ 3 query). Commit terpisah.
- Hasil dicatat di `docs/query-comparison.md`: jumlah record, query sebelum, query sesudah, tangkapan layar.

## 12. Deliverables (Checkpoint)

- [ ] Tautan satu repo
- [ ] `README.md` dengan header isian LKPD (lihat template) dan cara menjalankan
- [ ] Backlog dan urutan kerja (`docs/backlog.md`)
- [ ] Pull Request per fitur (riwayat branch dan PR terlihat)
- [ ] Bukti uji T-01 s.d. T-13
- [ ] Bukti perbandingan query (`docs/query-comparison.md`)
- [ ] Tangkapan layar semua halaman utama

**Template README (minimal):**
```
# WorkshopTIX
Kelompok   : Individu          Maintainer : <nama kamu>
Anggota    : <nama kamu>       Tautan repo: <url repo>

## Cara menjalankan
composer install && npm install
cp .env.example .env && php artisan key:generate
# isi DB_* dan MIDTRANS_SERVER_KEY / MIDTRANS_CLIENT_KEY (Sandbox)
php artisan migrate --seed
npm run dev   (terminal 1)   |   php artisan serve   (terminal 2)

## Akun uji
panitia: ______ / ______     peserta: ______ / ______
```

## 13. Rencana waktu (1–2 pertemuan)

| Sesi | Fokus |
|---|---|
| **Sebelum pertemuan** | Pasang PHP 8.3+, Composer, Node, MySQL, Git; buat akun Midtrans Sandbox; siapkan repo dasar (item 1) |
| **Pertemuan 1** | Langkah 01 → 02 → 03 |
| **Pertemuan 2** | Langkah 04 → 05 → 06 |
| **Di luar kelas** | Lanjutkan/selesaikan Langkah 03–05, lengkapi item P2 (kuota, responsif, komponen, *empty state*), bukti uji, README, dan latihan demo |

Kerjakan **P1** dahulu, lalu P2 memakai waktu di luar kelas. Dengan waktu tambahan ini risiko kekurangan waktu jauh lebih kecil.

## 14. Risiko

| Risiko | Mitigasi |
|---|---|
| Waktu kurang | Prioritas P1; manfaatkan waktu di luar kelas; persiapan sebelum pertemuan |
| Lupa urutan / branch menumpuk | Ikuti backlog 9.1, satu branch satu fitur, PR kecil, `git pull` di `main` sebelum branch baru |
| Tidak paham kode bantuan AI | Minta penjelasan tiap perubahan, baca setiap diff sebelum merge, latih demo |
| Bocor Server Key | `.env` di `.gitignore`, hanya commit `.env.example` |
| Sandbox lambat/error | Siapkan tangkapan layar cadangan untuk demo |

## 15. Keputusan dan asumsi

Sudah diputuskan: Tailwind; gaya modern minimalis; Laravel 13 + Breeze Blade; daftar workshop wajib login; harga ≥ 1; tanpa halaman konfirmasi; satu pendaftaran per peserta per workshop dengan `order_id` baru tiap percobaan bayar; kuota seperti 7.4; tes otomatis opsional; dikerjakan **individu** (kamu = maintainer), satu branch + satu PR per fitur.

Sudah dikonfirmasi: penggunaan agent AI **diperbolehkan** dan **ada waktu kerja di luar kelas**.

Masih perlu konfirmasi guru: rubrik penilaian, dan apakah PR yang ditinjau sendiri (tanpa reviewer lain) dapat diterima.
