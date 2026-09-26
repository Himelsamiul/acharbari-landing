{{-- Section: how-it-works | Design 3 — Big Numbered Editorial (scoped: st-v3) --}}
@php
    $st3head = ab_t('steps_eyebrow', 'প্রসেস', 'Process');
    $st3tbn = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ')['bn'] . ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps')['bn'];
    $st3ten = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ')['en'] . ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps')['en'];
    $st3rows = [
        ['t' => ab_t('step1_t', 'পছন্দের জার নির্বাচন', 'Pick Your Favourite Jar'), 'd' => ab_t('step1_d', 'আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে সহজ ফর্মে নাম ও ঠিকানা দিন।', 'Pick your jar and fill in the simple form.')],
        ['t' => ab_t('step2_t', 'ফোন কলে কনফার্মেশন', 'Phone Confirmation'), 'd' => ab_t('step2_d', 'সাপোর্ট টিম কল দিয়ে ঠিকানা ও বিবরণ নিশ্চিত করবে।', 'We call to confirm your details.')],
        ['t' => ab_t('step3_t', 'জার বুঝে টাকা দিন', 'Check the Jar, Then Pay'), 'd' => ab_t('step3_d', 'জার চেক করে ১০০% সন্তুষ্ট হয়ে টাকা দিন।', 'Check the jar, then pay when satisfied.')],
    ];
@endphp
<section class="st-v3" aria-label="process">
    <div class="st-v3__in">
        <div class="st-v3__head">
            <span class="st-v3__eyebrow" data-en="{{ $st3head['en'] }}">{{ $st3head['bn'] }}</span>
            <h2 data-en="{{ $st3ten }}">{{ $st3tbn }}</h2>
        </div>
        <div class="st-v3__rows">
            @foreach ($st3rows as $i => $row)
                <div class="st-v3__row">
                    <span class="st-v3__big">{{ str_pad((string) ($i + 1), 2, '0') }}</span>
                    <div class="st-v3__body">
                        <h3 data-en="{{ $row['t']['en'] }}">{{ $row['t']['bn'] }}</h3>
                        <p data-en="{{ $row['d']['en'] }}">{{ $row['d']['bn'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .st-v3 { padding: 54px 20px; background: var(--ds-primary-dark); }
    .st-v3__in { max-width: 860px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.5fr; gap: 42px; align-items: center; }
    .st-v3__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-lime-neon); margin-bottom: 10px; }
    .st-v3__head h2 { margin: 0; font-size: clamp(22px, 3vw, 31px); font-weight: 800; color: #fff; line-height: 1.32; }
    .st-v3__rows { display: flex; flex-direction: column; gap: 6px; }
    .st-v3__row { display: flex; gap: 20px; align-items: flex-start; padding: 15px 0; border-bottom: 1.5px solid rgba(255,255,255,.12); }
    .st-v3__row:last-child { border-bottom: 0; }
    .st-v3__big {
        font-size: 44px; font-weight: 800; line-height: 1; color: transparent;
        -webkit-text-stroke: 1.6px var(--ds-lime-neon); min-width: 62px;
    }
    .st-v3__body h3 { margin: 0 0 5px; font-size: 15.5px; font-weight: 800; color: #fff; }
    .st-v3__body p { margin: 0; font-size: 13px; color: rgba(255,255,255,.72); line-height: 1.6; }
    @media (max-width: 860px) {
        .st-v3__in { grid-template-columns: 1fr; gap: 22px; }
    }
</style>
