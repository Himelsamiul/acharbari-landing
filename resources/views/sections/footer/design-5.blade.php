{{-- Section: footer | Design 5 — Dark Centered Minimal (scoped: ft-v5)
     Preserves brand.js hooks: data-ab-logo-slot, data-ab-brand-logo, data-ab-brand-name --}}
@php
    $ft5tag = ab_t('footer_tag', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।', 'Homemade deshi pickles, honey & ghee — delivered nationwide with Cash on Delivery.');
    $ft5rights = ab_t('footer_rights', 'সর্বস্বত্ব সংরক্ষিত', 'All rights reserved');
    $ft5made = ab_t('footer_made', 'Made with love by', 'Made with love by');
@endphp
<footer class="ft-v5">
    <div class="ft-v5__in">
        <a class="ft-v5__logo" href="#">
            <span class="ft-v5__logo-ic" data-ab-logo-slot>
                @if (!empty($settings['logo_path']))
                    <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                @else
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                @endif
            </span>
            <span class="ft-v5__name" data-ab-brand-logo>{{ $settings['brand_bn1'] ?? 'আচার' }}<em>{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</em></span>
        </a>
        <p class="ft-v5__tag" data-en="{{ $ft5tag['en'] }}">{{ $ft5tag['bn'] }}</p>
        <nav class="ft-v5__nav" aria-label="footer">
            <a href="{{ url('/') }}" data-en="Home">হোম</a>
            <a href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
            <a href="{{ route('track') }}" data-en="Order Track">অর্ডার ট্র্যাক</a>
            <a href="{{ route('about') }}" data-en="About Us">আমাদের সম্পর্কে</a>
            <a href="{{ route('privacy') }}" data-en="Privacy Policy">প্রাইভেসি পলিসি</a>
            <a href="{{ route('terms') }}" data-en="Terms and Conditions">শর্তাবলি ও নিয়মাবলি</a>
        </nav>
        <div class="ft-v5__social">
            @if ($fb !== '')<a href="{{ $fb }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>@endif
            @if ($wa !== '')<a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg></a>@endif
            @if ($ms !== '')<a href="https://m.me/{{ $ms }}" target="_blank" rel="noopener" aria-label="Messenger"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></a>@endif
        </div>
        <div class="ft-v5__bar">
            <span>© {{ date('Y') }} <strong data-ab-brand-name>{{ ab_brand('bn') }}</strong>. <span data-en="{{ $ft5rights['en'] }}">{{ $ft5rights['bn'] }}</span></span>
            <span data-en="{{ $ft5made['en'] }}">{{ $ft5made['bn'] }} <strong data-ab-brand-name>{{ ab_made_by() }}</strong></span>
        </div>
    </div>
</footer>
<style>
    .ft-v5 { background: linear-gradient(180deg, #062b1f, #02231a); color: #fff; text-align: center; }
    .ft-v5__in { max-width: 760px; margin: 0 auto; padding: 40px 20px 16px; display: flex; flex-direction: column; align-items: center; }
    .ft-v5__logo { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: #fff; }
    .ft-v5__logo-ic {
        width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .ft-v5__logo-ic img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 2px; box-sizing: border-box; }
    .ft-v5__name { font-size: 19px; font-weight: 800; }
    .ft-v5__name em { font-style: normal; color: var(--ds-lime-neon, #a3e635); }
    .ft-v5__tag { margin: 10px 0 20px; font-size: 12px; line-height: 1.7; color: rgba(255,255,255,.65); max-width: 460px; }
    .ft-v5__nav { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px 22px; margin-bottom: 18px; }
    .ft-v5__nav a { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.75); text-decoration: none; transition: color .2s; }
    .ft-v5__nav a:hover { color: var(--ds-lime-neon, #a3e635); }
    .ft-v5__social { display: flex; gap: 10px; margin-bottom: 22px; }
    .ft-v5__social a {
        width: 36px; height: 36px; border-radius: 50%; display: grid; place-items: center;
        background: rgba(255,255,255,.08); color: #fff; transition: background .2s, transform .2s;
    }
    .ft-v5__social a:hover { background: var(--ds-primary); transform: translateY(-2px); }
    .ft-v5__bar {
        width: 100%; border-top: 1px solid rgba(255,255,255,.12); padding: 14px 0 4px;
        display: flex; flex-wrap: wrap; gap: 6px 16px; justify-content: space-between;
        font-size: 11px; color: rgba(255,255,255,.55);
    }
    .ft-v5__bar strong { color: rgba(255,255,255,.8); }
</style>
