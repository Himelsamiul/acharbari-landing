@extends('layouts.admin')

@section('title', 'ল্যান্ডিং কনটেন্ট')
@section('page_title', 'ল্যান্ডিং কনটেন্ট')
@section('page_sub', 'ল্যান্ডিং পেজের সব টেক্সট, ছবি ও তথ্য — কোড ছাড়াই বদলান')

@section('content')
    @php
        $s = $settings;
        // bilingual text-field pair (ab_t pattern: empty input keeps the landing default)
        $tf = function (string $key, string $label, bool $long = false) use ($s) {
            $bn = e($s[$key . '_bn'] ?? '');
            $en = e($s[$key . '_en'] ?? '');
            $tag = $long ? 'textarea rows="2"' : 'input';
            $bnField = $long
                ? '<textarea class="a-input" name="' . $key . '_bn">' . $bn . '</textarea>'
                : '<input class="a-input" name="' . $key . '_bn" value="' . $bn . '">';
            $enField = $long
                ? '<textarea class="a-input" name="' . $key . '_en">' . $en . '</textarea>'
                : '<input class="a-input" name="' . $key . '_en" value="' . $en . '">';
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
            ['bn' => '১০০% প্রাকৃতিক — প্রিজারভেটিভ ও কেমিক্যাল মুক্ত', 'en' => '100% natural — no preservatives or chemicals'],
            ['bn' => 'ছোট ব্যাচে ভালোবাসা দিয়ে হাতে তৈরি', 'en' => 'Handcrafted in small batches with love'],
            ['bn' => '২৪/৭ ডেডিকেটেড কাস্টমার সাপোর্ট', 'en' => '24/7 dedicated customer support'],
        ]);
        $faqRows = $jsonOf('faq_items', [
            ['q_bn' => 'প্রোডাক্ট হাতে পেয়ে কি টাকা দেওয়া যাবে?', 'q_en' => 'Can I pay cash after receiving the product?', 'a_bn' => 'হ্যাঁ, ১০০% ক্যাশ অন ডেলিভারি সুবিধা রয়েছে — ডেলিভারি ম্যানের সামনে সিল করা জার চেক করে টাকা পরিশোধ করতে পারবেন। কোনো অগ্রিম টাকা লাগবে না।', 'a_en' => 'Yes, we have 100% Cash on Delivery — check the sealed jar in front of the delivery man and then pay. No advance money is needed.'],
            ['q_bn' => 'আচার কতদিন ভালো থাকে? প্রিজারভেটিভ আছে কি?', 'q_en' => 'How long do the pickles last? Any preservatives?', 'a_bn' => 'সঠিক পদ্ধতিতে তৈরি ও খাঁটি সরিষার তেল, পর্যাপ্ত লবণ ও বিশুদ্ধ মসলার কারণে আমাদের আচার ঘরের তাপমাত্রায় ১২ মাস পর্যন্ত ভালো থাকে। প্রিজারভেটিভ, কালার ও কেমিক্যাল সম্পূর্ণ মুক্ত।', 'a_en' => 'Our pickles stay good for 12 months at room temperature — made the traditional way with premium mustard oil, enough salt and pure spices. Completely free of preservatives, colours and chemicals.'],
            ['q_bn' => 'ডেলিভারি চার্জ কত টাকা?', 'q_en' => 'What is the delivery charge?', 'a_bn' => 'ঢাকার ভেতরের জন্য ডেলিভারি চার্জ ৮০ টাকা এবং ঢাকার বাইরের জন্য ১৫০ টাকা। বিশেষ অফার চলাকালীন অনেক প্রোডাক্টে ফ্রি ডেলিভারিও থাকে।', 'a_en' => 'Delivery charge is ৳80 inside Dhaka and ৳150 outside Dhaka. During special offers many products also get free delivery.'],
            ['q_bn' => 'জার ভেঙে বা লিক হয়ে এলে কী করব?', 'q_en' => 'What if the jar arrives broken or leaked?', 'a_bn' => 'পার্সেল পাওয়ার ২৪ ঘণ্টার মধ্যে ছবি দিয়ে আমাদের হেল্পলাইনে জানালেই আমরা সম্পূর্ণ ফ্রি রিপ্লেসমেন্ট করে দেব।', 'a_en' => 'Just inform our helpline with a photo within 24 hours of receiving the parcel — we will replace it completely free of charge.'],
            ['q_bn' => 'অর্ডার কীভাবে ট্র্যাক করব?', 'q_en' => 'How do I track my order?', 'a_bn' => 'অর্ডার দেওয়ার পর ওয়েবসাইটের "অর্ডার ট্র্যাক" বাটন থেকে আপনার মোবাইল নম্বর অথবা ইনভয়েস আইডি দিয়ে লাইভ স্ট্যাটাস দেখতে পারবেন।', 'a_en' => 'You can see live status from the "Order Track" button on the website using your mobile number or invoice ID.'],
        ]);
        $reviewRows = $jsonOf('reviews_items', [
            ['img' => 'assets/img/rev1.jpg', 'name' => 'নুসরাত জাহান', 'loc_bn' => 'ভেরিফাইড পারচেজ • ঢাকা', 'loc_en' => 'Verified Purchase • Dhaka', 'text_bn' => '"আমের কুচি আচারটা একদম ঠাকুমার বানানো আচারের মতোই লেগেছে! তেল বেশি না, ঝাল-নোনতা পারফেক্ট ব্যালেন্স। ঢাকায় একদিনের মধ্যেই ডেলিভারি পেয়েছি!"', 'text_en' => '"The mango kuchi achar tastes exactly like my grandmother used to make! Not too oily, perfectly spiced. Delivery arrived within a day in Dhaka!"', 'stars' => 5, 'likes_bn' => 'Like (২৪)', 'likes_en' => 'Like (24)'],
            ['img' => 'assets/img/rev2.jpg', 'name' => 'ফারহানা ইয়াসমিন', 'loc_bn' => 'ভেরিফাইড পারচেজ • চট্টগ্রাম', 'loc_en' => 'Verified Purchase • Chattogram', 'text_bn' => '"মিক্সড প্যাকের প্যাকেজিং দেখে মুগ্ধ! তিনটা আলাদা সিল করা জার, এক ফোঁটাও লিক হয়নি। জলপাই আচারটা বছরের পর বছর ধরে খাওয়া সেরা আচার!"', 'text_en' => '"The mixed pack packaging was amazing — three sealed jars, not a drop leaked. The olive pickle is the best I have had in years!"', 'stars' => 5, 'likes_bn' => 'Like (১৮)', 'likes_en' => 'Like (18)'],
            ['img' => 'assets/img/rev3.jpg', 'name' => 'তানজিনা আক্তার', 'loc_bn' => 'ভেরিফাইড পারচেজ • রাজশাহী', 'loc_en' => 'Verified Purchase • Rajshahi', 'text_bn' => '"অবশেষে খাঁটি কাঁচা মধু পেলাম! শীতে প্রাকৃতিকভাবে সেট হয়ে গেছে — খাঁটি হওয়ার সবচেয়ে বড় প্রমাণ। পুরো পরিবারের সবাই খুব পছন্দ করেছে।"', 'text_en' => '"Finally found pure raw Sundarban honey! It crystallised naturally in winter — proof that it is real. The whole family loves it."', 'stars' => 5, 'likes_bn' => 'Like (৩১)', 'likes_en' => 'Like (31)'],
            ['img' => 'assets/img/rev4.jpg', 'name' => 'মেহেজাবীন চৌধুরী', 'loc_bn' => 'ভেরিফাইড পারচেজ • সিলেট', 'loc_en' => 'Verified Purchase • Sylhet', 'text_bn' => '"ঘি খুলতেই পুরো রান্নাঘর ঘ্রাণে ভরে গেল! গরম ভাতে এক চামচ ঘি মানেই আসল স্বাদ। আপনার বোনের জন্য আরও ৩টা অর্ডার দিয়েছি।"', 'text_en' => '"The ghee aroma fills the whole kitchen! One spoon on hot rice and you are in heaven. Ordered 3 more jars for my sister."', 'stars' => 5, 'likes_bn' => 'Like (১৫)', 'likes_en' => 'Like (15)'],
            ['img' => 'assets/img/rev5.jpg', 'name' => 'সাবরিনা ইসলাম', 'loc_bn' => 'ভেরিফাইড পারচেজ • খুলনা', 'loc_en' => 'Verified Purchase • Khulna', 'text_bn' => '"প্রথমবার অনলাইনে আচার অর্ডার করলাম এবং অভিজ্ঞতা দারুণ! ডেলিভারি ম্যানের সামনে চেক করে টাকা দিলাম। রিকমেন্ডেড শপ।"', 'text_en' => '"First time ordering pickles online and the experience was great! Checked the parcel in front of the delivery man and then paid. Recommended shop."', 'stars' => 5, 'likes_bn' => 'Like (২৯)', 'likes_en' => 'Like (29)'],
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
        <span>যেকোনো ঘর <b>খালি রাখলে</b> ল্যান্ডিং পেজে বর্তমান ডিফল্ট লেখা দেখাবে — কোনো ঘর ফাঁকা দেখাবে না। বদলাতে চাইলে নতুন লেখা বসিয়ে সেভ করুন, আবার ডিফল্টে ফিরতে ঘরটি মুছে খালি করে সেভ করুন।</span>
        <span style="display:inline-flex;gap:8px;margin-left:10px;flex-wrap:wrap">
            <a href="{{ url('/') }}#ds-hero" target="_blank" rel="noopener" class="a-btn ghost" style="padding:5px 12px;font-size:12px">হিরো প্রিভিউ</a>
            <a href="{{ url('/') }}#ds-products" target="_blank" rel="noopener" class="a-btn ghost" style="padding:5px 12px;font-size:12px">প্রোডাক্ট প্রিভিউ</a>
            <a href="{{ url('/') }}#order-form" target="_blank" rel="noopener" class="a-btn ghost" style="padding:5px 12px;font-size:12px">অর্ডার ফর্ম প্রিভিউ</a>
            <a href="{{ url('/') }}#lp-footer" target="_blank" rel="noopener" class="a-btn ghost" style="padding:5px 12px;font-size:12px">Footer প্রিভিউ</a>
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="a-btn" style="padding:5px 12px;font-size:12px"><i class="fa-solid fa-eye"></i> সম্পূর্ণ লাইভ প্রিভিউ</a>
        </span>
    </div>

    <div class="filter-tabs" id="contentTabs">
        <a class="filter-tab active" href="#" data-tab="hero"><i class="fa-solid fa-rocket"></i> হিরো</a>
        <a class="filter-tab" href="#" data-tab="sections"><i class="fa-solid fa-heading"></i> সেকশন হেডিং</a>
        <a class="filter-tab" href="#" data-tab="order"><i class="fa-solid fa-cart-shopping"></i> অর্ডার ফর্ম ও রিভিউ</a>
        <a class="filter-tab" href="#" data-tab="footer"><i class="fa-solid fa-window-maximize"></i> Footer ও নেভিগেশন</a>
    </div>

    {{-- ================= TAB 1: HERO ================= --}}
    <div class="card tab-panel" id="tab-hero">
        <form method="POST" action="{{ route('admin.settings.content.save') }}" enctype="multipart/form-data">
            @csrf
            <h3>হিরো টেক্সট</h3>
            <p class="desc">ল্যান্ডিংয়ের সবার উপরের অংশ — চিপ, ৩টি শিরোনাম স্লাইড, বিবরণ ও বাটন</p>
            <div class="fgrid">{!! $tf('hero_chip', 'চিপ (ছোট ব্যাজ)') !!}</div>
            <div class="fgrid">{!! $tf('hero_s1_main', 'শিরোনাম ১ — মূল অংশ') !!}{!! $tf('hero_s1_grad', 'শিরোনাম ১ — রঙিন অংশ') !!}</div>
            <div class="fgrid">{!! $tf('hero_s2_main', 'শিরোনাম ২ — মূল অংশ') !!}{!! $tf('hero_s2_grad', 'শিরোনাম ২ — রঙিন অংশ') !!}</div>
            <div class="fgrid">{!! $tf('hero_s3_main', 'শিরোনাম ৩ — মূল অংশ') !!}{!! $tf('hero_s3_grad', 'শিরোনাম ৩ — রঙিন অংশ') !!}</div>
            <div class="fgrid">{!! $tf('hero_lead', 'বিবরণ (লিড প্যারা)', true) !!}</div>
            <div class="fgrid">{!! $tf('hero_cta1', 'বাটন ১') !!}{!! $tf('hero_cta2', 'বাটন ২') !!}</div>

            <h3 style="margin-top:22px">হিরো স্ট্যাট (৪টি)</h3>
            <div class="fgrid">
                @foreach ([1, 2, 3, 4] as $i)
                    <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — সংখ্যা (বাংলা)</label>
                        <input class="a-input" name="hero_stat{{ $i }}_n_bn" value="{{ $rf($s['hero_stat' . $i . '_n_bn'] ?? '') }}" placeholder="যেমন: ১৫,০০০+"></div>
                    <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — সংখ্যা (English)</label>
                        <input class="a-input" name="hero_stat{{ $i }}_n_en" value="{{ $rf($s['hero_stat' . $i . '_n_en'] ?? '') }}" placeholder="e.g. 15,000+"></div>
                    <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — লেবেল (বাংলা)</label>
                        <input class="a-input" name="hero_stat{{ $i }}_bn" value="{{ $rf($s['hero_stat' . $i . '_bn'] ?? '') }}"></div>
                    <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — লেবেল (English)</label>
                        <input class="a-input" name="hero_stat{{ $i }}_en" value="{{ $rf($s['hero_stat' . $i . '_en'] ?? '') }}"></div>
                @endforeach
            </div>

            <h3 style="margin-top:22px">ফ্ল্যাশ ট্যাগ ও ফ্লোটিং ব্যাজ</h3>
            <div class="fgrid">{!! $tf('hero_flash', 'ছবির কোণের ফ্ল্যাশ ট্যাগ') !!}</div>
            <div class="fgrid">{!! $tf('hero_badge1_t', 'ব্যাজ ১ — শিরোনাম') !!}{!! $tf('hero_badge1_s', 'ব্যাজ ১ — সাবটেক্সট') !!}</div>
            <div class="fgrid">{!! $tf('hero_badge2_t', 'ব্যাজ ২ — শিরোনাম') !!}{!! $tf('hero_badge2_s', 'ব্যাজ ২ — সাবটেক্সট') !!}</div>

            <h3 style="margin-top:22px">হিরো ছবি (৪টি স্লাইড)</h3>
            <p class="desc">খালি রাখলে বর্তমান ডিফল্ট ছবি দেখাবে • সর্বোচ্চ 2MB • JPG/PNG/WebP</p>
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
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> হিরো সেভ করুন</button>
        </form>
    </div>

    {{-- ================= TAB 2: SECTIONS ================= --}}
    <div class="card tab-panel" id="tab-sections" hidden>
        {{-- marquee --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" class="rep-form">
            @csrf
            <h3>উপরের চলমান লেখা (মার্কি)</h3>
            <p class="desc">হিরোর নিচে একটানা চলমান ট্রাস্ট-বার্তাগুলো</p>
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
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> মার্কি সেভ করুন</button>
        </form>

        {{-- product section --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" style="margin-top:26px">
            @csrf
            <h3>প্রোডাক্ট সেকশন</h3>
            <div class="fgrid">{!! $tf('prod_eyebrow', 'আইব্রো (ছোট লেবেল)') !!}{!! $tf('prod_h2a', 'হেডিং — প্রথম অংশ') !!}{!! $tf('prod_h2b', 'হেডিং — রঙিন অংশ') !!}{!! $tf('prod_sub', 'সাব-হেডিং', true) !!}</div>
            <h3 style="margin-top:16px">ফিল্টার বাটনের লেবেল</h3>
            <div class="fgrid">{!! $tf('filter_all', '“সব প্রোডাক্ট” বাটন') !!}{!! $tf('filter_pickle', '“আচার” বাটন') !!}{!! $tf('filter_pure', '“মধু ও ঘি” বাটন') !!}{!! $tf('filter_chaatni', '“চাটনি” বাটন') !!}</div>
            <p class="desc">বাটনের সংখ্যা প্রোডাক্ট থেকে অটো হিসাব হয় — এখানে শুধু লেখা বদলান।</p>
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> প্রোডাক্ট সেকশন সেভ করুন</button>
        </form>

        {{-- promises --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" style="margin-top:26px">
            @csrf
            <h3>আমাদের গ্যারান্টি (৪ কার্ড)</h3>
            <div class="fgrid">{!! $tf('promise_eyebrow', 'আইব্রো') !!}{!! $tf('promise_h2a', 'হেডিং — প্রথম অংশ') !!}{!! $tf('promise_h2b', 'হেডিং — রঙিন অংশ') !!}{!! $tf('promise_sub', 'সাব-হেডিং', true) !!}</div>
            @foreach ([1, 2, 3, 4] as $i)
                <h4 style="margin:16px 0 8px;font-size:13px">কার্ড {{ bn_num($i) }}</h4>
                <div class="fgrid">{!! $tf("promise_c{$i}_t", 'টাইটেল') !!}{!! $tf("promise_c{$i}_d", 'বর্ণনা', true) !!}{!! $tf("promise_c{$i}_tag", 'ট্যাগ') !!}</div>
            @endforeach
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> গ্যারান্টি সেভ করুন</button>
        </form>

        {{-- steps --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" style="margin-top:26px">
            @csrf
            <h3>কীভাবে অর্ডার হয় (৩ ধাপ)</h3>
            <div class="fgrid">{!! $tf('steps_eyebrow', 'আইব্রো') !!}{!! $tf('steps_h2a', 'হেডিং — প্রথম অংশ') !!}{!! $tf('steps_h2b', 'হেডিং — রঙিন অংশ') !!}{!! $tf('steps_sub', 'সাব-হেডিং', true) !!}</div>
            @foreach ([1, 2, 3] as $i)
                <h4 style="margin:16px 0 8px;font-size:13px">ধাপ {{ bn_num($i) }}</h4>
                <div class="fgrid">{!! $tf("step{$i}_t", 'টাইটেল') !!}{!! $tf("step{$i}_d", 'বর্ণনা', true) !!}</div>
            @endforeach
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> ধাপগুলো সেভ করুন</button>
        </form>

        {{-- why us --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" style="margin-top:26px">
            @csrf
            <h3>কেন আমরা সেরা</h3>
            <div class="fgrid">{!! $tf('why_eyebrow', 'আইব্রো') !!}{!! $tf('why_h2a', 'হেডিং — প্রথম অংশ') !!}{!! $tf('why_h2b', 'হেডিং — রঙিন অংশ (ব্র্যান্ড নাম)' ) !!}{!! $tf('why_sub', 'সাব-হেডিং', true) !!}</div>
            <h4 style="margin:16px 0 8px;font-size:13px">বড় কার্ড</h4>
            <div class="fgrid">{!! $tf('why_big_t', 'বড় কার্ড — টাইটেল') !!}{!! $tf('why_verified', 'ভেরিফাইড লেবেল') !!}{!! $tf('why_big_d', 'বড় কার্ড — বর্ণনা', true) !!}</div>
            @foreach ([1, 2, 3, 4] as $i)
                <h4 style="margin:16px 0 8px;font-size:13px">সেল {{ bn_num($i) }}</h4>
                <div class="fgrid">{!! $tf("why_c{$i}_t", 'টাইটেল') !!}{!! $tf("why_c{$i}_d", 'বর্ণনা', true) !!}</div>
            @endforeach
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> সেকশন সেভ করুন</button>
        </form>

        {{-- faq --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" class="rep-form" style="margin-top:26px">
            @csrf
            <h3>প্রশ্ন-উত্তর (FAQ)</h3>
            <div class="fgrid">{!! $tf('faq_eyebrow', 'আইব্রো') !!}{!! $tf('faq_h2a', 'হেডিং — প্রথম অংশ') !!}{!! $tf('faq_h2b', 'হেডিং — রঙিন অংশ') !!}{!! $tf('faq_sub', 'সাব-হেডিং', true) !!}</div>
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
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> FAQ সেভ করুন</button>
        </form>
    </div>

    {{-- ================= TAB 3: ORDER + REVIEWS ================= --}}
    <div class="card tab-panel" id="tab-order" hidden>
        {{-- order form --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}">
            @csrf
            <h3>অর্ডার ফর্মের হেডিং ও লেবেল</h3>
            <div class="fgrid">{!! $tf('order_head_a', 'হেডিং — শুরুর অংশ') !!}{!! $tf('order_head_b', 'হেডিং — সবুজ অংশ') !!}{!! $tf('order_head_c', 'হেডিং — শেষের অংশ') !!}{!! $tf('order_head_sub', 'হেডিংয়ের নিচের লাইন', true) !!}</div>
            <div class="fgrid">{!! $tf('cart_title', 'কার্ট বক্সের টাইটেল') !!}{!! $tf('cart_coupon_ph', 'কুপন ইনপুট প্লেসহোল্ডার') !!}{!! $tf('cart_coupon_note', 'কুপনের নিচের নোট', true) !!}</div>
            <div class="fgrid">{!! $tf('cart_col_mark', 'কার্ট কলাম — মার্ক') !!}{!! $tf('cart_col_product', 'কার্ট কলাম — প্রোডাক্ট') !!}{!! $tf('cart_col_qty', 'কার্ট কলাম — পরিমাণ') !!}{!! $tf('cart_col_price', 'কার্ট কলাম — মূল্য') !!}</div>
            <div class="fgrid">{!! $tf('cart_total_sub', 'মোট লেবেল') !!}{!! $tf('cart_total_delivery', 'ডেলিভারি চার্জ লেবেল') !!}{!! $tf('cart_total_grand', 'সর্বমোট লেবেল') !!}{!! $tf('cart_empty', 'কার্ট খালি থাকলে দেখানোর লেখা', true) !!}</div>
            <div class="fgrid">{!! $tf('advance_title', 'অগ্রিম পেমেন্ট — টাইটেল') !!}{!! $tf('advance_payable', 'এখন দিতে হবে লেবেল') !!}{!! $tf('advance_due', 'বাকি লেবেল') !!}</div>
            <div class="fgrid">{!! $tf('checkout_title', 'ডেলিভারি তথ্য বক্সের টাইটেল') !!}{!! $tf('f_name_ph', 'নাম ইনপুট প্লেসহোল্ডার') !!}{!! $tf('f_phone_ph', 'মোবাইল প্লেসহোল্ডার') !!}{!! $tf('f_address_ph', 'ঠিকানা প্লেসহোল্ডার') !!}{!! $tf('f_area', 'ডেলিভারি এরিয়া লেবেল') !!}</div>
            <div class="fgrid">{!! $tf('area_pick', 'প্রোডাক্ট সিলেক্ট করুন টেক্সট') !!}{!! $tf('area_free', 'ফ্রি ডেলিভারি টেক্সট') !!}</div>

            <h3 style="margin-top:18px">ডেলিভারি চার্জ (টাকা)</h3>
            <div class="fgrid">
                <div class="a-field"><label>ঢাকার ভিতরে</label>
                    <input class="a-input" type="number" min="0" name="delivery_inside" value="{{ $rf($s['delivery_inside'] ?? '') }}" placeholder="80"></div>
                <div class="a-field"><label>ঢাকার বাইরে</label>
                    <input class="a-input" type="number" min="0" name="delivery_outside" value="{{ $rf($s['delivery_outside'] ?? '') }}" placeholder="150"></div>
                <div class="a-field"><label>“ঢাকার ভিতরে” অপশনের লেখা</label>
                    <input class="a-input" name="area_inside_bn" value="{{ $rf($s['area_inside_bn'] ?? '') }}" placeholder="ঢাকার ভিতরে"></div>
                <div class="a-field"><label>Inside Dhaka (English)</label>
                    <input class="a-input" name="area_inside_en" value="{{ $rf($s['area_inside_en'] ?? '') }}"></div>
                <div class="a-field"><label>“ঢাকার বাইরে” অপশনের লেখা</label>
                    <input class="a-input" name="area_outside_bn" value="{{ $rf($s['area_outside_bn'] ?? '') }}" placeholder="ঢাকার বাহিরে"></div>
                <div class="a-field"><label>Outside Dhaka (English)</label>
                    <input class="a-input" name="area_outside_en" value="{{ $rf($s['area_outside_en'] ?? '') }}"></div>
            </div>

            <h3 style="margin-top:18px">পেমেন্ট ও সাবমিট</h3>
            <div class="fgrid">{!! $tf('pay_method', 'পেমেন্ট মেথড টাইটেল') !!}{!! $tf('pay_cod', 'COD — টাইটেল') !!}{!! $tf('pay_cod_sub', 'COD — সাবটেক্সট') !!}{!! $tf('pay_online', 'অনলাইন পেমেন্ট টগল লেখা') !!}</div>
            <div class="fgrid">{!! $tf('pay_online_note_a', 'অনলাইন পেমেন্ট নোট — শুরু') !!}{!! $tf('pay_online_note_b', 'অনলাইন পেমেন্ট নোট — শেষ') !!}</div>
            <div class="fgrid">{!! $tf('confirm_order', 'সাবমিট বাটনের লেখা') !!}</div>
            <div class="fgrid">{!! $tf('trust_1', 'ট্রাস্ট ব্যাজ ১') !!}{!! $tf('trust_2', 'ট্রাস্ট ব্যাজ ২') !!}{!! $tf('trust_3', 'ট্রাস্ট ব্যাজ ৩') !!}</div>
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> অর্ডার ফর্ম সেভ করুন</button>
        </form>

        {{-- reviews --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" style="margin-top:26px">
            @csrf
            <h3>রিভিউ সেকশন হেডিং</h3>
            <div class="fgrid">{!! $tf('reviews_eyebrow', 'আইব্রো') !!}{!! $tf('reviews_h2a', 'হেডিং — প্রথম অংশ') !!}{!! $tf('reviews_h2b', 'হেডিং — রঙিন অংশ') !!}{!! $tf('reviews_sub', 'সাব-হেডিং', true) !!}</div>
            <div class="fgrid">{!! $tf('rating_score', 'রেটিং স্কোর (যেমন: ৪.৯)') !!}{!! $tf('rating_total', 'মোট রিভিউ লেখা (যেমন: ৫৩২টি ভেরিফাইড রিভিউ)') !!}</div>
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> হেডিং সেভ করুন</button>
        </form>

        {{-- rating bars --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" class="rep-form" style="margin-top:26px">
            @csrf
            <h3>রেটিং বার (৫ → ১ তারা)</h3>
            <div class="rep" data-json="rating_json">
                @foreach ($ratingRows as $row)
                    <div class="rep-row">
                        <input class="a-input" data-k="star" value="{{ $rf($row['star'] ?? '') }}" placeholder="তারা (1-5)" style="max-width:90px">
                        <input class="a-input" data-k="pct" value="{{ $rf($row['pct'] ?? '') }}" placeholder="শতকরা %" style="max-width:110px">
                        <input class="a-input" data-k="count_bn" value="{{ $rf($row['count_bn'] ?? '') }}" placeholder="সংখ্যা (বাংলা)" style="max-width:120px">
                        <input class="a-input" data-k="count_en" value="{{ $rf($row['count_en'] ?? '') }}" placeholder="Count (English)" style="max-width:120px">
                        <button type="button" class="btn-icon rep-del" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="a-btn ghost rep-add" style="margin-top:10px"><i class="fa-solid fa-plus"></i> নতুন বার</button>
            <input type="hidden" name="rating_json">
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> রেটিং বার সেভ করুন</button>
        </form>

        {{-- review cards --}}
        <form method="POST" action="{{ route('admin.settings.content.save') }}" class="rep-form" style="margin-top:26px">
            @csrf
            <h3>গ্রাহক রিভিউ কার্ড</h3>
            <p class="desc">ছবির ঘরে পাথ লিখুন (যেমন: assets/img/rev1.jpg) অথবা আগে আপলোড করা কোনো ছবির পাথ</p>
            <div class="rep" data-json="reviews_json">
                @foreach ($reviewRows as $row)
                    <div class="rep-row rep-row-block">
                        <div class="rep-line">
                            <input class="a-input" data-k="name" value="{{ $rf($row['name'] ?? '') }}" placeholder="নাম">
                            <input class="a-input" data-k="img" value="{{ $rf($row['img'] ?? '') }}" placeholder="ছবির পাথ">
                            <input class="a-input" data-k="stars" value="{{ $rf($row['stars'] ?? 5) }}" placeholder="তারা" style="max-width:80px">
                            <button type="button" class="btn-icon rep-del" title="মুছুন"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                        <div class="rep-line">
                            <input class="a-input" data-k="loc_bn" value="{{ $rf($row['loc_bn'] ?? '') }}" placeholder="লোকেশন (বাংলা)">
                            <input class="a-input" data-k="loc_en" value="{{ $rf($row['loc_en'] ?? '') }}" placeholder="Location (English)">
                        </div>
                        <div class="rep-line">
                            <textarea class="a-input" rows="2" data-k="text_bn" placeholder="রিভিউ (বাংলা)">{{ $rf($row['text_bn'] ?? '') }}</textarea>
                            <textarea class="a-input" rows="2" data-k="text_en" placeholder="Review (English)">{{ $rf($row['text_en'] ?? '') }}</textarea>
                        </div>
                        <div class="rep-line">
                            <input class="a-input" data-k="likes_bn" value="{{ $rf($row['likes_bn'] ?? '') }}" placeholder="Like (বাংলা)">
                            <input class="a-input" data-k="likes_en" value="{{ $rf($row['likes_en'] ?? '') }}" placeholder="Like (English)">
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="a-btn ghost rep-add" style="margin-top:10px"><i class="fa-solid fa-plus"></i> নতুন রিভিউ</button>
            <input type="hidden" name="reviews_json">
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> রিভিউ সেভ করুন</button>
        </form>
    </div>

    {{-- ================= TAB 4: FOOTER + NAV ================= --}}
    <div class="card tab-panel" id="tab-footer" hidden>
        <form method="POST" action="{{ route('admin.settings.content.save') }}">
            @csrf
            <h3>নিচের CTA (অর্ডার করতে চাই সেকশন)</h3>
            <div class="fgrid">{!! $tf('cta_h2a', 'হেডিং — প্রথম অংশ') !!}{!! $tf('cta_h2b', 'হেডিং — রঙিন অংশ') !!}{!! $tf('cta_sub', 'সাব-হেডিং', true) !!}{!! $tf('cta_btn', 'বাটনের লেখা') !!}</div>

            <h3 style="margin-top:22px">নেভিগেশন ও লোগো পিল</h3>
            <div class="fgrid">{!! $tf('logo_pill', 'লোগোর পাশের পিল (যেমন: খাঁটি)') !!}</div>
            <div class="fgrid">{!! $tf('nav_home', 'মেনু — হোম') !!}{!! $tf('nav_products', 'মেনু — সব প্রোডাক্ট') !!}{!! $tf('nav_why', 'মেনু — কেন আমরা') !!}{!! $tf('nav_reviews', 'মেনু — রিভিউ') !!}{!! $tf('nav_faq', 'মেনু — প্রশ্ন-উত্তর') !!}{!! $tf('nav_order', 'হেডারের অর্ডার বাটন') !!}</div>

            <h3 style="margin-top:22px">Footer</h3>
            <div class="fgrid">{!! $tf('footer_tag', 'Footer-এর বর্ণনা', true) !!}</div>
            <div class="fgrid">{!! $tf('footer_col_links', 'কলাম টাইটেল — কুইক লিংক') !!}{!! $tf('footer_col_contact', 'কলাম টাইটেল — যোগাযোগ') !!}{!! $tf('footer_fb', 'ফেসবুক পেজ লেখা') !!}</div>
            <div class="fgrid">{!! $tf('footer_rights', 'কপিরাইট লাইন (সর্বস্বত্ব সংরক্ষিত)') !!}{!! $tf('footer_made', 'Made with love লাইন') !!}</div>
            <p class="desc">কপিরাইটের বছর অটো বসে • ফোন/WhatsApp/Facebook যোগাযোগ <a href="{{ route('admin.settings.brand') }}">লোগো ও ব্র্যান্ড</a> পেজ থেকে বদলান।</p>
            <button class="a-btn" style="margin-top:14px"><i class="fa-solid fa-floppy-disk"></i> Footer সেভ করুন</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // tab switching (shared .filter-tab styles)
        document.querySelectorAll('#contentTabs .filter-tab').forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('#contentTabs .filter-tab').forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(function (p) { p.hidden = (p.id !== 'tab-' + tab.dataset.tab); });
            });
        });

        // repeaters: rows -> hidden JSON on submit
        document.querySelectorAll('.rep-form').forEach(function (form) {
            var wrap = form.querySelector('.rep');
            var hidden = form.querySelector('input[type=hidden][name="' + wrap.dataset.json + '"]');

            function bindDel(row) {
                row.querySelector('.rep-del').addEventListener('click', function () { row.remove(); });
            }
            wrap.querySelectorAll('.rep-row').forEach(bindDel);

            form.querySelector('.rep-add').addEventListener('click', function () {
                var clone = wrap.querySelector('.rep-row').cloneNode(true);
                clone.querySelectorAll('[data-k]').forEach(function (el) { el.value = ''; });
                bindDel(clone);
                wrap.appendChild(clone);
            });

            form.addEventListener('submit', function () {
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
        });
    </script>
@endpush
