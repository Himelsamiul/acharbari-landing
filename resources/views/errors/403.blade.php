<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অনুমতি নেই (403) — {{ ab_brand('bn') }}</title>
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?? 'assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            color: #12261d;
            background:
                radial-gradient(900px 500px at 85% -10%, rgba(16,185,129,.10), transparent 60%),
                radial-gradient(700px 400px at -10% 30%, rgba(163,230,53,.07), transparent 55%),
                color-mix(in srgb, var(--ds-primary, #059669) 7%, #f4f1ec);
            -webkit-font-smoothing: antialiased;
        }
        .e403-card {
            width: 100%;
            max-width: 520px;
            background: linear-gradient(180deg, #ffffff, #fdfcfa);
            border: 1px solid rgba(5,150,105,.13);
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(6,78,59,.04), 0 30px 70px -30px rgba(6,78,59,.45);
            padding: 40px 34px;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: cardIn .4s ease both;
        }
        @keyframes cardIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        .e403-card::before {
            content: "";
            position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, #dc2626, #f87171, #fbbf24);
        }
        .e403-ic {
            width: 76px; height: 76px; margin: 0 auto 18px;
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; color: #dc2626;
            background: linear-gradient(135deg, rgba(220,38,38,.12), rgba(220,38,38,.05));
            border: 1px solid rgba(220,38,38,.22);
        }
        .e403-code {
            font-size: 13px; font-weight: 800; letter-spacing: 3px;
            color: #dc2626; text-transform: uppercase;
        }
        h1 { margin: 8px 0 10px; font-size: 24px; }
        p.msg { margin: 0 auto 6px; font-size: 14px; color: #5f7a6d; line-height: 1.7; max-width: 400px; }
        p.hint { margin: 0 0 24px; font-size: 12px; color: #8b7355; }
        .e403-actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .a-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            border: none; cursor: pointer; font-family: inherit; text-decoration: none;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; font-weight: 800; font-size: 13.5px;
            padding: 12px 22px; border-radius: 12px;
            box-shadow: 0 12px 26px -10px rgba(5,150,105,.55);
            transition: transform .18s, box-shadow .25s;
        }
        .a-btn:hover { transform: translateY(-2px); box-shadow: 0 18px 34px -12px rgba(5,150,105,.65); }
        .a-btn.ghost {
            background: #fff; color: #1f4234;
            border: 1.5px solid rgba(5,150,105,.25);
            box-shadow: 0 3px 10px -6px rgba(6,78,59,.25);
        }
        .a-btn.ghost:hover { border-color: #059669; background: rgba(5,150,105,.06); }
    </style>
</head>

<body>
    <div class="e403-card">
        <div class="e403-ic"><i class="fa-solid fa-lock"></i></div>
        <div class="e403-code">403 — Forbidden</div>
        <h1>অনুমতি নেই</h1>
        <p class="msg">{{ $exception->getMessage() ?: 'এই পেজটি দেখার বা এই কাজটি করার অনুমতি আপনার অ্যাকাউন্টে নেই।' }}</p>
        <p class="hint">অনুমতি পেতে সুপার অ্যাডমিনের সাথে যোগাযোগ করুন।</p>
        <div class="e403-actions">
            @auth
                <a class="a-btn" href="{{ url(auth()->user()->isCustomer() ? '/account' : '/admin') }}"><i class="fa-solid fa-gauge-high"></i> ড্যাশবোর্ডে ফিরে যান</a>
            @else
                <a class="a-btn" href="{{ route('admin.login') }}"><i class="fa-solid fa-right-to-bracket"></i> লগইন করুন</a>
            @endauth
            <a class="a-btn ghost" href="{{ url('/') }}"><i class="fa-solid fa-house"></i> হোমপেজ</a>
        </div>
    </div>
</body>

</html>
