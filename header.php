<?php
$judul = $judul ?? 'Beranda';
$aktif = $aktif ?? 0;
$menu = [0 => ['index.php', 'Beranda'], 1 => ['p1.php', 'Praktikum 1'], 2 => ['p2.php', 'Praktikum 2'], 3 => ['p3.php', 'Praktikum 3'], 4 => ['p4.php', 'Praktikum 4'], 5 => ['p5.php', 'Praktikum 5']];
?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($judul) ?> – Praktikum UTS ERP</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header><div>
<h1>Jawaban Praktikum UTS Enterprise Resource Planning</h1>
<p>ERP / PL/4008 · Dosen: Adie Kusna Wibowo · Teknologi Rekayasa Perangkat Lunak · Politeknik META Industri · Semester Ganjil 2026/2027</p>
</div></header>
<nav>
<?php foreach ($menu as $k => $m): ?>
<a href="<?= $m[0] ?>"<?= $k === $aktif ? ' class="on"' : '' ?>><?= $m[1] ?></a>
<?php endforeach; ?>
</nav>
<main>
