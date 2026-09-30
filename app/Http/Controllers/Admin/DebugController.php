<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Debug panel — SHUDHU seeded super admin (admin@khorak.shop) er jonno.
 * Onno kono admin/user e login korle route-o sidebar-o kichui dekhabe na.
 * Error findout korar jonno: system info + latest laravel.log er tail.
 */
class DebugController extends Controller
{
    private const SUPER_EMAIL = 'admin@khorak.shop';

    public function page(Request $request)
    {
        abort_unless($this->isSuperAdmin($request), 404);

        $debugOn = Setting::get('debug_panel', '') === '1';

        $dbOk = true;
        try {
            DB::select('select 1');
        } catch (\Throwable $e) {
            $dbOk = false;
        }

        $versionFile = public_path('version.txt');

        $info = [
            'PHP Version' => PHP_VERSION,
            'Laravel' => app()->version(),
            'Environment' => app()->environment(),
            'APP_DEBUG' => config('app.debug') ? 'ON' : 'OFF',
            'DB Connection' => $dbOk ? 'OK' : 'FAIL',
            'storage:link' => is_file(public_path('storage')) || is_dir(public_path('storage')) ? 'OK' : 'MISSING (setup.php chalano hoyni?)',
            'Deploy Version' => is_file($versionFile) ? trim((string) file_get_contents($versionFile)) : 'unknown',
            'Generated' => now()->format('d M Y, h:i A'),
        ];

        $logFile = $this->latestLogFile();
        $errors = $debugOn ? $this->parseLog($logFile, 60) : [];

        return view('admin.debug', [
            'debugOn' => $debugOn,
            'info' => $info,
            'logFile' => $logFile,
            'errors' => $errors,
            'errorCount' => count(array_filter($errors, fn ($e) => $e['level'] === 'error')),
            'logSize' => $logFile !== '' && is_file($logFile) ? number_format(filesize($logFile) / 1024, 1) . ' KB' : '—',
        ]);
    }

    /** Debug panel on/off — super admin chara kono path e aslei 404. */
    public function toggle(Request $request)
    {
        abort_unless($this->isSuperAdmin($request), 404);

        $on = $request->boolean('debug_panel');
        Setting::set('debug_panel', $on ? '1' : '');

        return back()->with('success', $on
            ? 'Debug mode ON — এখন নিচে latest error log দেখা যাবে।'
            : 'Debug mode OFF।');
    }

    private function isSuperAdmin(Request $request): bool
    {
        return strtolower((string) ($request->user()?->email ?? '')) === self::SUPER_EMAIL;
    }

    /** storage/logs er sobceye notun laravel*.log file. */
    private function latestLogFile(): string
    {
        $files = glob(storage_path('logs/laravel*.log')) ?: [];
        if ($files === []) {
            return '';
        }

        return (string) max($files);
    }

    /**
     * Laravel log ke alada alada error entry-e bhange, NOTUN theke purano —
     * .env te APP_DEBUG on na korei prottekta error er message, file/line
     * ar stack trace ekhanei dekha jay.
     */
    private function parseLog(string $file, int $limit): array
    {
        if ($file === '' || ! is_file($file)) {
            return [];
        }

        $content = (string) file_get_contents($file);
        $all = preg_split('/\r\n|\r|\n/', $content) ?: [];

        // log entry shuru hoy "[2026-10-01 12:00:00] production.ERROR: message"
        $entries = [];
        $current = null;
        foreach ($all as $line) {
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2}[^\]]*)\]\s+\S+\.(\w+):\s?(.*)$/', $line, $m)) {
                if ($current !== null) {
                    $entries[] = $current;
                }
                $level = strtolower($m[2]);
                $current = [
                    'time' => $m[1],
                    'level' => in_array($level, ['error', 'critical', 'alert', 'emergency'], true) ? 'error'
                        : ($level === 'warning' ? 'warning' : 'info'),
                    'level_name' => strtoupper($level),
                    'message' => $m[3] !== '' ? $m[3] : '(empty)',
                    'stack' => '',
                ];
            } elseif ($current !== null && $line !== '') {
                $current['stack'] .= ($current['stack'] === '' ? '' : "\n") . $line;
            }
        }
        if ($current !== null) {
            $entries[] = $current;
        }

        return array_slice(array_reverse($entries), 0, $limit);
    }
}
