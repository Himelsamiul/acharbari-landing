{{-- theme variables from admin settings (DB) --}}
@php
    // base theme from DB — a festive schedule row (if active today) overrides it
    $theme = json_decode(\App\Models\Setting::get('theme_json', ''), true);
    $festive = \App\Http\Controllers\Admin\ThemeLibrary::activeFestive();
    if ($festive) {
        $theme = $festive['theme'];
    }

    // fonts picked in admin (body font stack falls back to Hind Siliguri for Bengali glyphs)
    $fontBody = \App\Http\Controllers\Admin\ThemeLibrary::font(\App\Models\Setting::get('font_body', 'jakarta'));
    $fontHeadingId = \App\Models\Setting::get('font_heading', '');
    $fontHeading = $fontHeadingId !== '' ? \App\Http\Controllers\Admin\ThemeLibrary::font($fontHeadingId) : null;

    // style tokens (corner / shadow intensity)
    $styleRadius = \App\Models\Setting::get('style_radius', 'default');
    $styleShadow = \App\Models\Setting::get('style_shadow', 'default');
@endphp
@if (is_array($theme))
<style>
    :root {
        --ds-primary: {{ $theme['primary'] }};
        --ds-primary-hover: {{ $theme['hover'] }};
        --ds-primary-dark: {{ $theme['dark'] }};
        --ds-primary-xdark: {{ $theme['xdark'] }};
        --ds-accent: {{ $theme['accent'] }};
        --ds-accent-light: {{ $theme['accentLight'] }};
        --ds-lime: {{ $theme['lime'] }};
        --ds-lime-neon: {{ $theme['limeNeon'] }};
        --ds-lime-deep: {{ $theme['limeDeep'] }};
        --ds-teal: {{ $theme['teal'] }};
        --ds-teal-light: {{ $theme['tealLight'] }};
    }

    @if ($styleRadius === 'sharp')
    :root {
        --ds-radius-sm: 4px;
        --ds-radius-md: 8px;
        --ds-radius-lg: 12px;
        --ds-radius-xl: 16px;
        --ds-radius-full: 10px;
    }
    @elseif ($styleRadius === 'rounded')
    :root {
        --ds-radius-sm: 12px;
        --ds-radius-md: 20px;
        --ds-radius-lg: 28px;
        --ds-radius-xl: 36px;
    }
    @endif

    @if ($styleShadow === 'soft')
    :root {
        --ds-shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.03);
        --ds-shadow-sm: 0 2px 8px -2px rgba(6, 78, 59, 0.05);
        --ds-shadow-md: 0 6px 18px -8px rgba(6, 78, 59, 0.08);
        --ds-shadow-lg: 0 12px 30px -12px rgba(6, 78, 59, 0.12);
        --ds-shadow-glow: 0 0 20px rgba(16, 185, 129, 0.2);
    }
    @elseif ($styleShadow === 'strong')
    :root {
        --ds-shadow-xs: 0 2px 6px rgba(0, 0, 0, 0.07);
        --ds-shadow-sm: 0 8px 22px -4px rgba(6, 78, 59, 0.16);
        --ds-shadow-md: 0 18px 42px -8px rgba(6, 78, 59, 0.22);
        --ds-shadow-lg: 0 28px 70px -12px rgba(6, 78, 59, 0.3);
        --ds-shadow-glow: 0 0 55px rgba(16, 185, 129, 0.5);
    }
    @endif

    body {
        font-family: {!! $fontBody['stack'] !!};
    }

    @if ($fontHeading)
    h1, h2, h3, h4, h5, h6 {
        font-family: {!! $fontHeading['stack'] !!};
    }
    @endif
</style>
@endif
