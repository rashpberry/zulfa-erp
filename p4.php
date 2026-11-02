<?php $judul = 'Praktikum 4'; $aktif = 4; require __DIR__ . '/header.php'; ?>
<section id="p4">
<h2>Praktikum 4. Konfigurasi dan Simulasi Modul Keuangan</h2>
<p class="ind">Indikator: konfigurasi dan simulasi modul keuangan · saldo awal kas Rp30.000.000</p>

<h3>Tahap 1. Konfigurasi akun</h3>
<div class="tw"><table>
<tr><th>Kode</th><th>Akun</th><th>Tipe</th><th>Saldo normal</th></tr>
<tr><td>1-1100</td><td>Kas</td><td>Aset</td><td>Debit</td></tr>
<tr><td>1-1200</td><td>Piutang usaha</td><td>Aset</td><td>Debit</td></tr>
<tr><td>1-1300</td><td>Persediaan bahan baku</td><td>Aset</td><td>Debit</td></tr>
<tr><td>2-1100</td><td>Utang usaha</td><td>Liabilitas</td><td>Kredit</td></tr>
<tr><td>3-1000</td><td>Modal (saldo awal)</td><td>Ekuitas</td><td>Kredit</td></tr>
<tr><td>4-1000</td><td>Penjualan</td><td>Pendapatan</td><td>Kredit</td></tr>
<tr><td>6-1000</td><td>Beban operasional</td><td>Beban</td><td>Debit</td></tr>
</table></div>
<p class="lg">Metode pencatatan: perpetual dengan akun persediaan. Jurnal pembuka: Dr Kas 30.000.000 / Cr Modal 30.000.000.</p>

<h3>Tahap 2. Jurnal transaksi</h3>
<div class="tw"><table>
<tr><th>No</th><th>Jurnal</th><th class="n">Debit</th><th class="n">Kredit</th><th>Alasan</th></tr>
<tr><td rowspan="2">1</td><td>Persediaan bahan baku</td><td class="n">8.000.000</td><td></td><td>Aset (bahan) bertambah</td></tr>
<tr><td>&nbsp;&nbsp;Utang usaha</td><td></td><td class="n">8.000.000</td><td>Kewajiban timbul, belum ada kas keluar</td></tr>
<tr><td rowspan="2">2</td><td>Utang usaha</td><td class="n">3.000.000</td><td></td><td>Kewajiban berkurang</td></tr>
<tr><td>&nbsp;&nbsp;Kas</td><td></td><td class="n">3.000.000</td><td>Kas keluar</td></tr>
<tr><td rowspan="2">3</td><td>Piutang usaha</td><td class="n">12.000.000</td><td></td><td>Hak tagih timbul, kas belum masuk</td></tr>
<tr><td>&nbsp;&nbsp;Penjualan</td><td></td><td class="n">12.000.000</td><td>Pendapatan diakui saat barang terjual</td></tr>
<tr><td rowspan="2">4</td><td>Kas</td><td class="n">5.000.000</td><td></td><td>Kas masuk</td></tr>
<tr><td>&nbsp;&nbsp;Piutang usaha</td><td></td><td class="n">5.000.000</td><td>Hak tagih berkurang (bukan pendapatan baru)</td></tr>
<tr><td rowspan="2">5</td><td>Beban operasional</td><td class="n">1.500.000</td><td></td><td>Biaya periode berjalan</td></tr>
<tr><td>&nbsp;&nbsp;Kas</td><td></td><td class="n">1.500.000</td><td>Dibayar tunai</td></tr>
</table></div>

