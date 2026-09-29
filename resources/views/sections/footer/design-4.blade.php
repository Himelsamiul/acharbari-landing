{{-- Section: footer | Design 4 — Light Minimal with Giant Wordmark (scoped: ft-v4)
     Preserves brand.js hooks: data-ab-logo-slot, data-ab-brand-logo, data-ab-brand-name --}}
@php
    $ft4tag = ab_t('footer_tag', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু ও ঘি — সারা বাংলাদেশে ক্যাশ অন ডেলিভারিতে হোম ডেলিভারি।', 'Homemade deshi pickles, honey & ghee — delivered nationwide with Cash on Delivery.');
    $ft4rights = ab_t('footer_rights', 'সর্বস্বত্ব সংরক্ষিত', 'All rights reserved');
    $ft4made = ab_t('footer_made', 'Made with love by', 'Made with love by');
    $ft4links = ab_t('footer_col_links', 'কুইক লিংক', 'Quick Links');
@endphp
<footer class="ft-v4">
    <div class="ft-v4__in">
        <div class="ft-v4__wordmark" aria-hidden="true">{{ ($settings['brand_bn1'] ?? 'আচার') }}{{ ($settings['brand_bn2'] ?? 'বাড়ি') }}</div>
        <div class="ft-v4__row">
            <div class="ft-v4__brand">
                <a class="ft-v4__logo" href="#">
                    <span class="ft-v4__logo-ic" data-ab-logo-slot>
                        @if (!empty($settings['logo_path']))
                            <img src="{{ asset($settings['logo_path']) }}" alt="logo">
                        @else
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                        @endif
                    </span>
                    <span class="ft-v4__name" data-ab-brand-logo>{{ $settings['brand_bn1'] ?? 'আচার' }}<em>{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</em></span>
                </a>
                <p class="ft-v4__tag" data-en="{{ $ft4tag['en'] }}">{{ $ft4tag['bn'] }}</p>
            </div>

            <nav class="ft-v4__nav" aria-label="footer">
                <a href="{{ url('/') }}" data-en="Home">হোম</a>
                <a href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
                <a href="{{ route('track') }}" data-en="Order Track">অর্ডার ট্র্যাক</a>
                <a href="{{ route('privacy') }}" data-en="Privacy Policy">প্রাইভেসি পলিসি</a>
                <a href="{{ route('terms') }}" data-en="Terms and Conditions">শর্তাবলি ও নিয়মাবলি</a>
            </nav>

            <div class="ft-v4__social">
                @if ($fb !== '')<a href="{{ $fb }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>@endif
                @if ($wa !== '')<a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg></a>@endif
                @if ($ms !== '')<a href="https://m.me/{{ $ms }}" target="_blank" rel="noopener" aria-label="Messenger"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></a>@endif
            </div>
        </div>
        <div class="ft-v4__bar">
            <span>© {{ date('Y') }} <strong data-ab-brand-name>{{ ab_brand('bn') }}</strong>. <span data-en="{{ $ft4rights['en'] }}">{{ $ft4rights['bn'] }}</span></span>
            <span data-en="{{ $ft4made['en'] }}">{{ $ft4made['bn'] }} <strong data-ab-brand-name>{{ ab_made_by() }}</strong></span>
        </div>
    </div>
</footer>
<style>
    .ft-v4 { background: #fff; border-top: 1.5px solid rgba(18,38,29,.08); overflow: hidden; }
    .ft-v4__in { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .ft-v4__wordmark {
        font-size: clamp(52px, 10vw, 130px); font-weight: 800; line-height: 1.05; text-align: center;
        color: transparent; -webkit-text-stroke: 1.5px rgba(5,150,105,.25);
        padding: 34px 0 6px; user-select: none; white-space: nowrap;
    }
    .ft-v4__row {
        display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between;
        gap: 18px 30px; padding: 18px 0 26px;
    }
    .ft-v4__brand { display: flex; flex-direction: column; gap: 8px; }
    .ft-v4__logo { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #12261d; }
    .ft-v4__logo-ic {
        width: 32px; height: 32px; border-radius: 9px; display: grid; place-items: center; overflow: hidden;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
    }
    .ft-v4__logo-ic img { width: 100%; height: 100%; object-fit: cover; background: #fff; padding: 2px; box-sizing: border-box; }
    .ft-v4__name { font-weight: 800; font-size: 15px; }
    .ft-v4__name em { font-style: normal; color: var(--ds-accent); }
    .ft-v4__tag { margin: 0; font-size: 11.5px; color: #8b7355; max-width: 300px; line-height: 1.6; }
    .ft-v4__nav { display: flex; flex-wrap: wrap; gap: 6px 20px; align-self: center; }
    .ft-v4__nav a { font-size: 12px; font-weight: 700; color: #4b6357; text-decoration: none; }
    .ft-v4__nav a:hover { color: var(--ds-primary); }
    .ft-v4__social { display: flex; gap: 8px; align-self: center; }
    .ft-v4__social a {
        width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center;
        background: rgba(5,150,105,.08); color: var(--ds-primary); transition: background .2s, color .2s;
    }
    .ft-v4__social a:hover { background: var(--ds-primary); color: #fff; }
    .ft-v4__bar {
        display: flex; flex-wrap: wrap; gap: 6px 18px; justify-content: space-between;
        border-top: 1px solid rgba(18,38,29,.07); padding: 12px 0 16px; font-size: 11px; color: #8b7355;
    }
</style>
