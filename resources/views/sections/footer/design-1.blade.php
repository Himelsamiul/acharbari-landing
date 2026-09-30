{{-- Section: footer | Design 1 (extracted original) --}}
<footer class="lp-footer" id="lp-footer">
        <div class="lp-footer-glow"></div>
        <div class="lp-footer-in">
            <div class="lp-f-brand">
                <a class="lp-f-logo" href="#">
                    <span class="lp-f-logo-ic" data-ab-logo-slot>
                        @if (!empty($settings['logo_path']))
                            <img src="{{ asset($settings['logo_path']) }}" alt="logo" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 2.5h8"></path>
                                <path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"></path>
                                <path d="M5 10h14"></path>
                                <path d="M9.5 14.5h5"></path>
                            </svg>
                        @endif
                    </span>
                    <span class="lp-f-logo-tx" data-ab-brand-logo>{{ $settings['brand_bn1'] ?? 'আচার' }}<em>{{ $settings['brand_bn2'] ?? 'বাড়ি' }}</em></span>
                </a>
                <p class="lp-f-tag" data-en="{{ $footerTag['en'] }}">{{ $footerTag['bn'] }}</p>
                <div class="lp-f-social">
                    @if ($fb !== '')
                    <a href="{{ ab_social('facebook', 'https://facebook.com/') }}" target="_blank" rel="noopener" aria-label="Facebook" data-brand="facebook">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    @endif
                    @if ($ms !== '')
                    <a href="{{ ab_social('messenger', 'https://m.me/') }}" target="_blank" rel="noopener" aria-label="Messenger" data-brand="messenger">
                        <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    </a>
                    @endif
                    @if ($wa !== '')
                    <a href="{{ ab_social('whatsapp', 'https://wa.me/') }}" target="_blank" rel="noopener" aria-label="WhatsApp" data-brand="whatsapp">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    </a>
                    @endif
                    @if ($phone !== '')
                    <a href="tel:{{ $phone }}" aria-label="Hotline" data-brand="phone">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
                    </a>
                    @endif
                </div>
                <div class="lp-f-pay">
                    @if (ab_online_payment())
                        <span class="img-chip"><img src="{{ asset('assets/img/pay/bkash.svg') }}" alt="bKash"></span>
                        <span class="img-chip"><img src="{{ asset('assets/img/pay/nagad.svg') }}" alt="Nagad"></span>
                    @endif
                    <span data-en="Cash on Delivery">ক্যাশ অন ডেলিভারি</span>
                </div>
            </div>

            <div class="lp-f-col">
                <h4 data-en="{{ $footerLinksH['en'] }}">{{ $footerLinksH['bn'] }}</h4>
                <a href="{{ url('/') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-9 9 9"/><path d="M5 10v10a1 1 0 0 0 1 1h3v-6h6v6h3a1 1 0 0 0 1-1V10"/></svg> <span data-en="Home">হোম</span></a>
                <a href="{{ route('products') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="3" rx="1.5"/><rect width="7" height="7" x="14" y="14" rx="1.5"/><rect width="7" height="7" x="3" y="14" rx="1.5"/></svg> <span data-en="All Products">সব প্রোডাক্ট</span></a>
                <a href="{{ route('track') }}" onclick="openTrackModal();return false;"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/><path d="M11 8a3 3 0 0 1 3 3"/></svg> <span data-en="Track Order">অর্ডার ট্র্যাক করুন</span></a>
                <a href="{{ route('about') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg> <span data-en="About Us">আমাদের সম্পর্কে</span></a>
                <a href="{{ route('privacy') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span data-en="Privacy Policy">প্রাইভেসি পলিসি</span></a>
                <a href="{{ route('terms') }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M9 13h6"/><path d="M9 17h6"/></svg> <span data-en="Terms & Conditions">শর্তাবলি ও নিয়মাবলি</span></a>
            </div>

            @if ($phone !== '' || $wa !== '' || $fb !== '')
            <div class="lp-f-col">
                <h4 data-en="{{ $footerContactH['en'] }}">{{ $footerContactH['bn'] }}</h4>
                @if ($phone !== '')
                <a href="tel:{{ $phone }}"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg> {{ $phone }}</a>
                @endif
                @if ($wa !== '')
                <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg> WhatsApp</a>
                @endif
                @if ($fb !== '')
                <a href="{{ $fb }}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    <span data-en="{{ $footerFb['en'] }}">{{ $footerFb['bn'] }}</span></a>
                @endif
            </div>
            @endif
        </div>

        <div class="lp-f-bar">
            <span>© {{ date('Y') }} <strong data-ab-brand-name>{{ ab_brand('bn') }}</strong>. <span data-en="{{ $footerRights['en'] }}">{{ $footerRights['bn'] }}</span></span>
            <span class="lp-f-made"><span data-en="{{ $footerMade['en'] }}">{{ $footerMade['bn'] }}</span> <strong
                    data-ab-brand-name>{{ ab_made_by() }}</strong> <svg class="lp-f-heart" viewBox="0 0 24 24" width="13" height="13" fill="currentColor" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></span>
        </div>
    </footer>
