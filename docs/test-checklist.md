# Checklist Skenario Uji (T-01 s.d. T-13)

Akun uji: `panitia@workshoptix.test` / `password`, `peserta1@workshoptix.test` / `password` (dan peserta2..8).

Bukti: checklist ini + tangkapan layar. Tandai status: `[x]` lolos, `[ ]` belum diuji.

## Alur utama

- [ ] **T-01** login → pilih workshop → daftar → bayar Sandbox → cek status → buka tiket.
  Hasil: status `paid`; tiket tampil (kode, nama, workshop, jadwal).
- [ ] **T-02** daftar workshop yang sama dua kali.
  Hasil: ditolak berpesan, tidak ada record ganda.
- [ ] **T-03** peserta A membuka tiket/pendaftaran milik B.
  Hasil: **403**.
- [ ] **T-04** buka tiket saat belum lunas.
  Hasil: redirect ke halaman status + pesan.
- [ ] **T-05** peserta mengakses `/panitia/*`.
  Hasil: **403**.
- [ ] **T-06** tamu membuka halaman workshop.
  Hasil: redirect ke login.
- [ ] **T-07** ubah nominal lewat inspect/request manual.
  Hasil: nominal tetap dari database.
- [ ] **T-08** form workshop tidak valid (termasuk harga 0).
  Hasil: error validasi, data tidak tersimpan.
- [ ] **T-09** hapus workshop yang sudah punya pendaftar.
  Hasil: ditolak berpesan.
- [ ] **T-10** Cek Status sebelum membayar; lalu bayar ulang setelah `failed`/`expired`.
  Hasil: tidak error 500; tetap `pending`; pembayaran ulang memakai `order_id` baru.
- [ ] **T-11** daftar pendaftar (≥ 20 data) sebelum/sesudah eager loading.
  Hasil: jumlah query turun (45 → 3), angka tercatat di `docs/query-comparison.md`.
- [ ] **T-12** navigasi dengan data dummy: buka semua halaman, klik semua menu/tombol.
  Hasil: tidak ada 404/500; menu sesuai peran.
- [ ] **T-13** buka halaman di lebar HP dan desktop.
  Hasil: layout tidak pecah, gaya konsisten.

## Yang sudah dibuktikan lewat pengujian otomatis/sekunder

- T-02 (validasi ganda ditolak: “Kamu sudah terdaftar di workshop ini.”) — diuji via tinker.
- T-08 (harga 0 ditolak: “Harga minimal Rp 1.”) — diuji via tinker.
- T-09 (hapus workshop ber-pendaftar ditolak; FK `restrict` bekerja) — diuji via tinker.
- T-11 (lazy 45 → eager 3 query) — diuji via `DB::getQueryLog()`.
- T-06 (tamu → `/login`) — diuji via HTTP.
- Pemetaan status Midtrans (9 kasus) — diuji via `MidtransService::mapStatus()`.
- T-10 sebagian: `checkStatus()` saat API error → tetap `pending` (bukan 500).

## Sisa yang perlu dikerjakan manual (butuh login + kunci Midtrans)

- T-01 alur bayar penuh (Snap Sandbox) dan tiket.
- T-03/T-04 akses lintas akun.
- T-05 akses panitia oleh peserta.
- T-07 manipulasi nominal.
- T-10 bayar ulang setelah `failed`/`expired`.
- T-12/T-13 navigasi dan tampilan HP/desktop + tangkapan layar.
