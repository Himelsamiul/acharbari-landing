{{-- Section: how-it-works | Design 4 — Connected Zigzag Cards (scoped: st-v4) --}}
@php
    $s4head = ab_t('steps_eyebrow', 'প্রসেস', 'Process');
    $s4tbn = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ')['bn'] . ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps')['bn'];
    $s4ten = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ')['en'] . ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps')['en'];
    $s4rows = [
        ['t' => ab_t('step1_t', 'পছন্দের জার নির্বাচন', 'Pick Your Favourite Jar'), 'd' => ab_t('step1_d', 'আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে নিচের ফর্মে নাম ও ঠিকানা দিন।', 'Pick your jar and fill in the simple form.')],
        ['t' => ab_t('step2_t', 'ফোন কলে কনফার্মেশন', 'Phone Confirmation'), 'd' => ab_t('step2_d', 'সাপোর্ট টিম কল দিয়ে সব নিশ্চিত করবে।', 'We call to confirm everything.')],
        ['t' => ab_t('step3_t', 'জার বুঝে টাকা দিন', 'Check the Jar, Then Pay'), 'd' => ab_t('step3_d', 'জার চেক করে সন্তুষ্ট হয়ে পেমেন্ট করুন।', 'Check the jar, pay when satisfied.')],
    ];
@endphp
<section class="st-v4" aria-label="process">
    <div class="st-v4__head">
        <span class="st-v4__eyebrow" data-en="{{ $s4head['en'] }}">{{ $s4head['bn'] }}</span>
        <h2 data-en="{{ $s4ten }}">{{ $s4tbn }}</h2>
    </div>
    <div class="st-v4__flow">
        @foreach ($s4rows as $i => $row)
            <div class="st-v4__card">
                <span class="st-v4__n">{{ bn_num($i + 1) }}</span>
                <h3 data-en="{{ $row['t']['en'] }}">{{ $row['t']['bn'] }}</h3>
                <p data-en="{{ $row['d']['en'] }}">{{ $row['d']['bn'] }}</p>
            </div>
            @if (!$loop->last)
                <div class="st-v4__link" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </div>
            @endif
        @endforeach
    </div>
</section>
<style>
    .st-v4 { padding: 52px 20px; }
    .st-v4__head { text-align: center; margin-bottom: 30px; }
    .st-v4__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .st-v4__head h2 { margin: 0; font-size: clamp(21px, 3vw, 30px); font-weight: 800; color: #12261d; }
    .st-v4__flow { display: flex; align-items: stretch; justify-content: center; gap: 14px; max-width: 1100px; margin: 0 auto; }
    .st-v4__card {
        flex: 1; background: #fff; border: 1.5px solid rgba(5,150,105,.18); border-radius: 20px;
        padding: 24px 22px; position: relative;
        box-shadow: 0 18px 40px -30px rgba(6,78,59,.5);
    }
    .st-v4__n {
        position: absolute; top: -16px; left: 22px; width: 38px; height: 38px;
        display: grid; place-items: center; border-radius: 12px; transform: rotate(-6deg);
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        font-weight: 800; font-size: 16px; box-shadow: 0 10px 20px -8px rgba(5,150,105,.5);
    }
    .st-v4__card h3 { margin: 8px 0 6px; font-size: 15px; font-weight: 800; color: #12261d; }
    .st-v4__card p { margin: 0; font-size: 13px; color: #4b6357; line-height: 1.6; }
    .st-v4__link { display: grid; place-items: center; color: var(--ds-primary); padding-top: 30px; }
    @media (max-width: 860px) {
        .st-v4__flow { flex-direction: column; align-items: stretch; }
        .st-v4__link { transform: rotate(90deg); padding: 4px 0; }
    }
</style>
