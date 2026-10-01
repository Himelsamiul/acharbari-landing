{{-- Section: how-it-works | Design 5 — Vertical Timeline (scoped: hw-v5)
     Same content keys as design-1: steps_eyebrow, steps_h2a/b, steps_sub, step1-3 t/d --}}
    <section class="hw-v5">
        <div class="hw-v5__in">
            @php
                $hw5h = ab_t('steps_eyebrow', 'প্রসেস', 'Process');
                $hw5a = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ');
                $hw5b = ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps');
                $hw5s = ab_t('steps_sub', 'সহজ ও নিরাপদ প্রক্রিয়া — ঝামেলাহীন অর্ডারের অভিজ্ঞতা', 'Simple & secure process — a hassle-free ordering experience');
                $hw5steps = [
                    ['n' => '১', 't' => ab_t('step1_t', 'পছন্দের জার নির্বাচন', 'Pick Your Favourite Jar'), 'd' => ab_t('step1_d', 'আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে নিচের সহজ ফর্মটিতে নাম ও ঠিকানা পূরণ করুন।', 'Select your favourite pickle, honey or ghee and fill in the simple form below with your name and address.')],
                    ['n' => '২', 't' => ab_t('step2_t', 'ফোন কলে কনফার্মেশন', 'Phone Confirmation'), 'd' => ab_t('step2_d', 'অর্ডার পাওয়ার পরই আমাদের সাপোর্ট টিম কল দিয়ে ঠিকানা ও বিবরণ নিশ্চিত করবে।', 'As soon as we receive your order, our support team calls you to confirm the address and details.')],
                    ['n' => '৩', 't' => ab_t('step3_t', 'জার বুঝে টাকা দিন', 'Check the Jar, Then Pay'), 'd' => ab_t('step3_d', 'ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে ১০০% সন্তুষ্ট হয়ে টাকা পরিশোধ করুন।', 'Check the sealed jar in front of the delivery man and pay only when 100% satisfied.')],
                ];
            @endphp
            <div class="hw-v5__head">
                <span class="hw-v5__eyebrow" data-en="{{ $hw5h['en'] }}">{{ $hw5h['bn'] }}</span>
                <h2 class="hw-v5__h2"><span data-en="{{ $hw5a['en'] }}">{{ $hw5a['bn'] }}</span><span class="hw-v5__grad" data-en="{{ $hw5b['en'] }}">{{ $hw5b['bn'] }}</span></h2>
                <p class="hw-v5__sub" data-en="{{ $hw5s['en'] }}">{{ $hw5s['bn'] }}</p>
            </div>
            <div class="hw-v5__line">
                @foreach ($hw5steps as $i => $st)
                    <div class="hw-v5__step {{ $i % 2 ? 'hw-v5__step--right' : '' }}">
                        <div class="hw-v5__dot">{{ $st['n'] }}</div>
                        <div class="hw-v5__card">
                            <h4 data-en="{{ $st['t']['en'] }}">{{ $st['t']['bn'] }}</h4>
                            <p data-en="{{ $st['d']['en'] }}">{{ $st['d']['bn'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
<style>
    .hw-v5 { padding: 54px 20px; background: linear-gradient(180deg, #fff, #f4faf6); }
    .hw-v5__in { max-width: 760px; margin: 0 auto; }
    .hw-v5__head { text-align: center; margin-bottom: 34px; }
    .hw-v5__eyebrow { display: block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .hw-v5__h2 { margin: 0 0 10px; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .hw-v5__grad { background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent)); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .hw-v5__sub { margin: 0; font-size: 13.5px; color: #5b6b60; }
    .hw-v5__line { position: relative; padding-left: 56px; }
    .hw-v5__line::before {
        content: ''; position: absolute; left: 23px; top: 8px; bottom: 8px; width: 3px;
        border-radius: 3px; background: linear-gradient(180deg, var(--ds-primary), var(--ds-accent));
    }
    .hw-v5__step { position: relative; margin-bottom: 18px; }
    .hw-v5__dot {
        position: absolute; left: -56px; top: 4px; width: 46px; height: 46px; border-radius: 50%;
        display: grid; place-items: center; font-size: 15px; font-weight: 800; color: #fff;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent));
        box-shadow: 0 10px 22px -8px rgba(5,150,105,.6); border: 3px solid #fff;
    }
    .hw-v5__card {
        background: #fff; border: 1.5px solid rgba(5,150,105,.14); border-radius: 16px; padding: 15px 18px;
        box-shadow: 0 12px 26px -20px rgba(6,78,59,.35); transition: transform .18s ease, box-shadow .25s ease;
    }
    .hw-v5__card:hover { transform: translateY(-3px); box-shadow: 0 22px 40px -24px rgba(6,78,59,.45); }
    .hw-v5__card h4 { margin: 0 0 4px; font-size: 14.5px; font-weight: 800; color: #12261d; }
    .hw-v5__card p { margin: 0; font-size: 12.5px; line-height: 1.7; color: #5b6b60; }
</style>
