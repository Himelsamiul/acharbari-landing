{{-- Section: footer | Design 2 — Compact One-Row Footer (scoped: ft-v2)
     Preserves brand.js hooks: data-ab-logo-slot, data-ab-brand-logo, data-ab-brand-name --}}
@php
    $ft2tag = ab_t('footer_tag', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।', 'Homemade deshi pickles, honey & ghee — delivered nationwide with Cash on Delivery.');
    $ft2rights = ab_t('footer_rights', 'সর্বস্বত্ব সংরক্ষিত', 'All rights reserved');
    $ft2made = ab_t('footer_made', 'Made with love by', 'Made with love by');
@endphp
<footer class="ft-v2">
    <div class="ft-v2__row">
        <a class="ft-v2__brand" href="#">
            <span class="ft-v2__logo" data-ab-logo-slot>
                @if (!empty($settings['logo_path']))
                    <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                @else
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                @endif
            </span>
            <span class="ft-v2__name" data-ab-brand-logo>{{ $settings['brand_bn1'] ?? 'আচার' }}<em>{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</em></span>
        </a>

        <nav class="ft-v2__links" aria-label="footer">
            <a href="{{ url('/#ds-products') }}" data-en="Products">প্রোডাক্টস</a>
            <a href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
            <a href="{{ url('/#ds-why') }}" data-en="Why Us">কেন আমরা</a>
            <a href="{{ route('track') }}" data-en="Order Track">অর্ডার ট্র্যাক</a>
            <a href="{{ route('privacy') }}" data-en="Privacy Policy">প্রাইভেসি পলিসি</a>
            <a href="{{ route('terms') }}" data-en="Terms and Conditions">শর্তাবলি ও নিয়মাবলি</a>
            @if ($phone !== '')<a href="tel:{{ $phone }}">{{ $phone }}</a>@endif
            @if ($fb !== '')<a href="{{ $fb }}" target="_blank" rel="noopener" data-en="Facebook">ফেসবুক</a>@endif
        </nav>

        <div class="ft-v2__pay">
            <span class="ft-v2__chip"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
            <span class="ft-v2__chip"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
            <span data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</span>
        </div>
    </div>
    <div class="ft-v2__bar">
        <span>© {{ date('Y') }} <strong data-ab-brand-name>{{ ab_brand('bn') }}</strong>. <span data-en="{{ $ft2rights['en'] }}">{{ $ft2rights['bn'] }}</span></span>
        <span data-en="{{ $ft2made['en'] }}">{{ $ft2made['bn'] }} <strong data-ab-brand-name>{{ ab_made_by() }}</strong></span>
    </div>
</footer>
<style>
    .ft-v2 { border-top: 1.5px solid rgba(5,150,105,.14); background: #fff; }
    .ft-v2__row {
        max-width: 1200px; margin: 0 auto; padding: 20px;
        display: flex; flex-wrap: wrap; align-items: center; gap: 14px 26px; justify-content: space-between;
    }
    .ft-v2__brand { display: inline-flex; align-items: center; gap: 9px; text-decoration: none; color: #12261d; }
    .ft-v2__logo {
        width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .ft-v2__logo img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 3px; box-sizing: border-box; }
    .ft-v2__name { font-weight: 800; font-size: 16px; }
    .ft-v2__name em { font-style: normal; color: var(--ds-accent); }
    .ft-v2__links { display: flex; flex-wrap: wrap; gap: 4px 18px; }
    .ft-v2__links a { font-size: 12.5px; font-weight: 700; color: #4b6357; text-decoration: none; }
    .ft-v2__links a:hover { color: var(--ds-primary); }
    .ft-v2__pay { display: inline-flex; align-items: center; gap: 8px; font-size: 11.5px; font-weight: 700; color: #4b6357; }
    .ft-v2__chip { display: inline-grid; place-items: center; background: #fff; border: 1px solid rgba(18,38,29,.1); border-radius: 7px; padding: 3px 6px; }
    .ft-v2__chip img { height: 15px; display: block; }
    .ft-v2__bar {
        border-top: 1px solid rgba(18,38,29,.07); padding: 11px 20px;
        max-width: 1200px; margin: 0 auto;
        display: flex; flex-wrap: wrap; gap: 6px 18px; justify-content: space-between;
        font-size: 11.5px; color: #8b7355;
    }
            <a href="{{ url('/') }}" data-en="Home">হোম</a>
            <a href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
            <a href="{{ route('track') }}" data-en="Order Track">অর্ডার ট্র্যাক</a>
            <a href="{{ route('privacy') }}" data-en="Privacy Policy">প্রাইভেসি পলিসি</a>
            <a href="{{ route('terms') }}" data-en="Terms and Conditions">শর্তাবলি ও নিয়মাবলি</a>
            @if ($phone !== '')<a href="tel:{{ $phone }}">{{ $phone }}</a>@endif
            @if ($fb !== '')<a href="{{ $fb }}" target="_blank" rel="noopener" data-en="Facebook">ফেসবুক</a>@endif
        </nav>

        <div class="ft-v2__pay">
            <span class="ft-v2__chip"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
            <span class="ft-v2__chip"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
            <span data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</span>
        </div>
    </div>
    <div class="ft-v2__bar">
        <span>© {{ date('Y') }} <strong data-ab-brand-name>{{ ab_brand('bn') }}</strong>. <span data-en="{{ $ft2rights['en'] }}">{{ $ft2rights['bn'] }}</span></span>
        <span data-en="{{ $ft2made['en'] }}">{{ $ft2made['bn'] }} <strong data-ab-brand-name>{{ ab_made_by() }}</strong></span>
    </div>
</footer>
<style>
    .ft-v2 { border-top: 1.5px solid rgba(5,150,105,.14); background: #fff; }
    .ft-v2__row {
        max-width: 1200px; margin: 0 auto; padding: 20px;
        display: flex; flex-wrap: wrap; align-items: center; gap: 14px 26px; justify-content: space-between;
    }
    .ft-v2__brand { display: inline-flex; align-items: center; gap: 9px; text-decoration: none; color: #12261d; }
    .ft-v2__logo {
        width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .ft-v2__logo img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 3px; box-sizing: border-box; }
    .ft-v2__name { font-weight: 800; font-size: 16px; }
    .ft-v2__name em { font-style: normal; color: var(--ds-accent); }
    .ft-v2__links { display: flex; flex-wrap: wrap; gap: 4px 18px; }
    .ft-v2__links a { font-size: 12.5px; font-weight: 700; color: #4b6357; text-decoration: none; }
    .ft-v2__links a:hover { color: var(--ds-primary); }
    .ft-v2__pay { display: inline-flex; align-items: center; gap: 8px; font-size: 11.5px; font-weight: 700; color: #4b6357; }
    .ft-v2__chip { display: inline-grid; place-items: center; background: #fff; border: 1px solid rgba(18,38,29,.1); border-radius: 7px; padding: 3px 6px; }
    .ft-v2__chip img { height: 15px; display: block; }
    .ft-v2__bar {
        border-top: 1px solid rgba(18,38,29,.07); padding: 11px 20px;
        max-width: 1200px; margin: 0 auto;
        display: flex; flex-wrap: wrap; gap: 6px 18px; justify-content: space-between;
        font-size: 11.5px; color: #8b7355;
    }
</style>
