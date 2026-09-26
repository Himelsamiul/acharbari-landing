<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ \App\Models\Order::class ? 'আচারবাড়ি' : '' }}</title>
    <link rel="icon" href="{{ asset($settings['favicon_path'] ?? 'assets/img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap"
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
            overflow: hidden;
            background: #06130d;
        }
        .login-bg {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: loginBg 18s ease-in-out infinite alternate;
        }
        @keyframes loginBg {
            from { transform: scale(1.04) translateX(0); }
            to { transform: scale(1.12) translateX(-1.5%); }
        }
        .login-bg-ov {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(600px 400px at 15% 20%, rgba(16, 185, 129, .25), transparent 60%),
                linear-gradient(150deg, rgba(2, 44, 34, .88), rgba(2, 44, 34, .5) 50%, rgba(6, 78, 59, .85));
        }
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(24px) saturate(150%);
            -webkit-backdrop-filter: blur(24px) saturate(150%);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 26px;
            padding: 38px 32px;
            box-shadow: 0 40px 90px -20px rgba(0, 0, 0, 0.65), inset 0 1px 0 rgba(255, 255, 255, 0.25);
            overflow: hidden;
        }
        .login-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #059669, #10b981, #a3e635);
            background-size: 200% 100%;
            animation: grad 5s ease infinite;
        }
        @keyframes grad { 0%,100% { background-position: 0% 0; } 50% { background-position: 100% 0; } }
        .login-logo {
            width: 60px; height: 60px;
            margin: 0 auto 16px;
            border-radius: 18px;
            background: linear-gradient(135deg, #059669, #10b981);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 25px;
            box-shadow: 0 14px 30px -8px rgba(0, 0, 0, .6), inset 0 1px 1px rgba(255, 255, 255, .4);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .3);
        }
        .login-logo img { width: 100%; height: 100%; object-fit: cover; }
        h1 { text-align: center; margin: 0 0 4px; font-size: 22px; color: #fff; text-shadow: 0 2px 14px rgba(0,0,0,.35); }
        h1 span.hl { color: #a3e635; }
        p.sub { text-align: center; margin: 0 0 22px; font-size: 13px; color: rgba(255,255,255,.68); }
        .a-field { margin-bottom: 14px; }
        .a-field label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 6px; color: rgba(255,255,255,.88); }
        .a-input {
            width: 100%;
            background: rgba(255,255,255,.12);
            border: 1.5px solid rgba(255,255,255,.26);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: inherit;
            color: #fff;
            outline: none;
            transition: border .2s, box-shadow .2s;
        }
        .a-input::placeholder { color: rgba(255,255,255,.45); }
        .a-input:focus { border-color: #a3e635; box-shadow: 0 0 0 4px rgba(163,230,53,.16); }
        .pass-wrap { position: relative; }
        .pass-wrap .a-input { padding-right: 46px; }
        .pass-eye {
            position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
            width: 34px; height: 34px; border: none; border-radius: 9px;
            background: transparent; color: rgba(255,255,255,.6);
            cursor: pointer; font-size: 14px;
            transition: color .2s, background .2s;
        }
        .pass-eye:hover { color: #a3e635; background: rgba(255,255,255,.08); }
        .a-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%;
            border: none; cursor: pointer; font-family: inherit;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; font-weight: 800; font-size: 15px;
            padding: 13px; border-radius: 12px;
            box-shadow: 0 14px 30px -10px rgba(0,0,0,.6);
            transition: transform .15s, filter .2s;
        }
        .a-btn:hover { transform: translateY(-1px); filter: brightness(1.06); }
        .err-box {
            background: rgba(220,38,38,.15);
            border: 1px solid rgba(220,38,38,.4);
            color: #fca5a5;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 14px;
        }
        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; font-size: 12px; color: rgba(255,255,255,.75); }
        .remember-row input { accent-color: #10b981; width: 15px; height: 15px; }
    </style>
</head>

<body>
    <img class="login-bg" src="{{ asset('assets/img/hero_achar.jpg') }}" alt="">
    <div class="login-bg-ov"></div>
    <div class="login-card">
        <div class="login-logo">
            <i class="fa-solid fa-jar"></i>
        </div>
        <h1><span>{{ config('app.name') }}</span> <span class="hl">Admin</span></h1>
        <p class="sub">অ্যাডমিন প্যানেল — লগইন করে অর্ডার ম্যানেজ করুন</p>

        @if ($errors->any())
            <div class="err-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}">
            @csrf
            <div class="a-field">
                <label>ইমেইল</label>
                <input class="a-input" type="email" name="email" value="{{ old('email') }}" placeholder="apnar@email.com" required autofocus>
            </div>
            <div class="a-field">
                <label>পাসওয়ার্ড</label>
                <div class="pass-wrap">
                    <input class="a-input" type="password" name="password" id="loginPassword" value="{{ old('password') }}" placeholder="••••••••" required>
                    <button type="button" class="pass-eye" onclick="togglePass()" aria-label="পাসওয়ার্ড দেখুন">
                        <i class="fa-solid fa-eye" id="passEye"></i>
                    </button>
                </div>
            </div>
            <script>
                function togglePass() {
                    var input = document.getElementById('loginPassword');
                    var eye = document.getElementById('passEye');
                    if (input.type === 'password') { input.type = 'text'; eye.className = 'fa-solid fa-eye-slash'; }
                    else { input.type = 'password'; eye.className = 'fa-solid fa-eye'; }
                }
            </script>
            <label class="remember-row">
                <input type="checkbox" name="remember" checked> মনে রাখুন
            </label>
            <button class="a-btn" type="submit">
                <i class="fa-solid fa-right-to-bracket"></i> লগইন করুন
            </button>
        </form>
    </div>
</body>

</html>
