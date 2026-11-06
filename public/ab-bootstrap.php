<?php

/**
 * Fresh-deploy bootstrap for cPanel hosting (no SSH).
 *
 * Used when vendor/ is shipped as a single vendor.tar.gz instead of 8869 loose
 * files — FTP reliably drops files on a fresh vendor upload, but one archive
 * transfers cleanly, and this script rebuilds vendor/ server-side via PharData.
 *
 * Flow: verify key (last 16 chars of APP_KEY, read from .env) -> extract
 * vendor.tar.gz if vendor/ is missing (or ?extract=1) -> clear caches -> migrate --force ->
 * storage:link -> optional ?seed=1 (fresh, empty database only).
 *
 * URL: https://domain.com/public/ab-bootstrap.php?key=<last 16 of APP_KEY>[&extract=1][&seed=1]
 * Kaj sesh hole EI FILE + public_html/vendor.tar.gz DELETE kore din.
 */

ini_set('display_errors', '1');
error_reporting(E_ALL);
@set_time_limit(900);

$base = dirname(__DIR__); // public_html (project root)

// --- key check WITHOUT the framework (vendor may not exist yet) ---
$env = @file_get_contents($base . '/.env');
$appKey = '';
if ($env !== false && preg_match('/^APP_KEY=(.*)$/m', $env, $m)) {
    $appKey = trim($m[1], " \"'\r\n");
}
$given = (string) ($_GET['key'] ?? '');
if ($appKey === '' || strlen($appKey) < 16 || $given === '' || ! hash_equals(substr($appKey, -16), $given)) {
    http_response_code(403);
    exit('Forbidden — ?key= te .env er APP_KEY er shesh 16 ta character din.');
}

header('Content-Type: text/plain; charset=utf-8');
echo 'PHP ' . PHP_VERSION . "\n";

// --- rebuild vendor from the archive when missing (or ?extract=1 forces it) ---
$tar = $base . '/vendor.tar.gz';
$needVendor = ! is_file($base . '/vendor/autoload.php') || ($_GET['extract'] ?? '') === '1';
if ($needVendor && is_file($tar)) {
    echo '== EXTRACT vendor.tar.gz (' . round(filesize($tar) / 1048576, 1) . " MB) ==\n";
    try {
        (new PharData($tar))->extractTo($base, null, true); // null, true = all files, overwrite
        echo "vendor extracted\n";
    } catch (\Throwable $e) {
        echo 'EXTRACT ERROR: ' . $e->getMessage() . "\n";
    }
}

if (! is_file($base . '/vendor/autoload.php')) {
    http_response_code(500);
    exit("vendor/autoload.php nei — public_html/ e vendor.tar.gz upload kore abar chalan.\n");
}

require $base . '/vendor/autoload.php';
$app = require $base . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// stale caches from the previous code (routes, config, compiled views) must not
// outlive a deploy; then migrate
$steps = [
    ['config:clear', []], ['route:clear', []], ['view:clear', []], ['event:clear', []],
    ['migrate', ['--force' => true]], ['storage:link', []],
];
foreach ($steps as [$name, $opts]) {
    echo "\n== php artisan {$name} ==\n";
    try {
        $kernel->call($name, $opts);
        echo $kernel->output();
    } catch (\Throwable $e) {
        echo 'ERROR: ' . $e->getMessage() . "\n";
    }
}

// the served robots.txt is a file — rewrite it from the admin's setting so an
// old copy on the server never outlives a deploy
echo "\n== robots.txt ==\n";
try {
    $robots = \App\Http\Controllers\Admin\SeoController::syncRobotsFile();
    echo ($robots ?? 'WARNING: public/robots.txt could not be written') . "\n";
    if (str_contains((string) $robots, '//localhost')) {
        echo "WARNING: robots.txt points to localhost — fix the Sitemap line in Admin → SEO → robots.txt (and APP_URL in .env)\n";
    }
} catch (\Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}

if (($_GET['seed'] ?? '') === '1') {
    echo "\n== php artisan db:seed ==\n";
    try {
        // starter data is for a fresh install only — a live store keeps its own
        if (\Illuminate\Support\Facades\DB::table('users')->exists()) {
            echo "skipped — database already has accounts (seed only runs on a fresh install)\n";
        } else {
            $kernel->call('db:seed', ['--force' => true]);
            echo $kernel->output();
        }
    } catch (\Throwable $e) {
        echo 'ERROR: ' . $e->getMessage() . "\n";
    }
}

echo "\n== DONE ==\nEkhon public/ab-bootstrap.php AR public_html/vendor.tar.gz DELETE kore din.\n";
