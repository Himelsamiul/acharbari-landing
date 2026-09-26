@extends('layouts.admin')

@section('title', 'ল্যান্ডিং কনটেন্ট')
@section('page_title', 'ল্যান্ডিং কনটেন্ট')
@section('page_sub', 'ল্যান্ডিং পেজের সব লেখা ও ছবি — কোড ছাড়াই বদলান')

@section('content')
    @php
        $s = $settings;
        // bilingual text-field pair (ab_t pattern: empty input keeps the landing default)
        $tf = function (string $key, string $label, bool $long = false, string $ph = '') use ($s) {
            $bn = e($s[$key . '_bn'] ?? '');
            $en = e($s[$key . '_en'] ?? '');
            $bnField = $long
                ? '<textarea class="a-input" rows="2" name="' . $key . '_bn" placeholder="' . e($ph) . '">' . $bn . '</textarea>'
                : '<input class="a-input" name="' . $key . '_bn" value="' . $bn . '" placeholder="' . e($ph) . '">';
            $enField = $long
                ? '<textarea class="a-input" rows="2" name="' . $key . '_en" placeholder="' . e($ph) . '">' . $en . '</textarea>'
                : '<input class="a-input" name="' . $key . '_en" value="' . $en . '" placeholder="' . e($ph) . '">';
            return '<div class="a-field"><label>' . $label . ' — বাংলা</label>' . $bnField . '</div>'
                . '<div class="a-field"><label>' . $label . ' — English</label>' . $enField . '</div>';
        };
        $heroImgDefaults = [
            'hero_img1' => 'assets/img/hero_achar.jpg',
            'hero_img2' => 'assets/img/prod_mix.jpg',
            'hero_img3' => 'assets/img/prod_honey.jpg',
            'hero_img4' => 'assets/img/spice_box.jpg',
        ];
        $current = fn (string $key) => trim((string) ($s[$key] ?? ''));
        $jsonOf = function (string $key, array $default) use ($s) {
            $rows = json_decode((string) ($s[$key] ?? ''), true);
            return (is_array($rows) && count($rows)) ? $rows : $default;
        };
        $marqueeRows = $jsonOf('marquee_items', [
            ['bn' => 'সারা বাংলাদেশে হোম ডেলিভারি', 'en' => 'Home delivery across Bangladesh'],
            ['bn' => 'পণ্য বুঝে টাকা দিন (ক্যাশ অন ডেলিভারি)', 'en' => 'Pay after checking the parcel (Cash on Delivery)'],
            ['bn' => 'ভাঙা জারে ফ্রি রিপ্লেসমেন্ট গ্যারান্টি', 'en' => 'Broken jar? Free replacement guarantee'],
            ['ln' => '', 'en' => ''], // placeholder row kept intentionally empty
            ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
            ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
            ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
        ]);
        $faqRows = $jsonOf('faq_items', [
            ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া বা?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন। কোনো অগ্রিম টাকা লাগবে না।', 'a_en' => 'Yes, we have 100% Cash on Delivery — check the sealed jar in front of the delivery man and then pay. No advance money is needed.'],
            ['q_bn' => 'আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?', 'q_en' => 'How long do the pickles last? Any preservatives?', 'a_bn' => 'সঠিক পদ্ধতিতে তৈরি ও খাঁটি সরিষার তেল, পর্যাপ্ত লবণ ও বিশুদ্ধ মসলার কারণে আমাদের আচার ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ, কালার নয়, কেমিক্যাল সম্পূর্ণ মুক্ত।', 'a_en' => 'Our pickles stay good for 12 months at room temperature — made the traditional way with premium mustard oil, enough salt and pure spices. Completely free of preservatives, colours and chemicals.'],
            ['q_bn' => 'ডেলিভারি চার্জ কত টাকা?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'ঢাকার ভেতরের জন্য ডেলিভারি চার্জ ৮০ টাকা এবং ঢাকার বাইরের জন্য ১৫০ টাকা। বিশেষ অফার চলাকালীন অনেক প্রোডাক্টে ফ্রি ডেলিভারিও থাকে।', 'a_en' => 'Delivery charge is ৳80 inside Dhaka and 150 outside Dhaka. During special offers many products also get free delivery.'],
            ['q_bn' => 'জার ভেঙে বা লিক হয়ে এলে কী করব?', 'q_en' => 'What if the jar arrives broken or leaked?', 'a_bn' => 'পার্সেল পাওয়ার ২৪ ঘণ্টার মধ্যে ছবি দিয়ে আমাদের হেল্পলাইনে জানালেই আমরা সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট করে দেব।', 'a_en' => 'Just inform our helpline with a photo within 24 hours of receiving the parcel — we will replace it completely free of charge.'],
            ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => 'অর্ডার দেওয়ার পর ওয়েবসাইটের "অর্ডার ট্র্যাক" বাটন থেকে আপনার মোবাইল নম্বর অথবা ইনভয়েস আইডি দিয়ে লাইভ স্ট্যাটাস দেখতে পারবেন।', 'a_en' => 'You can see live status from the "Order Track" button on the website using your mobile number or invoice ID.'],
        ]);
        $reviewRows = $jsonOf('reviews_items', [
            ['img' => 'assets/img/rev1.jpg', 'name' => 'নুসরাত জাহান', 'loc_bn' => 'ভেরিফাইড পারচেজ • ঢাকা', 'loc_en' => 'Verified Purchase • Dhaka', 'text_bn' => '"আমের কুচি আচারটা একদম ঠাকুমার বানানো আচারের মতোই লেগেছে! তেল বেশি না, ঝাল-নোনতা পারফেক্ট ব্যালেন্স। ঢাকায় একদিনের মধ্যেই ডেলিভারি পেয়েছি!"', 'text_en' => '"The mango kuchi achar tastes exactly like my grandmother used to make! Not too oily, perfectly spiced. Delivery arrived within a day in Dhaka!"', 'stars' => 5, 'likes_bn' => 'Like (২৪)', 'likes_en' => 'Like (24)'],
            ['img' => 'assets/img/rev2.jpg', 'name' => 'ফারহানা ইয়াসমিন', 'loc_bn' => 'ভেরিফাইড পারচেজ • চট্টগ্রাম', 'loc_en' => 'Verified Purchase • Chattogram', 'text_bn' => '"মিক্সড প্যাকের প্যাকেজিং দেখে মুগ্ধ! তিনটা আলাদা সিল করা জার, এক ফোঁটাও লিক হয়নি। জলপাই আচারটা বছরের পর বছর ধরে খাওয়া সেরা আচার!"', 'text_en' => '"The mixed pack packaging was amazing — three sealed jars, not a drop leaked. The olive pickle is the best I have had in years!"', 'stars' => 5, 'likes_bn' => 'Like (১৮)', 'likes_en' => 'Like (18)'],
            ['img' => 'assets/img/rev3.jpg', 'name' => 'তানজিনা আক্তার', 'loc_bn' => 'ভেরিফাইড পারচেজ • রাজশাহী', 'loc_en' => 'Verified Purchase • Rajshahi', 'text_bn' => '"অবশেষে খাঁটি কাঁচা মধু পেলাম! শীতে প্রাকৃতিকভাবে সেট হয়ে গেছে — খাঁটি হওয়ার সবচেয়ে বড় প্রমাণ। পুরো পরিবারের সবাই খুব পছন্দ করেছে।"', 'text_en' => '"Finally found pure raw Sundarban honey! It crystallised naturally in winter — proof that it is real. The whole family loves it."', 'stars' => 5, 'likes_bn' => 'Like (৩১)', 'likes_en' => 'Like (31)'],
            ['img' => 'assets/img/rev4.jpg', 'name' => 'মেহেজাবীন চৌধুরী', 'loc_bn' => 'ভেরিফাইড পারচেজ • সিলেট', 'loc_en' => 'Verified Purchase • Sylhet', 'text_bn' => '"ঘি খুলতেই পুরো রান্নাঘর ঘ্রাণে ভরে গেল! গরম ভাতে এক চামচ ঘি মানেই আসল স্বাদ। গরম ভাতে এক চামচ ঘি মানেই আসল স্বাদ।"', 'text_en' => '"The ghee aroma fills the whole kitchen! One spoon on hot rice and you are in heaven. Ordered 3 more jars for my sister."', 'stars' => 5, 'likes_bn' => 'Like (১৫)', 'likes_en' => 'Like (15)'],
            ['img' => 'assets/img/rev4.jpg', 'name' => 'সাবরিনা ইসলাম', 'loc_bn' => 'ভেরিফাইড পারচেজ • খুলনা', 'loc_en' => 'Verified Purchase • Khulna', 'text_bn' => '"প্রথমবার অনলাইনে আচার অর্ডার করলাম এবং অভিজ্ঞতা দারুণ! ডেলিভারি ম্যানের সামনে চেক করে টাকা দিলাম। রিকমেন্ডেড শপ।"', 'text_en' => '"First time ordering pickles online and the experience was great! Checked the parcel in front of the delivery man and then paid. Recommended shop."', 'stars' => 5, 'likes_bn' => 'Like (২৯)', 'likes_en' => 'Like (29)'],
        ]);
        $ratingRows = $jsonOf('rating_items', [
            ['star' => 5, 'pct' => 89, 'count_bn' => '৪৭২', 'count_en' => '472'],
            ['star' => 4, 'pct' => 8, 'count_bn' => '৪১', 'count_en' => '41'],
            ['star' => 3, 'pct' => 2, 'count_bn' => '১২', 'count_en' => '12'],
            ['star' => 2, 'pct' => 0.8, 'count_bn' => '৪', 'count_en' => '4'],
            ['star' => 1, 'pct' => 0.6, 'count_bn' => '৩', 'count_en' => '3'],
        ]);
        $rf = fn (string $val) => e((string) $val);
    @endphp

    <div class="note-banner">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
        <span>যেকোনো ঘর <b>খালি রাখলে</b> ডিফল্ট লেখা দেখাবে। <b>প্রতিটি ট্যাবে নিচে একটাই সেভ বাটন</b> — পুরো ট্যাব একসাথে সেভ হয়।</span>
        <span style="display:inline-flex;gap:8px;margin-left:10px;flex-wrap:wrap">
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="a-btn" style="padding:5px 12px;font-size:12px"><i class="fa-solid fa-eye"></i> লাইভ প্রিভিউ</a>
        </a>
        </span>
    </div>

    <div class="filter-tabs" id="contentTabs">
        <a class="filter-tab active" href="#" data-tab="hero"><i class="fa-solid fa-rocket"></i> হিরো</a>
        <a class="filter-tab" href="#" data-tab="sections"><i class="fa-solid fa-heading"></i> সেকশন লেখা</a>
        <a class="filter-tab" href="#" data-tab="order"><i class="fa-solid fa-cart-shopping"></i> অর্ডার ফর্ম</a>
        <a class="filter-tab" href="#" data-tab="footer"><i class="fa-solid fa-window-maximize"></i> নেভিগেশন ও ফুটার</a>
    </div>

    {{-- ================= ট্যাব ১: হিরো ================= --}}
    <div class="tab-panel" id="tab-hero">
        <form method="POST" action="{{ route('admin.settings.content.save') }}" enctype="multipart/form-data">
            @csrf
            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#059669"><i class="fa-solid fa-quote-left"></i></span>
                    <div>
                        <b>শিরোনাম ও বাটন</b>
                        <small>ল্যান্ডিং পেজের একদম উপরে — বড় করে যে লেখাটা ঘুরে ফিরে আসে</small>
                    </div>
                </div>
                <div class="fgrid">{!! $tf('hero_chip', 'সবচেয়ে উপরের ছোট ব্যাজ', false, 'যেমন: ১০০% খাঁটি ও প্রাকৃতিক') !!}</div>
                <div class="fgrid">
                    {!! $tf('hero_s1_main', 'শিরোনাম ১ — সাদা অংশ', false, 'যেমন: খাঁটি দেশি') !!}
                    {!! $tf('hero_s1_grad', 'শিরোনাম ১ — রঙিন অংশ', false, 'যেমন: আচার') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('hero_s2_main', 'শিরোনাম ২ — সাদা অংশ', false, 'যেমন: বিশুদ্ধ') !!}
                    {!! $tf('hero_s2_grad', 'শিরোনাম ২ — রঙিন অংশ', false, 'যেমন: মধু') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('hero_s3_main', 'শিরোনাম ৩ — সাদা অংশ', false, 'যেমন: ঘরে ভাঙা') !!}
                    {!! $tf('hero_s3_grad', 'শিরোনাম ৩ — রঙিন অংশ', false, 'যেমন: ঘি') !!}
                </div>
                <div class="fgrid">{!! $tf('hero_lead', 'নিচের বিবরণ', true, '২-৩ লাইনের পরিচয়') !!}</div>
                <div class="fgrid">
                    {!! $tf('hero_cta1', 'বাটন ১-এর লেখা', false, 'যেমন: প্রোডাক্ট দেখুন') !!}
                    {!! $tf('hero_cta2', 'বাটন ২-এর লেখা', false, 'যেমন: অর্ডার করুন') !!}
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#0ea5e9"><i class="fa-solid fa-chart-simple"></i></span>
                    <div>
                        <b>৪টি স্ট্যাট (সংখ্যা)</b>
                        <small>যেমন: ১৫,০০০+ সন্তুষ্ট গ্রাহক — ৪ জোড়া লেখা</small>
                    </div>
                </div>
                <div class="fgrid">
                    @foreach ([1, 2, 3, 4] as $i)
                        <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — সংখ্যা (বাংলা)</label>
                            <input class="a-input" name="hero_stat{{ $i }}_n_bn" value="{{ $rf($s['hero_stat' . $i . '_n_bn'] ?? '') }}" placeholder="যেমন: ১৫,০০০+"></div>
                        <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — সংখ্যা (English)</label>
                            <input class="a-input" name="hero_stat{{ $i }}_n_en" value="{{ $rf($s['hero_stat' . $i . '_n_en'] ?? '') }}" placeholder="e.g. 15,000+"></div>
                        <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — লেবেল (বাংলা)</label>
                            <input class="a-input" name="hero_stat{{ $i }}_bn" value="{{ $rf($s['hero_stat' . $i . '_bn'] ?? '') }}" placeholder="যেমন: সন্তুষ্ট গ্রাহক"></div>
                        <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — লেবেল (English)</label>
                            <input class="a-input" name="hero_stat{{ $i }}_en" value="{{ $rf($s['hero_stat' . $i . '_en'] ?? '') }}" placeholder="e.g. Happy customers"></div>
                    @endforeach
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#d97706"><i class="fa-solid fa-stamp"></i></span>
                    <div>
                        <b>ফ্ল্যাশ ট্যাগ ও ফ্লোটিং ব্যাজ</b>
                        <small>হিরো ছবির কোণে ও ছবির পাশে ভাসমান ব্যাজগুলো</small>
                    </div>
                </div>
                <div class="fgrid">{!! $tf('hero_flash', 'ছবির কোণের ফ্ল্যাশ ট্যাগ', false, 'যেমন: আজকের বিশেষ অফার!') !!}</div>
                <div class="fgrid">
                    {!! $tf('hero_badge1_t', 'ব্যাজ ১ — টাইটেল', false, 'যেমন: ১০০% ন্যাচারাল') !!}
                    {!! $tf('hero_badge1_s', 'ব্যাজ ১ — ছোট লেখা', false, 'যেমন: প্রিজারভেটিভ মুক্ত') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('hero_badge2_t', 'ব্যাজ ২ — টাইটেল', false, 'যেমন: ফ্রি রিপ্লেসমেন্ট') !!}
                    {!! $tf('hero_badge2_s', 'ব্যাজ ২ — ছোট লেখা', false, 'যেমন: ভাঙা জারে') !!}
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#7c3aed"><i class="fa-solid fa-images"></i></span>
                    <div>
                        <b>হিরো ছবি (৪টি স্লাইড)</b>
                        <small>খালি রাখলে বর্তমান ছবি থাকবে • সর্বোচ্চ 2MB • JPG/PNG/WebP</small>
                    </div>
                </div>
                <div class="fgrid">
                    @foreach ($heroImgDefaults as $key => $defaultPath)
                        <div class="a-field">
                            <label>স্লাইড {{ bn_num($loop->iteration) }}</label>
                            @if ($current($key))
                                <img src="{{ asset($current($key)) }}" alt="slide" class="content-img-preview">
                            @else
                                <img src="{{ asset($defaultPath) }}" alt="slide default" class="content-img-preview" style="opacity:.55">
                            @endif
                            <input class="a-input" type="file" name="{{ $key }}" accept="image/*">
                            @if ($current($key))
                                <label style="margin-top:6px;font-weight:600;display:flex;gap:6px;align-items:center">
                                    <input type="checkbox" name="{{ $key }}_remove" value="1"> ডিফল্ট ছবিতে ফিরুন
                                </label>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="ct-savebar">
                <button class="a-btn" style="padding:12px 28px"><i class="fa-solid fa-floppy-disk"></i> হিরো সেভ করুন</button>
                <span class="ct-savehint">এই ট্যাবের সব ঘর একসাথে সেভ হয়</span>
            </div>
        </form>
    </div>

    {{-- ================= ট্যাব ২: সেকশন লেখা ================= --}}
    <div class="tab-panel" id="tab-sections" hidden>
        <form method="POST" action="{{ route('admin.settings.content.save') }}" class="rep-form">
            @csrf
            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#059669"><i class="fa-solid fa-arrows-left-right"></i></span>
                    <div>
                        <b>উপরের চলমান লেখা (মার্কি)</b>
                        <small>হিরোর নিচে একটানা চলমান ট্রাস্ট-বার্তা</small>
                    </div>
                </div>
                <div class="rep" data-json="marquee_json">
                    @foreach ($marqueeRows as $row)
                        <div class="rep-row">
                            <input class="a-input" data-k="bn" value="{{ $rf($row['bn'] ?? '') }}" placeholder="বাংলা লেখা">
                            <input class="a-input" data-k="en" value="{{ $rf($row['en'] ?? '') }}" placeholder="English">
                            <button type="button" class="btn-icon rep-del" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="a-btn ghost rep-add" style="margin-top:10px"><i class="fa-solid fa-plus"></i> নতুন আইটেম</button>
                <input type="hidden" name="marquee_json">
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#d97706"><i class="fa-solid fa-jar"></i></span>
                    <div>
                        <b>প্রোডাক্ট সেকশন</b>
                        <small>প্রোডাক্ট দেখানোর অংশের হেডিং ও ফিল্টার বাটন</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('prod_eyebrow', 'উপরের ছোট লেখা', false, 'যেমন: আমাদের প্রোডাক্ট') !!}
                    {!! $tf('prod_h2a', 'হেডিং — সাদা অংশ', false, 'যেমন: বেছে নিন') !!}
                    {!! $tf('prod_h2b', 'হেডিং — রঙিন অংশ', false, 'যেমন: পছন্দের আচার') !!}
                    {!! $tf('prod_sub', 'নিচের লেখা', true, 'এক লাইনের বর্ণনা') !!}
                </div>
                <h4 class="ct-sub">ফিল্টার বাটনের লেবেল</h4>
                <div class="fgrid">
                    {!! $tf('filter_all', '“সব” বাটন') !!}
                    {!! $tf('filter_pickle', '“আচার” বাটন') !!}
                    {!! $tf('filter_pure', '“মধু ও ঘি” বাটন') !!}
                    {!! $tf('filter_chaatni', '“চাটনি” বাটন') !!}
                </div>
                <p class="desc">ফিল্টারের সংখ্যা প্রোডাক্ট থেকে অটো আসে — এখানে শুধু লেখা বদলান।</p>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#16a34a"><i class="fa-solid fa-shield-halved"></i></span>
                    <div>
                        <b>আমাদের গ্যারান্টি (৪ কার্ড)</b>
                        <small>প্রোডাক্টের নিচের ৪টি গ্যারান্টি কার্ড</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('promise_eyebrow', 'উপরের ছোট লেখা') !!}
                    {!! $tf('promise_h2a', 'হেডিং — সাদা অংশ') !!}
                    {!! $tf('promise_h2b', 'হেডিং — রঙিন অংশ') !!}
                    {!! $tf('promise_sub', 'নিচের লেখা', true) !!}
                </div>
                @foreach ([1, 2, 3, 4] as $i)
                    <h4 class="ct-sub">কার্ড {{ bn_num($i) }}</h4>
                    <div class="fgrid">
                        {!! $tf("promise_c{$i}_t", 'টাইটেল') !!}
                        {!! $tf("promise_c{$i}_d", 'বর্ণনা', true) !!}
                        {!! $tf("promise_c{$i}_tag", 'কোণার ছোট ট্যাগ') !!}
                    </div>
                @endforeach
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#0ea5e9"><i class="fa-solid fa-list-ol"></i></span>
                    <div>
                        <b>কীভাবে অর্ডার হয় (৩ ধাপ)</b>
                        <small>অর্ডার প্রক্রিয়ার ৩টি ধাপের কার্ড</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('steps_eyebrow', 'উপরের ছোট লেখা') !!}
                    {!! $tf('steps_h2a', 'হেডিং — সাদা অংশ') !!}
                    {!! $tf('steps_h2b', 'হেডিং — রঙিন অংশ') !!}
                    {!! $tf('steps_sub', 'নিচের লেখা', true) !!}
                </div>
                @foreach ([1, 2, 3] as $i)
                    <h4 class="ct-sub">ধাপ {{ bn_num($i) }}</h4>
                    <div class="fgrid">
                        {!! $tf("step{$i}_t", 'টাইটেল') !!}
                        {!! $tf("step{$i}_d", 'বর্ণনা', true) !!}
                    </div>
                @endforeach
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#7c3aed"><i class="fa-solid fa-award"></i></span>
                    <div>
                        <b>কেন আমরা সেরা</b>
                        <small>১টি বড় কার্ড + ৪টি ছোট কার্ড</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('why_eyebrow', 'উপরের ছোট লেখা') !!}
                    {!! $tf('why_h2a', 'হেডিং — সাদা অংশ') !!}
                    {!! $tf('why_h2b', 'হেডিং — রঙিন অংশ') !!}
                    {!! $tf('why_sub', 'নিচের লেখা', true) !!}
                </div>
                <h4 class="ct-sub">বড় কার্ড</h4>
                <div class="fgrid">
                    {!! $tf('why_big_t', 'বড় কার্ড — টাইটেল') !!}
                    {!! $tf('why_verified', 'ভেরিফাইড লেবেল') !!}
                    {!! $tf('why_big_d', 'বড় কার্ড — বর্ণনা', true) !!}
                </div>
                @foreach ([1, 2, 3, 4] as $i)
                    <h4 class="ct-sub">সেল {{ bn_num($i) }}</h4>
                    <div class="fgrid">
                        {!! $tf("why_c{$i}_t", 'টাইটেল') !!}
                        {!! $tf("why_c{$i}_d", 'বর্ণনা', true) !!}
                    </div>
                @endforeach
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#dc2626"><i class="fa-solid fa-circle-question"></i></span>
                    <div>
                        <b>প্রশ্ন-উত্তর (FAQ)</b>
                        <small>গ্রাহকের সাধারণ প্রশ্নগুলো</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('faq_eyebrow', 'উপরের ছোট লেখা') !!}
                    {!! $tf('faq_h2a', 'হেডিং — সাদা অংশ') !!}
                    {!! $tf('faq_h2b', 'হেডিং — রঙিন অংশ') !!}
                    {!! $tf('faq_sub', 'নিচের লেখা', true) !!}
                </div>
                <div class="rep" data-json="faq_json">
                    @foreach ($faqRows as $row)
                        <div class="rep-row rep-row-block">
                            <div class="rep-line"><input class="a-input" data-k="q_bn" value="{{ $rf($row['q_bn'] ?? '') }}" placeholder="প্রশ্ন (বাংলা)"><input class="a-input" data-k="q_en" value="{{ $rf($row['q_en'] ?? '') }}" placeholder="Question (English)"><button type="button" class="btn-icon rep-del" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button></div>
                            <div class="rep-line"><textarea class="a-input" rows="2" data-k="a_bn" placeholder="উত্তর (বাংলা)">{{ $rf($row['a_bn'] ?? '') }}</textarea><textarea class="a-input" rows="2" data-k="a_en" placeholder="Answer (English)">{{ $rf($row['a_en'] ?? '') }}</textarea></div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="a-btn ghost rep-add" style="margin-top:10px"><i class="fa-solid fa-plus"></i> নতুন প্রশ্ন</button>
                <input type="hidden" name="faq_json">
            </div>

            <div class="ct-savebar">
                <button class="a-btn" style="padding:12px 28px"><i class="fa-solid fa-floppy-disk"></i> সেকশন লেখা সেভ করুন</button>
                <span class="ct-savehint">এই ট্যাবের সব ঘর একসাথে সেভ হয়</span>
            </div>
        </form>
    </div>

    {{-- ================= ট্যাব ৩: অর্ডার ফর্ম ও রিভিউ ================= --}}
    <div class="tab-panel" id="tab-order" hidden>
        <form method="POST" action="{{ route('admin.settings.content.save') }}">
            @csrf
            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#059669"><i class="fa-solid fa-cart-shopping"></i></span>
                    <div>
                        <b>অর্ডার বক্সের হেডিং ও লেবেল</b>
                        <small>কার্ট, কুপন ও ডেলিভারি তথ্য বক্সের লেখা</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('order_head_a', 'হেডিং — সাদা অংশ') !!}
                    {!! $tf('order_head_b', 'হেডিং — সবুজ অংশ') !!}
                    {!! $tf('order_head_c', 'হেডিং — শেষের অংশ') !!}
                    {!! $tf('order_head_sub', 'হেডিংয়ের নিচের লাইন', true) !!}
                </div>
                <div class="fgrid">
                    {!! $tf('cart_title', 'কার্ট বক্সের টাইটেল') !!}
                    {!! $tf('cart_coupon_ph', 'কুপন ইনপুটের লেখা') !!}
                    {!! $tf('cart_coupon_note', 'কুপনের নিচের নোট', true) !!}
                </div>
                <div class="fgrid">
                    {!! $tf('cart_col_mark', 'কার্ট কলাম — মার্ক') !!}
                    {!! $tf('cart_col_product', 'কার্ট কলাম — প্রোডাক্ট') !!}
                    {!! $tf('cart_col_qty', 'কার্ট কলাম — পরিমাণ') !!}
                    {!! $tf('cart_col_price', 'কার্ট কলাম — মূল্য') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('cart_total_sub', 'মোট লেবেল') !!}
                    {!! $tf('cart_total_delivery', 'ডেলিভারি চার্জ লেবেল') !!}
                    {!! $tf('cart_total_grand', 'সর্বমোট লেবেল') !!}
                    {!! $tf('cart_empty', 'কার্ট খালির লেখা', true) !!}
                </div>
                <div class="fgrid">
                    {!! $tf('advance_title', 'অগ্রিম পেমেন্ট টাইটেল') !!}
                    {!! $tf('advance_payable', 'এখন দিতে হবে লেবেল') !!}
                    {!! $tf('advance_due', 'বাকি লেবেল') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('checkout_title', 'ডেলিভারি তথ্য বক্সের টাইটেল') !!}
                    {!! $tf('f_name_ph', 'নাম ইনপুটের লেখা') !!}
                    {!! $tf('f_phone_ph', 'মোবাইল ইনপুটের লেখা') !!}
                    {!! $tf('f_address_ph', 'ঠিকানা ইনপুটের লেখা') !!}
                    {!! $tf('f_area', 'ডেলিভারি এরিয়া লেবেল') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('area_pick', 'প্রোডাক্ট না বাছলে দেখানো লেখা') !!}
                    {!! $tf('area_free', 'ফ্রি ডেলিভারির লেখা') !!}
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#d97706"><i class="fa-solid fa-truck-fast"></i></span>
                    <div>
                        <b>ডেলিভারি চার্জ (টাকা)</b>
                        <small>চেকআউটে অটো যোগ হয়</small>
                    </div>
                </div>
                <div class="fgrid">
                    <div class="a-field"><label>ঢাকার ভিতরে (৳)</label>
                        <input class="a-input" type="number" min="0" name="delivery_inside" value="{{ $rf($s['delivery_inside'] ?? '') }}" placeholder="80"></div>
                    <div class="a-field"><label>ঢাকার বাইরে (৳)</label>
                        <input class="a-input" type="number" min="0" name="delivery_outside" value="{{ $rf($s['delivery_outside'] ?? '') }}" placeholder="150"></div>
                    <div class="a-field"><label>“ঢাকার ভিতরে” অপশনের লেখা (বাংলা)</label>
                        <input class="a-input" name="area_inside_bn" value="{{ $rf($s['area_inside_bn'] ?? '') }}" placeholder="ঢাকার ভিতরে"></div>
                    <div class="a-field"><label>Inside Dhaka (English)</label>
                        <input class="a-input" name="area_inside_en" value="{{ $rf($s['area_inside_en'] ?? '') }}" placeholder="Inside Dhaka"></div>
                    <div class="a-field"><label>“ঢাকার বাইরে” অপশনের লেখা (বাংলা)</label>
                        <input class="a-input" name="area_outside_bn" value="{{ $rf($s['area_outside_bn'] ?? '') }}" placeholder="ঢাকার বাহিরে"></div>
                    <div class="a-field"><label>Outside Dhaka (English)</label>
                        <input class="a-input" name="area_outside_en" value="{{ $rf($s['area_outside_en'] ?? '') }}" placeholder="Outside Dhaka"></div>
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#7c3aed"><i class="fa-solid fa-credit-card"></i></span>
                    <div>
                        <b>পেমেন্ট ও সাবমিট</b>
                        <small>পেমেন্ট অপশন ও অর্ডার কনফার্ম বাটনের লেখা</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('pay_method', 'পেমেন্ট মেথড টাইটেল') !!}
                    {!! $tf('pay_cod', 'COD — টাইটেল') !!}
                    {!! $tf('pay_cod_sub', 'COD — ছোট লেখা') !!}
                    {!! $tf('pay_online', 'অনলাইন পেমেন্ট টগলের লেখা') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('pay_online_note_a', 'অনলাইন পেমেন্ট নোট — শুরু') !!}
                    {!! $tf('pay_online_note_b', 'অনলাইন পেমেন্ট নোট — শেষ') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('confirm_order', 'কনফার্ম বাটনের লেখা', false, 'যেমন: অর্ডার কনফার্ম করুন') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('trust_1', 'ট্রাস্ট ব্যাজ ১') !!}
                    {!! $tf('trust_2', 'ট্রাস্ট ব্যাজ ২') !!}
                    {!! $tf('trust_3', 'ট্রাস্ট ব্যাজ ৩') !!}
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#e11d48"><i class="fa-solid fa-star"></i></span>
                    <div>
                        <b>রিভিউ সেকশন</b>
                        <small>গ্রাহকদের রিভিউ অংশের হেডিং</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('reviews_eyebrow', 'উপরের ছোট লেখা') !!}
                    {!! $tf('reviews_h2a', 'হেডিং — সাদা অংশ') !!}
                    {!! $tf('reviews_h2b', 'হেডিং — রঙিন অংশ') !!}
                    {!! $tf('reviews_sub', 'নিচের লেখা', true) !!}
                </div>
                <div class="fgrid">
                    {!! $tf('rating_score', 'রেটিং স্কোর', false, 'যেমন: ৪.৯') !!}
                    {!! $tf('rating_total', 'মোট রিভিউ লেখা', false, 'যেমন: ৫৩২টি ভেরিফাইড রিভিউ') !!}
                </div>
            </div>

            <div class="ct-savebar">
                <button class="a-btn" style="padding:12px 28px"><i class="fa-solid fa-floppy-disk"></i> অর্ডার ফর্ম সেভ করুন</button>
                <span class="ct-savehint">এই ট্যাবের সব ঘর একসাথে সেভ হয়</span>
            </div>
        </form>
    </div>

    {{-- ================= ট্যাব ৪: নেভিগেশন ও ফুটার ================= --}}
    <div class="tab-panel" id="tab-footer" hidden>
        <form method="POST" action="{{ route('admin.settings.content.save') }}">
            @csrf
            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#059669"><i class="fa-solid fa-bullhorn"></i></span>
                    <div>
                        <b>নিচের CTA (অর্ডারের আহ্বান)</b>
                        <small>রিভিউয়ের পরের বড় সবুজ বক্স</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('cta_h2a', 'হেডিং — সাদা অংশ') !!}
                    {!! $tf('cta_h2b', 'হেডিং — রঙিন অংশ') !!}
                    {!! $tf('cta_sub', 'নিচের লেখা', true) !!}
                    {!! $tf('cta_btn', 'বাটনের লেখা') !!}
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#0ea5e9"><i class="fa-solid fa-compass"></i></span>
                    <div>
                        <b>নেভিগেশন (উপরের মেনু)</b>
                        <small>হেডারের মেনু ও লোগোর পাশের পিল</small>
                    </div>
                </div>
                <div class="fgrid">
                    {!! $tf('logo_pill', 'লোগোর পাশের পিল', false, 'যেমন: খাঁটি') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('nav_home', 'মেনু — হোম') !!}
                    {!! $tf('nav_products', 'মেনু — সব প্রোডাক্ট') !!}
                    {!! $tf('nav_why', 'মেনু — কেন আমরা') !!}
                    {!! $tf('nav_reviews', 'মেনু — রিভিউ') !!}
                    {!! $tf('nav_faq', 'মেনু — প্রশ্ন-উত্তর') !!}
                    {!! $tf('nav_order', 'হেডারের অর্ডার বাটন') !!}
                </div>
            </div>

            <div class="ct-sec">
                <div class="ct-sec-head">
                    <span class="ct-ic" style="--cc:#64748b"><i class="fa-solid fa-window-maximize"></i></span>
                    <div>
                        <b>ফুটার</b>
                        <small>পেজের একদম নিচের অংশ</small>
                    </div>
                </div>
                <div class="fgrid">{!! $tf('footer_tag', 'ফুটারের বর্ণনা', true) !!}</div>
                <div class="fgrid">
                    {!! $tf('footer_col_links', 'কলাম টাইটেল — কুইক লিংক') !!}
                    {!! $tf('footer_col_contact', 'কলাম টাইটেল — যোগাযোগ') !!}
                    {!! $tf('footer_fb', 'ফেসবুক পেজ লেখা') !!}
                </div>
                <div class="fgrid">
                    {!! $tf('footer_rights', 'কপিরাইট লাইন') !!}
                    {!! $tf('footer_made', 'Made with love লাইন') !!}
                </div>
                <p class="desc">ফোন/WhatsApp/Facebook বদলাতে <a href="{{ route('admin.settings.brand') }}">লোগো ও ব্র্যান্ড</a> পেজে যান। কপিরাইটের বছর অটো বসে।</p>
            </div>

            <div class="ct-savebar">
                <button class="a-btn" style="padding:12px 28px"><i class="fa-solid fa-floppy-disk"></i> নেভিগেশন ও ফুটার সেভ করুন</button>
                <span class="ct-savehint">এই ট্যাবের সব ঘর একসাথে সেভ হয়</span>
            </div>
        </form>
    </div>
