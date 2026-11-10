<?php
$f = $argv[1] ?? '';
if (!is_file($f)) { fwrite(STDERR, "File .env tidak ditemukan: $f" . PHP_EOL); exit(1); }
$c = file_get_contents($f);
$vals = [
    'APP_NAME'      => 'DVWA-Laravel',
    'APP_ENV'       => 'local',
    'APP_DEBUG'     => 'true',
    'APP_URL'       => 'http://' . getenv('APP_HOST') . ':' . getenv('APP_PORT'),
    'DB_CONNECTION' => 'mysql',
    'DB_HOST'       => getenv('DB_HOST') ?: '127.0.0.1',
    'DB_PORT'       => getenv('DB_PORT') ?: '3306',
    'DB_DATABASE'   => getenv('DB_NAME') ?: 'dvwa_laravel',
    'DB_USERNAME'   => getenv('DB_USER') ?: 'root',
    'DB_PASSWORD'   => getenv('DB_PASS') ?: '',
    'SESSION_DRIVER'=> 'database',
];
foreach ($vals as $k => $v) {
    $line = "$k=$v";
    $re = '/^#?\s*' . preg_quote($k, '/') . '=.*$/m';
    if (preg_match($re, $c)) {
        $c = preg_replace_callback($re, fn () => $line, $c, 1);
    } else {
        $c = rtrim($c) . PHP_EOL . $line . PHP_EOL;
    }
}
file_put_contents($f, $c);
echo "     .env diperbarui." . PHP_EOL;