<h3>Tahap 3. Saldo akhir dan neraca saldo</h3>
<div class="tw"><table>
<tr><th>Akun</th><th>Perhitungan</th><th class="n">Saldo</th></tr>
<tr><td>Kas</td><td>30.000.000 − 3.000.000 + 5.000.000 − 1.500.000</td><td class="n">30.500.000 (D)</td></tr>
<tr><td>Piutang usaha</td><td>12.000.000 − 5.000.000</td><td class="n">7.000.000 (D)</td></tr>
<tr><td>Persediaan</td><td>8.000.000</td><td class="n">8.000.000 (D)</td></tr>
<tr><td>Utang usaha</td><td>8.000.000 − 3.000.000</td><td class="n">5.000.000 (K)</td></tr>
<tr><td>Penjualan</td><td>12.000.000</td><td class="n">12.000.000 (K)</td></tr>
<tr><td>Beban operasional</td><td>1.500.000</td><td class="n">1.500.000 (D)</td></tr>
<tr><td>Modal</td><td>saldo awal</td><td class="n">30.000.000 (K)</td></tr>
<tr class="t"><td colspan="2">Total debit = total kredit (30,5 + 7 + 8 + 1,5 = 47 juta; 5 + 12 + 30 = 47 juta)</td><td class="n">47.000.000</td></tr>
</table></div>

<div class="box sim"><b>Simulasi interaktif: catat transaksi satu per satu</b>
<div id="b4"></div>
<div class="tw"><table id="t4"></table></div>
<div><button id="dup">Catat pembayaran ganda (kesalahan)</button><button id="cor">Koreksi dengan jurnal pembalik</button><label>Nama <input id="nm4" type="text" maxlength="100" style="width:9rem"></label><button id="sv4">Simpan ke database</button><button id="rst4">Reset</button><span id="st4" class="lg"></span></div>
<ol id="l4"></ol><div class="out" id="o4"></div></div>

