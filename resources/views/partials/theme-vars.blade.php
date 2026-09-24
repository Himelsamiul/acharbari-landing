{{-- theme variables from admin settings (DB) --}}
@php
    $theme = json_decode(\App\Models\Setting::get('theme_json', ''), true);
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
</style>
@endif
