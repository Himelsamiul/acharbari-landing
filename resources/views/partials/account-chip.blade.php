{{-- Storefront auth state chip: guests get লগইন/রেজিস্টার, logged-in customers get a
     name dropdown (আমার অর্ডার / প্রোফাইল / লগআউট). Admins render nothing here —
     their auth state never mixes into storefront or admin UI. --}}
@php $abAccUser = auth()->user(); @endphp

@if ($abAccUser && $abAccUser->isCustomer())
    <div class="ab-acc-wrap" @if (!($mobile ?? false)) style="position:relative" @endif>
        <button type="button" class="ab-acc-chip {{ ($mobile ?? false) ? 'ab-acc-chip-mob' : '' }}" onclick="abAccToggle(event)" aria-haspopup="true" aria-expanded="false">
            <span class="ab-acc-av">{{ mb_substr($abAccUser->name, 0, 1) }}</span>
            <span class="ab-acc-name">{{ $abAccUser->name }}</span>
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div class="ab-acc-drop {{ ($mobile ?? false) ? 'ab-acc-drop-mob' : '' }}" id="abAccDrop">
            <a href="{{ route('account.orders') }}">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                আমার অর্ডার
            </a>
            <a href="{{ route('account') }}">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                প্রোফাইল
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    লগআউট
                </button>
            </form>
        </div>
    </div>
@elseif (!$abAccUser)
    <div class="ab-acc-wrap">
        <a href="{{ route('login') }}" class="ab-acc-login {{ ($mobile ?? false) ? 'ab-acc-chip-mob' : '' }}">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/></svg>
            লগইন
        </a>
        <a href="{{ route('register') }}" class="ab-acc-register {{ ($mobile ?? false) ? 'ab-acc-chip-mob' : '' }}">
            রেজিস্টার
        </a>
    </div>
@endif

<style>
    .ab-acc-wrap { display: inline-flex; align-items: center; gap: 6px; }
    .ab-acc-chip {
        display: inline-flex; align-items: center; gap: 7px;
        background: #fff; color: #12261d;
        border: 1.5px solid rgba(5, 150, 105, .22);
        border-radius: 999px; padding: 5px 12px 5px 5px;
        font-family: inherit; font-size: 12.5px; font-weight: 700;
        cursor: pointer; transition: box-shadow .2s, border-color .2s;
    }
    .ab-acc-chip:hover { border-color: var(--ds-primary, #059669); box-shadow: 0 8px 18px -10px rgba(6, 78, 59, .35); }
    .ab-acc-av {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, var(--ds-primary, #059669), #10b981);
        color: #fff; display: inline-flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 800;
    }
    .ab-acc-drop {
        display: none; position: absolute; right: 0; top: calc(100% + 8px); z-index: 70;
        min-width: 190px; background: #fff;
        border: 1px solid rgba(5, 150, 105, .16); border-radius: 14px;
        box-shadow: 0 24px 50px -18px rgba(6, 78, 59, .35); overflow: hidden;
        padding: 6px;
    }
    .ab-acc-drop.open { display: block; }
    .ab-acc-drop a, .ab-acc-drop button {
        display: flex; align-items: center; gap: 9px; width: 100%;
        padding: 9px 12px; border-radius: 9px; text-decoration: none;
        font-family: inherit; font-size: 13px; font-weight: 600; color: #12261d;
        border: none; background: transparent; cursor: pointer; text-align: left;
        transition: background .15s;
    }
    .ab-acc-drop a:hover, .ab-acc-drop button:hover { background: rgba(5, 150, 105, .08); }
    .ab-acc-drop svg { color: var(--ds-primary, #059669); }
    .ab-acc-login {
        display: inline-flex; align-items: center; gap: 6px;
        color: #12261d; text-decoration: none; font-size: 13px; font-weight: 700;
        border: 1.5px solid rgba(5, 150, 105, .22); border-radius: 999px; padding: 7px 15px;
        background: #fff; transition: border-color .2s, transform .15s;
        white-space: nowrap;
    }
    .ab-acc-login:hover { border-color: var(--ds-primary, #059669); transform: translateY(-1px); }
    .ab-acc-register {
        display: inline-flex; align-items: center;
        color: #fff; text-decoration: none; font-size: 13px; font-weight: 700;
        border-radius: 999px; padding: 8px 15px; white-space: nowrap;
        background: linear-gradient(135deg, var(--ds-primary, #059669), #10b981);
        box-shadow: 0 10px 22px -10px rgba(5, 150, 105, .6);
        transition: transform .15s, filter .2s;
    }
    .ab-acc-register:hover { transform: translateY(-1px); filter: brightness(1.06); }
    /* mobile drawer variant: stacked, full width */
    .ab-acc-chip-mob, .ab-acc-chip-mob.ab-acc-login { width: 100%; justify-content: flex-start; }
    .ab-acc-drop-mob { position: static; display: none; box-shadow: none; border: none; padding: 4px 0 0 8px; }
    .ab-acc-drop-mob.open { display: block; }
</style>
<script>
    function abAccToggle(e) {
        e.stopPropagation();
        document.querySelectorAll('.ab-acc-drop.open').forEach(function (d) {
            if (d !== e.currentTarget.closest('.ab-acc-wrap').querySelector('.ab-acc-drop')) d.classList.remove('open');
        });
        var wrap = e.currentTarget.closest('.ab-acc-wrap');
        var drop = wrap.querySelector('.ab-acc-drop');
        drop.classList.toggle('open');
        e.currentTarget.setAttribute('aria-expanded', drop.classList.contains('open') ? 'true' : 'false');
    }
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.ab-acc-wrap')) {
            document.querySelectorAll('.ab-acc-drop.open').forEach(function (d) { d.classList.remove('open'); });
        }
    });
</script>
