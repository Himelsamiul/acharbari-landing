{{-- Section: faq | Design 2 — Two-Column Accordion (scoped: faq-v2) --}}
@php
    $fv2head = ab_t('faq_eyebrow', 'প্রশ্ন-উত্তর', 'FAQ');
    $fv2tbn = ab_t('faq_h2a', 'সাধারণ ', 'Common ')['bn'] . ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions')['bn'];
    $fv2ten = ab_t('faq_h2a', 'সাধারণ ', 'Common ')['en'] . ab_t('faq_h2b', 'জিজ্ঞাসা', 'Questions')['en'];
    $fv2sub = ab_t('faq_sub', 'আপনার মনে থাকা সাধারণ প্রশ্নের উত্তর জেনে নিন', 'Find answers to the questions you have in mind');
    $fv2items = collect(ab_json('faq_items', [
        ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন।', 'a_en' => 'Yes, 100% Cash on Delivery — check the sealed jar, then pay.'],
        ['q_bn' => 'আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?', 'q_en' => 'How long do the pickles last? Any preservatives?', 'a_bn' => 'ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ ও কেমিক্যাল মুক্ত।', 'a_en' => 'Good for 12 months at room temperature — preservative free.'],
        ['q_bn' => 'ডেলিভারি চার্জ কত টাকা?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'জেলাভিত্তিক চার্জ চেকআউটে দেখানো হয় — বিশেষ অফারে ফ্রি ডেলিভারিও আছে।', 'a_en' => 'District-wise charges shown at checkout — free delivery on special offers.'],
        ['q_bn' => 'জার ভেঙে বা লিক হয়ে এলে কী করব?', 'q_en' => 'What if the jar arrives broken or leaked?', 'a_bn' => '২৪ ঘণ্টার মধ্যে ছবি দিয়ে জানালেই ফ্রি রিপ্লেসমেন্ট।', 'a_en' => 'Report with a photo within 24 hours — free replacement.'],
        ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => '"অর্ডার ট্র্যাক" বাটনে মোবাইল নম্বর বা ইনভয়েস আইডি দিয়ে লাইভ স্ট্যাটাস দেখুন।', 'a_en' => 'Use "Order Track" with your mobile number or invoice ID.'],
        ['q_bn' => 'পাইকারি অর্ডার করা যাবে?', 'q_en' => 'Can I order in bulk?', 'a_bn' => 'হ্যাঁ, পাইকারি অর্ডারের জন্য হটলাইনে কল বা WhatsApp করুন।', 'a_en' => 'Yes — call our hotline or WhatsApp for bulk orders.'],
    ]));
@endphp
<section class="faq-v2" id="ds-faq" aria-label="faq">
    <div class="faq-v2__in">
        <div class="faq-v2__intro">
            <span class="faq-v2__eyebrow" data-en="{{ $fv2head['en'] }}">{{ $fv2head['bn'] }}</span>
            <h2 data-en="{{ $fv2ten }}">{{ $fv2tbn }}</h2>
            <p data-en="{{ $fv2sub['en'] }}">{{ $fv2sub['bn'] }}</p>
        </div>
        <div class="faq-v2__cols">
            @foreach ($fv2items->chunk(ceil($fv2items->count() / 2)) as $col)
                <div class="faq-v2__col">
                    @foreach ($col as $j => $fi)
                        <details class="faq-v2__item" {{ $j === 0 ? 'open' : '' }}>
                            <summary><span data-en="{{ $fi['q_en'] ?? '' }}">{{ $fi['q_bn'] ?? '' }}</span><i class="faq-v2__chev">▾</i></summary>
                            <div data-en="{{ $fi['a_en'] ?? '' }}">{{ $fi['a_bn'] ?? '' }}</div>
                        </details>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .faq-v2 { padding: 56px 20px; background: #f8fbf9; }
    .faq-v2__in { max-width: 1180px; margin: 0 auto; display: grid; grid-template-columns: 1fr 2.2fr; gap: 38px; align-items: start; }
    .faq-v2__eyebrow { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ds-primary); margin-bottom: 10px; }
    .faq-v2__intro h2 { margin: 0 0 10px; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #12261d; }
    .faq-v2__intro p { margin: 0; font-size: 14px; color: #4b6357; line-height: 1.6; }
    .faq-v2__cols { display: grid; grid-template-columns: 1fr 1fr; gap: 0 22px; align-items: start; }
    .faq-v2__item { background: #fff; border: 1.5px solid rgba(5,150,105,.18); border-radius: 14px; margin-bottom: 12px; overflow: hidden; }
    .faq-v2__item summary {
        list-style: none; cursor: pointer; display: flex; justify-content: space-between; gap: 10px; align-items: center;
        padding: 14px 16px; font-size: 13.5px; font-weight: 700; color: #12261d;
    }
    .faq-v2__item summary::-webkit-details-marker { display: none; }
    .faq-v2__chev { transition: transform .25s; color: var(--ds-primary); font-style: normal; }
    .faq-v2__item[open] .faq-v2__chev { transform: rotate(180deg); }
    .faq-v2__item > div { padding: 0 16px 14px; font-size: 13px; color: #4b6357; line-height: 1.65; }
    @media (max-width: 960px) {
        .faq-v2__in { grid-template-columns: 1fr; gap: 20px; }
        .faq-v2__cols { grid-template-columns: 1fr; }
    }
</style>
