# Backlog WorkshopTIX

Satu fitur = satu branch = satu Pull Request ke `main`.

| # | Item | Branch | Langkah | Status |
|---|---|---|---|---|
| 1 | Repo, Laravel 13, Breeze Blade, migration, model + relasi, `.env.example`, `.gitignore` | `main` (commit awal) | 01 | Sebagian — kode selesai; repo + PR #1 dibuat; nama maintainer di README belum diisi |
| 2 | Layout induk, navbar, komponen bersama, styling Tailwind | `feat/ui-layout` | 02 | Selesai |
| 3 | Semua halaman dengan data dummy + uji navigasi (T-12) | `feat/ui-pages-dummy` | 02 | Selesai |
| 4 | Seeder, middleware `role`, policy, redirect login per peran, nonaktifkan hapus akun | `feat/auth-role` | 03 | Selesai |
| 5 | CRUD workshop + validasi + blokir hapus; ganti dummy ke database | `feat/workshop-crud` | 03 | Selesai |
| 6 | Daftar/detail workshop (DB), pendaftaran, validasi ganda/kuota, Pendaftaran Saya, status pendaftaran | `feat/registration` | 03 | Selesai |
| 7 | `MidtransService`, tombol Bayar, Cek Status, pemetaan status, `ticket_code`, halaman tiket | `feat/midtrans-ticket` | 04 | Selesai (perlu kunci Midtrans asli untuk uji bayar penuh) |
| 8 | Dashboard panitia + daftar pendaftar: lazy → catat → eager → catat | `perf/n-plus-one` | 05 | Selesai (45 → 3 query; `docs/query-comparison.md`) |
| 9 | Uji semua skenario, bukti, README, latihan demo | `docs/evidence` | 06 | Sebagian — README + checklist dibuat; bukti T-01 s.d. T-13 dikerjakan manual |

## Catatan

- Rute dummy untuk tampilan (ditandai `DUMMY — hapus di Langkah 03`) sudah
  digantikan controller untuk workshop, pendaftaran, pembayaran, dan tiket.
- Semua fitur dikerjakan di branch `feat/full-app` (bukan satu branch per item)
  dan dikumpulkan dalam PR #1; perbandingan query item 8 tercatat di
  `docs/query-comparison.md`.
- Landing page publik dipindah ke `/landing`; `/` mengarahkan tamu ke login dan
  pengguna login sesuai peran (PRD 7.6).
- Foto workshop (tambahan di luar PRD 7.1, disetujui maintainer): kolom `image`,
  unggah di form panitia, thumbnail di katalog/landing/detail/daftar panitia.
