@extends('layouts.admin')

@section('title', $product->exists ? 'প্রোডাক্ট এডিট' : 'নতুন প্রোডাক্ট')
@section('page_title', $product->exists ? 'প্রোডাক্ট এডিট — ' . $product->name : 'নতুন প্রোডাক্ট')
@section('page_sub', 'প্রোডাক্টের সব তথ্য দিন — দাম, VAT, স্টক, ব্র্যান্ড ও বারকোড')

@section('content')
    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
        enctype="multipart/form-data" style="max-width:920px;margin:0 auto">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div class="card">
            <h3>বেসিক তথ্য</h3>
            <p class="desc">নাম, ক্যাটাগরি ও ব্র্যান্ড</p>
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

        <div class="card">
            <h3>দাম, VAT ও ডিসকাউন্ট</h3>
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

        <div class="card">
            <h3>বর্ণনা ও স্ট্যাটাস</h3>
            <p class="desc">প্রোডাক্টের বিবরণ, রেটিং ও প্রদর্শন</p>
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
            <label style="display:flex;gap:8px;align-items:center;font-size:13px;font-weight:700;margin:8px 0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}> লাইভ করুন (ল্যান্ডিং পেজে দেখাবে)
            </label>
            <label style="display:flex;gap:8px;align-items:center;font-size:13px;font-weight:700;margin:8px 0">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}> ফিচার্ড প্রোডাক্ট
            </label>
        </div>

        <div class="card">
            <h3>ছবি ও বারকোড</h3>
            <p class="desc">প্রোডাক্টের ছবি আপলোড করুন — বারকোড অটো তৈরি হবে</p>
            <div class="a-field">
                <label>প্রোডাক্টের ছবি {{ $product->exists ? '(অপরিবর্তিত রাখতে খালি রাখুন)' : '*' }}</label>
                <input class="a-input" type="file" name="image" accept="image/*" {{ $product->exists ? '' : 'required' }}>
                @if ($product->exists)
                    <img src="{{ asset($p->image ?? $product->image) }}" alt="" style="width:70px;height:70px;object-fit:cover;border-radius:10px;margin-top:10px">
                @endif
            </div>
            @if ($product->exists && $product->barcode)
                <div class="a-field">
                    <label>বারকোড</label>
                    <div style="display:flex;align-items:center;gap:14px">
                        <code style="font-size:15px;font-weight:800;letter-spacing:2px;background:rgba(5,150,105,.08);padding:8px 16px;border-radius:10px">{{ $product->barcode }}</code>
                    </div>
                </div>
            @endif
        </div>

        <button class="a-btn" style="padding:14px 30px;font-size:15px">
            <i class="fa-solid fa-floppy-disk"></i>
            {{ $product->exists ? 'আপডেট করুন' : 'প্রোডাক্ট তৈরি করুন' }}
        </button>
        <a class="a-btn ghost" href="{{ route('admin.products.index') }}" style="margin-left:8px;text-decoration:none">বাতিল</a>
    </form>
@endsection
