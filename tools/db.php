<?php
$h = getenv('DB_HOST') ?: '127.0.0.1';
$p = getenv('DB_PORT') ?: '3306';
$n = getenv('DB_NAME') ?: 'dvwa_laravel';
$u = getenv('DB_USER') ?: 'root';
$w = getenv('DB_PASS') ?: '';
try {
    $pdo = new PDO("mysql:host=$h;port=$p;charset=utf8mb4", $u, $w, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Throwable $e) {
    fwrite(STDERR, "Gagal konek MySQL: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
if (($argv[1] ?? '') === 'create') {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$n` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "     Database $n siap." . PHP_EOL;
} else {
    echo "     MySQL OK." . PHP_EOL;
}
