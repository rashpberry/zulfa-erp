<?php $judul = 'Praktikum 5'; $aktif = 5; require __DIR__ . '/header.php'; ?>
<section id="p5">
<h2>Praktikum 5. Konfigurasi SCM dan Pembelian Berbasis Kebutuhan Material</h2>
<p class="ind">Indikator: konfigurasi modul SCM dan pembelian · produksi 300 unit, selesai dalam 6 hari kerja</p>

<h3>Tahap 1. Data master</h3>
<div class="tw"><table>
<tr><th>Data</th><th>Isian</th></tr>
<tr><td>Produk jadi</td><td>Produk P-001, satuan unit</td></tr>
<tr><td>Bahan baku</td><td>A (satuan unit), B (satuan unit)</td></tr>
<tr><td>BOM P-001</td><td>3 unit A + 2 unit B per 1 produk</td></tr>
<tr><td>Gudang</td><td>Gudang Bahan Baku (stok A 400, B 250)</td></tr>
<tr><td>Pemasok</td><td>Pemasok A (lead time 4 hari kerja), Pemasok B (7 hari kerja)</td></tr>
<tr><td>Aturan pemesanan</td><td>Beli sesuai kebutuhan bersih (lot-for-lot), tambah stok pengaman sesuai kebijakan</td></tr>
</table></div>

<h3>Tahap 2. Perhitungan kebutuhan</h3>
<div class="tw"><table>
<tr><th>Bahan</th><th>Kebutuhan bruto</th><th>Stok</th><th>Pesanan belum diterima</th><th>Kebutuhan bersih</th></tr>
<tr><td>A</td><td>300 × 3 = 900</td><td>400</td><td>100</td><td>900 − 400 − 100 = <b>400</b></td></tr>
<tr><td>B</td><td>300 × 2 = 600</td><td>250</td><td>0</td><td>600 − 250 − 0 = <b>350</b></td></tr>
</table></div>
<div class="box">Asumsi: pesanan 100 unit A yang belum diterima dihitung karena lead time A (4 hari) lebih pendek dari batas produksi 6 hari, dengan syarat tiba paling lambat hari ke-4 atau ke-5. Bila tanggal kedatangan tidak pasti, kebutuhan bersih A menjadi 500. Untuk B, pembelian baru memerlukan 7 hari kerja sehingga <b>melewati batas 6 hari</b> (terlambat 1 hari) bila dipesan hari ini.</div>

<div class="box sim"><b>Simulasi interaktif: ubah angka, hasil langsung dihitung</b><br>
<label>Produksi <input id="q" type="number" value="300"></label><label>Waktu (hari) <input id="hr" type="number" value="6"></label><br>
<label>BOM A <input id="ba" type="number" value="3"></label><label>Stok A <input id="sa" type="number" value="400"></label><label>PO A <input id="pa" type="number" value="100"></label><label>Lead A <input id="la" type="number" value="4"></label><br>
<label>BOM B <input id="bb" type="number" value="2"></label><label>Stok B <input id="sb" type="number" value="250"></label><label>PO B <input id="pb" type="number" value="0"></label><label>Lead B <input id="lb" type="number" value="7"></label><br>
<button id="late">Pemasok B baru kirim 8 hari</button><label>Nama <input id="nm5" type="text" maxlength="100" style="width:9rem"></label><button id="sv5">Simpan ke database</button><button id="rst5">Reset</button><span id="st5" class="lg"></span>
<div class="out" id="o5"></div></div>

<h3>Tahap 3. Simulasi permintaan pembelian</h3>
<div class="flow"><b>Rencana produksi 300 unit</b><b>BOM → bruto A 900, B 600</b><b>Kurangi stok dan PO berjalan</b><b>PR-001: A 400 unit</b><b>PR-002: B 350 unit</b><b class="d">Disetujui?</b><b class="g">PO ke pemasok A dan B</b></div>

<h3>Tahap 4. Penerimaan sebagian</h3>
<div class="tw"><table>
<tr><th>Kejadian</th><th>Stok A</th><th>Status PO A</th></tr>
<tr><td>Awal</td><td>400</td><td>PO lama 100 terbuka; PO baru 400 diterbitkan</td></tr>
<tr><td>PO lama 100 diterima penuh</td><td>500</td><td>PO lama <i>selesai</i></td></tr>
<tr><td>Pemasok kirim 250 dari PO baru 400</td><td>750</td><td>PO baru <i>diterima sebagian</i>, sisa 150</td></tr>
</table></div>
<p class="lg">Stok bertambah sesuai jumlah yang benar-benar diterima. Sisa 150 tetap menjadi pesanan terbuka sampai dikirim atau dibatalkan, dan utang usaha hanya dicatat untuk barang yang sudah diterima.</p>

