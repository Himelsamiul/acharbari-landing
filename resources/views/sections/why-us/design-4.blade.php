{{-- Section: why-us | Design 4 — Dark Stats + Benefits Split (scoped: wy-v4) --}}
@php
    $wy4head = ab_t('why_eyebrow', 'কেন আমরা সেরা', 'Why We Are the Best');
    $wy4tbn = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ')['bn'] . ab_t('why_h2b', 'আচারবাড়ি', 'AcharBari')['bn'];
    $wy4ten = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ')['en'] . ab_t('why_h2b', 'আচারবাড়ি', 'AcharBari')['en'];
    $wy4big = ['t' => ab_t('why_big_t', '১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি', '100% Pure & Preservative-Free Guarantee')];
    $wy4ver = ab_t('why_verified', 'ভেরিফাইড গ্রামীণ রান্নাঘর', 'Verified Village Kitchens');
    $wy4cells = [
        ['t' => ab_t('why_c1_t', 'সুপারফাস্ট ডেলিভারি', 'Superfast Delivery'), 'd' => ab_t('why_c1_d', 'ঢাকায় ২৪ ঘণ্টা, বাইরে ৪৮-৭২ ঘণ্টা।', '24h Dhaka, 48-72h outside.')],
        ['t' => ab_t('why_c2_t', 'ক্যাশ অন ডেলিভারি', 'Cash on Delivery'), 'd' => ab_t('why_c2_d', 'হাতে পেয়ে চেক করে পেমেন্ট।', 'Check first, pay after.')],
        ['t' => ab_t('why_c3_t', 'ভাঙা জারে রিপ্লেসমেন্ট', 'Broken Jar Replacement'), 'd' => ab_t('why_c3_d', '২৪ ঘণ্টায় ছবি দিলেই ফ্রি।', 'Photo within 24h = free.')],
        ['t' => ab_t('why_c4_t', '২৪/৭ সাপোর্ট', '24/7 Support'), 'd' => ab_t('why_c4_d', 'যেকোনো সময় কল বা WhatsApp।', 'Call or WhatsApp anytime.')],
    ];
@endphp
<section class="wy-v4" aria-label="why us">
    <div class="wy-v4__split">
        <div class="wy-v4__left">
            <span class="wy-v4__eyebrow" data-en="{{ $wy4head['en'] }}">{{ $wy4head['bn'] }}</span>
            <h2 data-en="{{ $wy4ten }}">{{ $wy4tbn }}</h2>
            <p class="wy-v4__big" data-en="{{ $wy4big['t']['en'] }}">{{ $wy4big['t']['bn'] }}</p>
            <span class="wy-v4__ver">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
                <span data-en="{{ $wy4ver['en'] }}">{{ $wy4ver['bn'] }}</span>
            </span>
        </div>
        <div class="wy-v4__list">
            @foreach ($wy4cells as $i => $cell)
                <div class="wy-v4__row">
                    <span class="wy-v4__num">{{ str_pad((string) ($i + 1), 2, '0') }}</span>
                    <div>
                        <h3 data-en="{{ $cell['t']['en'] }}">{{ $cell['t']['bn'] }}</h3>
                        <p data-en="{{ $cell['d']['en'] }}">{{ $cell['d']['bn'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .wy-v4 { padding: 56px 20px; }
    .wy-v4__split {
        max-width: 1140px; margin: 0 auto;
        display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;
        background: linear-gradient(150deg, var(--ds-primary-dark), var(--ds-primary-xdark));
        border-radius: 28px; padding: 48px 44px;
        box-shadow: 0 40px 80px -40px rgba(6,78,59,.6);
    }
    .wy-v4__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-lime-neon); margin-bottom: 10px; }
    .wy-v4__left h2 { margin: 0 0 14px; font-size: clamp(23px, 3vw, 34px); font-weight: 800; color: #fff; line-height: 1.25; }
    .wy-v4__big { margin: 0 0 18px; font-size: 15px; line-height: 1.7; color: rgba(255,255,255,.8); }
    .wy-v4__ver { display: inline-flex; gap: 8px; align-items: center; font-size: 12.5px; font-weight: 800; color: var(--ds-lime-neon); }
    .wy-v4__list { display: flex; flex-direction: column; gap: 4px; }
    .wy-v4__row { display: flex; gap: 16px; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,.1); }
    .wy-v4__row:last-child { border-bottom: 0; }
    .wy-v4__num { font-size: 22px; font-weight: 800; color: var(--ds-lime-neon); min-width: 36px; line-height: 1.2; }
    .wy-v4__row h3 { margin: 0 0 3px; font-size: 14.5px; font-weight: 800; color: #fff; }
    .wy-v4__row p { margin: 0; font-size: 12.5px; color: rgba(255,255,255,.65); line-height: 1.55; }
    @media (max-width: 900px) {
        .wy-v4__split { grid-template-columns: 1fr; gap: 24px; padding: 34px 26px; }
    }
</style>
