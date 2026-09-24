<?php

/**
 * One-time deployment helper — runs migrations & seeders on the server.
 * Token protected. DELETE THIS FILE after the first successful run.
 */

$TOKEN = 'AcharBari-Deploy-2026-Xk92m';
if (!isset($_GET['token']) || !hash_equals($TOKEN, $_GET['token'])) {
    http_response_code(403);
    exit('forbidden');
}
@set_time_limit(300);
header('Content-Type: text/plain; charset=utf-8');

// locate the Laravel base (works locally in public/ and deployed in public_html/)
$base = dirname(__DIR__);
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    $base = __DIR__;
}

if (!file_exists($base . '/.env')) {
    exit("ERROR: .env not found on the server — create it first.\n");
}

require $base . '/vendor/autoload.php';
$app = require $base . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "== migrate ==\n";
Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
echo Illuminate\Support\Facades\Artisan::output();

echo "== seed ==\n";
Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
echo Illuminate\Support\Facades\Artisan::output();

echo "\nDONE — now DELETE this file.\n";
