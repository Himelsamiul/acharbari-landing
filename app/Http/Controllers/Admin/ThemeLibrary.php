<?php

namespace App\Http\Controllers\Admin;

class ThemeLibrary
{
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
}
