# AGENTS.md — WorkshopTIX

Panduan untuk AI coding agent (Claude Code, Copilot, Cursor, dll.) yang membantu siswa membangun **WorkshopTIX**: aplikasi Laravel untuk pendaftaran dan tiket digital workshop IT. Baca file ini sebelum mengubah apa pun. Spesifikasi lengkap ada di `PRD.md` (ID `FR-xx` dan `T-xx` merujuk ke sana).

> Untuk Claude Code, buat `CLAUDE.md` berisi satu baris: `@AGENTS.md`.

---

## 1. Konteks

- Ini **tugas belajar** (LKPD Drill Pra-Sertifikasi, XI RPL, SMK PESAT), dikerjakan **sendiri** (projek dari guru); kamu sekaligus maintainer. Penggunaan agent AI **diperbolehkan**, dan ada waktu kerja di luar kelas.
- Siswa harus **memahami dan bisa menjelaskan** kode yang mereka kumpulkan saat demo. Tujuan utama adalah belajar, bukan sekadar aplikasi jadi.
- Alur inti: `login → pilih workshop → daftar → bayar (Midtrans Sandbox) → cek status → buka tiket`.
- Peran: `panitia` (kelola workshop, lihat pendaftar, tidak mendaftar) dan `peserta` (daftar, bayar, tiket sendiri).

## 2. Cara bekerja dengan siswa

1. **Jelaskan, jangan hanya menulis.** Tiap perubahan disertai penjelasan singkat (Bahasa Indonesia): apa, kenapa, bagian Laravel mana.
2. **Bertahap.** Satu fitur kecil per langkah, jangan membuat seluruh aplikasi sekaligus.
3. **Tanya bila ambigu** atau bertentangan dengan `PRD.md`; jangan menebak.
4. **Tetap di cakupan branch/item backlog yang sedang dikerjakan** (PRD bagian 9). Satu PR = satu fitur; jangan mengubah area lain yang tidak terkait.
5. **Dorong siswa menulis sendiri** bagian inti (policy, validasi). Beri petunjuk dan contoh kecil, lalu tinjau hasilnya.
6. Penjelasan dalam Bahasa Indonesia; **nama kode** (class, method, tabel, kolom) dalam bahasa Inggris.

## 3. Tech stack

| Bagian | Pilihan |
|---|---|
| Framework | **Laravel 13**, PHP ≥ 8.3 (Laravel 12 + PHP 8.2 bila lab belum PHP 8.3). Ikuti `composer.json`; jangan ganti versi mayor tanpa persetujuan maintainer. |
| Database | MySQL |
| Auth + tampilan | **Laravel Breeze (stack Blade)** + **Tailwind CSS**. Pasang manual: `composer require laravel/breeze --dev` lalu `php artisan breeze:install blade` |
| Pembayaran | Midtrans **Sandbox**, SDK `midtrans/midtrans-php` |
| Uji | Manual (checklist + tangkapan layar). Tes otomatis opsional. |

## 4. Perintah umum

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
# .env: DB_*, MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY, MIDTRANS_IS_PRODUCTION=false,
#       APP_TIMEZONE=Asia/Jakarta, APP_LOCALE=id
php artisan migrate --seed
npm run dev            # terminal 1
php artisan serve      # terminal 2

php artisan route:list
php artisan migrate:fresh --seed   # hanya lokal!
./vendor/bin/pint                  # format kode (jika ada)
```

## 5. Struktur dan konvensi

```
app/
  Http/Controllers/          # tipis: validasi → service/model → view
    Panitia/
  Http/Middleware/EnsureRole.php   # alias `role` didaftarkan di bootstrap/app.php
  Models/                    # User, Workshop, Registration
  Policies/RegistrationPolicy.php
  Services/MidtransService.php
database/migrations, seeders, factories
resources/views/
  layouts/, components/      # workshop-card, status-badge, button, alert, ticket-card
  workshops/, registrations/, panitia/
