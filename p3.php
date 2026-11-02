<?php $judul = 'Praktikum 3'; $aktif = 3; require __DIR__ . '/header.php'; ?>
<section id="p3">
<h2>Praktikum 3. Pemetaan Proses Bisnis dan Perancangan Alur Persetujuan</h2>
<p class="ind">Indikator: pemetaan dan perancangan proses bisnis · pembelian bahan praktik laboratorium</p>

<h3>A. Diagram as-is</h3>
<div class="flow"><b>Dosen minta bahan<small>lewat WhatsApp</small></b><b class="r">Kepala lab verifikasi<small>berdasarkan perkiraan</small></b><b class="r">Gudang cek stok<small>tidak selalu dilakukan / tidak tercatat</small></b><b>Pembelian pilih pemasok</b><b class="r">Persetujuan pimpinan<small>tidak ada bukti, lisan</small></b><b>Gudang terima barang</b><b class="r">Bukti terima via pesan<small>bisa hilang / telat</small></b><b>Keuangan bayar</b></div>
<p class="lg">Merah = aktivitas berisiko salah atau terlambat. Kelemahan: permintaan tanpa identitas dan nomor, stok tidak dicek sehingga barang menumpuk dan ganda, dokumen tersebar di chat sehingga pembayaran telat.</p>

<h3>B. Diagram to-be</h3>
<div class="flow"><b>Dosen isi permintaan di ERP<small>identitas otomatis, nomor PR</small></b><b class="g">Kepala lab verifikasi di sistem</b><b class="d">Stok gudang cukup?</b><b class="g">Ya: gudang keluarkan stok, selesai</b><b class="g">Tidak: PR ke Pembelian<small>jumlah = kebutuhan − stok − PO berjalan</small></b><b>Pembelian: bandingkan penawaran, buat PO</b><b class="d">Nilai PO ≤ batas?</b><b class="g">Pimpinan / wakil setujui</b><b class="g">Gudang terima barang (GR) terhadap PO</b><b class="g">Faktur pemasok dicocokkan PO + GR (3-way match)</b><b class="g">Keuangan bayar</b></div>
<p class="lg">Perbedaan nyata: permintaan, stok, persetujuan, penerimaan, dan pembayaran terhubung dalam satu rantai dokumen, dan setiap langkah memeriksa langkah sebelumnya.</p>

<h3>C. Aturan bisnis</h3>
<ol>
<li>Setiap permintaan wajib memiliki identitas pengaju dan kode mata kuliah/kegiatan.</li>
<li>PR tidak bisa menjadi PO sebelum sistem memeriksa stok; jumlah beli = kebutuhan − stok − PO yang belum diterima.</li>
<li>PO hanya sah setelah disetujui pihak berwenang sesuai batas nilai; pembuat PO tidak boleh menyetujui PO sendiri.</li>
<li>Pembayaran hanya diproses bila PO, penerimaan barang, dan faktur cocok (3-way match) dalam toleransi yang ditetapkan.</li>
<li>Barang yang sama dari pemasok yang sama tidak boleh dipesan ulang selama PO sebelumnya masih terbuka (peringatan duplikasi).</li>
</ol>

<h3>Tabel aktor dan tanggung jawab</h3>
<div class="tw"><table>
<tr><th>Aktor</th><th>Tanggung jawab</th></tr>
<tr><td>Dosen</td><td>Mengajukan permintaan bahan dengan jumlah dan kebutuhan jelas</td></tr>
<tr><td>Kepala laboratorium</td><td>Memverifikasi kebutuhan dan kewajaran jumlah</td></tr>
<tr><td>Gudang</td><td>Menjaga stok akurat, mengeluarkan stok, menerima barang</td></tr>
<tr><td>Pembelian</td><td>Meminta penawaran, memilih pemasok, membuat PO</td></tr>
<tr><td>Pimpinan</td><td>Menyetujui PO sesuai batas wewenang</td></tr>
<tr><td>Keuangan</td><td>Mencocokkan dokumen dan membayar tepat waktu</td></tr>
</table></div>

<h3>D. Simulasi kondisi khusus: nilai pembelian naik setelah penawaran baru</h3>
<div class="box">Aturan tambahan: persetujuan hanya berlaku untuk nilai yang disetujui. Bila nilai baru naik lebih dari <b>5%</b> (atau melewati batas wewenang penyetuju awal), status PO kembali ke <i>menunggu persetujuan</i>.<br>Contoh: disetujui Rp10.000.000, penawaran baru Rp10.300.000 (naik 3%) → persetujuan masih berlaku, perubahan dicatat. Bila menjadi Rp11.000.000 (naik 10%) → <b>persetujuan harus diulang</b> dan versi PO sebelumnya tetap tersimpan sebagai riwayat.</div>

<h3>Kondisi darurat 24 jam (dari soal esai)</h3>
<div class="box">Jalur <i>emergency purchase</i>: Kepala lab menandai permintaan darurat dengan alasan tertulis, pimpinan menyetujui lewat ponsel dalam hitungan jam, nilai dibatasi batas darurat, pembelian ke pemasok terdaftar, dan setelahnya ditinjau ulang oleh Keuangan. Kontrol tetap ada (identitas, persetujuan, 3-way match), hanya waktunya dipercepat.</div>

<h3>Alasan rancangan baru lebih baik</h3>
<div class="box">Stok dicek sebelum membeli (mengurangi penumpukan dan pembelian ganda), persetujuan tercatat dan terikat nilai, dan pembayaran berdasarkan dokumen yang cocok sehingga tidak menunggu pesan manual. Semua jejaknya bisa diaudit.</div>
</section>
<div class="pg"><a href="p2.php">← Praktikum 2</a><a href="p4.php">Praktikum 4 →</a></div>
<?php require __DIR__ . '/footer.php'; ?>
