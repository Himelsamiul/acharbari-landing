<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'সুপার অ্যাডমিন') — {{ ab_brand('bn') }} Super Admin</title>
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?? 'assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css') }}">
    <style>
        :root { --super-accent: #6d28d9; --super-accent-2: #8b5cf6; --super-glow: #fbbf24; --admin-radius: 16px; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            background:
                radial-gradient(900px 500px at 85% -10%, rgba(139,92,246,.12), transparent 60%),
                radial-gradient(700px 400px at -10% 30%, rgba(251,191,36,.07), transparent 55%),
                color-mix(in srgb, var(--super-accent) 6%, #f6f4fb);
            background-attachment: fixed;
            color: #1e1b2e;
            -webkit-font-smoothing: antialiased;
        }
        .admin-shell { display: flex; min-height: 100vh; }
        .sidebar {
            width: 252px; flex-shrink: 0;
            background: linear-gradient(180deg, #1e1b4b, #170f33);
            color: #fff;
            display: flex; flex-direction: column;
            padding: 22px 14px;
            position: sticky; top: 0; height: 100vh;
            overflow-y: auto;
        }
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 99px; }
        .side-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 4px 8px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            margin-bottom: 16px;
        }
        .side-brand .logo-box {
            width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--super-accent), var(--super-accent-2));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 17px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.2);
        }
        .side-brand .logo-box img { width: 100%; height: 100%; object-fit: cover; }
        .side-brand b { font-size: 16px; }
        .side-brand span { display: block; font-size: 10.5px; opacity: .65; letter-spacing: 1.5px; }
        .super-badge {
            display: inline-flex; align-items: center; gap: 6px;
            margin: 0 4px 16px; padding: 9px 12px; border-radius: 12px;
            background: rgba(251,191,36,.10); border: 1px solid rgba(251,191,36,.30);
            color: #fde68a; font-size: 11px; font-weight: 800; letter-spacing: 1.2px;
        }
        .super-badge i { color: var(--super-glow); }
        .side-nav { display: flex; flex-direction: column; gap: 4px; flex: 1; }
        .side-link {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,.78);
            text-decoration: none;
            font-size: 13.5px; font-weight: 600;
            padding: 11px 14px; border-radius: 12px;
            cursor: pointer; border: none; background: transparent;
            font-family: inherit; text-align: left;
            transition: background .2s, color .2s, transform .15s, box-shadow .2s;
            width: 100%;
        }
        .side-link i { width: 18px; text-align: center; font-size: 15px; transition: transform .2s, color .2s; }
        .side-link:hover { background: rgba(255,255,255,.09); color: #fff; transform: translateX(3px); }
        .side-link:hover i { transform: scale(1.12); }
        .side-link.active {
            background: linear-gradient(135deg, rgba(139,92,246,.42), rgba(109,40,217,.20));
            color: #fff;
            box-shadow: inset 3px 0 0 var(--super-glow), 0 8px 20px -10px rgba(139,92,246,.55);
        }
        .side-link.active i { color: #fde68a; }
        .side-foot { border-top: 1px solid rgba(255,255,255,.12); padding-top: 12px; }
        .side-group-label {
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            color: rgba(255,255,255,.38);
            padding: 16px 14px 6px;
        }
        .side-group-label:first-child { padding-top: 4px; }

        .main-wrap { flex: 1; padding: 24px 28px; min-width: 0; }
        .topbar {
            position: sticky; top: 0; z-index: 40;
            display: flex; align-items: center; justify-content: space-between;
            margin: -24px -28px 22px; padding: 16px 28px;
            gap: 14px; flex-wrap: wrap;
            background: rgba(246, 244, 251, .82);
            backdrop-filter: blur(14px) saturate(150%);
            -webkit-backdrop-filter: blur(14px) saturate(150%);
            border-bottom: 1px solid rgba(109,40,217,.12);
        }
        .topbar-title { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .menu-btn {
            display: none;
            border: 1px solid rgba(109,40,217,.2);
            background: #fff; color: #3b2f63;
            width: 40px; height: 40px; border-radius: 12px;
            font-size: 15px; cursor: pointer; flex-shrink: 0;
            align-items: center; justify-content: center;
            transition: background .2s, color .2s;
        }
        .menu-btn:hover { background: var(--super-accent); color: #fff; }
        .topbar h2 { margin: 0; font-size: 21px; }
        .topbar p { margin: 2px 0 0; font-size: 12.5px; color: #6d5f8a; }
        .top-actions { display: flex; gap: 10px; align-items: center; }
        .avatar-chip {
            display: flex; align-items: center; gap: 9px;
            background: #fff; border: 1px solid rgba(109,40,217,.2);
            padding: 6px 14px 6px 7px; border-radius: 999px;
            font-size: 12.5px; font-weight: 700; color: #3b2f63;
            box-shadow: 0 6px 16px -8px rgba(30,27,75,.3);
            transition: box-shadow .2s, border-color .2s;
        }
        .avatar-chip .av {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--super-accent), var(--super-accent-2));
            color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px;
            box-shadow: 0 0 0 2.5px #fff, 0 0 0 4px rgba(139,92,246,.35);
        }
        .role-pill {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 10px; font-weight: 800; letter-spacing: .8px;
            padding: 4px 10px; border-radius: 999px;
            background: rgba(251,191,36,.14); color: #b45309;
            border: 1px solid rgba(251,191,36,.35);
        }

        .card {
            background: linear-gradient(180deg, #ffffff, #fdfcff);
            border: 1px solid rgba(109,40,217,.13);
            border-radius: var(--admin-radius);
            box-shadow: 0 2px 4px rgba(30,27,75,.04), 0 14px 34px -20px rgba(30,27,75,.35);
            padding: 20px;
            margin-bottom: 18px;
            position: relative;
            animation: cardIn .4s ease both;
            transition: box-shadow .3s ease, border-color .3s ease;
        }
        .card:hover { box-shadow: 0 4px 8px rgba(30,27,75,.05), 0 22px 44px -22px rgba(30,27,75,.42); }
        @keyframes cardIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
        .card h3 { margin: 0 0 4px; font-size: 15.5px; display: flex; align-items: center; gap: 8px; }
        .card h3 i {
            color: var(--super-accent);
            width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px;
            background: linear-gradient(135deg, rgba(139,92,246,.16), rgba(109,40,217,.08));
        }
        .card p.desc { margin: 0 0 16px; font-size: 12.5px; color: #6d5f8a; }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 215px), 1fr)); gap: 14px; margin-bottom: 18px; }
        .stat-card {
            background: linear-gradient(160deg, #ffffff 30%, #f9f7ff);
            border: 1px solid rgba(109,40,217,.13);
            border-radius: var(--admin-radius);
            padding: 16px 18px;
            position: relative; overflow: hidden;
            transition: transform .25s ease, box-shadow .3s ease, border-color .3s;
        }
        .stat-card::before {
            content: "";
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #6d28d9, #8b5cf6, #fbbf24);
            background-size: 200% 100%;
            opacity: 0; transition: opacity .3s;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 20px 44px -18px rgba(30,27,75,.42); border-color: rgba(109,40,217,.28); }
        .stat-card:hover::before { opacity: 1; animation: gradSlide 2.2s ease infinite; }
        @keyframes gradSlide { 0%,100% { background-position: 0% 0; } 50% { background-position: 100% 0; } }
        .stat-card .ic {
            position: absolute; right: 14px; top: 14px;
            width: 40px; height: 40px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(139,92,246,.18), rgba(109,40,217,.1));
            color: var(--super-accent); font-size: 16px;
            border: 1px solid rgba(139,92,246,.2);
            transition: transform .25s;
        }
        .stat-card:hover .ic { transform: scale(1.1) rotate(-5deg); }
        .stat-card .lbl { font-size: 11.5px; color: #6d5f8a; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; }
        .stat-card .val { font-size: 26px; font-weight: 800; margin-top: 6px; color: #1e1b2e; letter-spacing: -.5px; }
        .stat-card .chg { font-size: 11.5px; font-weight: 700; margin-top: 6px; color: var(--super-accent); }
        .stat-card .chg.mut { color: #6d5f8a; }
        .stat-card .chg.red { color: #dc2626; }

        .tbl { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; }
        .tbl th {
            text-align: left; font-size: 10.5px; letter-spacing: 1px; text-transform: uppercase;
            color: #7a7394; padding: 10px;
            background: linear-gradient(180deg, rgba(109,40,217,.06), rgba(109,40,217,.02));
            border-bottom: 2px solid rgba(109,40,217,.14);
        }
        .tbl th:first-child { border-radius: 10px 0 0 0; }
        .tbl th:last-child { border-radius: 0 10px 0 0; }
        .tbl td { padding: 11px 10px; border-bottom: 1px solid rgba(109,40,217,.08); }
        .tbl tbody tr { transition: background .18s; }
        .tbl tbody tr:hover { background: rgba(139,92,246,.06); }
        .pill {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 800;
            padding: 4px 12px; border-radius: 999px;
            border: 1px solid transparent;
        }
        .pill::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .pill.ok { background: rgba(22,163,74,.1); color: #15803d; border-color: rgba(22,163,74,.22); }
        .pill.mut { background: rgba(109,40,217,.06); color: #5f5a78; border-color: rgba(109,40,217,.15); }
        .pill.red { background: rgba(220,38,38,.08); color: #dc2626; border-color: rgba(220,38,38,.2); }
        .pill.gold { background: rgba(251,191,36,.14); color: #b45309; border-color: rgba(251,191,36,.35); }
        .pill.violet { background: rgba(139,92,246,.12); color: #6d28d9; border-color: rgba(139,92,246,.25); }

        .alert-success {
            display: flex; align-items: center; gap: 10px;
            background: linear-gradient(135deg, rgba(22,163,74,.12), rgba(16,185,129,.06));
            border: 1px solid rgba(22,163,74,.32);
            color: #15803d;
            border-radius: 13px; padding: 12px 16px;
            font-size: 13px; font-weight: 700;
            margin-bottom: 18px;
            animation: cardIn .35s ease both;
        }
        .alert-success i {
            width: 26px; height: 26px; border-radius: 8px; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center; font-size: 12px;
            background: rgba(22,163,74,.15);
        }
        .alert-error {
            display: flex; align-items: center; gap: 10px;
            background: rgba(220,38,38,.08);
            border: 1px solid rgba(220,38,38,.28);
            color: #dc2626;
            border-radius: 13px; padding: 12px 16px;
            font-size: 13px; font-weight: 700;
            margin-bottom: 18px;
        }
        .err-inline { color: #dc2626; font-weight: 700; font-size: 13px; margin-bottom: 12px; }

        .note-banner {
            display: flex; gap: 12px; align-items: flex-start;
            background: linear-gradient(135deg, rgba(109,40,217,.09), rgba(139,92,246,.05));
            border: 1px dashed rgba(109,40,217,.4);
            border-radius: 14px; padding: 13px 16px;
            font-size: 12.5px; color: #3b2f63;
            margin-bottom: 18px;
        }
        .note-banner i {
            color: var(--super-accent); margin-top: 2px; flex-shrink: 0;
            width: 28px; height: 28px; border-radius: 9px;
            display: inline-flex; align-items: center; justify-content: center; font-size: 12px;
            background: rgba(109,40,217,.12);
        }

        /* ---- Shared form styles ---- */
        .a-field { margin-bottom: 4px; }
        .a-field label {
            display: block; font-size: 12px; font-weight: 700;
            margin-bottom: 6px; color: #3b2f63;
        }
        .a-input {
            width: 100%;
            background: #fff;
            border: 1.5px solid rgba(109,40,217,.22);
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 13.5px;
            font-family: inherit;
            color: #1e1b2e;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .a-input::placeholder { color: #b0a8c8; }
        .a-input:hover { border-color: rgba(109,40,217,.4); }
        .a-input:focus { border-color: var(--super-accent); box-shadow: 0 0 0 4px rgba(139,92,246,.14); background: #fefeff; }
        select.a-input { cursor: pointer; }
        input[type="checkbox"] { accent-color: var(--super-accent); width: 16px; height: 16px; cursor: pointer; }
        .a-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            border: none; cursor: pointer; font-family: inherit; text-decoration: none;
            background: linear-gradient(135deg, var(--super-accent), var(--super-accent-2));
            color: #fff; font-weight: 800; font-size: 13.5px;
            padding: 12px 22px; border-radius: 12px;
            box-shadow: 0 12px 26px -10px rgba(109,40,217,.55), inset 0 1px 0 rgba(255,255,255,.25);
            transition: transform .18s, box-shadow .25s, filter .2s;
        }
        .a-btn i { transition: transform .2s; }
        .a-btn:hover { transform: translateY(-2px); filter: brightness(1.08); box-shadow: 0 18px 34px -12px rgba(109,40,217,.65); }
        .a-btn:active { transform: translateY(0) scale(.98); }
        .a-btn.ghost {
            background: #fff; color: #3b2f63;
            border: 1.5px solid rgba(109,40,217,.25);
            box-shadow: 0 3px 10px -6px rgba(30,27,75,.25);
        }
        .a-btn.ghost:hover { border-color: var(--super-accent); background: rgba(109,40,217,.06); }
        .a-btn.gold {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            box-shadow: 0 12px 26px -10px rgba(217,119,6,.55);
        }
        .a-btn.red {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            box-shadow: 0 12px 26px -10px rgba(220,38,38,.55);
        }
        .btn-mini {
            display: inline-flex; align-items: center; gap: 6px;
            border: 1.5px solid rgba(109,40,217,.25); cursor: pointer; font-family: inherit; text-decoration: none;
            background: #fff; color: #3b2f63; font-weight: 700; font-size: 12px;
            padding: 7px 13px; border-radius: 10px;
            transition: all .2s;
        }
        .btn-mini:hover { border-color: var(--super-accent); background: rgba(109,40,217,.06); transform: translateY(-1px); }
        .btn-mini.red { border-color: rgba(220,38,38,.3); background: rgba(220,38,38,.06); color: #dc2626; }
        .btn-mini.red:hover { background: rgba(220,38,38,.12); }
        .fgrid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 12px 14px; }
        .side-overlay {
            display: none;
            position: fixed; inset: 0; z-index: 98;
            background: rgba(23, 15, 51, .55);
            backdrop-filter: blur(3px);
        }

        /* ---- Permission matrix ---- */
        .pm-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 250px), 1fr)); gap: 12px; }
        .pm-card {
            border: 1.5px solid rgba(109,40,217,.16);
            border-radius: 14px; padding: 14px;
            background: linear-gradient(180deg, #fff, #fbfaff);
            transition: border-color .2s, box-shadow .2s;
        }
        .pm-card:hover { border-color: rgba(109,40,217,.35); box-shadow: 0 10px 24px -14px rgba(30,27,75,.3); }
        .pm-head { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding-bottom: 10px; margin-bottom: 10px; border-bottom: 1px dashed rgba(109,40,217,.2); }
        .pm-head b { font-size: 13px; color: #1e1b2e; }
        .pm-all { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: var(--super-accent); cursor: pointer; user-select: none; }
        .pm-row { display: flex; align-items: center; gap: 9px; padding: 5px 2px; font-size: 12.5px; color: #4b4463; cursor: pointer; border-radius: 8px; }
        .pm-row:hover { background: rgba(139,92,246,.07); }

        .preset-row { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }

        @media (max-width: 900px) {
            .menu-btn { display: inline-flex; }
            .side-overlay { display: block; pointer-events: none; }
            .sidebar {
                position: fixed; left: 0; top: 0; z-index: 100;
                width: 272px; height: 100dvh;
                transform: translateX(-102%);
                transition: transform .32s cubic-bezier(.32,.72,.28,1);
                box-shadow: 0 0 60px rgba(0,0,0,.35);
                padding-top: 16px;
            }
            .sidebar.open { transform: translateX(0); }
            .side-overlay.show { opacity: 1; pointer-events: auto; }
            body.drawer-open { overflow: hidden; }
            .topbar { margin: 0 -14px 16px; padding: 12px 14px; border-radius: 0 0 18px 18px; }
            .topbar h2 { font-size: 18px; }
            .main-wrap { padding: 14px; }
            .card { overflow-x: auto; padding: 16px 14px; }
            .tbl { min-width: 560px; }
            .stat-card .val { font-size: 21px; }
        }
        @media (max-width: 420px) {
            .stat-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card { padding: 13px 14px; }
            .stat-card .ic { width: 32px; height: 32px; font-size: 13px; }
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="admin-shell">
        <div class="side-overlay" id="sideOverlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="adminSidebar">
            <div class="side-brand">
                <div class="logo-box">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div>
                    <b>{{ ab_brand('bn') }}</b>
                    <span>SUPER ADMIN</span>
                </div>
            </div>

            <div class="super-badge"><i class="fa-solid fa-shield-halved"></i> PLATFORM OWNER</div>

            <nav class="side-nav">
                <div class="side-group-label">সুপার অ্যাডমিন</div>
                <a class="side-link {{ request()->routeIs('super.overview') ? 'active' : '' }}" href="{{ route('super.overview') }}"><i class="fa-solid fa-chart-pie"></i> ওভারভিউ</a>
                <a class="side-link {{ request()->routeIs('super.orders*') ? 'active' : '' }}" href="{{ route('super.orders.index') }}"><i class="fa-solid fa-palette"></i> ল্যান্ডিং অর্ডার</a>
                <a class="side-link {{ request()->routeIs('super.admins*') ? 'active' : '' }}" href="{{ route('super.admins.index') }}"><i class="fa-solid fa-user-shield"></i> অ্যাডমিন ইউজার্স</a>

                <div class="side-group-label">কুইক লিংক</div>
                <a class="side-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high"></i> অ্যাডমিন ড্যাশবোর্ড</a>
                <a class="side-link" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-boxes-stacked"></i> সব অর্ডার</a>
                <a class="side-link" href="{{ route('admin.settings.theme') }}"><i class="fa-solid fa-industry"></i> ইন্ডাস্ট্রি প্রিসেট</a>
                <a class="side-link" href="{{ url('/') }}" target="_blank" rel="noopener"><i class="fa-solid fa-globe"></i> ল্যান্ডিং পেজ দেখুন</a>
            </nav>

            <div class="side-foot">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="side-link"><i class="fa-solid fa-right-from-bracket"></i> লগআউট</button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="main-wrap">
            <div class="topbar">
                <div class="topbar-title">
                    <button class="menu-btn" id="menuBtn" aria-label="মেনু"><i class="fa-solid fa-bars"></i></button>
                    <div>
                        <h2>@yield('page_title', 'সুপার অ্যাডমিন')</h2>
                        <p>@yield('page_sub', 'প্ল্যাটফর্ম কন্ট্রোল প্যানেল')</p>
                    </div>
                </div>
                <div class="top-actions">
                    <span class="role-pill"><i class="fa-solid fa-crown"></i> SUPER ADMIN</span>
                    <div class="avatar-chip"><span class="av">SA</span> {{ auth()->user()->name ?? 'Super Admin' }} <i class="fa-solid fa-circle" style="font-size:7px;color:#f59e0b"></i></div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif
            @if (session('errors') && session('errors')->first('admin'))
                <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('errors')->first('admin') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        /* ===== SweetAlert2 global helpers (toast + confirm) — same API as the admin panel ===== */
        var SW_TOKEN = document.querySelector('meta[name="csrf-token"]');
        function showToast(msg, icon) {
            Swal.fire({
                toast: true, position: 'bottom-end', icon: icon || 'success',
                title: msg, showConfirmButton: false, timer: 2600, timerProgressBar: true
            });
        }
        function swConfirm(opts) {
            var o = typeof opts === 'string' ? { title: opts } : (opts || {});
            return Swal.fire({
                title: o.title || 'আপনি নিশ্চিত?',
                text: o.text || '',
                icon: o.icon || 'warning',
                showCancelButton: true,
                confirmButtonText: o.confirmText || 'হ্যাঁ, নিশ্চিত',
                cancelButtonText: o.cancelText || 'বাতিল',
                confirmButtonColor: '#6d28d9',
                cancelButtonColor: '#9ca3af',
                reverseButtons: true
            }).then(function (r) { return r.isConfirmed; });
        }
        /* delete-form helper: async Swal confirm then real submit (bypasses this handler) */
        function swConfirmSubmit(e, title, text) {
            e.preventDefault();
            var form = e.target;
            swConfirm({ title: title, text: text || '' }).then(function (ok) {
                if (ok) { form.onsubmit = null; form.submit(); }
            });
            return false;
        }
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function () { showToast(@js(session('success'))); });
        @endif
        (function () {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('sideOverlay');
            var btn = document.getElementById('menuBtn');
            function setDrawer(open) {
                sidebar.classList.toggle('open', open);
                overlay.classList.toggle('show', open);
                document.body.classList.toggle('drawer-open', open);
            }
            if (btn) btn.addEventListener('click', function () { setDrawer(!sidebar.classList.contains('open')); });
            if (overlay) overlay.addEventListener('click', function () { setDrawer(false); });
            sidebar.querySelectorAll('.side-link').forEach(function (a) {
                a.addEventListener('click', function () { setDrawer(false); });
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setDrawer(false);
            });
        })();
    </script>
    @stack('scripts')
</body>

</html>
