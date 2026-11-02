<?php
require_once __DIR__ . '/config.php';

function db() {
    static $pdo = null;
    if ($pdo) return $pdo;
    if (DB_NAME === 'nama_database' || DB_USER === 'user_database') {
        throw new RuntimeException('config.php belum diisi dengan data database hosting.');
    }
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    try { $pdo->exec("SET time_zone = '+07:00'"); } catch (Throwable $e) {}
    $pdo->exec("CREATE TABLE IF NOT EXISTS simulasi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        jenis VARCHAR(20) NOT NULL,
        nama VARCHAR(100) NULL,
        ringkasan VARCHAR(255) NULL,
        data TEXT NOT NULL,
        dibuat TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX (jenis)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    return $pdo;
}

function riwayat($jenis) {
    $st = db()->prepare('SELECT id, nama, ringkasan, data, dibuat FROM simulasi WHERE jenis = ? ORDER BY id DESC LIMIT 50');
    $st->execute([$jenis]);
    return $st->fetchAll();
}