routes/web.php, routes/panitia.php, routes/payment.php
docs/backlog.md, docs/query-comparison.md
```

- PSR-12, gaya Laravel. Model tunggal, tabel jamak, controller `WorkshopController`.
- Controller **tipis**. Logika Midtrans di `MidtransService`, bukan di controller/Blade.
- Validasi lewat Form Request atau `$request->validate()`; jangan percaya input klien.
- Akses data lewat Eloquent dan relasi di model.
- Blade hanya menampilkan data. Pesan validasi/flash dalam Bahasa Indonesia.

## 6. Bangun tampilan (Langkah 02)

Sesuai LKPD: *buat layout Blade dan styling konsisten; hubungkan halaman daftar workshop, detail, pendaftaran, status pembayaran, tiket, dan dashboard panitia; uji navigasi dengan data dummy sebelum menyambungkan database.*

### Urutan kerja
1. Layout induk. 2. Komponen bersama. 3. Halaman satu per satu dengan **data dummy**. 4. Uji navigasi (T-12). 5. Baru sambungkan ke database (Langkah 03).

### Halaman (rinci di PRD 8.1)
`login`/`register`, `workshops.index`, `workshops.show`, `registrations.index`, `registrations.show` (status pendaftaran), `registrations.ticket`, `panitia.dashboard`, `panitia.workshops.*`, `panitia.registrations.index`. **Tidak ada** halaman konfirmasi pendaftaran: tombol Daftar langsung POST lalu redirect ke status pendaftaran.

### Aturan tampilan
- **Satu layout induk**; jangan salin-tempel navbar/kerangka HTML ke tiap view.
- **Gaya modern dan minimalis dengan Tailwind**: ruang kosong lega; dasar `bg-white`/`bg-gray-50`, teks `text-gray-900`/`text-gray-600`; **satu warna aksen** (mis. `indigo-600`); `rounded-xl`, border tipis atau `shadow-sm`; tanpa gradasi dan animasi mencolok (cukup `transition` halus); satu font sans-serif; ikon sederhana (Heroicons). Hindari `style=""` inline.
- **Komponen Blade** untuk bagian berulang.
- **Badge status** seragam dan lembut: `pending` kuning, `paid` hijau, `failed` merah, `expired` abu-abu (mis. `bg-green-100 text-green-800`).
- **Named route** untuk semua tautan (`route('workshops.show', $workshop)`); navbar menurut peran (PRD 8.2).
- **Responsif**: grid 1 kolom di HP, 2–3 kolom di layar besar. Sediakan *empty state* dan pesan sukses/error.
- `@auth`/`@can` boleh untuk menyembunyikan tombol, tetapi **keamanan tetap dicek di server**.

### Aturan data dummy
- Bentuk **sama dengan kolom database** (`starts_at` Carbon, `price` integer > 0) agar view tidak berubah saat memakai database.
- Satu tempat, tandai `// DUMMY — hapus di Langkah 03`. Jangan membuat query/migration hanya demi tampilan.
- Saat pindah ke database, ganti **sumber** data, bukan struktur view.

## 7. Aturan domain (jangan dilanggar)

### Otorisasi
- Rute panitia: `auth` + `role:panitia`. Semua halaman workshop/pendaftaran: `auth` (tamu → login).
- Peserta hanya boleh membuka pendaftaran dan tiket **miliknya** lewat **Policy**; selain itu **403**.
- Panitia tidak boleh mendaftar workshop (server menolak, tombol disembunyikan).
- Setelah login: peserta → `workshops.index`, panitia → `panitia.dashboard`. `role` **tidak** boleh diisi dari input register. Nonaktifkan fitur "hapus akun" bawaan Breeze.

### Workshop dan pendaftaran
- Validasi workshop: semua wajib, **harga ≥ 1**, kuota ≥ 1, selesai setelah mulai.
- Workshop yang sudah punya pendaftaran **tidak boleh dihapus** (cek di controller + FK restrict).
- Satu pendaftaran per `(user_id, workshop_id)`: validasi **dan** `unique` di migration.
- Tolak jika kuota penuh atau workshop sudah dimulai. Kuota terpakai = `paid` + `pending` yang dibuat < 24 jam lalu.
- Saat daftar: `amount` disalin dari `workshops.price`, status `pending`, redirect ke `registrations.show`.

### Pembayaran (Midtrans Sandbox)
- `gross_amount` **selalu** dari `registrations.amount` di server, tidak pernah dari klien.
- Tombol Bayar (`registrations.pay`): bila `pending` dan `snap_token` ada → pakai ulang; bila `failed`/`expired` atau belum ada → buat `order_id` baru (`WTX-{id}-{timestamp}`) dan `snap_token` baru. Kirim token ke halaman status (flash) lalu panggil `snap.pay(token)`.
- Status berubah **hanya** lewat **Cek Status**: backend memanggil Transaction Status Midtrans. Bungkus dengan `try/catch`; error/404 → tetap `pending` + pesan, **bukan 500**.
- Pemetaan: `settlement` atau `capture`+`fraud_status=accept` → `paid`; `capture`+`challenge`, `pending` → `pending`; `deny`/`cancel`/`failure` → `failed`; `expire` → `expired`.
- Saat menjadi `paid`: isi `paid_at` dan `ticket_code` unik (`WTX-` + 8 karakter acak) **sekali saja**; jangan ditimpa saat dicek ulang.
- Hanya Sandbox (`isProduction = false`). Simulasi bayar lewat simulator/metode uji resmi Midtrans; **dilarang** membuat tombol "anggap lunas".

