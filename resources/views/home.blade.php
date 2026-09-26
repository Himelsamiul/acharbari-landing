@extends('layouts.landing')

@section('nav', 'home')

@section('title', ab_brand('bn') . ' — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ')

@section('content')
{{-- ================= THIN ORCHESTRATOR: section order + selected variants ================= --}}
    @include(ab_section_view("hero"))
    @include(ab_section_view("trust"))
    @include(ab_section_view("products"))
    @include(ab_section_view("promises"))
    @include(ab_section_view("how-it-works"))
    @include(ab_section_view("why-us"))
    @include(ab_section_view("faq"))
    @include(ab_section_view("checkout"))
    @include(ab_section_view("reviews"))
    @include(ab_section_view("bottom-cta"))
<!-- ================= FOOTER ================= -->
    @endsection
