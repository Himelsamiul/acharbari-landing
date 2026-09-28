@extends('layouts.landing')

@section('nav', 'home')

@section('title', $title . ' — ' . ab_brand('bn'))

@section('content')
    <section class="ds-section" style="padding-top:34px">
        <div class="ds-container" style="max-width:860px">
            <nav style="display:flex;gap:8px;align-items:center;font-size:12.5px;font-weight:700;margin-bottom:18px">
                <a href="{{ url('/') }}" style="color:#059669;text-decoration:none">হোম</a>
                <span style="color:#b7c4bd">›</span>
                <span style="color:#8b7355">{{ $title }}</span>
                <a href="{{ url()->previous() }}" style="margin-left:auto;color:#059669;text-decoration:none;font-size:12px">← ফিরে যান</a>
            </nav>

            <h1 style="font-size:30px;font-weight:800;color:#12261d;margin:0 0 4px">{{ $title }}</h1>
            <p style="color:#8b7355;font-weight:700;font-size:13px;margin:0 0 20px">{{ $titleEn }}</p>

            <div class="legal-content">
                {!! $content !!}
            </div>
        </div>
page-end
    </section>

    <style>
        .legal-content { background:#fff; border:1px solid rgba(5,150,105,.14); border-radius:16px;
            padding:26px 30px; font-size:14.5px; line-height:2; color:#33443c; }
        .legal-content p { margin: 0 0 14px; }
        .legal-content p:last-child { margin-bottom: 0; }
        .legal-content b { color:#12261d; }
        @media (max-width:640px){ .legal-content { padding:20px 18px; } }
    </style>
@endsection
