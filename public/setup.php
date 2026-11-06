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

// stale caches from the previous code (routes, config, compiled views) must not
// outlive a deploy
echo "== CLEAR CACHES ==\n";
foreach (['config:clear', 'route:clear', 'view:clear', 'event:clear'] as $command) {
    \Illuminate\Support\Facades\Artisan::call($command);
    echo \Illuminate\Support\Facades\Artisan::output();
}

echo "\n== MIGRATE ==\n";
\Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
echo \Illuminate\Support\Facades\Artisan::output();

// the served robots.txt is a file — rewrite it from the admin's setting so an
// old copy on the server never outlives a deploy
echo "\n== ROBOTS.TXT ==\n";
$robots = \App\Http\Controllers\Admin\SeoController::syncRobotsFile();
echo ($robots ?? 'WARNING: public/robots.txt could not be written') . "\n";
if (str_contains((string) $robots, '//localhost')) {
    echo "WARNING: robots.txt points to localhost — fix the Sitemap line in Admin → SEO → robots.txt (and APP_URL in .env)\n";
}

echo "\n== STORAGE LINK ==\n";
\Illuminate\Support\Facades\Artisan::call('storage:link');
echo \Illuminate\Support\Facades\Artisan::output();

if (($_GET['seed'] ?? '') === '1') {
    echo "\n== SEED ==\n";
    // starter data is for a fresh install only — a live store keeps its own
    if (\Illuminate\Support\Facades\DB::table('users')->exists()) {
        echo "skipped — database already has accounts (seed only runs on a fresh install)\n";
    } else {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        echo \Illuminate\Support\Facades\Artisan::output();
    }
}

echo "\n== DONE ==\nSob thik ache. Ekhon ei setup.php file DELETE kore din (File Manager theke).";