@endsection

@section('styles')
    <style>
        .ct-sec {
            background: #fff; border: 1px solid rgba(5, 150, 105, .12); border-radius: 14px;
            padding: 18px 20px; margin-bottom: 16px;
        }
        .ct-sec-head { display: flex; gap: 12px; align-items: center; margin-bottom: 14px; }
        .ct-ic {
            width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 14px;
            background: color-mix(in srgb, var(--cc, #059669) 12%, white);
            color: var(--cc, #059669);
        }
        .ct-sec-head b { display: block; font-size: 14.5px; color: #12261d; }
        .ct-sec-head small { display: block; font-size: 12px; color: #8b7355; margin-top: 2px; }
        .ct-sub { margin: 16px 0 8px; font-size: 13px; color: #1f4234; font-weight: 800;
            padding-left: 10px; border-left: 3px solid rgba(5, 150, 105, .35); }
        .ct-savebar {
            display: flex; gap: 12px; align-items: center; position: sticky; bottom: 12px;
            background: #fff; border: 1px solid rgba(5, 150, 105, .2); border-radius: 14px;
            padding: 12px 18px; box-shadow: 0 18px 40px -18px rgba(6, 78, 59, .45); z-index: 5;
        }
        .ct-savehint { font-size: 12px; color: #8b7355; }
    </style>
@endsection

@push('scripts')
    <script>
        // tab switching
        document.querySelectorAll('#contentTabs .filter-tab').forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('#contentTabs .filter-tab').forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(function (p) { p.hidden = (p.id !== 'tab-' + tab.dataset.tab); });
            });
        });

        // repeaters: এক form-এ একাধিক .rep ব্লক থাকলেও সবগুলো কাজ করে
        document.querySelectorAll('.rep-form').forEach(function (form) {
            var hiddenMap = {};
            form.querySelectorAll('.rep').forEach(function (wrap) {
                var hidden = form.querySelector('input[type=hidden][name="' + wrap.dataset.json + '"]');
                if (!hidden) return;
                hiddenMap[wrap.dataset.json] = hidden;

                function bindDel(row) {
                    row.querySelectorAll('.rep-del').forEach(function (btn) {
                        btn.addEventListener('click', function () { row.remove(); });
                    });
                }
                wrap.querySelectorAll('.rep-row').forEach(bindDel);

                var addBtn = form.querySelector('.rep-add[data-for="' + wrap.dataset.json + '"]');
                if (addBtn) {
                    addBtn.addEventListener('click', function () {
                        var clone = wrap.querySelector('.rep-row').cloneNode(true);
                        clone.querySelectorAll('[data-k]').forEach(function (el) { el.value = ''; });
                        bindDel(clone);
                        wrap.appendChild(clone);
                    });
                }
            });

            form.addEventListener('submit', function () {
                form.querySelectorAll('.rep').forEach(function (wrap) {
                    var hidden = hiddenMap[wrap.dataset.json];
                    if (!hidden) return;
                    var rows = [];
                    wrap.querySelectorAll('.rep-row').forEach(function (row) {
                        var obj = {};
                        var hasValue = false;
                        row.querySelectorAll('[data-k]').forEach(function (el) {
                            var v = el.value.trim();
                            obj[el.dataset.k] = v;
                            if (v !== '') hasValue = true;
                        });
                        if (hasValue) rows.push(obj);
                    });
                    hidden.value = rows.length ? JSON.stringify(rows) : '';
                });
                Object.keys(hiddenMap).forEach(function (k) {
                    var h = form.querySelector('input[type=hidden][name="' + k + '"]');
                    if (h && h.value === '') h.value = '[]';
                });
            });
        });
    </script>
@endpush
