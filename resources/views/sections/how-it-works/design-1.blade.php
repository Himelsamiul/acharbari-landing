{{-- Section: how-it-works | Design 1 (extracted original) --}}
<!-- ================= HOW IT WORKS ================= -->
    <section class="ds-section">
        <div class="ds-container">
            @php
                $sth = ab_t('steps_eyebrow', 'প্রসেস', 'Process');
                $st2a = ab_t('steps_h2a', 'মাত্র ৩ ধাপে ', 'Order in just ');
                $st2b = ab_t('steps_h2b', 'অর্ডার সম্পন্ন', '3 Simple Steps');
                $stsub = ab_t('steps_sub', 'সহজ ও নিরাপদ প্রক্রিয়া — ঝামেলাহীন অর্ডারের অভিজ্ঞতা', 'Simple & secure process — a hassle-free ordering experience');
                $steps = [
                    ['n' => '১', 't' => ab_t('step1_t', 'পছন্দের জার নির্বাচন', 'Pick Your Favourite Jar'), 'd' => ab_t('step1_d', 'আপনার পছন্দের আচার, মধু বা ঘি সিলেক্ট করে নিচের সহজ ফর্মটিতে নাম ও ঠিকানা পূরণ করুন।', 'Select your favourite pickle, honey or ghee and fill in the simple form below with your name and address.'), 'icon' => 'jar'],
                    ['n' => '২', 't' => ab_t('step2_t', 'ফোন কলে কনফার্মেশন', 'Phone Confirmation'), 'd' => ab_t('step2_d', 'অর্ডার পাওয়ার পরই আমাদের সাপোর্ট টিম কল দিয়ে ঠিকানা ও বিবরণ নিশ্চিত করবে।', 'As soon as we receive your order, our support team calls you to confirm the address and details.'), 'icon' => 'phone'],
                    ['n' => '৩', 't' => ab_t('step3_t', 'জার বুঝে টাকা দিন', 'Check the Jar, Then Pay'), 'd' => ab_t('step3_d', 'ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে ১০০% সন্তুষ্ট হয়ে টাকা পরিশোধ করুন।', 'Check the sealed jar in front of the delivery man and pay only when 100% satisfied.'), 'icon' => 'package'],
                ];
            @endphp
            <div class="ds-sec-head">
                <span class="ds-eyebrow" data-en="{{ $sth['en'] }}">{{ $sth['bn'] }}</span>
                <h2 class="ds-h2"><span data-en="{{ $st2a['en'] }}">{{ $st2a['bn'] }}</span><span class="ds-grad" data-en="{{ $st2b['en'] }}">{{ $st2b['bn'] }}</span></h2>
                <p class="ds-sub" data-en="{{ $stsub['en'] }}">{{ $stsub['bn'] }}</p>
            </div>
            <div class="ds-steps">
                @foreach ($steps as $step)
                    <div class="ds-step">
                        <span class="ds-step-n">{{ $step['n'] }}</span>
                        @if ($step['icon'] === 'jar')
                            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2.5h8"/><path d="M7 2.5v4.2L5 10v9.5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V10l-2-3.3V2.5"/><path d="M5 10h14"/><path d="M9.5 14.5h5"/></svg>
                        @elseif ($step['icon'] === 'phone')
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                        @endif
                        <h3 data-en="{{ $step['t']['en'] }}">{{ $step['t']['bn'] }}</h3>
                        <p data-en="{{ $step['d']['en'] }}">{{ $step['d']['bn'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
<style>
/* modern polish (scoped, additive) */
.ds-step { transition: transform .2s ease, box-shadow .25s ease; border-radius: 16px; }
.ds-step:hover { transform: translateY(-4px); box-shadow: 0 22px 44px -26px rgba(6,78,59,.45); }
.ds-step-n { transition: transform .3s ease; }
.ds-step:hover .ds-step-n { transform: scale(1.12); }
</style>
