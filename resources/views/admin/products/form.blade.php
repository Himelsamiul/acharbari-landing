@extends('layouts.admin')

@section('title', $product->exists ? 'প্রোডাক্ট এডিট' : 'নতুন প্রোডাক্ট')
@section('page_title', $product->exists ? 'প্রোডাক্ট এডিট — ' . $product->name : 'নতুন প্রোডাক্ট')
@section('page_sub', 'প্রোডাক্টের সব তথ্য দিন — দাম, VAT, স্টক, ব্র্যান্ড ও বারকোড')

@section('content')
    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
        enctype="multipart/form-data" style="max-width:960px;margin:0 auto">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div class="note-banner">
            <i class="fa-solid fa-lightbulb"></i>
            <span>{{ $product->exists ? 'তথ্য পাল্টে <b>আপডেট করুন</b> চাপুন — সাথে সাথে লাইভ সাইটে দেখা যাবে।' : 'তারা চিহ্নিত (*) ঘরগুলো জরুরি — বাকিগুলো পরেও এডিট করা যাবে।' }}</span>
        </div>

        {{-- ===== 1. বেসিক ===== --}}
        <div class="card pf-card">
            <h3><span class="pf-ic" style="--pc:#059669"><i class="fa-solid fa-jar"></i></span> বেসিক তথ্য</h3>
            <p class="desc">প্রোডাক্টের নাম, ক্যাটাগরি, ব্র্যান্ড ও স্টক</p>
            <div class="fgrid">
                <div class="a-field">
                    <label>প্রোডাক্টের নাম (বাংলা) *</label>
                    <input class="a-input" name="name" value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="a-field">
                    <label>Product Name (English) *</label>
                    <input class="a-input" name="name_en" value="{{ old('name_en', $product->name_en) }}" required>
                </div>
                <div class="a-field">
                    <label>ক্যাটাগরি *</label>
                    <select class="a-input" name="category_key" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->key }}" {{ old('category_key', $product->category_key) === $cat->key ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->name_en }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="a-field">
                    <label>ব্র্যান্ড</label>
                    <input class="a-input" name="brand" list="brandList" value="{{ old('brand', $product->brand ?? 'আচারবাড়ি') }}">
                    <datalist id="brandList">
                        @foreach ($brands as $b)
                            <option value="{{ $b->name }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="a-field">
                    <label>স্টক পরিমাণ *</label>
                    <input class="a-input" type="number" name="stock" min="0" value="{{ old('stock', $product->stock ?? 50) }}" required>
                </div>
                <div class="a-field">
                    <label>একক (Unit)</label>
                    <select class="a-input" name="unit">
                        @foreach (['pcs' => 'পিস', 'gm' => 'গ্রাম', 'kg' => 'কেজি', 'ml' => 'মিলি', 'liter' => 'লিটার', 'jar' => 'জার'] as $uk => $ul)
                            <option value="{{ $uk }}" {{ old('unit', $product->unit ?? 'pcs') === $uk ? 'selected' : '' }}>{{ $ul }} ({{ $uk }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- ===== 2. দাম ===== --}}
        <div class="card pf-card">
            <h3><span class="pf-ic" style="--pc:#d97706"><i class="fa-solid fa-tags"></i></span> দাম, VAT ও ডিসকাউন্ট</h3>
            <p class="desc">বিক্রয়মূল্য, আগের দাম ও ভ্যাটের হার</p>
            <div class="fgrid">
                <div class="a-field">
                    <label>বিক্রয়মূল্য (৳) *</label>
                    <input class="a-input" type="number" step="0.01" name="price" min="0" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="a-field">
                    <label>আগের দাম (কাটা দাম)</label>
                    <input class="a-input" type="number" step="0.01" name="old_price" min="0" value="{{ old('old_price', $product->old_price) }}">
                </div>
                <div class="a-field">
                    <label>VAT (% — না থাকলে ০)</label>
                    <input class="a-input" type="number" step="0.01" name="vat_percent" min="0" max="100" value="{{ old('vat_percent', $product->vat_percent ?? 0) }}">
                </div>
                <div class="a-field">
                    <label>ডিসকাউন্ট ব্যাজ (বাংলা)</label>
                    <input class="a-input" name="discount_bn" value="{{ old('discount_bn', $product->discount_bn) }}" placeholder="-২৫% ছাড়">
                </div>
                <div class="a-field">
                    <label>Discount Badge (EN)</label>
                    <input class="a-input" name="discount_en" value="{{ old('discount_en', $product->discount_en) }}" placeholder="-25% Off">
                </div>
            </div>
        </div>

        {{-- ===== 3. ছবি ও বারকোড ===== --}}
        <div class="card pf-card">
            <h3><span class="pf-ic" style="--pc:#7c3aed"><i class="fa-solid fa-barcode"></i></span> ছবি ও বারকোড</h3>
            <p class="desc">ছবি আপলোড করুন — বারকোড নিজে লিখুন, না লিখলে অটো তৈরি হবে</p>
            <div class="pf-two">
                <div class="pf-imgbox">
                    <div class="a-field">
                        <label>প্রোডাক্টের ছবি {{ $product->exists ? '(অপরিবর্তিত রাখতে খালি রাখুন)' : '*' }}</label>
                        <input class="a-input" type="file" name="image" accept="image/*" {{ $product->exists ? '' : 'required' }}>
                    </div>
                    <div class="pf-preview">
                        @if ($product->exists)
                            <img src="{{ asset($p->image ?? $product->image) }}" alt="">
                        @else
                            <i class="fa-solid fa-image"></i>
                            <span>প্রিভিউ এখানে দেখা যাবে</span>
                        @endif
                    </div>
                </div>
                <div class="a-field">
                    <label>বারকোড {{ $product->exists ? '' : '(খালি রাখলে অটো তৈরি হবে)' }}</label>
                    <input class="a-input" name="barcode" value="{{ old('barcode', $product->barcode) }}"
                        placeholder="যেমন: ABP-0001 বা নিজের কোড" maxlength="40"
                        style="font-family:monospace;letter-spacing:1.5px;font-weight:700">
                    <p class="pf-hint">বারকোড প্রিন্ট/স্ক্যানের জন্য — ইনভয়েস ও প্রোডাক্ট লিস্টে দেখা যাবে</p>
                </div>
            </div>
        </div>

        {{-- ===== 4. বর্ণনা ===== --}}
        <div class="card pf-card">
            <h3><span class="pf-ic" style="--pc:#0ea5e9"><i class="fa-solid fa-file-lines"></i></span> বর্ণনা ও ডিটেইলস</h3>
            <p class="desc">প্রোডাক্টের বিবরণ, রেটিং ও ব্যাজ</p>
            <div class="a-field">
                <label>বিবরণ (বাংলা)</label>
                <textarea class="a-input" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="a-field">
                <label>Description (English)</label>
                <textarea class="a-input" name="description_en" rows="2">{{ old('description_en', $product->description_en) }}</textarea>
            </div>
            <div class="fgrid">
                <div class="a-field">
                    <label>রেটিং (০-৫)</label>
                    <input class="a-input" type="number" step="0.1" name="rating" min="0" max="5" value="{{ old('rating', $product->rating ?? 5) }}">
                </div>
                <div class="a-field">
                    <label>রিভিউ সংখ্যা</label>
                    <input class="a-input" type="number" name="reviews_count" min="0" value="{{ old('reviews_count', $product->reviews_count ?? 0) }}">
                </div>
                <div class="a-field">
                    <label>স্টক ব্যাজ (বাংলা)</label>
                    <input class="a-input" name="stock_badge" value="{{ old('stock_badge', $product->stock_badge) }}" placeholder="স্টকে আছে">
                </div>
                <div class="a-field">
                    <label>Stock Badge (EN)</label>
                    <input class="a-input" name="stock_badge_en" value="{{ old('stock_badge_en', $product->stock_badge_en) }}" placeholder="In Stock">
                </div>
                <div class="a-field">
                    <label>সর্ট অর্ডার</label>
                    <input class="a-input" type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}">
                </div>
            </div>
        </div>

        {{-- ===== 5. স্ট্যাটাস + SEO ===== --}}
        <div class="card pf-card">
            <h3><span class="pf-ic" style="--pc:#16a34a"><i class="fa-solid fa-sliders"></i></span> স্ট্যাটাস ও SEO</h3>
            <p class="desc">লাইভ/ফিচার্ড স্ট্যাটাস ও ঐচ্ছিক SEO তথ্য</p>
            <div class="pf-status">
                <label class="pf-check {{ old('is_active', $product->is_active ?? true) ? 'on' : '' }}">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                    <span class="pf-check-ic"><i class="fa-solid fa-globe"></i></span>
                    <span><b>লাইভ করুন</b><small>ল্যান্ডিং পেজে দেখাবে</small></span>
                </label>
                <label class="pf-check {{ old('is_featured', $product->is_featured ?? false) ? 'on' : '' }}">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                    <span class="pf-check-ic" style="--pc:#d97706"><i class="fa-solid fa-star"></i></span>
                    <span><b>ফিচার্ড প্রোডাক্ট</b><small>বিশেষভাবে দেখানো হবে</small></span>
                </label>
            </div>
            <div class="fgrid" style="margin-top:16px">
                <div class="a-field">
                    <label>Meta Title (ঐচ্ছিক)</label>
                    <input class="a-input" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" maxlength="150" placeholder="{{ $product->name }} — আচারবাড়ি">
                </div>
                <div class="a-field">
                    <label>Image Alt Text (ঐচ্ছিক)</label>
                    <input class="a-input" name="image_alt" value="{{ old('image_alt', $product->image_alt) }}" maxlength="200" placeholder="{{ $product->name }} — খাঁটি দেশি আচার">
                </div>
            </div>
            <div class="a-field">
                <label>Meta Description (ঐচ্ছিক)</label>
                <textarea class="a-input" name="meta_description" rows="2" maxlength="320" placeholder="প্রোডাক্টের ছোট বর্ণনা যা গুগল সার্চে দেখাবে">{{ old('meta_description', $product->meta_description) }}</textarea>
            </div>
        </div>

        {{-- ===== SAVE BAR ===== --}}
        <div class="pf-savebar">
            <button class="a-btn" style="padding:14px 34px;font-size:15px">
                <i class="fa-solid fa-floppy-disk"></i>
                {{ $product->exists ? 'আপডেট করুন' : 'প্রোডাক্ট তৈরি করুন' }}
            </button>
            <a class="a-btn ghost" href="{{ route('admin.products.index') }}" style="text-decoration:none">বাতিল</a>
        </div>
    </form>

    <style>
        .pf-card { border-top: 3px solid rgba(5, 150, 105, .25); }
        .pf-card h3 { display: flex; align-items: center; gap: 10px; }
        .pf-ic {
            width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 14px;
            background: color-mix(in srgb, var(--pc, #059669) 12%, white);
            color: var(--pc, #059669);
        }
        .pf-two { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: start; }
        .pf-imgbox { background: rgba(5, 150, 105, .03); border: 1px dashed rgba(5, 150, 105, .25); border-radius: 12px; padding: 14px; }
        .pf-preview {
            margin-top: 12px; height: 110px; border-radius: 10px; background: #fff;
            border: 1px solid rgba(5, 150, 105, .12); display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 6px; color: #8b7355; font-size: 12px;
            overflow: hidden;
        }
        .pf-preview i { font-size: 26px; color: rgba(5, 150, 105, .4); }
        .pf-preview img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }
        .pf-hint { font-size: 11.5px; color: #8b7355; margin: 8px 0 0; }
        .pf-status { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .pf-check {
            display: flex; gap: 12px; align-items: center; cursor: pointer;
            border: 1.5px solid rgba(5, 150, 105, .18); border-radius: 12px; padding: 12px 14px;
            transition: .2s; background: #fff;
        }
        .pf-check:hover { border-color: rgba(5, 150, 105, .4); }
        .pf-check.on { border-color: #059669; background: rgba(5, 150, 105, .05); }
        .pf-check input { accent-color: #059669; width: 16px; height: 16px; flex-shrink: 0; }
        .pf-check-ic {
            width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
            display: grid; place-items: center; font-size: 15px;
            background: rgba(5, 150, 105, .1); color: var(--pc, #059669);
        }
        .pf-check b { display: block; font-size: 13.5px; color: #12261d; }
        .pf-check small { display: block; font-size: 11.5px; color: #8b7355; }
        .pf-savebar {
            display: flex; gap: 10px; align-items: center; margin-top: 4px;
            background: #fff; border: 1px solid rgba(5, 150, 105, .15);
            border-radius: 16px; padding: 14px 18px;
            box-shadow: 0 14px 34px -22px rgba(6, 78, 59, .4);
        }
        @media (max-width: 760px) {
            .pf-two, .pf-status { grid-template-columns: 1fr; }
        }
    </style>
@endsection
