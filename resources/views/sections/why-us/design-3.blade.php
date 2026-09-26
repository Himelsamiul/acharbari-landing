{{-- Section: why-us | Design 3 — Split Editorial: visual left, benefits right (scoped: wy-v3) --}}
@php
    $wy3head = ab_t('why_eyebrow', 'কেন আমরা সেরা', 'Why We Are the Best');
    $wy3tbn = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ')['bn'] . ab_t('why_h2b', 'আচারবাড়ি', 'AcharBari')['bn'];
    $wy3ten = ab_t('why_h2a', 'কেন বেছে নেবেন ', 'Why choose ')['en'] . ab_t('why_h2b', 'আচারবাড়ি', 'AcharBari')['en'];
    $wy3bigT = ab_t('why_big_t', '১০০% খাঁটি ও প্রিজারভেটিভ-মুক্ত গ্যারান্টি', '100% Pure & Preservative-Free Guarantee');
    $wy3ver = ab_t('why_verified', 'ভেরিফাইড গ্রামীণ রান্নাঘর', 'Verified Village Kitchens');
    $wy3cells = [
        ['t' => ab_t('why_c1_t', 'সুপারফাস্ট ডেলিভারি', 'Superfast Delivery'), 'd' => ab_t('why_c1_d', 'ঢাকায় ২৪ ঘণ্টা, বাইরে ৪৮-৭২ ঘণ্টায় নিরাপদে পৌঁছে যায়।', '24h in Dhaka, 48-72h outside.')],
        ['t' => ab_t('why_c2_t', 'ক্যাশ অন ডেলিভারি', 'Cash on Delivery'), 'd' => ab_t('why_c2_d', 'অগ্রিম টাকা লাগবে না — হাতে পেয়ে চেক করে পেমেন্ট।', 'No advance — check then pay.')],
        ['t' => ab_t('why_c3_t', 'ভাঙা জারে রিপ্লেসমেন্ট', 'Broken Jar Replacement'), 'd' => ab_t('why_c3_d', '২৪ ঘণ্টায় ছবি দিলেই ফ্রি রিপ্লেসমেন্ট।', 'Photo within 24h = free replacement.')],
        ['t' => ab_t('why_c4_t', '২৪/৭ সাপোর্ট হেল্পলাইন', '24/7 Support Helpline'), 'd' => ab_t('why_c4_d', 'যেকোনো প্রশ্নে কল বা WhatsApp করুন।', 'Call or WhatsApp anytime.')],
    ];
@endphp
<section class="wy-v3" aria-label="why us">
    <div class="wy-v3__grid">
        <div class="wy-v3__visual">
            <span class="wy-v3__eyebrow" data-en="{{ $wy3head['en'] }}">{{ $wy3head['bn'] }}</span>
            <h2 data-en="{{ $wy3ten }}">{{ $wy3tbn }}</h2>
            <div class="wy-v3__big">
                <h3 data-en="{{ $wy3bigT['en'] }}">{{ $wy3bigT['bn'] }}</h3>
                <span class="wy-v3__ver">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
                    <span data-en="{{ $wy3ver['en'] }}">{{ $wy3ver['bn'] }}</span>
                </span>
            </div>
        </div>
        <ul class="wy-v3__list">
            @foreach ($wy3cells as $cell)
                <li class="wy-v3__row">
                    <span class="wy-v3__tick">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                    </span>
                    <div>
                        <h3 data-en="{{ $cell['t']['en'] }}">{{ $cell['t']['bn'] }}</h3>
                        <p data-en="{{ $cell['d']['en'] }}">{{ $cell['d']['bn'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
<style>
    .wy-v3 { padding: 56px 20px; }
    .wy-v3__grid { max-width: 1120px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.15fr; gap: 44px; align-items: center; }
    .wy-v3__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 10px; }
    .wy-v3__visual h2 { margin: 0 0 22px; font-size: clamp(23px, 3vw, 33px); font-weight: 800; color: #12261d; line-height: 1.3; }
    .wy-v3__big {
        background:
            radial-gradient(120% 130% at 90% 10%, rgba(163,230,53,.22), transparent 50%),
            linear-gradient(150deg, var(--ds-primary), var(--ds-primary-dark));
        border-radius: 24px; padding: 30px 28px; color: #fff;
        box-shadow: 0 26px 50px -22px rgba(var(--ds-primary-rgb, 5,150,105), .65);
    }
    .wy-v3__big h3 { margin: 0 0 14px; font-size: clamp(16px, 2vw, 20px); font-weight: 800; line-height: 1.45; }
    .wy-v3__ver { display: inline-flex; gap: 8px; align-items: center; font-size: 12.5px; font-weight: 800; color: var(--ds-lime-neon); }
    .wy-v3__list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 6px; }
    .wy-v3__row { display: flex; gap: 14px; padding: 13px 12px; border-radius: 14px; transition: background .2s; }
    .wy-v3__row:hover { background: rgba(5,150,105,.05); }
    .wy-v3__tick {
        flex-shrink: 0; width: 30px; height: 30px; border-radius: 10px; display: grid; place-items: center;
        background: rgba(5,150,105,.12); color: var(--ds-primary); margin-top: 2px;
    }
    .wy-v3__row h3 { margin: 0 0 3px; font-size: 14.5px; font-weight: 800; color: #12261d; }
    .wy-v3__row p { margin: 0; font-size: 12.5px; color: #4b6357; line-height: 1.55; }
    @media (max-width: 900px) {
        .wy-v3__grid { grid-template-columns: 1fr; gap: 26px; }
    }
</style>
