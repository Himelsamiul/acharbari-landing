{{-- SEO meta from admin settings --}}
<title>{{ \App\Models\Setting::get('seo_title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ') }}</title>
<meta name="description" content="{{ \App\Models\Setting::get('seo_desc', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনি — প্রিজারভেটিভ মুক্ত, ক্যাশ অন ডেলিভারিতে সারা বাংলাদেশে হোম ডেলিভারি।') }}">
@php
    $kw = \App\Models\Setting::get('seo_keywords', 'deshi achar, mango pickle, আচারবাড়ি, homemade pickle BD, sundarban honey, deshi ghee, tamarind chutney');
@endphp
<meta name="keywords" content="{{ $kw }}">
