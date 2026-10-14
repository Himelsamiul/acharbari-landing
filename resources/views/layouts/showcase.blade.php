<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('showcase.title_bn') }} — {{ config('showcase.title_en') }}</title>
    <meta name="description" content="{{ config('showcase.description') }}">
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css') }}">

    {{-- own neutral tokens — the global theme-vars partial is intentionally
         NOT included so this page never moves with the store's theme --}}
    <link rel="stylesheet" href="{{ asset_v('assets/showcase.css') }}">

    <script>
        try {
            if ((localStorage.getItem('ab_lang') || 'bn') === 'en') {
                document.documentElement.setAttribute('lang', 'en');
            }
        } catch (e) { }
    </script>
    <script>window.AB_MODE = 'server';</script>
</head>

<body class="sc-body">
    @yield('content')

    <script src="{{ asset_v('assets/brand.js') }}" defer></script>
    <script src="{{ asset_v('assets/showcase.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.AB) AB.applyLang();
        });
    </script>
</body>
</html>
