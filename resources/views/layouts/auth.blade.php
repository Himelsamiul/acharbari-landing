<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'অ্যাকাউন্ট') — {{ ab_brand('bn') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?? 'assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @include('partials.theme-vars')
    <link rel="stylesheet" href="{{ asset_v('assets/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        body.ab-auth-body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            font-family: var(--ds-font-body, 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif);
            color: #12261d;
            background:
                radial-gradient(900px 500px at 85% -10%, rgba(16, 185, 129, .12), transparent 60%),
                radial-gradient(700px 400px at -10% 30%, rgba(163, 230, 53, .10), transparent 55%),
                color-mix(in srgb, var(--ds-primary, #059669) 8%, #f4f1ec);
            -webkit-font-smoothing: antialiased;
        }
        .ab-auth-card {
            width: 100%;
            max-width: 460px;
            background: linear-gradient(180deg, #ffffff, #fdfcfa);
            border: 1px solid rgba(5, 150, 105, .14);
            border-radius: 24px;
            box-shadow: 0 2px 4px rgba(6, 78, 59, .04), 0 34px 80px -34px rgba(6, 78, 59, .5);
            padding: 36px 30px;
            position: relative;
            overflow: hidden;
            animation: abAuthIn .4s ease both;
        }
        @keyframes abAuthIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        .ab-auth-card::before {
            content: "";
            position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--ds-primary, #059669), #10b981, var(--ds-lime-neon, #a3e635));
        }
        .ab-auth-logo {
            width: 58px; height: 58px;
            margin: 0 auto 14px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--ds-primary, #059669), #10b981);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 24px;
            box-shadow: 0 14px 30px -10px rgba(5, 150, 105, .55);
            overflow: hidden;
        }
        .ab-auth-logo img { width: 100%; height: 100%; object-fit: cover; }
        .ab-auth-card h1 { text-align: center; margin: 0 0 6px; font-size: 22px; font-weight: 800; }
        .ab-auth-card p.sub { text-align: center; margin: 0 0 22px; font-size: 13px; color: #8b7355; }
        .ab-field { margin-bottom: 14px; }
        .ab-field label { display: block; font-size: 12.5px; font-weight: 700; margin-bottom: 6px; color: #1f4234; }
        .ab-input {
            width: 100%;
            background: #fff;
            border: 1.5px solid rgba(5, 150, 105, .22);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: inherit;
            color: #12261d;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .ab-input::placeholder { color: #a8b8af; }
        .ab-input:focus { border-color: var(--ds-primary, #059669); box-shadow: 0 0 0 4px rgba(5, 150, 105, .12); }
        .ab-input.err { border-color: #dc2626; }
        .ab-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%;
            border: none; cursor: pointer; font-family: inherit;
            background: linear-gradient(135deg, var(--ds-primary, #059669), #10b981);
            color: #fff; font-weight: 800; font-size: 15px;
            padding: 13px; border-radius: 12px;
            box-shadow: 0 14px 30px -12px rgba(5, 150, 105, .6);
            transition: transform .15s, filter .2s;
            text-decoration: none;
        }
        .ab-btn:hover { transform: translateY(-1px); filter: brightness(1.06); }
        .ab-btn.ghost {
            background: #fff; color: #1f4234;
            border: 1.5px solid rgba(5, 150, 105, .25);
            box-shadow: 0 3px 10px -6px rgba(6, 78, 59, .25);
            font-size: 13.5px; font-weight: 700;
        }
        .ab-auth-err {
            background: rgba(220, 38, 38, .08);
            border: 1px solid rgba(220, 38, 38, .3);
            color: #dc2626;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 14px;
        }
        .ab-auth-ok {
            background: rgba(22, 163, 74, .1);
            border: 1px solid rgba(22, 163, 74, .3);
            color: #15803d;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 14px;
        }
        .ab-auth-foot { text-align: center; margin-top: 18px; font-size: 13px; color: #5f7a6d; }
        .ab-auth-foot a { color: var(--ds-primary, #059669); font-weight: 700; text-decoration: none; }
        .ab-auth-foot a:hover { text-decoration: underline; }
        .ab-auth-back {
            position: fixed; top: 18px; left: 18px;
            display: inline-flex; align-items: center; gap: 7px;
            background: #fff; color: #1f4234; text-decoration: none;
            border: 1px solid rgba(5, 150, 105, .2);
            padding: 9px 15px; border-radius: 999px;
            font-size: 12.5px; font-weight: 700;
            box-shadow: 0 8px 20px -10px rgba(6, 78, 59, .3);
            transition: transform .15s;
        }
        .ab-auth-back:hover { transform: translateY(-2px); }
        .ab-auth-note { font-size: 11.5px; color: #8b7355; margin-top: 8px; text-align: center; }
        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; font-size: 12.5px; color: #4b5f54; font-weight: 600; }
        .remember-row input { accent-color: var(--ds-primary, #059669); width: 15px; height: 15px; }
        input[type="checkbox"].ab-check { accent-color: var(--ds-primary, #059669); width: 16px; height: 16px; }
    </style>
</head>

<body class="ab-auth-body">
    <a class="ab-auth-back" href="{{ url('/') }}">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
        {{ ab_brand('bn') }} হোম
    </a>

    <div class="ab-auth-card">
        <div class="ab-auth-logo">
            @if (!empty($settings['logo_path']))
                <img src="{{ asset($settings['logo_path']) }}" alt="logo">
            @else
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
            @endif
        </div>
        @yield('content')
    </div>
</body>

</html>