<h3>Tahap 4. Pengujian kesalahan: pembayaran utang Rp3.000.000 tercatat dua kali</h3>
<ol>
<li><b>Menemukan:</b> di buku besar kas dan utang usaha terdapat dua entri identik (tanggal, jumlah, pemasok, referensi). Kas menjadi 27.500.000 dan utang usaha 2.000.000, padahal rekening koran hanya menunjukkan satu pembayaran dan faktur pemasok masih tersisa 5.000.000.</li>
<li><b>Dampak:</b> kas dan utang usaha sama-sama terlalu rendah Rp3.000.000. Neraca saldo tetap seimbang, jadi kesalahan tidak terdeteksi oleh keseimbangan saja. Laba tidak terpengaruh, tetapi posisi kas dan kewajiban salah.</li>
<li><b>Koreksi:</b> jangan menghapus jurnal. Buat <i>jurnal pembalik</i> dengan referensi ke entri duplikat: Dr Kas 3.000.000 / Cr Utang usaha 3.000.000, keterangan "Koreksi pembayaran ganda ref. #2". Saldo kembali ke kas 30.500.000 dan utang 5.000.000.</li>
<li><b>Jejak audit:</b> ketiga jurnal (asli, duplikat, pembalik) tetap tampil di laporan jurnal dengan pembuat, waktu, dan alasan. Alternatif di ERP: fitur <i>reverse entry</i> atau <i>void</i> yang membuat pembalik otomatis.</li>
</ol>
</section>
<?php $jenis = 'jurnal'; require __DIR__ . '/riwayat_tabel.php'; ?>
<div class="pg"><a href="p3.php">← Praktikum 3</a><a href="p5.php">Praktikum 5 →</a></div>
<script src="riwayat.js"></script>
<script>
(function(){
var $=function(i){return document.getElementById(i)},rp=function(n){return 'Rp'+n.toLocaleString('id-ID')};
/* Praktikum 4 */
var N={kas:'Kas',piu:'Piutang usaha',per:'Persediaan',utg:'Utang usaha',pen:'Penjualan',beb:'Beban operasional',mod:'Modal'};
var TX=[['1. Beli bahan kredit','per','utg',8e6],['2. Bayar utang pemasok','utg','kas',3e6],['3. Jual kredit','piu','pen',12e6],['4. Terima piutang','kas','piu',5e6],['5. Bayar listrik/operasional','beb','kas',1.5e6]];
var d,k,used,log;
function reset4(){d={};k={};for(var a in N){d[a]=0;k[a]=0}d.kas=3e7;k.mod=3e7;used={};log=[];draw4()}
function post(dr,cr,a,t){d[dr]+=a;k[cr]+=a;log.push(t+': Dr '+N[dr]+' / Cr '+N[cr]+' '+rp(a))}
function draw4(){
$('b4').innerHTML='';
TX.forEach(function(t,i){var b=document.createElement('button');b.textContent=t[0]+' ('+rp(t[3])+')';b.disabled=!!used[i];b.onclick=function(){used[i]=1;post(t[1],t[2],t[3],t[0]);draw4()};$('b4').appendChild(b)});
var h='<tr><th>Akun</th><th class="n">Debit</th><th class="n">Kredit</th><th class="n">Saldo</th></tr>',td=0,tk=0;
for(var a in N){var s=d[a]-k[a];td+=d[a];tk+=k[a];h+='<tr><td>'+N[a]+'</td><td class="n">'+d[a].toLocaleString('id-ID')+'</td><td class="n">'+k[a].toLocaleString('id-ID')+'</td><td class="n">'+Math.abs(s).toLocaleString('id-ID')+(s>=0?' D':' K')+'</td></tr>'}
h+='<tr class="t"><td>Total</td><td class="n">'+td.toLocaleString('id-ID')+'</td><td class="n">'+tk.toLocaleString('id-ID')+'</td><td class="n">'+(td===tk?'Seimbang':'TIDAK seimbang')+'</td></tr>';
$('t4').innerHTML=h;
$('l4').innerHTML=log.map(function(x){return '<li>'+x+'</li>'}).join('');
$('dup').disabled=!used[1]||log.some(function(x){return x.indexOf('GANDA')>-1});
$('cor').disabled=!log.some(function(x){return x.indexOf('GANDA')>-1})||log.some(function(x){return x.indexOf('KOREKSI')>-1});
$('o4').textContent=log.some(function(x){return x.indexOf('GANDA')>-1})&&!log.some(function(x){return x.indexOf('KOREKSI')>-1})?'Kas dan utang usaha sama-sama terlalu rendah Rp3.000.000, tetapi total debit tetap sama dengan kredit. Kesalahan ini tidak terlihat dari keseimbangan saja, harus dicocokkan dengan rekening koran dan faktur.':'Klik transaksi 1 sampai 5. Setelah transaksi 2 dicatat, tombol kesalahan aktif.';
}
$('dup').onclick=function(){post('utg','kas',3e6,'GANDA (duplikat transaksi 2)');draw4()};
$('cor').onclick=function(){post('kas','utg',3e6,'KOREKSI (pembalik duplikat, tidak menghapus jejak)');$('o4').textContent='Saldo kembali benar dan ketiga jurnal tetap tercatat sebagai jejak audit.';var o=$('o4').textContent;draw4();$('o4').textContent=o};
$('sv4').onclick=function(){
if(!log.length){$('st4').textContent=' Catat minimal satu transaksi dulu.';return}
var s={};for(var a in N)s[N[a]]=d[a]-k[a];
var kor=log.some(function(x){return x.indexOf('KOREKSI')>-1});
RW.simpan('jurnal',$('nm4').value,'Kas '+rp(s['Kas'])+', utang '+rp(-s['Utang usaha'])+', '+log.length+' jurnal'+(kor?', ada koreksi':''),{jurnal:log,saldo:s})
.then(function(){$('st4').textContent=' Tersimpan.'}).catch(function(e){$('st4').textContent=' Gagal menyimpan: '+e.message});};
RW.muat('jurnal');
$('rst4').onclick=reset4;reset4();
})();
</script>
<?php require __DIR__ . '/footer.php'; ?>
