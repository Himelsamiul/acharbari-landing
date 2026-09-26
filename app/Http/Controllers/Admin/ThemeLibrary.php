<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Carbon\Carbon;

class ThemeLibrary
{
    /** Max entries kept in the theme history stack. */
    const MAX_HISTORY = 5;

    /** Max custom themes an admin can save in "My Themes". */
    const MAX_MY_THEMES = 12;

    /** Fonts the admin can assign to headings/body (Google Fonts, loaded on demand). */
    public static function fonts(): array
    {
        return [
            '' => ['label' => 'বডির সাথে একই', 'stack' => '', 'google' => ''],
            'hind' => ['label' => 'Hind Siliguri', 'stack' => "'Hind Siliguri', sans-serif", 'google' => 'Hind+Siliguri:wght@400;500;600;700'],
            'jakarta' => ['label' => 'Plus Jakarta Sans', 'stack' => "'Plus Jakarta Sans', 'Hind Siliguri', sans-serif", 'google' => 'Plus+Jakarta+Sans:wght@400;500;600;700;800'],
            'noto-serif' => ['label' => 'Noto Serif Bengali', 'stack' => "'Noto Serif Bengali', 'Hind Siliguri', serif", 'google' => 'Noto+Serif+Bengali:wght@400;500;600;700'],
            'baloo' => ['label' => 'Baloo Da 2', 'stack' => "'Baloo Da 2', 'Hind Siliguri', sans-serif", 'google' => 'Baloo+Da+2:wght@400;500;600;700'],
            'anek' => ['label' => 'Anek Bangla', 'stack' => "'Anek Bangla', 'Hind Siliguri', sans-serif", 'google' => 'Anek+Bangla:wght@400;500;600;700'],
            'tiro' => ['label' => 'Tiro Bangla', 'stack' => "'Tiro Bangla', 'Hind Siliguri', serif", 'google' => 'Tiro+Bangla'],
        ];
    }

    public static function font(string $id): array
    {
        return self::fonts()[$id] ?? self::fonts()['hind'];
    }

