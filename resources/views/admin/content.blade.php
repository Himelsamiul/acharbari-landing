@extends('layouts.admin')

@section('title', 'ল্যান্ডিং কনটেন্ট')
@section('page_title', 'ল্যান্ডিং কনটেন্ট')
@section('page_sub', 'ল্যান্ডিং পেজের সব লেখা ও ছবি — কোড ছাড়াই বদলান')

@section('content')
    @php
        $s = $settings;
        // DB value, else the default text from the active landing template —
        // so every field shows the text visitors actually see right now
        $effOf = function (string $key, string $lang) use ($s, $defaults) {
            $v = trim((string) ($s[$key . '_' . $lang] ?? ''));
            if ($v !== '') {
                return $v;
            }
            $d = $defaults[$key] ?? [];
            if ($lang === 'en' && ($d['en'] ?? '') === '') {
                return $d['bn'] ?? '';
            }
            return $d[$lang] ?? '';
        };
        // bilingual text-field pair (ab_t pattern: empty input keeps the landing default)
        $tf = function (string $key, string $label, bool $long = false, string $ph = '') use ($effOf) {
            $bn = e($effOf($key, 'bn'));
            $en = e($effOf($key, 'en'));
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
        $rf = fn (string $val) => e((string) $val);
    @endphp

    @if (isset($errors) && $errors->any())
        <div class="alert-success" style="background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <b>এগুলো ঠিক করে আবার সেভ করুন:</b>
                <ul style="margin:6px 0 0;padding-left:18px">
                    @foreach ($errors->all() as $err)
                        <li style="font-size:12.5px">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="note-banner">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
        <span>ঘরগুলোতে <b>সাইটে এখন যে লেখা দেখাচ্ছে</b> সেটাই বসানো আছে — সরাসরি এডিট করুন। ✕ চাপলে ঘর খালি হয়ে ডিফল্টে ফিরে যায়। <b>প্রতিটি ট্যাবে নিচে একটাই সেভ বাটন</b> — পুরো ট্যাব একসাথে সেভ হয়। ঘরে ক্লিক করলে প্রিভিউতে সেই জায়গা হাইলাইট হবে।</span>
        <span style="display:inline-flex;gap:8px;margin-left:10px;flex-wrap:wrap">
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="a-btn" style="padding:5px 12px;font-size:12px"><i class="fa-solid fa-eye"></i> লাইভ প্রিভিউ</a>
        </span>
    </div>

    {{-- ===== LIVE LANDING PREVIEW ===== --}}
    <div class="card">
        <div class="cp-head">
            <h3>লাইভ প্রিভিউ</h3>
            <div class="cp-tools">
                <button type="button" class="a-btn ghost cp-dev active" data-w="desktop" onclick="setCpWidth(this)"><i class="fa-solid fa-desktop"></i> ডেস্কটপ</button>
                <button type="button" class="a-btn ghost cp-dev" data-w="mobile" onclick="setCpWidth(this)"><i class="fa-solid fa-mobile-screen"></i> মোবাইল</button>
                <button type="button" class="a-btn ghost" onclick="reloadCp()" title="রিফ্রেশ"><i class="fa-solid fa-rotate-right"></i></button>
            </div>
        </div>
        <p class="desc">ঘরে ক্লিক/ফোকাস করলে প্রিভিউতে সেই লেখাটা হলুদ বর্ডার দিয়ে হাইলাইট হবে — বাংলা ঘরে লিখলে প্রিভিউতেও লাইভ বদলাবে।</p>
        <div class="cp-jumps">
            <button type="button" onclick="cpJump('top')">টপ</button>
            <button type="button" onclick="cpJump('ds-products')">প্রোডাক্ট</button>
            <button type="button" onclick="cpJump('ds-why')">কেন আমরা</button>
            <button type="button" onclick="cpJump('ds-reviews')">রিভিউ</button>
            <button type="button" onclick="cpJump('ds-faq')">FAQ</button>
            <button type="button" onclick="cpJump('order-form')">অর্ডার ফর্ম</button>
            <button type="button" onclick="cpJump('lp-footer')">ফুটার</button>
        </div>
        <div class="cp-frame" id="cpFrameWrap">
            <iframe id="contentPreview" src="{{ url('/') }}" title="ল্যান্ডিং প্রিভিউ" loading="lazy"></iframe>
        </div>
    </div>

    {{-- ===== SEARCH ===== --}}
    <div class="card">
        <div class="search-row">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input class="a-input" id="contentSearch" placeholder="খুঁজুন — যেমন: ডেলিভারি, হেডিং, ফুটার…" autocomplete="off">
            <button type="button" class="a-btn ghost" id="searchClear" hidden onclick="clearSearch()"><i class="fa-solid fa-xmark"></i> সার্চ বন্ধ</button>
        </div>
        <p class="desc" id="searchHint" hidden>সার্চে মেলা ঘরগুলো সব ট্যাব থেকে দেখানো হচ্ছে — প্রতিটির নিজের সেভ বাটন আছে। সার্চ বন্ধ করলে আগের ট্যাবে ফিরে যাবে।</p>
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
                            <input class="a-input" name="hero_stat{{ $i }}_n_bn" value="{{ $rf($effOf('hero_stat' . $i . '_n', 'bn')) }}" placeholder="যেমন: ১৫,০০০+"></div>
                        <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — সংখ্যা (English)</label>
                            <input class="a-input" name="hero_stat{{ $i }}_n_en" value="{{ $rf($effOf('hero_stat' . $i . '_n', 'en')) }}" placeholder="e.g. 15,000+"></div>
                        <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — লেবেল (বাংলা)</label>
                            <input class="a-input" name="hero_stat{{ $i }}_bn" value="{{ $rf($effOf('hero_stat' . $i, 'bn')) }}" placeholder="যেমন: সন্তুষ্ট গ্রাহক"></div>
                        <div class="a-field"><label>স্ট্যাট {{ bn_num($i) }} — লেবেল (English)</label>
                            <input class="a-input" name="hero_stat{{ $i }}_en" value="{{ $rf($effOf('hero_stat' . $i, 'en')) }}" placeholder="e.g. Happy customers"></div>
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
                <div class="hero-tiles">
                    @foreach ($heroImgDefaults as $key => $defaultPath)
                        <div class="hero-tile-wrap">
                            <label class="hero-tile">
                                <input type="file" name="{{ $key }}" accept="image/*" hidden onchange="heroImgPicked(this)">
                                @if ($current($key))
                                    <img src="{{ asset($current($key)) }}" alt="slide">
                                @else
                                    <img src="{{ asset($defaultPath) }}" alt="slide default" style="opacity:.55">
                                @endif
                                <span class="hero-tile-hit"><i class="fa-solid fa-camera"></i> ছবি বাছুন</span>
                            </label>
                            <span class="hero-tile-name">স্লাইড {{ bn_num($loop->iteration) }}</span>
                            @if ($current($key))
                                <label class="hero-tile-remove">
                                    <input type="checkbox" name="{{ $key }}_remove" value="1"> ডিফল্টে ফিরুন
                                </label>
                            @endif
                        </div>
                    @endforeach
                </div>
                <p class="desc" style="margin-top:10px;margin-bottom:0">খালি রাখলে বর্তমান ছবি থাকবে • সর্বোচ্চ 2MB • JPG/PNG/WebP</p>
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
                <h4 class="ct-sub">ফিল্টার বাটন</h4>
                <div class="fgrid">
                    {!! $tf('filter_all', '“সব” বাটন') !!}
                </div>
                <p class="desc">ক্যাটাগরি ফিল্টার বাটন অটো তৈরি হয় — নতুন ক্যাটাগরি যোগ বা নাম বদল <a href="{{ route('admin.taxonomy') }}"><b>ক্যাটাগরি ও ব্র্যান্ড</b></a> পেজ থেকে করুন, ল্যান্ডিংয়ের ফিল্টারে সাথে সাথে দেখা যাবে। ফিল্টারের সংখ্যাও প্রোডাক্ট থেকে অটো আসে।</p>
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
                        <b>ডেলিভারি চার্জ</b>
                        <small>জেলা-ভিত্তিক চার্জ আলাদা পেজে সেট হয়</small>
                    </div>
                </div>
                <p class="desc">৬৪ জেলার আলাদা ডেলিভারি চার্জ এখন <a href="{{ route('admin.settings.delivery') }}"><b>ডেলিভারি এরিয়া</b></a> পেজ থেকে সেট করা হয় — চেকআউটের এরিয়া লিস্টে অটো দেখা যায়।</p>
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
                <p class="desc">⭐ রিভিউ কার্ডের নাম, ছবি ও লেখা বদলাতে <a href="{{ route('admin.reviews') }}"><b>রিভিউ</b></a> পেজে যান — সেখান থেকে রিভিউ কার্ড ও রেটিং ব্রেকডাউন সেট করা হয়।</p>
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

        /* live preview card */
        .cp-head { display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; }
        .cp-head h3 { margin: 0; }
        .cp-tools { display: flex; gap: 8px; }
        .cp-dev { padding: 8px 14px; font-size: 12.5px; }
        .cp-dev.active { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-color: transparent; }
        .cp-jumps { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 10px; }
        .cp-jumps button {
            border: 1px solid rgba(5,150,105,.25); background: #fff; color: #065f46; cursor: pointer;
            padding: 5px 12px; border-radius: 999px; font-size: 11.5px; font-weight: 600; font-family: inherit;
            transition: background .15s, border .15s;
        }
        .cp-jumps button:hover { background: rgba(5,150,105,.08); border-color: #059669; }
        .cp-frame {
            margin-top: 10px; border: 1.5px solid rgba(5,150,105,.22); border-radius: 16px;
            overflow: hidden; background: #f6faf8; transition: max-width .3s ease;
        }
        .cp-frame iframe { display: block; width: 100%; height: 520px; border: 0; background: #fff; }
        .cp-frame.mobile { max-width: 402px; margin-left: auto; margin-right: auto; }

        /* search */
        .search-row { display: flex; align-items: center; gap: 10px; }
        .search-row > i { color: #059669; }
        .search-row .a-input { max-width: 420px; }

        /* hero image tiles */
        .hero-tiles { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 150px), 1fr)); gap: 12px; }
        .hero-tile {
            position: relative; display: block; border-radius: 14px; overflow: hidden; cursor: pointer;
            border: 2px solid rgba(5,150,105,.2); background: #fff; aspect-ratio: 4 / 3;
        }
        .hero-tile img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .hero-tile:hover { border-color: #059669; }
        .hero-tile-hit {
            position: absolute; inset: auto 0 0 0; padding: 7px 0; text-align: center;
            background: rgba(2, 44, 34, .72); color: #fff; font-size: 11.5px; font-weight: 700;
            opacity: 0; transition: opacity .15s;
        }
        .hero-tile:hover .hero-tile-hit { opacity: 1; }
        .hero-tile-name { display: block; font-size: 12px; font-weight: 700; color: #1f4234; margin-top: 6px; }
        .hero-tile-remove { display: flex; gap: 6px; align-items: center; font-size: 11.5px; color: #8b7355; margin-top: 3px; cursor: pointer; }
        .hero-tile-wrap.chosen .hero-tile { border-color: #d97706; }

        /* per-field clear (✕ = back to default) */
        .a-clear {
            border: 0; background: #fee2e2; color: #b91c1c; border-radius: 6px; cursor: pointer;
            font-size: 10px; padding: 2px 7px; margin-left: 6px; font-family: inherit; font-weight: 700;
        }
        .a-clear:hover { background: #fecaca; }

        /* dirty (unsaved) indicator */
        .tab-panel.dirty .ct-savebar { border-color: #d97706; }
        .tab-panel.dirty .ct-savebar::after {
            content: 'অসংরক্ষিত পরিবর্তন আছে'; font-size: 11px; font-weight: 700; color: #b45309;
            background: #fef3c7; border-radius: 999px; padding: 3px 10px; margin-left: auto;
        }
        .ct-sec.hl-target { border-color: #d97706; box-shadow: 0 0 0 3px rgba(217, 119, 6, .15); }
    </style>
@endsection

@push('scripts')
    <script>
        /* ================= tab switching + persistence + dirty guard ================= */

        var TAB_KEY = 'ab_content_tab';
        var dirty = false;

        function showTab(id) {
            document.querySelectorAll('#contentTabs .filter-tab').forEach(function (t) { t.classList.toggle('active', t.dataset.tab === id); });
            document.querySelectorAll('.tab-panel').forEach(function (p) { p.hidden = (p.id !== 'tab-' + id); });
        }

        function currentTabId() {
            var active = document.querySelector('#contentTabs .filter-tab.active');
            return active ? active.dataset.tab : 'hero';
        }

        function markDirty() {
            if (dirty) return;
            dirty = true;
            var panel = document.getElementById('tab-' + currentTabId());
            if (panel) panel.classList.add('dirty');
        }

        document.querySelectorAll('#contentTabs .filter-tab').forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                if (tab.classList.contains('active')) return;
                var target = tab.dataset.tab;
                var doSwitch = function () {
                    showTab(target);
                    localStorage.setItem(TAB_KEY, target);
                };
                if (dirty) {
                    swConfirm({
                        title: 'অসংরক্ষিত পরিবর্তন আছে',
                        text: 'ট্যাব বদলালে এই ট্যাবের পরিবর্তন হারিয়ে যাবে। তবুও বদলাবেন?',
                        confirmText: 'হ্যাঁ, বদলান'
                    }).then(function (ok) { if (ok) doSwitch(); });
                    return;
                }
                doSwitch();
            });
        });

        /* restore last tab after reload/save */
        (function () {
            var saved = localStorage.getItem(TAB_KEY);
            if (saved) {
                var tab = document.querySelector('#contentTabs .filter-tab[data-tab="' + saved + '"]');
                if (tab) showTab(saved);
            }
        })();

        /* unsaved-changes guard: any input in any panel marks dirty */
        document.querySelectorAll('.tab-panel form').forEach(function (form) {
            form.addEventListener('input', markDirty);
            form.addEventListener('change', markDirty);
            form.addEventListener('submit', function () {
                dirty = false;
                localStorage.setItem(TAB_KEY, currentTabId());
            });
        });
        window.addEventListener('beforeunload', function (e) {
            if (dirty) { e.preventDefault(); e.returnValue = ''; }
        });

        /* ================= per-field ✕ (clear -> default) ================= */

        document.querySelectorAll('.tab-panel .a-field').forEach(function (field) {
            var control = field.querySelector('input.a-input:not([type=file]), textarea.a-input');
            if (!control) return;
            var label = field.querySelector('label');
            if (!label) return;
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'a-clear';
            btn.title = 'খালি করে ডিফল্ট লেখায় ফিরুন';
            btn.textContent = '✕';
            btn.addEventListener('click', function () {
                control.value = '';
                control.dispatchEvent(new Event('input', { bubbles: true }));
            });
            label.appendChild(btn);
        });

        /* ================= search across all tabs ================= */

        var searchInput = document.getElementById('contentSearch');
        var searchClear = document.getElementById('searchClear');
        var searchHint = document.getElementById('searchHint');

        function applySearch(q) {
            q = q.trim().toLowerCase();
            document.querySelectorAll('.tab-panel').forEach(function (panel) {
                var searching = q !== '';
                panel.hidden = searching ? false : (panel.id !== 'tab-' + currentTabId());
                panel.querySelectorAll('.ct-sec').forEach(function (sec) {
                    var secMatch = sec.textContent.toLowerCase().indexOf(q) !== -1;
                    sec.hidden = searching ? !secMatch : false;
                    sec.querySelectorAll(':scope > .fgrid > .a-field').forEach(function (f) {
                        var text = f.textContent.toLowerCase();
                        var val = f.querySelector('input, textarea');
                        if (val && val.value) text += ' ' + val.value.toLowerCase();
                        f.hidden = searching ? (text.indexOf(q) === -1) : false;
                    });
                });
            });
            document.querySelectorAll('.ct-savebar').forEach(function (bar) { bar.hidden = q !== ''; });
            searchClear.hidden = q === '';
            searchHint.hidden = q === '';
        }

        searchInput.addEventListener('input', function () { applySearch(this.value); });
        searchInput.addEventListener('keydown', function (e) { if (e.key === 'Escape') clearSearch(); });

        function clearSearch() {
            searchInput.value = '';
            applySearch('');
        }

        /* ================= hero image tiles ================= */

        function heroImgPicked(input) {
            var f = input.files && input.files[0];
            if (!f) return;
            if (f.size > 2 * 1024 * 1024) {
                showToast('ছবিটা খুব বড় — সর্বোচ্চ 2MB দিন (এখন ' + (f.size / 1048576).toFixed(1) + 'MB)');
                input.value = '';
                return;
            }
            var wrap = input.closest('.hero-tile-wrap');
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = wrap.querySelector('.hero-tile img');
                img.src = e.target.result;
                img.style.opacity = 1;
            };
            reader.readAsDataURL(f);
            wrap.classList.add('chosen');
        }

        /* ================= live preview: highlight + inline edit ================= */

        var cp = document.getElementById('contentPreview');

        function cpDoc() {
            try { return cp.contentDocument; } catch (e) { return null; }
        }

        function setCpWidth(btn) {
            document.querySelectorAll('.cp-dev').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            document.getElementById('cpFrameWrap').classList.toggle('mobile', btn.dataset.w === 'mobile');
        }

        function reloadCp() { cp.src = cp.src; }

        function cpJump(id) {
            var doc = cpDoc();
            if (!doc) return;
            if (id === 'top') { doc.documentElement.scrollTo({ top: 0, behavior: 'smooth' }); return; }
            var el = doc.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        }

        /* find the text node inside the preview that shows `text` */
        function findPreviewNode(text) {
            var doc = cpDoc();
            if (!doc || !doc.body || text.length < 2) return null;
            var walker = doc.createTreeWalker(doc.body, NodeFilter.SHOW_TEXT, {
                acceptNode: function (n) {
                    var p = n.parentNode.nodeName;
                    if (p === 'SCRIPT' || p === 'STYLE') return NodeFilter.FILTER_REJECT;
                    return n.nodeValue.trim() ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT;
                }
            });
            var node, best = null, bestLen = 0;
            while ((node = walker.nextNode())) {
                var nv = node.nodeValue.replace(/\s+/g, ' ').trim();
                if (nv === text) return node;               /* exact match wins */
                if (nv.indexOf(text) !== -1 && text.length > bestLen) { best = node; bestLen = text.length; }
            }
            return best;
        }

        var hl = { node: null, orig: '', enEl: null, enOrig: '' };

        function clearHighlight() {
            if (hl.node) {
                hl.node.nodeValue = hl.orig;
                if (hl.node.parentElement) {
                    hl.node.parentElement.style.outline = '';
                    hl.node.parentElement.style.borderRadius = '';
                }
            }
            if (hl.enEl) {
                hl.enEl.setAttribute('data-en', hl.enOrig);
                hl.enEl.style.outline = '';
            }
            hl = { node: null, orig: '', enEl: null, enOrig: '' };
        }

        document.addEventListener('focusin', function (e) {
            var el = e.target;
            if (!el.name || (el.name.slice(-3) !== '_bn' && el.name.slice(-3) !== '_en')) return;
            var isBn = el.name.slice(-3) === '_bn';
            var text = (el.value || '').trim();
            if (!text) return;   /* খালি ঘর = ডিফল্ট লেখা — ম্যাচ করার উপায় নেই */

            if (isBn) {
                var node = findPreviewNode(text);
                if (!node) return;
                clearHighlight();
                hl.node = node;
                hl.orig = node.nodeValue;
                var parentEl = node.parentElement;
                parentEl.style.outline = '2px solid #f59e0b';
                parentEl.style.borderRadius = '4px';
                parentEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                /* English text lives in [data-en] attributes (hidden in bn mode) */
                var doc = cpDoc();
                if (!doc) return;
                var enEl = null;
                doc.querySelectorAll('[data-en]').forEach(function (cand) {
                    if (enEl) return;
                    var v2 = (cand.getAttribute('data-en') || '').replace(/\s+/g, ' ').trim();
                    if (v2 === text) enEl = cand;
                });
                if (!enEl) return;
                clearHighlight();
                hl.enEl = enEl;
                hl.enOrig = enEl.getAttribute('data-en');
                enEl.style.outline = '2px solid #f59e0b';
                enEl.style.borderRadius = '4px';
                enEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        document.addEventListener('focusout', clearHighlight);

        /* live-edit the preview while typing (bn text is visible; en updates data-en) */
        document.addEventListener('input', function (e) {
            var el = e.target;
            if (!hl.node && !hl.enEl) return;
            if (!el.name || (el.name.slice(-3) !== '_bn' && el.name.slice(-3) !== '_en')) return;
            var v = el.value;
            if (hl.node) hl.node.nodeValue = v === '' ? hl.orig : v;
            if (hl.enEl) hl.enEl.setAttribute('data-en', v === '' ? hl.enOrig : v);
        });

        /* ================= repeaters ================= */

        document.querySelectorAll('.rep-form').forEach(function (form) {
            var hiddenMap = {};
            form.querySelectorAll('.rep').forEach(function (wrap) {
                var hidden = form.querySelector('input[type=hidden][name="' + wrap.dataset.json + '"]');
                if (!hidden) return;
                hiddenMap[wrap.dataset.json] = hidden;

                function bindDel(row) {
                    row.querySelectorAll('.rep-del').forEach(function (btn) {
                        btn.addEventListener('click', function () { row.remove(); markDirty(); });
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
                        markDirty();
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
