<?php $judul = 'Praktikum 2'; $aktif = 2; require __DIR__ . '/header.php'; ?>
<section id="p2">
<h2>Praktikum 2. Merancang dan Menguji Arsitektur Teknis ERP</h2>
<p class="ind">Indikator: arsitektur teknis ERP · 100 pengguna (penjualan, gudang, produksi, pembelian, keuangan)</p>

<h3>1. Diagram arsitektur</h3>
<div class="arch">
<div><b>Pengguna kantor (LAN)</b><b>Pengguna remote (VPN)</b></div><i>▼ HTTPS</i>
<div><b>Firewall + VPN gateway</b></div><i>▼</i>
<div><b>Load balancer / reverse proxy</b></div><i>▼ ▼</i>
<div><b>Server aplikasi 1<br><small>antarmuka web + logika bisnis</small></b><b>Server aplikasi 2<br><small>standby / aktif</small></b></div><i>▼ ▼ (jaringan database terpisah)</i>
<div><b>Database utama</b><i>⇄ replikasi</i><b>Database replika</b></div><i>▼ backup terjadwal</i>
<div><b>Storage backup lokal</b><i>→ salin</i><b>Backup luar lokasi / cloud</b></div>
</div>
<div class="tw"><table>
<tr><th>Komponen</th><th>Fungsi</th></tr>
<tr><td>Firewall dan VPN</td><td>Membatasi lalu lintas, akses dari luar hanya lewat terowongan terenkripsi</td></tr>
<tr><td>Load balancer</td><td>Membagi permintaan dan memindahkan ke server sehat saat satu server mati</td></tr>
<tr><td>Server aplikasi (2)</td><td>Menjalankan antarmuka dan logika modul; tidak menyimpan data permanen</td></tr>
<tr><td>Database utama dan replika</td><td>Menyimpan seluruh transaksi; replika menjadi cadangan siap pakai dan menerima beban baca laporan</td></tr>
<tr><td>Backup lokal dan luar lokasi</td><td>Pemulihan bila data rusak, terhapus, atau terjadi bencana</td></tr>
</table></div>

<h3>2. Kebutuhan keamanan akses per departemen</h3>
<div class="tw"><table>
<tr><th>Peran</th><th>Penjualan</th><th>Gudang</th><th>Produksi</th><th>Pembelian</th><th>Keuangan</th></tr>
<tr><td>Staf Penjualan</td><td>Buat/ubah</td><td>Lihat stok</td><td>Lihat status</td><td>–</td><td>–</td></tr>
<tr><td>Staf Gudang</td><td>Lihat SO</td><td>Buat/ubah</td><td>Lihat</td><td>Terima barang</td><td>–</td></tr>
<tr><td>Staf Produksi</td><td>Lihat SO</td><td>Pakai bahan</td><td>Buat/ubah</td><td>Ajukan PR</td><td>–</td></tr>
<tr><td>Staf Pembelian</td><td>–</td><td>Lihat stok</td><td>Lihat</td><td>Buat/ubah PO</td><td>–</td></tr>
<tr><td>Staf Keuangan</td><td>Lihat faktur</td><td>–</td><td>–</td><td>Lihat PO</td><td>Buat/ubah</td></tr>
<tr><td>Manajer / Pimpinan</td><td colspan="5">Lihat semua laporan; menyetujui transaksi di atas batas nilai</td></tr>
</table></div>
<p class="lg">Prinsip: <i>least privilege</i>, pemisahan tugas (pembuat PO ≠ penyetuju ≠ pembayar), autentikasi dua langkah untuk keuangan dan akses VPN, serta log audit.</p>

<h3>3. Pencadangan dan pemulihan</h3>
<ul>
<li><b>Jadwal:</b> full backup harian (malam), incremental/log transaksi tiap 1 jam, replikasi ke database replika terus-menerus.</li>
<li><b>Lokasi:</b> aturan 3-2-1: 3 salinan, 2 media berbeda, 1 di luar kantor. Backup dienkripsi.</li>
<li><b>Target:</b> RPO maksimal 1 jam, RTO maksimal 4 jam.</li>
<li><b>Pemulihan:</b> (1) hentikan akses tulis, (2) pulihkan full backup terakhir ke lingkungan uji, (3) terapkan log hingga titik waktu sebelum kerusakan, (4) verifikasi saldo dan jumlah transaksi, (5) arahkan aplikasi ke database hasil pemulihan.</li>
<li><b>Uji restore</b> dilakukan tiap bulan; backup yang belum pernah diuji dianggap belum ada.</li>
</ul>

<h3>4. Aliran data transaksi pembelian</h3>
<div class="flow"><b>Pengguna isi PO di browser</b><b>Firewall / load balancer</b><b>Server aplikasi: validasi, cek hak akses dan anggaran</b><b>Database: simpan PO (status draft)</b><b>Persetujuan → status disetujui</b><b>Respons ke layar pengguna</b><b class="g">Replikasi dan backup</b></div>

<h3>5. Potensi kegagalan teknis</h3>
<div class="tw"><table>
<tr><th>Kegagalan</th><th>Dampak operasional</th></tr>
<tr><td>Server aplikasi mati (jika hanya satu)</td><td>Seluruh departemen tidak bisa bertransaksi walau database hidup</td></tr>
<tr><td>Database rusak / tidak bisa diakses</td><td>Semua transaksi berhenti, risiko kehilangan data</td></tr>
<tr><td>Backup tidak berjalan atau tidak pernah diuji</td><td>Data tidak bisa dipulihkan setelah kerusakan</td></tr>
<tr><td>Jaringan atau internet putus</td><td>Pengguna remote terputus; kantor tetap jalan lewat LAN</td></tr>
</table></div>

<h3>Simulasi gangguan</h3>
<div class="tw"><table>
<tr><th>Kondisi</th><th>Tindakan penanganan</th></tr>
<tr><td>1. Database tidak dapat diakses</td><td>Cek layanan dan disk; bila rusak, failover ke replika dan arahkan aplikasi ke sana; informasikan pengguna; setelah pulih, cocokkan jumlah transaksi</td></tr>
<tr><td>2. Server aplikasi gangguan</td><td>Load balancer mengalihkan ke server aplikasi 2; perbaiki server 1 tanpa menghentikan layanan</td></tr>
<tr><td>3. Internet terputus</td><td>Pengguna di kantor tetap bekerja lewat LAN; pengguna remote menunggu atau pakai jalur internet kedua; backup luar lokasi ditunda lalu dikejar</td></tr>
<tr><td>4. Pengguna tidak berwenang buka menu keuangan</td><td>Akses ditolak oleh matriks hak akses, percobaan dicatat di log audit, pimpinan atau admin ditinjau jika berulang</td></tr>
<tr><td>5. Data hilang karena backup tidak jalan</td><td>Pakai database replika atau backup luar lokasi terakhir, input ulang transaksi dari dokumen sumber; perbaiki penjadwalan dan pasang alarm kegagalan backup</td></tr>
</table></div>

<h3>Alasan pemilihan rancangan</h3>
<div class="box">Dengan 100 pengguna, dua server aplikasi di belakang load balancer sudah cukup dan menghilangkan titik kegagalan tunggal. Replika database dan backup luar lokasi menutup risiko kehilangan data dengan biaya yang masih wajar dibanding klaster besar.</div>
</section>
<div class="pg"><a href="p1.php">← Praktikum 1</a><a href="p3.php">Praktikum 3 →</a></div>
<?php require __DIR__ . '/footer.php'; ?>