    public static function all(): array
    {
        return [
            'herbal' => [
                'bn' => 'হার্বাল গ্রিন', 'en' => 'Herbal Green',
                'primary' => '#059669', 'hover' => '#047857', 'dark' => '#064e3b', 'xdark' => '#022c22',
                'accent' => '#10b981', 'accentLight' => '#34d399',
                'lime' => '#84cc16', 'limeNeon' => '#a3e635', 'limeDeep' => '#65a30d',
                'teal' => '#14b8a6', 'tealLight' => '#5eead4',
            ],
            'spice' => [
                'bn' => 'মসলা অ্যাম্বার', 'en' => 'Spice Amber',
                'primary' => '#d97706', 'hover' => '#b45309', 'dark' => '#7c2d12', 'xdark' => '#431407',
                'accent' => '#ea580c', 'accentLight' => '#fb923c',
                'lime' => '#ca8a04', 'limeNeon' => '#fbbf24', 'limeDeep' => '#a16207',
                'teal' => '#dc2626', 'tealLight' => '#fca5a5',
            ],
            'chili' => [
                'bn' => 'চিলি রেড', 'en' => 'Chili Red',
                'primary' => '#dc2626', 'hover' => '#b91c1c', 'dark' => '#7f1d1d', 'xdark' => '#450a0a',
                'accent' => '#ef4444', 'accentLight' => '#f87171',
                'lime' => '#c2410c', 'limeNeon' => '#fb923c', 'limeDeep' => '#9a3412',
                'teal' => '#ea580c', 'tealLight' => '#fdba74',
            ],
            'mango' => [
                'bn' => 'ম্যাঙ্গো ফ্রেশ', 'en' => 'Mango Fresh',
                'primary' => '#ca8a04', 'hover' => '#a16207', 'dark' => '#713f12', 'xdark' => '#422006',
                'accent' => '#eab308', 'accentLight' => '#facc15',
                'lime' => '#84cc16', 'limeNeon' => '#a3e635', 'limeDeep' => '#65a30d',
                'teal' => '#65a30d', 'tealLight' => '#bef264',
            ],
            'jamun' => [
                'bn' => 'জামুন পার্পল', 'en' => 'Jamun Purple',
                'primary' => '#7c3aed', 'hover' => '#6d28d9', 'dark' => '#4c1d95', 'xdark' => '#2e1065',
                'accent' => '#8b5cf6', 'accentLight' => '#a78bfa',
                'lime' => '#c026d3', 'limeNeon' => '#e879f9', 'limeDeep' => '#a21caf',
                'teal' => '#9333ea', 'tealLight' => '#d8b4fe',
            ],
            'neel' => [
                'bn' => 'নীল ব্লু', 'en' => 'Neel Blue',
                'primary' => '#2563eb', 'hover' => '#1d4ed8', 'dark' => '#1e3a8a', 'xdark' => '#172554',
                'accent' => '#3b82f6', 'accentLight' => '#60a5fa',
                'lime' => '#0891b2', 'limeNeon' => '#22d3ee', 'limeDeep' => '#0e7490',
                'teal' => '#0ea5e9', 'tealLight' => '#7dd3fc',
            ],

            /* ---------- modern & stylish additions ---------- */

            'rose' => [
                'bn' => 'রোজ এলিগ্যান্স', 'en' => 'Rose Luxury',
                'primary' => '#e11d48', 'hover' => '#be123c', 'dark' => '#881337', 'xdark' => '#4c0519',
                'accent' => '#ec4899', 'accentLight' => '#f9a8d4',
                'lime' => '#fb7185', 'limeNeon' => '#fda4af', 'limeDeep' => '#9f1239',
                'teal' => '#db2777', 'tealLight' => '#fbcfe8',
            ],
            'indigo' => [
                'bn' => 'ইন্ডিগো নাইট', 'en' => 'Indigo Night',
                'primary' => '#6366f1', 'hover' => '#4f46e5', 'dark' => '#312e81', 'xdark' => '#1e1b4b',
                'accent' => '#8b5cf6', 'accentLight' => '#c4b5fd',
                'lime' => '#38bdf8', 'limeNeon' => '#7dd3fc', 'limeDeep' => '#4338ca',
                'teal' => '#0ea5e9', 'tealLight' => '#bae6fd',
            ],
            'aqua' => [
                'bn' => 'একোয়া মিন্ট', 'en' => 'Aqua Mint',
                'primary' => '#0d9488', 'hover' => '#0f766e', 'dark' => '#134e4a', 'xdark' => '#042f2e',
                'accent' => '#06b6d4', 'accentLight' => '#67e8f9',
                'lime' => '#84cc16', 'limeNeon' => '#a3e635', 'limeDeep' => '#115e59',
                'teal' => '#0891b2', 'tealLight' => '#a5f3fc',
            ],
            'slate' => [
                'bn' => 'স্লেট মিনিমাল', 'en' => 'Slate Minimal',
                'primary' => '#1e293b', 'hover' => '#0f172a', 'dark' => '#020617', 'xdark' => '#000000',
                'accent' => '#64748b', 'accentLight' => '#94a3b8',
                'lime' => '#10b981', 'limeNeon' => '#34d399', 'limeDeep' => '#334155',
                'teal' => '#475569', 'tealLight' => '#cbd5e1',
            ],
            'coffee' => [
                'bn' => 'কফি মোকা', 'en' => 'Coffee Mocha',
                'primary' => '#92400e', 'hover' => '#78350f', 'dark' => '#451a03', 'xdark' => '#1c0a03',
                'accent' => '#b45309', 'accentLight' => '#fbbf24',
                'lime' => '#ca8a04', 'limeNeon' => '#fcd34d', 'limeDeep' => '#713f12',
                'teal' => '#a16207', 'tealLight' => '#fde68a',
            ],
            'sunset' => [
                'bn' => 'সানসেট অরেঞ্জ', 'en' => 'Sunset Orange',
                'primary' => '#ea580c', 'hover' => '#c2410c', 'dark' => '#7c2d12', 'xdark' => '#431407',
                'accent' => '#f97316', 'accentLight' => '#fdba74',
                'lime' => '#facc15', 'limeNeon' => '#fde047', 'limeDeep' => '#9a3412',
                'teal' => '#ef4444', 'tealLight' => '#fca5a5',
            ],
            'fuchsia' => [
                'bn' => 'ফাকশিয়া পপ', 'en' => 'Fuchsia Pop',
                'primary' => '#c026d3', 'hover' => '#a21caf', 'dark' => '#701a75', 'xdark' => '#4a044e',
                'accent' => '#d946ef', 'accentLight' => '#f0abfc',
                'lime' => '#8b5cf6', 'limeNeon' => '#c084fc', 'limeDeep' => '#86198f',
                'teal' => '#9333ea', 'tealLight' => '#e9d5ff',
            ],

            /* ---------- Japanese-inspired ---------- */

            'sakura' => [
                'bn' => 'সাকুরা ব্লসম', 'en' => 'Sakura Blossom',
                'primary' => '#db2777', 'hover' => '#be185d', 'dark' => '#831843', 'xdark' => '#500724',
                'accent' => '#f472b6', 'accentLight' => '#fbcfe8',
                'lime' => '#84cc16', 'limeNeon' => '#bef264', 'limeDeep' => '#9d174d',
                'teal' => '#0d9488', 'tealLight' => '#99f6e4',
            ],
            'matcha' => [
                'bn' => 'মাচা গ্রিন', 'en' => 'Matcha Green',
                'primary' => '#588143', 'hover' => '#47682f', 'dark' => '#1b4332', 'xdark' => '#081c15',
                'accent' => '#a7c957', 'accentLight' => '#d9f99d',
                'lime' => '#80b918', 'limeNeon' => '#a3e635', 'limeDeep' => '#386641',
                'teal' => '#52796f', 'tealLight' => '#b7e4c7',
            ],
            'ai' => [
                'bn' => 'জাপানি ইন্ডিগো', 'en' => 'Ai Indigo',
                'primary' => '#274690', 'hover' => '#1e3a75', 'dark' => '#142a63', 'xdark' => '#0a1740',
                'accent' => '#5b8def', 'accentLight' => '#a5c3f7',
                'lime' => '#e63946', 'limeNeon' => '#ff6b6b', 'limeDeep' => '#182d66',
                'teal' => '#45689e', 'tealLight' => '#b9c9ea',
            ],
            'zen' => [
                'bn' => 'জেন আর্থ', 'en' => 'Zen Earth',
                'primary' => '#7c6a56', 'hover' => '#655544', 'dark' => '#3e332a', 'xdark' => '#221b15',
                'accent' => '#a8927c', 'accentLight' => '#d4c5b2',
                'lime' => '#9caf88', 'limeNeon' => '#c2d4ab', 'limeDeep' => '#5c4d3c',
                'teal' => '#857b6f', 'tealLight' => '#e3dccf',
            ],

            /* ---------- more modern picks ---------- */

            'ocean' => [
                'bn' => 'ওশান ডিপ', 'en' => 'Ocean Deep',
                'primary' => '#0369a1', 'hover' => '#075985', 'dark' => '#0c4a6e', 'xdark' => '#082f49',
                'accent' => '#0ea5e9', 'accentLight' => '#7dd3fc',
                'lime' => '#14b8a6', 'limeNeon' => '#5eead4', 'limeDeep' => '#0c4a6e',
                'teal' => '#06b6d4', 'tealLight' => '#a5f3fc',
            ],
            'nightgold' => [
                'bn' => 'নাইট গোল্ড', 'en' => 'Night Gold',
                'primary' => '#292524', 'hover' => '#1c1917', 'dark' => '#0c0a09', 'xdark' => '#000000',
                'accent' => '#ca8a04', 'accentLight' => '#fbbf24',
                'lime' => '#d4a437', 'limeNeon' => '#fcd34d', 'limeDeep' => '#57534e',
                'teal' => '#78716c', 'tealLight' => '#d6d3d1',
            ],

            /* ---------- Industry Preset themes ---------- */

            'restaurant' => [
                'bn' => 'রেস্টুরেন্ট অ্যাম্বার', 'en' => 'Restaurant Amber',
                'primary' => '#c2410c', 'hover' => '#9a3412', 'dark' => '#7c2d12', 'xdark' => '#431407',
                'accent' => '#ea580c', 'accentLight' => '#fdba74',
                'lime' => '#f59e0b', 'limeNeon' => '#fbbf24', 'limeDeep' => '#9a3412',
                'teal' => '#b91c1c', 'tealLight' => '#fecaca',
            ],
            'fashion' => [
                'bn' => 'ফ্যাশন ক্যারাকোল', 'en' => 'Fashion Charcoal',
                'primary' => '#1f2937', 'hover' => '#111827', 'dark' => '#0b1220', 'xdark' => '#060a12',
                'accent' => '#9d174d', 'accentLight' => '#f9a8d4',
                'lime' => '#d4a437', 'limeNeon' => '#e7c873', 'limeDeep' => '#713f12',
                'teal' => '#4b5563', 'tealLight' => '#e5e7eb',
            ],
            'beauty' => [
                'bn' => 'বিউটি রোজ প্লাম', 'en' => 'Beauty Rose Plum',
                'primary' => '#db2777', 'hover' => '#be185d', 'dark' => '#831843', 'xdark' => '#500724',
                'accent' => '#c026d3', 'accentLight' => '#f5d0fe',
                'lime' => '#f472b6', 'limeNeon' => '#fbcfe8', 'limeDeep' => '#9d174d',
                'teal' => '#a21caf', 'tealLight' => '#e9d5ff',
            ],
            'electronics' => [
                'bn' => 'ইলেকট্রনিক্স নেভি সায়ান', 'en' => 'Electronics Navy Cyan',
                'primary' => '#1d4ed8', 'hover' => '#1e40af', 'dark' => '#1e3a8a', 'xdark' => '#172554',
                'accent' => '#06b6d4', 'accentLight' => '#67e8f9',
                'lime' => '#22d3ee', 'limeNeon' => '#7dd3fc', 'limeDeep' => '#1e40af',
                'teal' => '#0891b2', 'tealLight' => '#a5f3fc',
            ],
            'jewelry' => [
                'bn' => 'জুয়েলারি গোল্ড চারকোল', 'en' => 'Jewelry Gold Charcoal',
                'primary' => '#a16207', 'hover' => '#854d0e', 'dark' => '#292524', 'xdark' => '#0c0a09',
                'accent' => '#d4a437', 'accentLight' => '#fcd34d',
                'lime' => '#e7c873', 'limeNeon' => '#fde68a', 'limeDeep' => '#78350f',
                'teal' => '#78716c', 'tealLight' => '#e7e5e4',
            ],
            'furniture' => [
                'bn' => 'ফার্নিচার উড ওলিভ', 'en' => 'Furniture Wood Olive',
                'primary' => '#8b5e34', 'hover' => '#6f4a28', 'dark' => '#4a3421', 'xdark' => '#2b1e13',
                'accent' => '#b08968', 'accentLight' => '#e6ccb8',
                'lime' => '#808c5c', 'limeNeon' => '#a3b18a', 'limeDeep' => '#5c4d3c',
                'teal' => '#857b6f', 'tealLight' => '#e3dccf',
            ],
            'healthcare' => [
                'bn' => 'হেলথকেয়ার মেডিক্যাল ব্লু', 'en' => 'Healthcare Medical Blue',
                'primary' => '#0284c7', 'hover' => '#0369a1', 'dark' => '#075985', 'xdark' => '#0c4a6e',
                'accent' => '#0ea5e9', 'accentLight' => '#7dd3fc',
                'lime' => '#14b8a6', 'limeNeon' => '#5eead4', 'limeDeep' => '#0c4a6e',
                'teal' => '#06b6d4', 'tealLight' => '#cffafe',
            ],
            'education' => [
                'bn' => 'এডুকেশন রয়্যাল ইন্ডিগো', 'en' => 'Education Royal Indigo',
                'primary' => '#4f46e5', 'hover' => '#4338ca', 'dark' => '#3730a3', 'xdark' => '#1e1b4b',
                'accent' => '#7c3aed', 'accentLight' => '#c4b5fd',
                'lime' => '#38bdf8', 'limeNeon' => '#7dd3fc', 'limeDeep' => '#312e81',
                'teal' => '#8b5cf6', 'tealLight' => '#ddd6fe',
            ],
            'travel' => [
                'bn' => 'ট্রাভেল ওশান সানসেট', 'en' => 'Travel Ocean Sunset',
                'primary' => '#0e7490', 'hover' => '#155e75', 'dark' => '#164e63', 'xdark' => '#083344',
                'accent' => '#f97316', 'accentLight' => '#fdba74',
                'lime' => '#14b8a6', 'limeNeon' => '#5eead4', 'limeDeep' => '#155e75',
                'teal' => '#0ea5e9', 'tealLight' => '#bae6fd',
            ],
        ];
    }