<h3>Tahap 5. Pemasok B baru kirim dalam 8 hari, produksi harus selesai 6 hari</h3>
<div class="tw"><table>
<tr><th>Opsi</th><th>Waktu</th><th>Biaya</th><th>Risiko</th></tr>
<tr><td>Tetap menunggu pemasok B</td><td>Terlambat 2 hari</td><td>Terendah</td><td>Pengiriman ke pelanggan terlambat</td></tr>
<tr><td>Pemasok alternatif B</td><td>Tergantung lead time, jika ≤ 5 hari memenuhi</td><td>Mungkin lebih mahal</td><td>Kualitas belum terverifikasi</td></tr>
<tr><td>Pinjam stok dari lokasi lain</td><td>Cepat</td><td>Biaya transfer</td><td>Lokasi asal kekurangan</td></tr>
<tr><td>Susun ulang jadwal produksi</td><td>Pakai B yang ada</td><td>Rendah</td><td>Sebagian produk selesai belakangan</td></tr>
</table></div>
<div class="box"><b>Keputusan:</b> jalankan dua langkah bersamaan. (1) Mulai produksi tahap 1 sebanyak <b>125 unit</b> (250 B ÷ 2 per unit; bahan A cukup) agar selesai dalam 6 hari. (2) Cari pemasok alternatif atau transfer stok untuk 350 B. Bila tidak ada, sisa 175 unit diproduksi setelah B datang (hari ke-8) dan pelanggan diberi tahu pengiriman bertahap. Pilihan ini menjaga sebagian target tanpa menanggung biaya darurat penuh.</div>
</section>
<?php $jenis = 'material'; require __DIR__ . '/riwayat_tabel.php'; ?>
<div class="pg"><a href="p4.php">← Praktikum 4</a><a href="index.php">Beranda</a></div>
<script src="riwayat.js"></script>
<script>
(function(){
var $=function(i){return document.getElementById(i)},rp=function(n){return 'Rp'+n.toLocaleString('id-ID')};
/* Praktikum 5 */
var ids=['q','hr','ba','sa','pa','la','bb','sb','pb','lb'],def={q:300,hr:6,ba:3,sa:400,pa:100,la:4,bb:2,sb:250,pb:0,lb:7};
function v(i){return Math.max(0,+$(i).value||0)}
function calc(){
var q=v('q'),h=v('hr'),r=[],ok=true,u=q;
[['A','ba','sa','pa','la'],['B','bb','sb','pb','lb']].forEach(function(m){
var br=q*v(m[1]),ne=Math.max(0,br-v(m[2])-v(m[3])),lt=v(m[4]),ada=v(m[2])+v(m[3]);
var tepat=ne===0||lt<=h;if(!tepat){ok=false;u=Math.min(u,Math.floor(ada/v(m[1])))}
r.push('Bahan '+m[0]+': bruto '+br+' − stok '+v(m[2])+' − PO '+v(m[3])+' = kebutuhan bersih <b>'+ne+'</b>; lead time '+lt+' hari '+(ne===0?'(tidak perlu beli)':tepat?'≤ '+h+' hari, tepat waktu':'> '+h+' hari, <b>terlambat '+(lt-h)+' hari</b>'))});
$('o5').innerHTML=r.join('<br>')+'<br>'+(ok?'<b>Produksi '+q+' unit dapat selesai tepat waktu.</b>':'<b>Hanya '+u+' unit yang bisa selesai dalam '+h+' hari</b> dari stok dan PO yang ada; sisa '+(q-u)+' unit menunggu bahan datang.')}
ids.forEach(function(i){$(i).oninput=calc});
$('late').onclick=function(){$('lb').value=8;calc()};
$('rst5').onclick=function(){ids.forEach(function(i){$(i).value=def[i]});calc()};
$('sv5').onclick=function(){
var inp={};ids.forEach(function(i){inp[i]=v(i)});
var t=$('o5').innerText.trim(),ls=t.split('\n'),ring=ls[ls.length-1];
RW.simpan('material',$('nm5').value,ring,{input:inp,hasil:t})
.then(function(){$('st5').textContent=' Tersimpan.'}).catch(function(e){$('st5').textContent=' Gagal menyimpan: '+e.message});};
RW.muat('material');
calc();
})();
</script>
<?php require __DIR__ . '/footer.php'; ?>
