@extends('layouts.landing')

@section('nav', 'home')

{{-- kono hardcoded title nei — Admin > SEO Settings er Meta Title (na thakle
     dynamic brand default) home page er tab + og:title control korbe --}}


@section('content')
{{-- ================= THIN ORCHESTRATOR: section order + selected variants (admin active/deactive) ================= --}}
    @foreach (['hero', 'trust', 'products', 'promises', 'how-it-works', 'why-us', 'faq', 'checkout', 'reviews', 'bottom-cta'] as $abSec)
        @if (ab_section_active($abSec))
            @include(ab_section_view($abSec))
        @endif
    @endforeach
<!-- ================= FOOTER ================= -->
    @endsection
