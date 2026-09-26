{{-- Section: how-it-works | Design 2 — Center Timeline (scoped: st-v2) --}}
@php
    $st2head = ab_t('steps_eyebrow', 'প্রসেস', 'Process');
    $st2tbn = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ')['bn'] . ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps')['bn'];
    $st2ten = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ')['en'] . ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps')['en'];
    $st2rows = [
        ['t' => ab_t('step1_t', 'পছন্দের জার নির্বাচন', 'Pick Your Favourite Jar'), 'd' => ab_t('step1_d', 'আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে নিচের সহজ ফর্মটিতে নাম ও ঠিকানা পূরণ করুন।', 'Select your favourite pickle, honey or ghee and fill in the simple form below.')],
        ['t' => ab_t('step2_t', 'ফোন কলে কনফার্মেশন', 'Phone Confirmation'), 'd' => ab_t('step2_d', 'অর্ডার পাওয়ার পরই আমাদের সাপোর্ট টিম কল দিয়ে ঠিকানা ও বিবরণ নিশ্চিত করবে।', 'Our support team calls you to confirm the address and details.')],
        ['t' => ab_t('step3_t', 'জার বুঝে টাকা দিন', 'Check the Jar, Then Pay'), 'd' => ab_t('step3_d', 'ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে ১০০% সন্তুষ্ট হয়ে টাকা পরিশোধ করুন।', 'Check the sealed jar and pay only when 100% satisfied.')],
    ];
@endphp
<section class="st-v2" aria-label="process">
    <div class="st-v2__head">
        <span class="st-v2__eyebrow" data-en="{{ $st2head['en'] }}">{{ $st2head['bn'] }}</span>
        <h2 data-en="{{ $st2ten }}">{{ $st2tbn }}</h2>
    </div>
    <ol class="st-v2__timeline">
        @foreach ($st2rows as $i => $row)
            <li class="st-v2__item {{ $i % 2 ? 'st-v2__item--right' : '' }}">
                <span class="st-v2__dot">{{ bn_num($i + 1) }}</span>
                <div class="st-v2__card">
                    <h3 data-en="{{ $row['t']['en'] }}">{{ $row['t']['bn'] }}</h3>
                    <p data-en="{{ $row['d']['en'] }}">{{ $row['d']['bn'] }}</p>
                </div>
            </li>
        @endforeach
    </ol>
</section>
<style>
    .st-v2 { padding: 52px 20px; max-width: 900px; margin: 0 auto; }
    .st-v2__head { text-align: center; margin-bottom: 30px; }
    .st-v2__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .st-v2__head h2 { margin: 0; font-size: clamp(21px, 3vw, 30px); font-weight: 800; color: #12261d; }
    .st-v2__timeline { list-style: none; margin: 0; padding: 0; position: relative; }
    .st-v2__timeline::before {
        content: ''; position: absolute; top: 8px; bottom: 8px; left: 50%; width: 2.5px;
        transform: translateX(-50%); background: linear-gradient(var(--ds-primary), var(--ds-lime));
        border-radius: 2px; opacity: .35;
    }
    .st-v2__item { position: relative; width: 50%; padding: 10px 34px 22px 0; }
    .st-v2__item--right { margin-left: 50%; padding: 10px 0 22px 34px; }
    .st-v2__dot {
        position: absolute; top: 12px; right: -21px; z-index: 1;
        width: 42px; height: 42px; border-radius: 50%; display: grid; place-items: center;
        background: var(--ds-primary); color: #fff; font-weight: 800; font-size: 15px;
        box-shadow: 0 0 0 5px rgba(var(--ds-primary-rgb, 5,150,105), .15);
    }
    .st-v2__item--right .st-v2__dot { right: auto; left: -21px; }
    .st-v2__card {
        background: #fff; border: 1.5px solid rgba(5,150,105,.18); border-radius: 16px;
        padding: 16px 18px; box-shadow: 0 12px 26px -18px rgba(6,78,59,.4);
    }
    .st-v2__card h3 { margin: 0 0 6px; font-size: 15px; font-weight: 800; color: #12261d; }
    .st-v2__card p { margin: 0; font-size: 13px; color: #4b6357; line-height: 1.6; }
    @media (max-width: 720px) {
        .st-v2__timeline::before { left: 21px; }
        .st-v2__item, .st-v2__item--right { width: 100%; margin-left: 0; padding: 6px 0 20px 56px; }
        .st-v2__dot, .st-v2__item--right .st-v2__dot { left: 0; right: auto; }
    }
</style>