    public static function get(string $id): array
    {
        return self::all()[$id] ?? self::all()['herbal'];
    }

    /** Build a custom theme from 3 picked colors. */
    public static function custom(string $primary, string $dark, string $accent): array
    {
        return [
            'primary' => $primary,
            'hover' => self::shade($primary, -0.14),
            'dark' => $dark,
            'xdark' => self::shade($dark, -0.28),
            'accent' => $accent,
            'accentLight' => self::shade($accent, 0.32),
            'lime' => self::shade($primary, 0.18),
            'limeNeon' => self::shade($accent, 0.4),
            'limeDeep' => self::shade($primary, -0.2),
            'teal' => self::shade($accent, -0.12),
            'tealLight' => self::shade($accent, 0.5),
        ];
    }

    private static function shade(string $hex, float $pct): string
    {
        $h = ltrim($hex, '#');
        if (strlen($h) === 3) $h = $h[0] . $h[0] . $h[1] . $h[1] . $h[2] . $h[2];
        $n = hexdec($h);
        $r = ($n >> 16) & 255; $g = ($n >> 8) & 255; $b = $n & 255;
        $target = $pct > 0 ? 255 : 0;
        $p = abs($pct);
        $mix = fn ($c) => (int) round($c + ($target - $c) * $p);
        return sprintf('#%02x%02x%02x', $mix($r), $mix($g), $mix($b));
    }

