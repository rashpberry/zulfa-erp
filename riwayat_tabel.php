<?php // butuh variabel $jenis ('jurnal' atau 'material'); db.php dimuat di sini
require_once __DIR__ . '/db.php';
?>
<h3 id="riwayat">Riwayat simulasi (tersimpan di database)</h3>
<?php if (isset($_GET['tersimpan'])): ?><div class="box">Simulasi berhasil disimpan ke database.</div><?php endif; ?>
<div class="box sim"><div class="tw"><table id="rw">
<tr><th>Waktu</th><th>Nama</th><th>Ringkasan</th><th>Aksi</th></tr>
<?php
try {
    $rows = riwayat($jenis);
    if (!$rows) echo '<tr><td colspan="4">Belum ada simulasi tersimpan.</td></tr>';
    foreach ($rows as $r): ?>
<tr><td><?= htmlspecialchars($r['dibuat']) ?></td><td><?= htmlspecialchars($r['nama'] ?? '-') ?></td><td><?= htmlspecialchars($r['ringkasan'] ?? '') ?></td>
<td><button data-d="<?= htmlspecialchars($r['data'], ENT_QUOTES) ?>">Lihat</button><button data-x="<?= (int)$r['id'] ?>">Hapus</button></td></tr>
<?php endforeach;
} catch (Throwable $e) {
    echo '<tr><td colspan="4">Riwayat tidak bisa dimuat: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
}
?>
</table></div><div class="out" id="dt" hidden></div></div>
