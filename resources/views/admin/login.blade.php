<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#064e3b">
    <title>অ্যাডমিন লগইন — {{ ab_brand('bn') }}</title>
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?? 'assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome.min.css') }}">
    <style>
        :root {
            --g-950: #011a14;
            --g-900: #022c22;
            --g-800: #064e3b;
            --g-700: #047857;
            --g-600: #059669;
            --g-500: #10b981;
            --lime: #a3e635;
            --ink: #0f241b;
            --muted: #5b7266;
            --line: #d9e3de;
            --field: #f6f8f7;
            --cream: #f4f1ec;
            --danger: #b91c1c;
            --radius: 14px;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            color: var(--ink);
            background: #fff;
            -webkit-font-smoothing: antialiased;
        }
        .auth {
            min-height: 100vh;
            min-height: 100dvh;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
        }

        /* ===== Brand pane ===== */
        .brand-pane {
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(700px 480px at 0% 0%, rgba(16, 185, 129, .28), transparent 60%),
                radial-gradient(600px 420px at 100% 100%, rgba(110, 231, 183, .10), transparent 60%),
                linear-gradient(155deg, var(--g-800) 0%, var(--g-900) 55%, var(--g-950) 100%);
        }
        .brand-pane.has-banner { background: var(--g-900); }
        .brand-bg {
            position: absolute; inset: 0; z-index: 0;
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .brand-ov {
            position: absolute; inset: 0; z-index: 0;
            background: linear-gradient(160deg, rgba(2, 44, 34, .93), rgba(2, 44, 34, .74) 50%, rgba(6, 78, 59, .9));
        }
        /* dot grid */
        .brand-pane::before {
            content: "";
            position: absolute; inset: 0; z-index: 1;
            background-image: radial-gradient(rgba(255, 255, 255, .09) 1px, transparent 1.3px);
            background-size: 22px 22px;
            -webkit-mask-image: radial-gradient(ellipse 80% 70% at 30% 40%, #000 25%, transparent 75%);
            mask-image: radial-gradient(ellipse 80% 70% at 30% 40%, #000 25%, transparent 75%);
            pointer-events: none;
        }
        /* soft rings */
        .brand-pane::after {
            content: "";
            position: absolute; z-index: 1;
            width: 620px; height: 620px;
            right: -230px; bottom: -270px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .09);
            box-shadow: 0 0 0 70px rgba(255, 255, 255, .025), 0 0 0 140px rgba(255, 255, 255, .018);
            pointer-events: none;
        }
        .brand-inner {
            position: relative; z-index: 2;
            min-height: 100%;
            display: flex; flex-direction: column; justify-content: space-between; gap: 40px;
            padding: 44px clamp(28px, 4.5vw, 64px);
            max-width: 660px;
        }
        .brand-top { display: flex; align-items: center; gap: 12px; }
        .brand-logo {
            width: 48px; height: 48px; flex-shrink: 0;
            border-radius: 14px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            display: flex; align-items: center; justify-content: center;
            color: var(--lime); font-size: 20px;
            overflow: hidden;
        }
        .brand-logo img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 3px; }
        .brand-top b { display: block; font-size: 18px; font-weight: 700; line-height: 1.3; }
        .brand-top span { display: block; font-size: 10.5px; font-weight: 700; letter-spacing: 2px; opacity: .62; }
        .brand-copy h2 {
            margin: 0 0 16px;
            font-size: clamp(30px, 3.1vw, 44px);
            line-height: 1.3;
            font-weight: 700;
        }
        .brand-copy h2 span {
            background: linear-gradient(90deg, var(--lime), #6ee7b7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .brand-copy p {
            margin: 0 0 32px;
            max-width: 470px;
            font-size: 15.5px; line-height: 1.75;
            color: rgba(255, 255, 255, .72);
        }
        .brand-features { list-style: none; margin: 0; padding: 0; display: grid; gap: 12px; max-width: 470px; }
        .brand-features li {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
        }
        .brand-features .ic {
            width: 42px; height: 42px; flex-shrink: 0;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(16, 185, 129, .38), rgba(163, 230, 53, .2));
            color: #d9f99d; font-size: 16px;
        }
        .brand-features b { display: block; font-size: 14.5px; font-weight: 600; }
        .brand-features small { display: block; margin-top: 2px; font-size: 12.5px; color: rgba(255, 255, 255, .62); }
        .brand-foot { font-size: 12px; color: rgba(255, 255, 255, .5); }

        /* ===== Form pane ===== */
        .form-pane {
            display: flex; flex-direction: column; align-items: center;
            padding: 40px 32px 28px;
            background:
                radial-gradient(520px 320px at 100% 0%, rgba(16, 185, 129, .07), transparent 70%),
                #fff;
        }
        .form-card { width: 100%; max-width: 410px; margin: auto 0; }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 6px 12px;
            border-radius: 999px;
            background: #ecfdf5; border: 1px solid #d1fae5;
            color: var(--g-700); font-size: 12px; font-weight: 700;
        }
        .form-card h1 { margin: 16px 0 6px; font-size: 30px; font-weight: 700; line-height: 1.3; }
        .form-card .lead-text { margin: 0 0 28px; font-size: 14.5px; color: var(--muted); }
        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 20px; padding: 12px 14px;
            border-radius: 12px;
            background: #fef2f2; border: 1px solid #fecaca;
            color: var(--danger); font-size: 13.5px; font-weight: 600; line-height: 1.55;
        }
        .alert i { margin-top: 3px; }
        .field { margin-bottom: 18px; }
        .field > label { display: block; margin-bottom: 8px; font-size: 13.5px; font-weight: 600; }
        .control { position: relative; }
        .control .lead {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: #8aa197; font-size: 15px;
            pointer-events: none;
            transition: color .2s;
        }
        .control input {
            width: 100%; height: 52px;
            padding: 0 16px 0 46px;
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            background: var(--field);
            font: inherit; font-size: 15px; color: var(--ink);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .control input::placeholder { color: #9fb2a9; }
        .control input:hover { border-color: #c3d1ca; }
        .control input:focus { border-color: var(--g-500); background: #fff; box-shadow: 0 0 0 4px rgba(16, 185, 129, .14); }
        .control input[aria-invalid="true"] { border-color: #f3a5a5; }
        .control:focus-within .lead { color: var(--g-600); }
        .control.has-eye input { padding-right: 54px; }
        .eye {
            position: absolute; right: 7px; top: 50%; transform: translateY(-50%);
            width: 40px; height: 40px;
            border: 0; border-radius: 10px;
            background: transparent; color: #7d958a;
            font-size: 15px; cursor: pointer;
            transition: background .2s, color .2s;
        }
        .eye:hover { background: #ecf3ef; color: var(--g-700); }
        .eye:focus-visible { outline: 2px solid var(--g-500); outline-offset: 1px; }
        .caps {
            display: flex; align-items: center; gap: 6px;
            margin: 8px 0 0;
            font-size: 12.5px; font-weight: 600; color: #b45309;
        }
        .caps[hidden] { display: none; }
        .check {
            position: relative;
            display: inline-flex; align-items: center; gap: 10px;
            margin: 2px 0 24px;
            font-size: 14px; color: #34493f;
            cursor: pointer; user-select: none;
        }
        .check input { position: absolute; opacity: 0; width: 1px; height: 1px; }
        .check .box {
            width: 20px; height: 20px;
            border-radius: 6px;
            border: 1.5px solid #b9c8c0; background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 11px;
            transition: background .15s, border-color .15s, box-shadow .15s;
        }
        .check .box i { opacity: 0; transform: scale(.6); transition: opacity .15s, transform .15s; }
        .check input:checked + .box { background: var(--g-600); border-color: var(--g-600); }
        .check input:checked + .box i { opacity: 1; transform: none; }
        .check input:focus-visible + .box { box-shadow: 0 0 0 4px rgba(16, 185, 129, .22); }
        .submit {
            width: 100%; height: 54px;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            border: 0; border-radius: var(--radius);
            background: linear-gradient(135deg, var(--g-600), var(--g-500));
            color: #fff; font: inherit; font-size: 16px; font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 24px -10px rgba(5, 150, 105, .6), inset 0 1px 0 rgba(255, 255, 255, .2);
            transition: transform .15s, box-shadow .2s, filter .2s;
        }
        .submit:hover { transform: translateY(-1px); filter: brightness(1.04); box-shadow: 0 16px 30px -12px rgba(5, 150, 105, .7), inset 0 1px 0 rgba(255, 255, 255, .2); }
        .submit:active { transform: none; }
        .submit:focus-visible { outline: 3px solid rgba(16, 185, 129, .4); outline-offset: 2px; }
        .submit .arrow { transition: transform .2s; }
        .submit:hover .arrow { transform: translateX(3px); }
        .submit .spin {
            display: none;
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 2.5px solid rgba(255, 255, 255, .35); border-top-color: #fff;
            animation: spin .7s linear infinite;
        }
        .submit.is-loading { cursor: progress; transform: none; }
        .submit.is-loading .spin { display: inline-block; }
        .submit.is-loading .arrow { display: none; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .form-foot {
            display: flex; flex-direction: column; gap: 12px;
            margin-top: 26px; padding-top: 22px;
            border-top: 1px solid #edf1ee;
        }
        .help { display: flex; align-items: flex-start; gap: 8px; margin: 0; font-size: 13px; line-height: 1.6; color: var(--muted); }
        .help i { margin-top: 3px; color: var(--g-600); }
        .back {
            align-self: flex-start;
            display: inline-flex; align-items: center; gap: 8px;
            margin-left: -12px; padding: 8px 12px;
            border-radius: 10px;
            font-size: 13.5px; font-weight: 600; color: var(--g-700);
            text-decoration: none;
            transition: background .2s;
        }
        .back:hover { background: #ecfdf5; }
        .back:focus-visible { outline: 2px solid var(--g-500); outline-offset: 1px; }
        .copy { display: none; margin: 20px 0 0; font-size: 12px; color: #93a69c; text-align: center; }

        @media (prefers-reduced-motion: no-preference) {
            .brand-bg { animation: drift 22s ease-in-out infinite alternate; }
            .brand-copy, .form-card { animation: rise .7s cubic-bezier(.2, .8, .2, 1) both; }
            .form-card { animation-delay: .08s; }
        }
        @keyframes drift {
            from { transform: scale(1.05); }
            to { transform: scale(1.12) translateX(-1.5%); }
        }
        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: none; }
        }

        /* ===== Tablet & mobile: brand becomes a header, form a card ===== */
        @media (max-width: 960px) {
            .auth { grid-template-columns: 1fr; grid-template-rows: auto 1fr; background: var(--cream); }
            .brand-inner { min-height: 0; gap: 22px; padding: 26px 22px 88px; }
            .brand-copy h2 { margin-bottom: 8px; font-size: 25px; }
            .brand-copy p { margin: 0; font-size: 14px; line-height: 1.65; }
            .brand-features, .brand-foot { display: none; }
            .brand-pane::after { width: 380px; height: 380px; right: -170px; bottom: -230px; }
            .form-pane { padding: 0 16px 24px; background: transparent; }
            .form-card {
                position: relative; z-index: 3;
                max-width: 480px;
                margin: -60px 0 0;
                padding: 26px 20px 20px;
                border-radius: 22px;
                background: #fff;
                box-shadow: 0 24px 48px -24px rgba(2, 44, 34, .4), 0 2px 6px rgba(2, 44, 34, .05);
            }
            .form-card h1 { margin-top: 12px; font-size: 24px; }
            .form-card .lead-text { margin-bottom: 22px; }
            .copy { display: block; }
        }

        /* tablets have room for the feature chips and a taller header */
        @media (min-width: 600px) and (max-width: 960px) {
            .brand-inner { min-height: 38vh; }
            .brand-features { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; max-width: none; margin-top: 22px; }
            .brand-features li { gap: 10px; padding: 10px 12px; border-radius: 14px; }
            .brand-features .ic { width: 34px; height: 34px; border-radius: 10px; font-size: 14px; }
            .brand-features b { font-size: 13.5px; }
            .brand-features small { display: none; }
        }
    </style>
</head>

<body>
    @php
        $brandName = ab_brand('bn');
        $logo = trim((string) \App\Models\Setting::get('logo_path', ''));
        // admin-er upload kora banner — na thakle sudhu sobuj design
        $banner = trim((string) \App\Models\Setting::get('admin_banner_path', ''));
        $email = old('email', $prefillEmail ?? '');
    @endphp

    <main class="auth">
        <section class="brand-pane {{ $banner !== '' ? 'has-banner' : '' }}">
            @if ($banner !== '')
                <img class="brand-bg" src="{{ asset($banner) }}" alt="">
                <div class="brand-ov"></div>
            @endif
            <div class="brand-inner">
                <div class="brand-top">
                    <div class="brand-logo">
                        @if ($logo !== '')
                            <img src="{{ asset($logo) }}" alt="">
                        @else
                            <i class="fa-solid fa-jar"></i>
                        @endif
                    </div>
                    <div>
                        <b>{{ $brandName }}</b>
                        <span>ADMIN PANEL</span>
                    </div>
                </div>

                <div class="brand-copy">
                    <h2>আপনার পুরো স্টোর,<br><span>এক ড্যাশবোর্ডে।</span></h2>
                    <p>অর্ডার, ডেলিভারি, প্রোডাক্ট আর টিম — সবকিছু গুছিয়ে সামলান এক জায়গা থেকে।</p>
                    <ul class="brand-features">
                        <li>
                            <span class="ic"><i class="fa-solid fa-truck-fast"></i></span>
                            <div><b>অর্ডার ও ডেলিভারি</b><small>কনফার্ম থেকে কুরিয়ার পর্যন্ত পুরো হিসাব</small></div>
                        </li>
                        <li>
                            <span class="ic"><i class="fa-solid fa-boxes-stacked"></i></span>
                            <div><b>প্রোডাক্ট ও স্টক</b><small>দাম, ভ্যারিয়েন্ট আর স্টক এক জায়গায়</small></div>
                        </li>
                        <li>
                            <span class="ic"><i class="fa-solid fa-user-shield"></i></span>
                            <div><b>টিম ও অনুমতি</b><small>প্রত্যেককে শুধু প্রয়োজনীয় অ্যাক্সেস দিন</small></div>
                        </li>
                    </ul>
                </div>

                <div class="brand-foot">© {{ date('Y') }} {{ $brandName }} · সর্বস্বত্ব সংরক্ষিত</div>
            </div>
        </section>

        <section class="form-pane">
            <div class="form-card">
                <span class="eyebrow"><i class="fa-solid fa-lock"></i> সুরক্ষিত অ্যাডমিন এরিয়া</span>
                <h1>অ্যাডমিন লগইন</h1>
                <p class="lead-text">চালিয়ে যেতে আপনার ইমেইল ও পাসওয়ার্ড দিন।</p>

                @if ($errors->any())
                    <div class="alert" role="alert" id="loginError">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.attempt') }}" id="loginForm">
                    @csrf
                    <div class="field">
                        <label for="loginEmail">ইমেইল</label>
                        <div class="control">
                            <i class="fa-solid fa-envelope lead" aria-hidden="true"></i>
                            <input id="loginEmail" type="email" name="email" value="{{ $email }}"
                                placeholder="apnar@email.com" autocomplete="username" inputmode="email" required
                                @if ($errors->any()) aria-invalid="true" aria-describedby="loginError" @endif
                                @if ($email === '') autofocus @endif>
                        </div>
                    </div>

                    <div class="field">
                        <label for="loginPassword">পাসওয়ার্ড</label>
                        <div class="control has-eye">
                            <i class="fa-solid fa-lock lead" aria-hidden="true"></i>
                            <input id="loginPassword" type="password" name="password" placeholder="আপনার পাসওয়ার্ড"
                                autocomplete="current-password" required
                                @if ($errors->any()) aria-describedby="loginError" @endif
                                @if ($email !== '') autofocus @endif>
                            <button type="button" class="eye" id="passToggle" aria-label="পাসওয়ার্ড দেখুন" aria-pressed="false">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <p class="caps" id="capsHint" hidden><i class="fa-solid fa-triangle-exclamation"></i> Caps Lock চালু আছে</p>
                    </div>

                    <label class="check">
                        <input type="checkbox" name="remember" checked>
                        <span class="box"><i class="fa-solid fa-check"></i></span>
                        মনে রাখুন
                    </label>

                    <button class="submit" type="submit" id="loginBtn">
                        <span class="spin" aria-hidden="true"></span>
                        <span class="label">লগইন করুন</span>
                        <i class="fa-solid fa-arrow-right arrow" aria-hidden="true"></i>
                    </button>
                </form>

                <div class="form-foot">
                    <p class="help"><i class="fa-solid fa-circle-info"></i> পাসওয়ার্ড ভুলে গেলে আপনার অ্যাডমিনের সাথে যোগাযোগ করুন।</p>
                    <a class="back" href="{{ route('home') }}"><i class="fa-solid fa-arrow-left"></i> স্টোরে ফিরে যান</a>
                </div>
            </div>
            <p class="copy">© {{ date('Y') }} {{ $brandName }}</p>
        </section>
    </main>

    <script>
        (function () {
            var form = document.getElementById('loginForm');
            var pass = document.getElementById('loginPassword');
            var toggle = document.getElementById('passToggle');
            var caps = document.getElementById('capsHint');
            var btn = document.getElementById('loginBtn');
            var label = btn.querySelector('.label');

            toggle.addEventListener('click', function () {
                var show = pass.type === 'password';
                pass.type = show ? 'text' : 'password';
                toggle.setAttribute('aria-pressed', show ? 'true' : 'false');
                toggle.setAttribute('aria-label', show ? 'পাসওয়ার্ড লুকান' : 'পাসওয়ার্ড দেখুন');
                toggle.firstElementChild.className = show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
                pass.focus();
            });

            function capsCheck(e) {
                if (e.getModifierState) caps.hidden = !e.getModifierState('CapsLock');
            }
            pass.addEventListener('keydown', capsCheck);
            pass.addEventListener('keyup', capsCheck);
            pass.addEventListener('blur', function () { caps.hidden = true; });

            // one click = one request: lock the button while the login is checked
            form.addEventListener('submit', function () {
                btn.disabled = true;
                btn.classList.add('is-loading');
                label.textContent = 'যাচাই হচ্ছে…';
            });

            // coming back with the browser's back button re-enables it
            window.addEventListener('pageshow', function (e) {
                if (!e.persisted) return;
                btn.disabled = false;
                btn.classList.remove('is-loading');
                label.textContent = 'লগইন করুন';
            });
        })();
    </script>
</body>

</html>