    /* ================= History (undo) ================= */

    /** Push the currently saved theme onto the history stack (call BEFORE overwriting it). */
    public static function pushHistory(): void
    {
        $themeId = Setting::get('theme_id', '');
        $themeJson = Setting::get('theme_json', '');
        if ($themeId === '' || $themeJson === '') return;

        $history = self::history();
        if (!empty($history) && ($history[0]['theme_json'] ?? '') === $themeJson) return;

        array_unshift($history, [
            'theme_id' => $themeId,
            'theme_json' => $themeJson,
            'label' => self::labelFor($themeId, $themeJson),
            'at' => now('Asia/Dhaka')->format('d M, h:i A'),
        ]);

        Setting::set('theme_history', json_encode(array_slice($history, 0, self::MAX_HISTORY)));
    }

    public static function history(): array
    {
        return json_decode(Setting::get('theme_history', '[]'), true) ?: [];
    }

    /** Drop one entry from history by index (after it has been restored). */
    public static function forgetHistory(int $index): void
    {
        $history = self::history();
        if (!isset($history[$index])) return;
        unset($history[$index]);
        Setting::set('theme_history', json_encode(array_values($history)));
    }

    /* ================= My Themes (saved custom presets) ================= */

    public static function myThemes(): array
    {
        return json_decode(Setting::get('custom_themes', '[]'), true) ?: [];
    }

