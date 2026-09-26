{{-- Section: promises | Design 4 — Gradient Icon Cards (scoped: pm-v4) --}}
@php
    $pm4head = ab_t('promise_eyebrow', 'আমাদের গ্যারান্টি', 'Our Guarantee');
    $pm4tbn = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ')['bn'] . ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind')['bn'];
    $pm4ten = ab_t('promise_h2a', 'অর্ডার করুন ', 'Order with ')['en'] . ab_t('promise_h2b', 'সম্পূর্ণ নিশ্চিন্তে', 'total peace of mind')['en'];
    $pm4icons = ['percent', 'banknote', 'truck', 'package'];
    $pm4cards = [
        ['icon' => 'percent', 't' => ab_t('promise_c1_t', '০% হিডেন সার্ভিস ফি', '0% Hidden Service Fee')],
        ['icon' => 'banknote', 't' => ab_t('promise_c2_t', '৪৮ ঘণ্টায় নিশ্চিত পেআউট', '48-Hour Guaranteed Payout')],
        ['icon' => 'truck', 't' => ab_t('promise_c3_t', '৬৪ জেলায় অটো লজিস্টিকস', 'Logistics in 64 Districts')],
        ['icon' => 'package', 't' => ab_t('promise_c4_t', 'সিলড ও সেফ প্যাকেজিং', 'Sealed & Safe Packaging')],
    ];
@endphp
<section class="pm-v4" aria-label="promises">
    <div class="pm-v4__head">
        <span class="pm-v4__eyebrow" data-en="{{ $pm4head['en'] }}">{{ $pm4head['bn'] }}</span>
        <h2 data-en="{{ $pm4ten }}">{{ $pm4tbn }}</h2>
    </div>
    <div class="pm-v4__grid">
        @foreach ($pm4cards as $c)
            <div class="pm-v4__card">
                <span class="pm-v4__ic">
                    @if ($c['icon'] === 'percent')
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" x2="5" y1="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                    @elseif ($c['icon'] === 'banknote')
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01"/><path d="M18 12h.01"/></svg>
                    @elseif ($c['icon'] === 'truck')
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                    @else
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    @endif
                </span>
                <h3 data-en="{{ $c['t']['en'] }}">{{ $c['t']['bn'] }}</h3>
            </div>
        @endforeach
    </div>
</section>
<style>
    .pm-v4 { padding: 50px 20px; }
    .pm-v4__head { text-align: center; margin-bottom: 26px; }
    .pm-v4__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .pm-v4__head h2 { margin: 0; font-size: clamp(21px, 3vw, 30px); font-weight: 800; color: #12261d; }
    .pm-v4__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 210px), 1fr)); gap: 14px; max-width: 1180px; margin: 0 auto; }
    .pm-v4__card {
        text-align: center; padding: 26px 18px; border-radius: 20px; color: #fff;
        background: linear-gradient(160deg, var(--ds-primary), var(--ds-primary-dark));
        box-shadow: 0 22px 44px -24px rgba(var(--ds-primary-rgb, 5,150,105), .65);
        transition: transform .2s ease;
    }
    .pm-v4__card:nth-child(2) { background: linear-gradient(160deg, var(--ds-accent), var(--ds-primary)); }
    .pm-v4__card:nth-child(3) { background: linear-gradient(160deg, var(--ds-teal), var(--ds-primary-dark)); }
    .pm-v4__card:nth-child(4) { background: linear-gradient(160deg, var(--ds-primary-dark), #12261d); }
    .pm-v4__card:hover { transform: translateY(-5px); }
    .pm-v4__ic {
        width: 52px; height: 52px; margin: 0 auto 14px; border-radius: 16px;
        display: grid; place-items: center; background: rgba(255,255,255,.18);
    }
    .pm-v4__card h3 { margin: 0; font-size: 14.5px; font-weight: 800; line-height: 1.45; }
    @media (prefers-reduced-motion: reduce) {
        .pm-v4__card { transition: none; }
    }
</style>
