{{-- Section: promises | Design 2 — Horizontal Feature Strip (scoped: pm-v2) --}}
@php
    $pm2head = ab_t('promise_eyebrow', 'আমাদের গ্যারান্টি', 'Our Guarantee');
    $pm2tbn = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ')['bn'] . ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind')['bn'];
    $pm2ten = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ')['en'] . ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind')['en'];
    $pm2cards = [
        ab_t('promise_c1_t', '০% হিডেন সার্ভিস ফি', '0% Hidden Service Fee'),
        ab_t('promise_c2_t', '৪৮ ঘণ্টায় নিশ্চিত পেআউট', '48-Hour Guaranteed Payout'),
        ab_t('promise_c3_t', '৬৪ জেলায় অটো লজিস্টিকস', 'Logistics in 64 Districts'),
        ab_t('promise_c4_t', 'সিলড ও সেফ প্যাকেজিং', 'Sealed & Safe Packaging'),
    ];
@endphp
<section class="pm-v2" aria-label="promises">
    <div class="pm-v2__head">
        <span class="pm-v2__eyebrow" data-en="{{ $pm2head['en'] }}">{{ $pm2head['bn'] }}</span>
        <h2 class="pm-v2__title" data-en="{{ $pm2ten }}">{{ $pm2tbn }}</h2>
    </div>
    <div class="pm-v2__strip">
        @foreach ($pm2cards as $i => $t)
            <div class="pm-v2__cell">
                <span class="pm-v2__n">{{ bn_num($i + 1) }}</span>
                <h3 data-en="{{ $t['en'] }}">{{ $t['bn'] }}</h3>
            </div>
        @endforeach
    </div>
</section>
<style>
    .pm-v2 { padding: 44px 20px; max-width: 1200px; margin: 0 auto; }
    .pm-v2__head { text-align: center; margin-bottom: 22px; }
    .pm-v2__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .pm-v2__title { margin: 0; font-size: clamp(21px, 3vw, 30px); font-weight: 800; color: #12261d; }
    .pm-v2__strip {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        border: 1.5px solid rgba(5,150,105,.2); border-radius: 18px; overflow: hidden;
        background: linear-gradient(135deg, rgba(5,150,105,.06), rgba(163,230,53,.08));
    }
    .pm-v2__cell { padding: 22px 20px; display: flex; flex-direction: column; gap: 8px; border-left: 1.5px solid rgba(5,150,105,.14); }
    .pm-v2__cell:first-child { border-left: 0; }
    .pm-v2__n {
        width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center;
        background: var(--ds-primary); color: #fff; font-weight: 800; font-size: 14px;
    }
    .pm-v2__cell h3 { margin: 0; font-size: 14.5px; font-weight: 800; color: #12261d; line-height: 1.4; }
    @media (max-width: 768px) {
        .pm-v2__strip { grid-template-columns: 1fr 1fr; }
        .pm-v2__cell:nth-child(3) { border-left: 0; }
        .pm-v2__cell:nth-child(n+3) { border-top: 1.5px solid rgba(5,150,105,.14); }
    }
    @media (max-width: 480px) {
        .pm-v2__strip { grid-template-columns: 1fr; }
        .pm-v2__cell { border-left: 0 !important; }
        .pm-v2__cell:nth-child(n+2) { border-top: 1.5px solid rgba(5,150,105,.14); }
    }
</style>
