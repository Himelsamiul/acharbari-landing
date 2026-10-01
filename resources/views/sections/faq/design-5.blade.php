{{-- Section: faq | Design 5 — Side Title + Accordions (scoped: fq-v5)
     Same content keys as design-1: faq_eyebrow, faq_h2a/b, faq_sub, faq_items --}}
    <section class="fq-v5" id="ds-faq">
        <div class="fq-v5__in">
            @php
                $fq5h = ab_t('faq_eyebrow', 'প্রশ্ন-উত্তর', 'FAQ');
                $fq5a = ab_t('faq_h2a', 'সাধারণ ', 'Common ');
                $fq5b = ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions');
                $fq5s = ab_t('faq_sub', 'আপনার মনে থাকা সাধারণ প্রশ্নের উত্তর জেনে নিন', 'Find answers to the questions you have in mind');
                $fq5items = ab_json('faq_items', [
                    ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন। কোনো অগ্রিম টাকা লাগবে না।', 'a_en' => 'Yes, we have 100% Cash on Delivery — check the sealed jar in front of the delivery man and then pay. No advance money is needed.'],
                    ['q_bn' => 'আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?', 'q_en' => 'How long do the pickles last? Any preservatives?', 'a_bn' => 'সঠিক পদ্ধতিতে তৈরি ও খাঁটি সরিষার তেল, পর্যাপ্ত লবণ ও বিশুদ্ধ মসলার কারণে আমাদের আচার ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ, কালার ও কেমিক্যাল সম্পূর্ণ মুক্ত।', 'a_en' => 'Our pickles stay good for 12 months at room temperature — made the traditional way with premium mustard oil, enough salt and pure spices. Completely free of preservatives, colours and chemicals.'],
                    ['q_bn' => 'ডেলিভারি চার্জ কত টাকা?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'ঢাকার ভেতরের জন্য ডেলিভারি চার্জ ৮০ টাকা এবং ঢাকার বাইরের জন্য ১৫০ টাকা। বিশেষ অফার চলাকালীন অনেক প্রোডাক্টে ফ্রি ডেলিভারিও থাকে।', 'a_en' => 'Delivery charge is ৳80 inside Dhaka and ৳150 outside Dhaka. During special offers many products also get free delivery.'],
                    ['q_bn' => 'জার ভেঙে বা লিক হয়ে এলে কী করব?', 'q_en' => 'What if the jar arrives broken or leaked?', 'a_bn' => 'পার্সেল পাওয়ার ২৪ ঘণ্টার মধ্যে ছবি দিয়ে আমাদের হেল্পলাইনে জানালেই আমরা সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট করে দেব।', 'a_en' => 'Just inform our helpline with a photo within 24 hours of receiving the parcel — we will replace it completely free of charge.'],
                    ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => 'অর্ডার দেওয়ার পর ওয়েবসাইটের "অর্ডার ট্র্যাক" বাটন থেকে আপনার মোবাইল নম্বর অথবা ইনভয়েস আইডি দিয়ে লাইভ স্ট্যাটাস দেখতে পারবেন।', 'a_en' => 'You can see live status from the "Order Track" button on the website using your mobile number or invoice ID.'],
                ]);
            @endphp
            <div class="fq-v5__grid">
                <div class="fq-v5__side">
                    <span class="fq-v5__eyebrow" data-en="{{ $fq5h['en'] }}">{{ $fq5h['bn'] }}</span>
                    <h2 class="fq-v5__h2"><span data-en="{{ $fq5a['en'] }}">{{ $fq5a['bn'] }}</span><span class="fq-v5__grad" data-en="{{ $fq5b['en'] }}">{{ $fq5b['bn'] }}</span></h2>
                    <p class="fq-v5__sub" data-en="{{ $fq5s['en'] }}">{{ $fq5s['bn'] }}</p>
                </div>
                <div class="fq-v5__list">
                    @foreach ($fq5items as $i => $fi)
                        <details class="fq-v5__item" {{ $i === 0 ? 'open' : '' }}>
                            <summary>
                                <span class="fq-v5__qmark">?</span>
                                <span data-en="{{ $fi['q_en'] ?? '' }}">{{ $fi['q_bn'] ?? '' }}</span>
                                <svg viewBox="0 0 24 24" width="1em" height="1em" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="fq-v5__ans" data-en="{{ $fi['a_en'] ?? '' }}">{{ $fi['a_bn'] ?? '' }}</div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
<style>
    .fq-v5 { padding: 54px 20px; background: linear-gradient(180deg, #fff, #f6fbf7); }
    .fq-v5__in { max-width: 1080px; margin: 0 auto; }
    .fq-v5__grid { display: grid; grid-template-columns: 320px 1fr; gap: 34px; align-items: start; }
    .fq-v5__side { position: sticky; top: 90px; }
    .fq-v5__eyebrow { display: block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 8px; }
    .fq-v5__h2 { margin: 0 0 10px; font-size: clamp(24px, 3vw, 34px); font-weight: 800; line-height: 1.25; color: #12261d; }
    .fq-v5__grad { background: linear-gradient(90deg, var(--ds-primary), var(--ds-accent)); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .fq-v5__sub { margin: 0; font-size: 13px; line-height: 1.75; color: #5b6b60; }
    .fq-v5__list { display: flex; flex-direction: column; gap: 10px; }
    .fq-v5__item {
        background: #fff; border: 1.5px solid rgba(5,150,105,.15); border-radius: 14px; overflow: hidden;
        transition: border-color .2s ease, box-shadow .25s ease;
    }
    .fq-v5__item[open] { border-color: rgba(5,150,105,.45); box-shadow: 0 18px 36px -26px rgba(6,78,59,.4); }
    .fq-v5__item summary {
        display: flex; align-items: center; gap: 12px; cursor: pointer; list-style: none;
        padding: 14px 16px; font-size: 13.5px; font-weight: 800; color: #12261d;
    }
    .fq-v5__item summary::-webkit-details-marker { display: none; }
    .fq-v5__item summary svg { margin-left: auto; flex-shrink: 0; color: var(--ds-primary); transition: transform .2s ease; }
    .fq-v5__item[open] summary svg { transform: rotate(180deg); }
    .fq-v5__qmark {
        width: 24px; height: 24px; border-radius: 8px; flex-shrink: 0; display: grid; place-items: center;
        background: linear-gradient(135deg, var(--ds-primary), var(--ds-accent)); color: #fff;
        font-size: 12px; font-weight: 800;
    }
    .fq-v5__ans { padding: 0 16px 14px 52px; font-size: 12.5px; line-height: 1.75; color: #5b6b60; }
    @media (max-width: 860px) {
        .fq-v5__grid { grid-template-columns: 1fr; gap: 18px; }
        .fq-v5__side { position: static; }
    }
</style>
