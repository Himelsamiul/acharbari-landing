<?php

/**
 * One-time deployment helper for cPanel hosting (no SSH).
 * Runs: php artisan migrate --force  +  storage:link
 *
 * Usage in browser: https://domain.com/setup.php?key=<APP_KEY er shesh 16 ta character>
 * APP_KEY ta .env file e pabe (base64:... er bhitorer string).
 *
 * Kaj sesh hole EI FILE DELETE KORE DIN.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();

$appKey = (string) env('APP_KEY');
$given = (string) ($_GET['key'] ?? '');

if ($appKey === '' || $given === '' || ! hash_equals(substr($appKey, -16), $given)) {
    http_response_code(403);
    exit('Forbidden — URL er ?key= te APP_KEY er shesh 16 ta character din.');
}

header('Content-Type: text/plain; charset=utf-8');

echo "== MIGRATE ==\n";
\Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
echo \Illuminate\Support\Facades\Artisan::output();

echo "\n== STORAGE LINK ==\n";
\Illuminate\Support\Facades\Artisan::call('storage:link');
echo \Illuminate\Support\Facades\Artisan::output();

echo "\n== DONE ==\nSob thik ache. Ekhon ei setup.php file DELETE kore din (File Manager theke).";
