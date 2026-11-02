<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/db.php';

function out($arr, $code = 200) {
    http_response_code($code);
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    exit;
}
function cut($s, $n) {
    return function_exists('mb_substr') ? mb_substr($s, 0, $n) : substr($s, 0, $n);
}

try {
    $a = $_GET['a'] ?? '';
    $jenisOk = ['jurnal', 'material'];
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(['error' => 'Gunakan metode POST'], 405);
    $in = json_decode(file_get_contents('php://input'), true);
    if (!is_array($in)) out(['error' => 'Data yang dikirim tidak terbaca'], 400);

    if ($a === 'save') {
        $j = $in['jenis'] ?? '';
        $data = json_encode($in['data'] ?? null, JSON_UNESCAPED_UNICODE);
        if (!in_array($j, $jenisOk, true) || !$data || strlen($data) > 20000) out(['error' => 'Data tidak valid'], 400);
        $nama = cut(trim((string)($in['nama'] ?? '')), 100);
        $ring = cut(trim((string)($in['ringkasan'] ?? '')), 250);
        $st = db()->prepare('INSERT INTO simulasi (jenis, nama, ringkasan, data) VALUES (?, ?, ?, ?)');
        $st->execute([$j, $nama !== '' ? $nama : null, $ring, $data]);
        out(['ok' => true, 'id' => (int)db()->lastInsertId()]);
    }

    if ($a === 'delete') {
        $st = db()->prepare('DELETE FROM simulasi WHERE id = ?');
        $st->execute([(int)($in['id'] ?? 0)]);
        out(['ok' => true]);
    }

    out(['error' => 'Aksi tidak dikenal'], 400);
} catch (Throwable $e) {
    out(['error' => 'Database: ' . $e->getMessage()], 500);
}