    public static function myTheme(string $id): ?array
    {
        foreach (self::myThemes() as $t) {
            if (($t['id'] ?? '') === $id) return $t;
        }
        return null;
    }

    /** Human-readable name of a saved theme (preset, my-theme or custom). */
    public static function labelFor(string $themeId, string $themeJson): string
    {
        if (str_starts_with($themeId, 'my_')) {
            $mine = self::myTheme($themeId);
            if ($mine) return $mine['name'];
        }
        $preset = self::all()[$themeId] ?? null;
        if ($preset) return $preset['bn'];

        // custom: try to identify by matching colors against presets
        $theme = json_decode($themeJson, true);
        if (is_array($theme)) {
            foreach (self::all() as $preset) {
                if (($preset['primary'] ?? '') === ($theme['primary'] ?? '')) return $preset['bn'];
            }
        }
        return 'কাস্টম রঙ';
    }

    /* ================= Festive auto-schedule ================= */

    /** All configured festive schedule rows. */
    public static function festiveSchedule(): array
    {
        return json_decode(Setting::get('festive_schedule', '[]'), true) ?: [];
    }

    /** The festive theme active today (Asia/Dhaka), or null. */
    public static function activeFestive(): ?array
    {
        $today = Carbon::today('Asia/Dhaka');
        foreach (self::festiveSchedule() as $row) {
            if (empty($row['enabled'])) continue;
            try {
                $start = Carbon::parse($row['start'], 'Asia/Dhaka')->startOfDay();
                $end = Carbon::parse($row['end'], 'Asia/Dhaka')->startOfDay();
            } catch (\Throwable) {
                continue;
            }
            if ($today->between($start, $end)) {
                $theme = json_decode($row['theme_json'] ?? '', true);
                if (is_array($theme)) {
                    return [
                        'theme' => $theme,
                        'label' => $row['label'] ?? 'উৎসব থিম',
                        'end' => $row['end'],
                    ];
                }
            }
        }
        return null;
    }
}
