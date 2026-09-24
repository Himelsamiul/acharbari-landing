<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ড্যাশবোর্ড') — আচারবাড়ি Admin</title>
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css') }}">
    <style>
        :root { --admin-radius: 16px; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            background: color-mix(in srgb, var(--ds-primary, #059669) 7%, #f4f1ec);
            color: #12261d;
            -webkit-font-smoothing: antialiased;
        }
        .admin-shell { display: flex; min-height: 100vh; }
        .sidebar {
            width: 252px; flex-shrink: 0;
            background: linear-gradient(180deg, #064e3b, #022c22);
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
            background: rgba(255,255,255,.14);
            display: flex; align-items: center; justify-content: center;
            color: #a3e635; font-size: 18px;
            overflow: hidden;
        }
        .side-brand .logo-box img { width: 100%; height: 100%; object-fit: cover; }
        .side-brand b { font-size: 16px; }
        .side-brand span { display: block; font-size: 10.5px; opacity: .65; letter-spacing: 1.5px; }
        .side-nav { display: flex; flex-direction: column; gap: 4px; flex: 1; }
        .side-link {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,.78);
            text-decoration: none;
            font-size: 13.5px; font-weight: 600;
            padding: 11px 14px; border-radius: 12px;
            cursor: pointer; border: none; background: transparent;
            font-family: inherit; text-align: left;
            transition: background .2s, color .2s;
            width: 100%;
        }
        .side-link i { width: 18px; text-align: center; font-size: 15px; }
        .side-link:hover { background: rgba(255,255,255,.08); color: #fff; }
        .side-link.active { background: rgba(16,185,129,.28); color: #fff; box-shadow: inset 3px 0 0 #a3e635; }
        .side-foot { border-top: 1px solid rgba(255,255,255,.12); padding-top: 12px; }

        .main-wrap { flex: 1; padding: 24px 28px; max-width: 1160px; }
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 22px; gap: 14px; flex-wrap: wrap;
        }
        .topbar h2 { margin: 0; font-size: 21px; }
        .topbar p { margin: 2px 0 0; font-size: 12.5px; color: #8b7355; }
        .top-actions { display: flex; gap: 10px; align-items: center; }
        .avatar-chip {
            display: flex; align-items: center; gap: 9px;
            background: #fff; border: 1px solid rgba(5,150,105,.2);
            padding: 7px 13px 7px 8px; border-radius: 999px;
            font-size: 12.5px; font-weight: 700; color: #1f4234;
        }
        .avatar-chip .av {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px;
        }

        .card {
            background: #fff;
            border: 1px solid rgba(5,150,105,.14);
            border-radius: var(--admin-radius);
            box-shadow: 0 10px 30px -18px rgba(6,78,59,.35);
            padding: 20px;
            margin-bottom: 18px;
            animation: cardIn .4s ease both;
        }
        @keyframes cardIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
        .card h3 { margin: 0 0 4px; font-size: 15.5px; display: flex; align-items: center; gap: 8px; }
        .card h3 i { color: #059669; }
        .card p.desc { margin: 0 0 16px; font-size: 12.5px; color: #8b7355; }

        .page { display: block; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 215px), 1fr)); gap: 14px; margin-bottom: 18px; }
        .stat-card {
            background: #fff;
            border: 1px solid rgba(5,150,105,.14);
            border-radius: var(--admin-radius);
            padding: 16px 18px;
            position: relative; overflow: hidden;
            transition: transform .25s ease, box-shadow .3s ease;
        }
        .stat-card::before {
            content: "";
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #059669, #10b981);
            opacity: 0; transition: opacity .3s;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px -18px rgba(6,78,59,.4); }
        .stat-card:hover::before { opacity: 1; }
        .stat-card .ic {
            position: absolute; right: 14px; top: 14px;
            width: 38px; height: 38px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(16,185,129,.12); color: #059669; font-size: 16px;
        }
        .stat-card .lbl { font-size: 12px; color: #8b7355; font-weight: 600; }
        .stat-card .val { font-size: 24px; font-weight: 800; margin-top: 6px; color: #12261d; }
        .stat-card .chg { font-size: 11.5px; font-weight: 700; margin-top: 6px; color: #16a34a; }
        .stat-card .chg.mut { color: #8b7355; }

        .tbl { width: 100%; border-collapse: collapse; font-size: 13px; }
        .tbl th {
            text-align: left; font-size: 11px; letter-spacing: .8px; text-transform: uppercase;
            color: #8b7355; padding: 9px 10px;
            border-bottom: 2px solid rgba(5,150,105,.14);
        }
        .tbl td { padding: 11px 10px; border-bottom: 1px solid rgba(5,150,105,.08); }
        .tbl tbody tr { transition: background .2s; }
        .tbl tbody tr:hover { background: rgba(5,150,105,.05); }
        .tbl .pimg {
            width: 42px; height: 42px; border-radius: 10px; object-fit: cover;
            border: 1px solid rgba(5,150,105,.2);
            vertical-align: middle; margin-right: 10px; background: #fff;
        }
        .pill {
            display: inline-block; font-size: 11px; font-weight: 800;
            padding: 4px 12px; border-radius: 999px;
        }
        .pill.ok { background: rgba(22,163,74,.12); color: #16a34a; }
        .pill.wait { background: rgba(217,119,6,.14); color: #b45309; }
        .pill.mut { background: rgba(5,150,105,.08); color: #5f7a6d; }
        .pill.red { background: rgba(220,38,38,.1); color: #dc2626; }
        .pill.info { background: rgba(59,130,246,.12); color: #2563eb; }

        .status-select {
            border: 1.5px solid rgba(5,150,105,.3);
            border-radius: 10px; padding: 7px 10px;
            font-family: inherit; font-size: 12.5px; font-weight: 700;
            background: rgba(5,150,105,.05); color: #1f4234;
            cursor: pointer; outline: none;
        }
        .btn-icon {
            border: none; cursor: pointer; font-family: inherit;
            background: rgba(220,38,38,.08); color: #dc2626;
            width: 34px; height: 34px; border-radius: 10px;
            transition: background .2s, transform .15s;
        }
        .btn-icon:hover { background: #dc2626; color: #fff; transform: scale(1.05); }

        .note-banner {
            display: flex; gap: 10px; align-items: flex-start;
            background: rgba(5,150,105,.08);
            border: 1px dashed rgba(5,150,105,.35);
            border-radius: 12px; padding: 12px 14px;
            font-size: 12.5px; color: #1f4234;
            margin-bottom: 18px;
        }
        .note-banner i { color: #059669; margin-top: 2px; }

        .toast {
            position: fixed; bottom: 26px; left: 50%; transform: translateX(-50%) translateY(20px);
            background: #12261d; color: #fff;
            padding: 12px 22px; border-radius: 999px;
            font-size: 13px; font-weight: 700;
            opacity: 0; pointer-events: none;
            transition: all .3s ease;
            z-index: 90;
            box-shadow: 0 18px 40px -12px rgba(0,0,0,.4);
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
        .filter-tab {
            text-decoration: none;
            font-size: 12px; font-weight: 700;
            padding: 7px 16px; border-radius: 999px;
            background: rgba(5,150,105,.07); color: #1f4234;
            border: 1.5px solid rgba(5,150,105,.15);
            transition: all .2s;
        }
        .filter-tab:hover { border-color: #059669; }
        .filter-tab.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-color: transparent; }
        .filter-tab b { opacity: .7; font-weight: 700; }

        .alert-success {
            background: rgba(22,163,74,.1);
            border: 1px solid rgba(22,163,74,.3);
            color: #16a34a;
            border-radius: 12px; padding: 12px 16px;
            font-size: 13px; font-weight: 700;
            margin-bottom: 18px;
        }

        @media (max-width: 900px) {
            .sidebar { display: none; }
            .main-wrap { padding: 14px; }
            .card { overflow-x: auto; }
            .tbl { min-width: 560px; }
            .mobile-nav { display: flex !important; }
        }
        .mobile-nav {
            display: none; gap: 6px; overflow-x: auto; margin-bottom: 16px; padding-bottom: 4px;
        }
        .mobile-nav .side-link {
            white-space: nowrap; width: auto;
            background: #fff; color: #1f4234;
            border: 1px solid rgba(5,150,105,.2);
        }
        .mobile-nav .side-link.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; }
    </style>
</head>

<body>
    <div class="admin-shell">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="side-brand">
                <div class="logo-box"><i class="fa-solid fa-jar"></i></div>
                <div>
                    <b>আচারবাড়ি</b>
                    <span>ADMIN PANEL</span>
                </div>
            </div>

            <nav class="side-nav">
                <div class="side-group-label">সাধারণ</div>
                <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high"></i> ড্যাশবোর্ড</a>
                <a class="side-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-boxes-stacked"></i> অর্ডারসমূহ</a>
                <a class="side-link {{ request()->routeIs('admin.products') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-jar"></i> প্রোডাক্ট</a>

                <div class="side-group-label">অ্যাকাউন্ট</div>
                <a class="side-link" href="{{ url('/') }}" target="_blank"><i class="fa-solid fa-globe"></i> সাইট দেখুন</a>
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
                <div>
                    <h2>@yield('page_title', 'ড্যাশবোর্ড')</h2>
                    <p>@yield('page_sub', 'আচারবাড়ি অ্যাডমিন প্যানেল')</p>
                </div>
                <div class="top-actions">
                    <a class="side-link" style="background:#fff;color:#1f4234;border-radius:12px" href="{{ url('/') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> সাইট দেখুন</a>
                    <div class="avatar-chip"><span class="av">AD</span> {{ auth()->user()->name ?? 'Admin' }} <i class="fa-solid fa-circle" style="font-size:7px;color:#16a34a"></i></div>
                </div>
            </div>

            <nav class="mobile-nav">
                <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high"></i> ড্যাশবোর্ড</a>
                <a class="side-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-boxes-stacked"></i> অর্ডার</a>
                <a class="side-link {{ request()->routeIs('admin.products') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-jar"></i> প্রোডাক্ট</a>
            </nav>

            @if (session('success'))
                <div class="alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <div class="toast" id="toast"><i class="fa-solid fa-circle-check"></i> <span id="toastText"></span></div>
    <script>
        function showToast(msg) {
            var t = document.getElementById('toast');
            document.getElementById('toastText').textContent = msg;
            t.classList.add('show');
            setTimeout(function () { t.classList.remove('show'); }, 2400);
        }
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function () { showToast(@js(session('success'))); });
        @endif
    </script>
</body>

</html>
