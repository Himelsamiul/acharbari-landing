<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ড্যাশবোর্ড') — আচারবাড়ি Admin</title>
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?: 'assets/img/favicon.svg') }}" type="image/svg+xml">
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
            background:
                radial-gradient(900px 500px at 85% -10%, rgba(16,185,129,.10), transparent 60%),
                radial-gradient(700px 400px at -10% 30%, rgba(163,230,53,.07), transparent 55%),
                color-mix(in srgb, var(--ds-primary, #059669) 7%, #f4f1ec);
            background-attachment: fixed;
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
            transition: background .2s, color .2s, transform .15s, box-shadow .2s;
            width: 100%;
        }
        .side-link i { width: 18px; text-align: center; font-size: 15px; transition: transform .2s, color .2s; }
        .side-link:hover { background: rgba(255,255,255,.09); color: #fff; transform: translateX(3px); }
        .side-link:hover i { transform: scale(1.12); }
        .side-link.active {
            background: linear-gradient(135deg, rgba(16,185,129,.38), rgba(5,150,105,.18));
            color: #fff;
            box-shadow: inset 3px 0 0 #a3e635, 0 8px 20px -10px rgba(16,185,129,.55);
        }
        .side-link.active i { color: #a3e635; }
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
        .draft-tag {
            margin-left: auto;
            font-size: 8.5px;
            font-weight: 800;
            letter-spacing: .5px;
            padding: 2px 7px;
            border-radius: 999px;
            background: rgba(251,191,36,.18);
            color: #fbbf24;
            border: 1px solid rgba(251,191,36,.35);
        }

        .main-wrap { flex: 1; padding: 24px 28px; min-width: 0; }
        .topbar {
            position: sticky; top: 0; z-index: 40;
            display: flex; align-items: center; justify-content: space-between;
            margin: -24px -28px 22px; padding: 16px 28px;
            gap: 14px; flex-wrap: wrap;
            background: rgba(244, 241, 236, .82);
            backdrop-filter: blur(14px) saturate(150%);
            -webkit-backdrop-filter: blur(14px) saturate(150%);
            border-bottom: 1px solid rgba(5,150,105,.10);
        }
        .topbar-title { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .menu-btn {
            display: none;
            border: 1px solid rgba(5,150,105,.2);
            background: #fff; color: #1f4234;
            width: 40px; height: 40px; border-radius: 12px;
            font-size: 15px; cursor: pointer; flex-shrink: 0;
            align-items: center; justify-content: center;
            transition: background .2s, color .2s;
        }
        .menu-btn:hover { background: #059669; color: #fff; }
        .topbar h2 { margin: 0; font-size: 21px; }
        .topbar p { margin: 2px 0 0; font-size: 12.5px; color: #8b7355; }
        .top-actions { display: flex; gap: 10px; align-items: center; }
        .avatar-chip {
            display: flex; align-items: center; gap: 9px;
            background: #fff; border: 1px solid rgba(5,150,105,.2);
            padding: 6px 14px 6px 7px; border-radius: 999px;
            font-size: 12.5px; font-weight: 700; color: #1f4234;
            box-shadow: 0 6px 16px -8px rgba(6,78,59,.3);
            transition: box-shadow .2s, border-color .2s;
        }
        .avatar-chip:hover { box-shadow: 0 10px 22px -10px rgba(6,78,59,.4); border-color: rgba(5,150,105,.4); }
        .avatar-chip .av {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px;
            box-shadow: 0 0 0 2.5px #fff, 0 0 0 4px rgba(16,185,129,.35);
        }

        .card {
            background: linear-gradient(180deg, #ffffff, #fdfcfa);
            border: 1px solid rgba(5,150,105,.13);
            border-radius: var(--admin-radius);
            box-shadow: 0 2px 4px rgba(6,78,59,.04), 0 14px 34px -20px rgba(6,78,59,.35);
            padding: 20px;
            margin-bottom: 18px;
            position: relative;
            animation: cardIn .4s ease both;
            transition: box-shadow .3s ease, border-color .3s ease;
        }
        .card:hover { box-shadow: 0 4px 8px rgba(6,78,59,.05), 0 22px 44px -22px rgba(6,78,59,.42); }
        @keyframes cardIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
        .card h3 { margin: 0 0 4px; font-size: 15.5px; display: flex; align-items: center; gap: 8px; }
        .card h3 i {
            color: #059669;
            width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 13px;
            background: linear-gradient(135deg, rgba(16,185,129,.16), rgba(5,150,105,.08));
        }
        .card p.desc { margin: 0 0 16px; font-size: 12.5px; color: #8b7355; }

        .page { display: block; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 215px), 1fr)); gap: 14px; margin-bottom: 18px; }
        .stat-card {
            background: linear-gradient(160deg, #ffffff 30%, #f6fbf8);
            border: 1px solid rgba(5,150,105,.13);
            border-radius: var(--admin-radius);
            padding: 16px 18px;
            position: relative; overflow: hidden;
            transition: transform .25s ease, box-shadow .3s ease, border-color .3s;
        }
        .stat-card::before {
            content: "";
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #059669, #10b981, #a3e635);
            background-size: 200% 100%;
            opacity: 0; transition: opacity .3s;
        }
        .stat-card::after {
            content: "";
            position: absolute; right: -34px; top: -34px;
            width: 110px; height: 110px; border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,.12), transparent 70%);
            pointer-events: none;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 20px 44px -18px rgba(6,78,59,.42); border-color: rgba(5,150,105,.28); }
        .stat-card:hover::before { opacity: 1; animation: gradSlide 2.2s ease infinite; }
        @keyframes gradSlide { 0%,100% { background-position: 0% 0; } 50% { background-position: 100% 0; } }
        .stat-card .ic {
            position: absolute; right: 14px; top: 14px;
            width: 40px; height: 40px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(16,185,129,.18), rgba(5,150,105,.1));
            color: #047857; font-size: 16px;
            border: 1px solid rgba(16,185,129,.2);
            transition: transform .25s;
        }
        .stat-card:hover .ic { transform: scale(1.1) rotate(-5deg); }
        .stat-card .lbl { font-size: 11.5px; color: #8b7355; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; }
        .stat-card .val { font-size: 26px; font-weight: 800; margin-top: 6px; color: #12261d; letter-spacing: -.5px; }
        .stat-card .chg { font-size: 11.5px; font-weight: 700; margin-top: 6px; color: #16a34a; }
        .stat-card .chg.mut { color: #8b7355; }

        .tbl { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; }
        .tbl th {
            text-align: left; font-size: 10.5px; letter-spacing: 1px; text-transform: uppercase;
            color: #7a8f84; padding: 10px;
            background: linear-gradient(180deg, rgba(5,150,105,.06), rgba(5,150,105,.02));
            border-bottom: 2px solid rgba(5,150,105,.14);
        }
        .tbl th:first-child { border-radius: 10px 0 0 0; }
        .tbl th:last-child { border-radius: 0 10px 0 0; }
        .tbl td { padding: 11px 10px; border-bottom: 1px solid rgba(5,150,105,.08); }
        .tbl tbody tr { transition: background .18s, transform .15s; }
        .tbl tbody tr:hover { background: rgba(16,185,129,.06); }
        .tbl .pimg {
            width: 42px; height: 42px; border-radius: 11px; object-fit: cover;
            border: 1px solid rgba(5,150,105,.2); box-shadow: 0 4px 10px -4px rgba(6,78,59,.3);
            vertical-align: middle; margin-right: 10px; background: #fff;
            transition: transform .2s;
        }
        .tbl .pimg:hover { transform: scale(1.08); }
        .pill {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; font-weight: 800;
            padding: 4px 12px; border-radius: 999px;
            border: 1px solid transparent;
        }
        .pill::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .pill.ok { background: rgba(22,163,74,.1); color: #15803d; border-color: rgba(22,163,74,.22); }
        .pill.wait { background: rgba(217,119,6,.1); color: #b45309; border-color: rgba(217,119,6,.22); }
        .pill.mut { background: rgba(5,150,105,.06); color: #5f7a6d; border-color: rgba(5,150,105,.15); }
        .pill.red { background: rgba(220,38,38,.08); color: #dc2626; border-color: rgba(220,38,38,.2); }
        .pill.info { background: rgba(59,130,246,.1); color: #2563eb; border-color: rgba(59,130,246,.22); }

        .status-select {
            border: 1.5px solid rgba(5,150,105,.28);
            border-radius: 10px; padding: 7px 10px;
            font-family: inherit; font-size: 12.5px; font-weight: 700;
            background: #fff; color: #1f4234;
            cursor: pointer; outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .status-select:hover { border-color: #059669; }
        .status-select:focus { border-color: #059669; box-shadow: 0 0 0 4px rgba(5,150,105,.12); }
        .btn-icon {
            border: 1px solid rgba(220,38,38,.18); cursor: pointer; font-family: inherit;
            background: rgba(220,38,38,.07); color: #dc2626;
            width: 34px; height: 34px; border-radius: 10px;
            transition: background .2s, transform .15s, box-shadow .2s;
        }
        .btn-icon:hover { background: linear-gradient(135deg, #dc2626, #ef4444); color: #fff; transform: translateY(-2px); box-shadow: 0 10px 20px -8px rgba(220,38,38,.5); }
        .btn-icon:active { transform: translateY(0); }

        .note-banner {
            display: flex; gap: 12px; align-items: flex-start;
            background: linear-gradient(135deg, rgba(5,150,105,.09), rgba(16,185,129,.05));
            border: 1px dashed rgba(5,150,105,.4);
            border-radius: 14px; padding: 13px 16px;
            font-size: 12.5px; color: #1f4234;
            margin-bottom: 18px;
        }
        .note-banner i {
            color: #059669; margin-top: 2px; flex-shrink: 0;
            width: 28px; height: 28px; border-radius: 9px;
            display: inline-flex; align-items: center; justify-content: center; font-size: 12px;
            background: rgba(5,150,105,.12);
        }

        .toast {
            position: fixed; bottom: 26px; left: 50%;
            transform: translateX(-50%) translateY(24px) scale(.95);
            background: linear-gradient(135deg, #0d2b20, #064e3b);
            color: #fff;
            padding: 13px 24px; border-radius: 999px;
            font-size: 13px; font-weight: 700;
            border: 1px solid rgba(163,230,53,.3);
            opacity: 0; pointer-events: none;
            transition: all .35s cubic-bezier(.32,.72,.28,1);
            z-index: 90;
            box-shadow: 0 20px 50px -12px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.08);
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0) scale(1); }
        .toast i { color: #a3e635; margin-right: 4px; }

        .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
        .filter-tab {
            text-decoration: none;
            font-size: 12px; font-weight: 700;
            padding: 8px 17px; border-radius: 999px;
            background: #fff; color: #1f4234;
            border: 1.5px solid rgba(5,150,105,.16);
            box-shadow: 0 3px 10px -5px rgba(6,78,59,.2);
            transition: all .2s;
        }
        .filter-tab:hover { border-color: #059669; transform: translateY(-2px); box-shadow: 0 8px 18px -8px rgba(6,78,59,.35); }
        .filter-tab.active {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; border-color: transparent;
            box-shadow: 0 10px 22px -8px rgba(5,150,105,.55);
        }
        .filter-tab b { opacity: .65; font-weight: 700; }

        /* ---- Shared form styles ---- */
        .a-field { margin-bottom: 4px; }
        .a-field label {
            display: block; font-size: 12px; font-weight: 700;
            margin-bottom: 6px; color: #1f4234;
        }
        .a-input {
            width: 100%;
            background: #fff;
            border: 1.5px solid rgba(5,150,105,.22);
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 13.5px;
            font-family: inherit;
            color: #12261d;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .a-input::placeholder { color: #a8b8af; }
        .a-input:hover { border-color: rgba(5,150,105,.4); }
        .a-input:focus { border-color: #059669; box-shadow: 0 0 0 4px rgba(5,150,105,.12); background: #fdfffe; }
        textarea.a-input { resize: vertical; min-height: 44px; }
        select.a-input { cursor: pointer; appearance: none; -webkit-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 14px center; padding-right: 38px; }
        input.a-input[type="file"] { padding: 9px 12px; cursor: pointer; border-style: dashed; background: rgba(5,150,105,.03); }
        input.a-input[type="file"]:hover { background: rgba(5,150,105,.06); }
        input[type="checkbox"] { accent-color: #059669; width: 16px; height: 16px; cursor: pointer; }
        .a-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            border: none; cursor: pointer; font-family: inherit;
            background: linear-gradient(135deg, #059669, #10b981);
            background-size: 150% 150%; background-position: 0% 0%;
            color: #fff; font-weight: 800; font-size: 13.5px;
            padding: 12px 22px; border-radius: 12px;
            box-shadow: 0 12px 26px -10px rgba(5,150,105,.55), inset 0 1px 0 rgba(255,255,255,.25);
            transition: transform .18s, box-shadow .25s, background-position .35s;
            text-decoration: none;
            position: relative; overflow: hidden;
        }
        .a-btn i { transition: transform .2s; }
        .a-btn:hover { transform: translateY(-2px); background-position: 100% 0%; box-shadow: 0 18px 34px -12px rgba(5,150,105,.65), inset 0 1px 0 rgba(255,255,255,.25); }
        .a-btn:hover i { transform: scale(1.15); }
        .a-btn:active { transform: translateY(0) scale(.98); }
        .a-btn.ghost {
            background: #fff; color: #1f4234;
            border: 1.5px solid rgba(5,150,105,.25);
            box-shadow: 0 3px 10px -6px rgba(6,78,59,.25);
        }
        .a-btn.ghost:hover { border-color: #059669; background: rgba(5,150,105,.06); box-shadow: 0 10px 22px -10px rgba(6,78,59,.35); }
        .fgrid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 12px 14px; }

        /* landing-content repeaters */
        .rep { display: flex; flex-direction: column; gap: 8px; }
        .rep-row { display: flex; gap: 8px; align-items: flex-start; }
        .rep-row-block { border: 1.5px dashed rgba(5,150,105,.25); border-radius: 14px; padding: 12px; background: rgba(5,150,105,.02); }
        .rep-row-block .rep-line { display: flex; gap: 8px; margin-bottom: 8px; }
        .rep-row-block .rep-line:last-child { margin-bottom: 0; }
        .rep-row .a-input { flex: 1; }
        .rep-del { flex-shrink: 0; margin-top: 4px; }
        .content-img-preview { width: 100%; height: 110px; object-fit: cover; border-radius: 12px; margin-bottom: 8px; border: 1.5px solid rgba(5,150,105,.18); }
        @media (max-width: 640px) {
            .rep-row, .rep-row-block .rep-line { flex-direction: column; }
            .rep-del { margin-top: 0; align-self: flex-end; }
        }

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

        .side-overlay {
            display: none;
            position: fixed; inset: 0; z-index: 98;
            background: rgba(2, 26, 20, .55);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            opacity: 0; transition: opacity .3s ease;
        }

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
            .topbar {
                margin: 0 -14px 16px; padding: 12px 14px;
                border-radius: 0 0 18px 18px;
            }
            .topbar h2 { font-size: 18px; }
            .topbar .top-actions .side-link { display: none; }
            .avatar-chip { padding: 5px 10px 5px 6px; font-size: 11.5px; }
            .avatar-chip .av { width: 26px; height: 26px; font-size: 10.5px; }
            .main-wrap { padding: 14px; }
            .card { overflow-x: auto; padding: 16px 14px; }
            .tbl { min-width: 560px; }
            .stat-card .val { font-size: 21px; }
            .mobile-nav { display: flex !important; }
        }
        @media (max-width: 420px) {
            .stat-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card { padding: 13px 14px; }
            .stat-card .ic { width: 32px; height: 32px; font-size: 13px; }
            .avatar-chip span:not(.av) { display: none; }
        }
        .mobile-nav {
            display: none; gap: 6px; overflow-x: auto; margin-bottom: 16px; padding-bottom: 4px;
            -webkit-overflow-scrolling: touch; scrollbar-width: none;
        }
        .mobile-nav::-webkit-scrollbar { display: none; }
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
        <div class="side-overlay" id="sideOverlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="adminSidebar">
            <div class="side-brand">
                <div class="logo-box">
                    @if (!empty($settings['logo_path']))
                        <img src="{{ asset($settings['logo_path']) }}" alt="logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">
                    @else
                        <i class="fa-solid fa-jar"></i>
                    @endif
                </div>
                <div>
                    <b>আচারবাড়ি</b>
                    <span>ADMIN PANEL</span>
                </div>
            </div>

            <nav class="side-nav">
                <div class="side-group-label">সাধারণ</div>
                <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high"></i> ড্যাশবোর্ড</a>
                <a class="side-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-boxes-stacked"></i> অর্ডারসমূহ
                    @php $pendingOrders = \App\Models\Order::where('status', 'pending')->count(); @endphp
                    @if ($pendingOrders > 0)<span class="draft-tag" style="background:rgba(220,38,38,.18);color:#fca5a5;border-color:rgba(220,38,38,.4)">{{ $pendingOrders }} নতুন</span>@endif
                </a>
                <a class="side-link {{ request()->routeIs('admin.module', request()->route('module') === 'customers') ? 'active' : '' }}" href="{{ route('admin.module', 'customers') }}"><i class="fa-solid fa-users"></i> গ্রাহক <span class="draft-tag">ড্রাফট</span></a>
                <a class="side-link {{ request()->routeIs('admin.complaints') ? 'active' : '' }}" href="{{ route('admin.complaints') }}"><i class="fa-solid fa-triangle-exclamation"></i> কমপ্লেইন
                    @php $openComplaints = \App\Models\Complaint::where('is_resolved', false)->count(); @endphp
                    @if ($openComplaints > 0)<span class="draft-tag" style="background:rgba(220,38,38,.18);color:#fca5a5;border-color:rgba(220,38,38,.4)">{{ $openComplaints }} নতুন</span>@endif
                </a>
                <a class="side-link {{ request()->route('module') === 'suppliers' ? 'active' : '' }}" href="{{ route('admin.module', 'suppliers') }}"><i class="fa-solid fa-truck-field"></i> সাপ্লায়ার <span class="draft-tag">ড্রাফট</span></a>
                <a class="side-link {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-jar"></i> প্রোডাক্ট</a>
                <a class="side-link {{ request()->routeIs('admin.taxonomy') ? 'active' : '' }}" href="{{ route('admin.taxonomy') }}"><i class="fa-solid fa-layer-group"></i> ক্যাটাগরি ও ব্র্যান্ড</a>
                <a class="side-link {{ request()->routeIs('admin.coupons') ? 'active' : '' }}" href="{{ route('admin.coupons') }}"><i class="fa-solid fa-ticket"></i> কুপন</a>
                <a class="side-link {{ request()->route('module') === 'reviews' ? 'active' : '' }}" href="{{ route('admin.module', 'reviews') }}"><i class="fa-solid fa-star"></i> রিভিউ <span class="draft-tag">ড্রাফট</span></a>

                <div class="side-group-label">মার্কেটিং ও ট্র্যাকিং</div>
                <a class="side-link {{ request()->route('module') === 'payments' ? 'active' : '' }}" href="{{ route('admin.module', 'payments') }}"><i class="fa-solid fa-credit-card"></i> পেমেন্ট গেটওয়ে <span class="draft-tag">ড্রাফট</span></a>
                <a class="side-link {{ request()->routeIs('admin.settings.tracking') ? 'active' : '' }}" href="{{ route('admin.settings.tracking') }}"><i class="fa-solid fa-bullhorn"></i> ট্র্যাকিং ও পিক্সেল</a>

                <div class="side-group-label">সাইট সাজানো</div>
                <a class="side-link {{ request()->routeIs('admin.settings.content') ? 'active' : '' }}" href="{{ route('admin.settings.content') }}"><i class="fa-solid fa-pen-to-square"></i> ল্যান্ডিং কনটেন্ট</a>
                <a class="side-link {{ request()->routeIs('admin.settings.brand') ? 'active' : '' }}" href="{{ route('admin.settings.brand') }}"><i class="fa-solid fa-jar"></i> লোগো ও ব্র্যান্ড</a>
                <a class="side-link {{ request()->routeIs('admin.settings.theme') ? 'active' : '' }}" href="{{ route('admin.settings.theme') }}"><i class="fa-solid fa-palette"></i> থিম কালার</a>

                <div class="side-group-label">SEO</div>
                <a class="side-link {{ request()->routeIs('admin.seo') ? 'active' : '' }}" href="{{ route('admin.seo') }}"><i class="fa-solid fa-magnifying-glass-chart"></i> SEO Settings</a>
                <a class="side-link {{ request()->routeIs('admin.robots') ? 'active' : '' }}" href="{{ route('admin.robots') }}"><i class="fa-solid fa-robot"></i> robots.txt</a>
                <a class="side-link {{ request()->routeIs('admin.redirects.*') ? 'active' : '' }}" href="{{ route('admin.redirects.index') }}"><i class="fa-solid fa-rotate"></i> 301 Redirects</a>
                <a class="side-link {{ request()->routeIs('admin.sitemap') ? 'active' : '' }}" href="{{ route('admin.sitemap') }}"><i class="fa-solid fa-sitemap"></i> Sitemap</a>

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
                <div class="topbar-title">
                    <button class="menu-btn" id="menuBtn" aria-label="মেনু"><i class="fa-solid fa-bars"></i></button>
                    <div>
                        <h2>@yield('page_title', 'ড্যাশবোর্ড')</h2>
                        <p>@yield('page_sub', 'আচারবাড়ি অ্যাডমিন প্যানেল')</p>
                    </div>
                </div>
                <div class="top-actions">
                    <a class="side-link" style="background:#fff;color:#1f4234;border-radius:12px" href="{{ url('/') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> সাইট দেখুন</a>
                    <div class="avatar-chip"><span class="av">AD</span> {{ auth()->user()->name ?? 'Admin' }} <i class="fa-solid fa-circle" style="font-size:7px;color:#16a34a"></i></div>
                </div>
            </div>

            <nav class="mobile-nav">
                <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high"></i> ড্যাশবোর্ড</a>
                <a class="side-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-boxes-stacked"></i> অর্ডার</a>
                <a class="side-link {{ request()->routeIs('admin.complaints') ? 'active' : '' }}" href="{{ route('admin.complaints') }}"><i class="fa-solid fa-triangle-exclamation"></i> কমপ্লেইন</a>
                <a class="side-link {{ request()->routeIs('admin.taxonomy') ? 'active' : '' }}" href="{{ route('admin.taxonomy') }}"><i class="fa-solid fa-layer-group"></i> ক্যাটাগরি</a>
                <a class="side-link {{ request()->routeIs('admin.products') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-jar"></i> প্রোডাক্ট</a>
                <a class="side-link" href="{{ route('admin.module', 'customers') }}"><i class="fa-solid fa-users"></i> গ্রাহক</a>
                <a class="side-link" href="{{ route('admin.module', 'seo') }}"><i class="fa-solid fa-magnifying-glass-chart"></i> SEO</a>
                <a class="side-link" href="{{ route('admin.module', 'payments') }}"><i class="fa-solid fa-credit-card"></i> পেমেন্ট</a>
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
