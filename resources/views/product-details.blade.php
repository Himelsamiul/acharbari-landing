@extends('layouts.landing')

@section('nav', 'products')

@section('title', ($product->meta_title ?: $product->name . ' — ' . ab_brand('bn')))

@section('content')
    <section class="ds-section" style="padding-top:34px">
        <div class="ds-container">
            <nav class="pd-breadcrumb" aria-label="breadcrumb">
                <a href="{{ url('/') }}" data-en="Home">হোম</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('products') }}" data-en="Products">প্রোডাক্ট</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $product->name }}</span>
            </nav>

            <div class="pd-grid">
                <div class="pd-media">
                    <img src="{{ asset(ab_img($product->image)) }}" alt="{{ $product->image_alt ?: $product->name }}" loading="eager">
                    @if ($product->discount_bn)<span class="pd-badge">{{ $product->discount_bn }}</span>@endif
                </div>

                <div class="pd-info">
                    <span class="ds-chip-hero" style="font-size:11px">{{ $product->category }} @if($product->brand) • {{ $product->brand }}@endif</span>
                    <h1 class="ds-h2" style="margin:12px 0 8px">{{ $product->name }}</h1>
                    @if ($product->name_en)<p style="margin:0 0 12px;color:#8b7355;font-weight:600">{{ $product->name_en }}</p>@endif

                    <div class="pd-price-row">
                        <span class="pd-price">৳{{ number_format($product->price) }}</span>
                        @if ($product->old_price > $product->price)
                            <span class="pd-old">৳{{ number_format($product->old_price) }}</span>
                        @endif
                        <span class="pill {{ $product->stock > 0 ? 'ok' : 'red' }}">
                            {{ $product->stock > 0 ? ($product->stock_badge ?: 'স্টকে আছে') : 'স্টক শেষ' }}
                        </span>
                    </div>

                    @if ($product->rating)
                        <div class="pd-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= round($product->rating) ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                            <span>{{ number_format($product->rating, 1) }} ({{ $product->reviews_count }} রিভিউ)</span>
                        </div>
                    @endif

                    @if ($product->description)
                        <p class="pd-desc">{{ $product->description }}</p>
                    @endif

                    <div class="pd-actions">
                        <a class="pd-cta" href="{{ url('/') }}#order" data-en="Order Now — Cash on Delivery">অর্ডার করুন — ক্যাশ অন ডেলিভারি</a>
                        <a class="pd-cta ghost" href="{{ route('products') }}" data-en="All Products">সব প্রোডাক্ট</a>
                    </div>

                    <ul class="pd-usp">
                        <li><i class="fa-solid fa-check"></i> <span data-en="100% homemade — no preservative">১০০% হোমমেড — প্রিজার্ভেটিভ মুক্ত</span></li>
                        <li><i class="fa-solid fa-check"></i> <span data-en="Sealed jar packaging">সিল করা জার প্যাকেজিং</span></li>
                        <li><i class="fa-solid fa-check"></i> <span data-en="Delivery all over Bangladesh">সারা বাংলাদেশে ডেলিভারি</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Products', 'item' => url('/products')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $product->name, 'item' => url('/product/' . $product->slug)],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <style>
        .pd-breadcrumb { display: flex; align-items: center; gap: 9px; font-size: 12.5px; font-weight: 600; margin-bottom: 22px; flex-wrap: wrap; }
        .pd-breadcrumb a { color: #059669; text-decoration: none; }
        .pd-breadcrumb a:hover { text-decoration: underline; }
        .pd-breadcrumb i { font-size: 8px; color: #b7c4bd; }
        .pd-breadcrumb span { color: #8b7355; }
        .pd-grid { display: grid; grid-template-columns: 1fr 1.1fr; gap: 34px; align-items: start; }
        .pd-media { position: relative; border-radius: 22px; overflow: hidden; border: 1px solid rgba(5,150,105,.16); background: #fff; box-shadow: 0 24px 54px -30px rgba(6,78,59,.45); }
        .pd-media img { width: 100%; height: 420px; object-fit: cover; display: block; }
        .pd-badge { position: absolute; top: 14px; left: 14px; background: linear-gradient(135deg, #dc2626, #f97316); color: #fff; font-size: 12px; font-weight: 800; padding: 5px 13px; border-radius: 999px; }
        .pd-price-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin: 14px 0; }
        .pd-price { font-size: 32px; font-weight: 800; color: #047857; }
        .pd-old { font-size: 17px; color: #b0a08c; text-decoration: line-through; font-weight: 700; }
        .pd-rating { display: flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 700; color: #8b7355; margin-bottom: 14px; }
        .pd-rating .fa-star { color: #f59e0b; font-size: 13px; }
        .pd-desc { font-size: 14.5px; line-height: 1.9; color: #4b5f54; margin: 0 0 20px; }
        .pd-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 22px; }
        .pd-cta { display: inline-flex; align-items: center; gap: 9px; background: linear-gradient(135deg, #059669, #10b981); color: #fff; font-weight: 800; font-size: 14.5px; padding: 15px 28px; border-radius: 14px; text-decoration: none; box-shadow: 0 16px 34px -14px rgba(5,150,105,.6); transition: transform .15s, filter .2s; }
        .pd-cta:hover { transform: translateY(-2px); filter: brightness(1.05); }
        .pd-cta.ghost { background: #fff; color: #1f4234; border: 1.5px solid rgba(5,150,105,.3); box-shadow: none; }
        .pd-usp { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 9px; }
        .pd-usp li { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; color: #1f4234; background: rgba(5,150,105,.06); border: 1px solid rgba(5,150,105,.12); padding: 9px 14px; border-radius: 10px; }
        .pd-usp i { color: #10b981; }
        @media (max-width: 860px) {
            .pd-grid { grid-template-columns: 1fr; gap: 20px; }
            .pd-media img { height: 300px; }
        }
    </style>
@endsection
