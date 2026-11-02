<?php $judul = 'Praktikum 1'; $aktif = 1; require __DIR__ . '/header.php'; ?>
<section id="p1">
<h2>Praktikum 1. Menganalisis Evolusi dan Integrasi ERP</h2>
<p class="ind">Indikator: konsep dan evolusi sistem ERP</p>

<h3>1. Hubungan data yang belum terintegrasi</h3>
<div class="tw"><table>
<tr><th>Dari → ke</th><th>Data yang seharusnya mengalir</th><th>Kondisi sekarang → akibat</th></tr>
<tr><td>Penjualan → Gudang</td><td>Pesanan pelanggan, ketersediaan stok</td><td>Spreadsheet tidak mengecek stok → janji barang ada padahal kosong</td></tr>
<tr><td>Penjualan → Produksi</td><td>Jumlah dan tanggal pesanan</td><td>Dikirim manual → jadwal produksi sering berubah</td></tr>
<tr><td>Gudang ↔ Pembelian</td><td>Barang masuk dan stok</td><td>Aplikasi stok terpisah → stok berbeda dengan catatan pembelian</td></tr>
<tr><td>Produksi → Gudang</td><td>Pemakaian bahan baku</td><td>Formulir manual → stok tidak berkurang tepat waktu</td></tr>
<tr><td>Semua → Keuangan</td><td>Faktur, penerimaan barang, pembayaran</td><td>Aplikasi akuntansi berdiri sendiri → transaksi diinput ulang, laporan terlambat</td></tr>
</table></div>

<h3>2. Diagram proses sebelum ERP (silo)</h3>
<div class="flow"><b>Penjualan<small>Spreadsheet</small></b><b class="r">Pesan WA / formulir ke Produksi<small>manual, rawan lambat</small></b><b>Produksi<small>Formulir manual</small></b><b class="r">Minta bahan ke Gudang<small>stok tidak dicek otomatis</small></b><b>Gudang<small>Aplikasi stok</small></b><b class="r">Rekap kertas / file ke Keuangan<small>input ulang</small></b><b>Keuangan<small>Aplikasi akuntansi</small></b></div>
<p class="lg">Merah = titik rawan kesalahan atau keterlambatan. Setiap departemen memiliki database sendiri.</p>

<h3>3. Diagram rancangan proses setelah ERP</h3>
<div class="flow"><b>Sales Order diinput sekali<small>Penjualan</small></b><b class="g">Sistem cek stok real-time<small>Gudang</small></b><b class="d">Stok cukup?</b><b class="g">Ya: reservasi stok, kirim<small>Gudang</small></b><b class="g">Tidak: work order otomatis<small>Produksi</small></b><b class="g">Kebutuhan bahan (BOM) → permintaan beli<small>Pembelian</small></b><b class="g">Faktur & piutang terbentuk otomatis<small>Keuangan</small></b></div>
<p class="lg">Semua departemen memakai satu database. Data diinput sekali oleh pemilik prosesnya, departemen lain membaca hasilnya.</p>

<h3>4. Data master yang dipakai bersama</h3>
<div class="tw"><table>
<tr><th>Data master</th><th>Dipakai oleh</th></tr>
<tr><td>Pelanggan</td><td>Penjualan, Keuangan (piutang)</td></tr>
<tr><td>Produk jadi + harga jual</td><td>Penjualan, Produksi, Gudang</td></tr>
<tr><td>Bahan baku + satuan</td><td>Produksi, Gudang, Pembelian</td></tr>
<tr><td>Bill of Materials (BOM)</td><td>Produksi, Pembelian, Gudang</td></tr>
<tr><td>Gudang / lokasi stok</td><td>Gudang, Produksi, Penjualan</td></tr>
<tr><td>Pemasok</td><td>Pembelian, Keuangan (utang)</td></tr>
<tr><td>Chart of Accounts (daftar akun)</td><td>Keuangan, semua modul yang menghasilkan jurnal</td></tr>
<tr><td>Pengguna dan peran</td><td>Seluruh departemen (hak akses)</td></tr>
</table></div>

<h3>5. Simulasi satu transaksi pesanan pelanggan</h3>
<div class="box">Asumsi: PT Sinar memesan <b>100 unit</b> komponen @ Rp250.000 = <b>Rp25.000.000</b>. Stok jadi 40 unit. BOM per unit: 2 bahan A + 1 bahan B. Stok bahan A 100, B 80.</div>
<div class="tw"><table>
<tr><th>Langkah</th><th>Modul</th><th>Dampak</th></tr>
<tr><td>Sales Order diinput</td><td>Penjualan</td><td>Sistem cek stok jadi: 40 tersedia, <b>kurang 60 unit</b></td></tr>
<tr><td>Work order 60 unit</td><td>Produksi</td><td>Butuh A 120 dan B 60. Stok A 100 → <b>kurang 20 A</b>; B cukup (80)</td></tr>
<tr><td>Permintaan beli 20 A</td><td>Pembelian</td><td>PR otomatis ke pemasok, produksi menunggu bahan</td></tr>
<tr><td>Produksi selesai</td><td>Gudang</td><td>Bahan A dan B berkurang; stok jadi +60 lalu 100 unit dikirim, stok jadi menjadi 0</td></tr>
<tr><td>Surat jalan dan faktur</td><td>Keuangan</td><td>Dr Piutang usaha 25.000.000 / Cr Penjualan 25.000.000 otomatis</td></tr>
</table></div>

<h3>Tantangan individual</h3>
<div class="tw"><table>
<tr><th>Perubahan</th><th>Bagian terdampak</th><th>Perubahan pada sistem</th></tr>
<tr><td>Stok bahan baku tidak cukup</td><td>Produksi, Pembelian, Penjualan</td><td>Work order tertahan, PR otomatis, tanggal janji kirim dihitung ulang</td></tr>
<tr><td>Pelanggan ubah jumlah pesanan</td><td>Penjualan, Produksi, Keuangan</td><td>Revisi SO, reservasi stok dan work order disesuaikan, nilai piutang berubah</td></tr>
<tr><td>Pembayaran belum diterima</td><td>Keuangan, Penjualan</td><td>Piutang tetap terbuka, umur piutang dipantau, blokir pesanan baru bila melewati batas kredit</td></tr>
<tr><td>Produksi terlambat</td><td>Produksi, Penjualan, Gudang</td><td>Jadwal diperbarui, tanggal kirim di SO direvisi, pelanggan diberi tahu</td></tr>
</table></div>

<h3>Masalah yang ditemukan dan solusinya</h3>
<div class="box">Masalah: stok di gudang berbeda dengan catatan produksi karena dua pihak mencatat stok sendiri-sendiri. Solusi: satu data stok di database ERP; pemakaian bahan tercatat otomatis saat work order selesai (<i>backflush</i>), jadi selisih hanya bisa muncul dari kerusakan atau kehilangan fisik yang diselesaikan lewat stock opname.</div>
</section>
<div class="pg"><a href="index.php">← Beranda</a><a href="p2.php">Praktikum 2 →</a></div>
<?php require __DIR__ . '/footer.php'; ?>
