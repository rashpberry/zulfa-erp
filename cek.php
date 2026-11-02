<?php
// Halaman pengecek: buka domainkamu.com/cek.php, hapus file ini setelah selesai.
header('Content-Type: text/html; charset=utf-8');
require __DIR__ . '/config.php';
function r($ok, $t) { echo '<p>' . ($ok ? '✅ ' : '❌ ') . htmlspecialchars($t) . '</p>'; }
echo '<h3>Cek instalasi Praktikum ERP</h3>';
r(true, 'PHP berjalan, versi ' . PHP_VERSION);
r(extension_loaded('pdo_mysql'), 'Ekstensi pdo_mysql ' . (extension_loaded('pdo_mysql') ? 'aktif' : 'TIDAK aktif (aktifkan di cPanel > Select PHP Version)'));
r(DB_NAME !== 'nama_database' && DB_USER !== 'user_database', 'config.php sudah diisi');
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    r(true, 'Koneksi ke database berhasil');
    $ada = $pdo->query("SHOW TABLES LIKE 'simulasi'")->fetch();
    r((bool)$ada, $ada ? 'Tabel simulasi ada' : 'Tabel simulasi belum ada (akan dibuat otomatis, atau impor database.sql)');
    if ($ada) r(true, 'Jumlah simulasi tersimpan: ' . $pdo->query('SELECT COUNT(*) FROM simulasi')->fetchColumn());
} catch (Throwable $e) {
    r(false, 'Koneksi gagal: ' . $e->getMessage());
}
