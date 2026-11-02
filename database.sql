-- =====================================================================
-- Database Praktikum UTS ERP (PL/4008) - Politeknik META Industri
-- Menyimpan riwayat simulasi Praktikum 4 (modul keuangan)
-- dan Praktikum 5 (SCM dan pembelian).
--
-- Catatan hosting: di cPanel database biasanya dibuat lewat menu
-- "MySQL Databases" (nama berawalan akun). Jika begitu, lewati dua
-- baris CREATE DATABASE dan USE di bawah, pilih database di phpMyAdmin,
-- lalu jalankan mulai dari CREATE TABLE.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS erp_praktikum
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE erp_praktikum;

-- Satu tabel dipakai untuk kedua jenis simulasi, dibedakan kolom jenis.
CREATE TABLE IF NOT EXISTS simulasi (
  id        INT AUTO_INCREMENT PRIMARY KEY,          -- nomor urut simulasi
  jenis     VARCHAR(20)  NOT NULL,                   -- 'jurnal' (Praktikum 4) atau 'material' (Praktikum 5)
  nama      VARCHAR(100) NULL,                       -- nama pengguna yang menjalankan (opsional)
  ringkasan VARCHAR(255) NULL,                       -- ringkasan hasil untuk tabel riwayat
  data      TEXT         NOT NULL,                   -- rincian simulasi dalam format JSON
  dibuat    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP, -- waktu simpan
  INDEX (jenis)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Contoh data 1: Praktikum 4
-- Saldo awal kas Rp30.000.000, lima transaksi sesuai soal, lalu pengujian
-- kesalahan (pembayaran Rp3.000.000 tercatat dua kali) dan koreksi
-- dengan jurnal pembalik tanpa menghapus jejak audit.
-- Saldo akhir: kas 30.500.000; piutang 7.000.000; utang 5.000.000;
-- penjualan 12.000.000; beban operasional 1.500.000.
-- ---------------------------------------------------------------------
INSERT INTO simulasi (jenis, nama, ringkasan, data, dibuat) VALUES (
  'jurnal',
  'Contoh',
  'Kas Rp30.500.000, utang Rp5.000.000, 7 jurnal, ada koreksi',
  '{"jurnal":[
    "1. Beli bahan kredit: Dr Persediaan / Cr Utang usaha Rp8.000.000",
    "2. Bayar utang pemasok: Dr Utang usaha / Cr Kas Rp3.000.000",
    "3. Jual kredit: Dr Piutang usaha / Cr Penjualan Rp12.000.000",
    "4. Terima piutang: Dr Kas / Cr Piutang usaha Rp5.000.000",
    "5. Bayar listrik/operasional: Dr Beban operasional / Cr Kas Rp1.500.000",
    "GANDA (duplikat transaksi 2): Dr Utang usaha / Cr Kas Rp3.000.000",
    "KOREKSI (pembalik duplikat, tidak menghapus jejak): Dr Kas / Cr Utang usaha Rp3.000.000"
  ],
  "saldo":{"Kas":30500000,"Piutang usaha":7000000,"Persediaan":8000000,"Utang usaha":-5000000,"Penjualan":-12000000,"Beban operasional":1500000,"Modal":-30000000}}',
  '2026-11-02 09:00:00'
);

-- ---------------------------------------------------------------------
-- Contoh data 2: Praktikum 5
-- Produksi 300 unit, selesai dalam 6 hari kerja.
-- BOM: bahan A 3 unit, bahan B 2 unit per produk.
-- Stok A 400 (PO belum diterima 100, lead time 4 hari),
-- stok B 250 (PO 0, lead time 7 hari).
-- Kebutuhan bersih: A = 900-400-100 = 400; B = 600-250-0 = 350.
-- B (7 hari) melewati batas 6 hari, sehingga hanya 125 unit
-- (250 / 2) yang dapat selesai tepat waktu.
-- ---------------------------------------------------------------------
INSERT INTO simulasi (jenis, nama, ringkasan, data, dibuat) VALUES (
  'material',
  'Contoh',
  'Hanya 125 unit yang bisa selesai dalam 6 hari dari stok dan PO yang ada; sisa 175 unit menunggu bahan datang.',
  '{"input":{"q":300,"hr":6,"ba":3,"sa":400,"pa":100,"la":4,"bb":2,"sb":250,"pb":0,"lb":7},
  "hasil":"Bahan A: bruto 900 − stok 400 − PO 100 = kebutuhan bersih 400; lead time 4 hari ≤ 6 hari, tepat waktu\\nBahan B: bruto 600 − stok 250 − PO 0 = kebutuhan bersih 350; lead time 7 hari > 6 hari, terlambat 1 hari\\nHanya 125 unit yang bisa selesai dalam 6 hari dari stok dan PO yang ada; sisa 175 unit menunggu bahan datang."}',
  '2026-11-02 09:05:00'
);