### Tiket
- Hanya jika `payment_status = paid` **dan** pemilik. Belum lunas → redirect ke `registrations.show` dengan pesan.
- Isi: kode tiket, nama peserta, nama workshop, jadwal (zona Asia/Jakarta).

### Performa query (N+1)
- **Wajib dua tahap, dua commit terpisah:**
  1. Versi lazy loading (`Registration::all()` + `$r->user->name`). Ukur jumlah query, catat di `docs/query-comparison.md`.
  2. Versi eager: `Registration::with(['user','workshop'])`. Ukur ulang dengan data yang sama.
- **Jangan langsung menulis versi eager** sebelum angka "sebelum" tercatat.

## 8. Keamanan — wajib

- **Jangan pernah** commit `.env`, Server Key, Client Key, atau kredensial. `.env` ada di `.gitignore`; hanya `.env.example` (nilai kosong) yang di-commit.
- Server Key hanya dibaca lewat `config/services.php` dari `.env`; tidak di kode atau view. Client Key boleh di front-end (Snap), Server Key **tidak**.
- Semua form pakai `@csrf`; gunakan `$fillable`.
- Jangan menjalankan perintah destruktif (`migrate:fresh`, `db:wipe`, `git push --force`, `rm -rf`) kecuali diminta jelas dan hanya di lokal.

## 9. Alur Git (solo, tetap sesuai LKPD)

- **Jangan push langsung ke `main`.** Satu-satunya pengecualian: **commit awal** setup repo (item 1 backlog).
- **Satu fitur = satu branch = satu PR**, sesuai backlog (PRD 9.1): `feat/ui-layout`, `feat/ui-pages-dummy`, `feat/auth-role`, `feat/workshop-crud`, `feat/registration`, `feat/midtrans-ticket`, `perf/n-plus-one`, `docs/evidence`.
- Commit kecil dan bermakna: `feat: tambah validasi pendaftaran ganda`, `fix: ...`, `docs: ...`, `perf: ...`.
- Sebelum PR: `git pull origin main` dan uji manual fitur.
- PR ke `main` berisi: apa yang dibuat, cara menguji, tangkapan layar.
- **Sebelum merge, tinjau diff di GitHub bersama siswa**: cek tidak ada rahasia/kode sisa dan pastikan siswa paham tiap bagian. Agent tidak boleh merge atas nama siswa.
- Setelah merge: `git pull` di `main` sebelum membuat branch berikutnya.
- Branch `perf/n-plus-one` harus punya **dua commit terpisah** (lazy, lalu eager).

## 10. Definition of Done (per fitur)

- [ ] Sesuai `PRD.md` (cek ID FR).
- [ ] Tampilan memakai layout induk dan komponen yang ada, rapi di layar HP.
- [ ] Validasi dan pesan error tampil benar.
- [ ] Otorisasi dicek di server.
- [ ] Skenario uji terkait di PRD bagian 10 lolos (bukti: checklist/tangkapan layar). Tes otomatis opsional (mock Midtrans bila dipakai).
- [ ] Tidak ada rahasia di commit; `.env.example` dan README diperbarui bila perlu.
- [ ] Siswa dapat menjelaskan kode yang dibuat.

## 11. Skenario uji (ringkas; lengkap di PRD bagian 10)

T-01 alur sukses · T-02 daftar ganda ditolak · T-03 tiket orang lain 403 · T-04 tiket belum lunas → redirect + pesan · T-05 peserta ke `/panitia/*` 403 · T-06 tamu → login · T-07 nominal tak bisa diubah klien · T-08 validasi workshop (harga 0 ditolak) · T-09 hapus workshop ber-pendaftar ditolak · T-10 Cek Status sebelum bayar tidak error, bayar ulang pakai `order_id` baru · T-11 jumlah query turun · T-12 navigasi dummy tanpa 404/500 · T-13 responsif.

## 12. Yang sebaiknya TIDAK dilakukan agent

- Menulis seluruh proyek sekaligus tanpa penjelasan.
- Menambah fitur di luar `PRD.md` (keranjang, refund, email, webhook, QR, workshop gratis) tanpa persetujuan.
- Menambah paket besar tanpa alasan dan persetujuan tim.
- Mengedit migration lama yang sudah di-merge (buat migration baru).
- Mencampur banyak fitur dalam satu branch/PR.
- Menyembunyikan error; jelaskan penyebab dan solusinya.

## 13. Bila ragu

Tanya siswa, atau rujuk `PRD.md` bagian 15. Hal yang masih menunggu guru: rubrik penilaian.
