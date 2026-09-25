@php
    $S = '\App\Models\Setting';
    $p = $product ?? null;
    $sectionTitle = trim($__env->getSections()['title'] ?? '');

    $defTitle = $S::get('seo_title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ');
    $defDesc = $S::get('seo_desc', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনি — প্রিজার্ভেটিভ মুক্ত, ক্যাশ অন ডেলিভারিতে সারা বাংলাদেশে হোম ডেলিভারি।');
    $defKw = $S::get('seo_keywords', 'deshi achar, mango pickle, আচারবাড়ি, homemade pickle BD, sundarban honey, deshi ghee, tamarind chutney');

    // Per-product SEO override > page section title > global settings
    $metaTitle = $p?->meta_title ?: ($sectionTitle ?: $defTitle);
    $metaDesc = $p?->meta_description ?: $defDesc;
    $metaKw = $defKw . ($p?->name ? ', ' . $p->name . ', ' . $p->name_en : '');

    $canonical = $S::get('seo_canonical');
    $canonicalUrl = $canonical && request()->path() === '/' ? $canonical : url()->current();

    $ogTitle = $S::get('og_title') ?: $metaTitle;
    $ogDesc = $S::get('og_desc') ?: $metaDesc;
    $ogImage = $S::get('og_image');
    $ogImage = $ogImage ? asset($ogImage) : asset('assets/img/hero_achar.jpg');
    if ($p?->image) { $ogImage = asset($p->image); }
@endphp
<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDesc }}">
<meta name="keywords" content="{{ $metaKw }}">
<meta name="robots" content="index, follow">
<meta name="author" content="AcharBari">
<link rel="canonical" href="{{ $canonicalUrl }}">

@php $gsc = $S::get('gsc_verification'); @endphp
@if ($gsc)
    <meta name="google-site-verification" content="{{ $gsc }}">
@endif

{{-- Open Graph (Facebook / WhatsApp share) --}}
<meta property="og:type" content="{{ $p ? 'product' : 'website' }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDesc }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ config('app.name') === 'Laravel' ? 'আচারবাড়ি' : config('app.name') }}">
<meta property="og:locale" content="bn_BD">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDesc }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- JSON-LD Structured Data: Organization + WebSite --}}
@php
    $brandName = trim(($S::get('brand_bn1', '') ?: '') . ($S::get('brand_bn2', '') ?: '')) ?: 'AcharBari';
    $orgSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'OnlineStore',
        'name' => $brandName,
        'url' => url('/'),
        'logo' => $S::get('logo_path') ? url(asset($S::get('logo_path'))) : url(asset('assets/img/favicon.svg')),
        'telephone' => ab_contact('phone'),
        'sameAs' => array_values(array_filter([ab_contact('facebook'), ab_contact('messenger') ? 'https://m.me/' . ab_contact('messenger') : ''])),
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => $brandName,
    'url' => url('/'),
    'inLanguage' => 'bn-BD',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

{{-- JSON-LD Structured Data: Product (detail page only) --}}
@if ($p)
    @php
        $productSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $p->name,
            'description' => $p->meta_description ?: $p->description ?: $p->name,
            'image' => asset($p->image),
            'sku' => $p->barcode,
            'brand' => ['@type' => 'Brand', 'name' => $p->brand ?: 'আচারবাড়ি'],
            'offers' => [
                '@type' => 'Offer',
                'url' => url('/product/' . $p->slug),
                'priceCurrency' => 'BDT',
                'price' => number_format((float) $p->price, 2, '.', ''),
                'availability' => $p->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ],
        ];
        if ($p->rating && $p->rating > 0) {
            $productSchema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => (float) $p->rating,
                'reviewCount' => max(1, (int) $p->reviews_count),
            ];
        }
    @endphp
    <script type="application/ld+json">
    {!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endif
