@extends('layouts.demo')

{{-- Genre live-demo body: every section rendered as design-1, fully resolved
     from the pack (copy/images/theme) — store settings are never consulted --}}
@section('content')
    @foreach (['hero', 'trust', 'products', 'promises', 'how-it-works', 'why-us', 'faq', 'checkout', 'reviews', 'bottom-cta'] as $abSec)
        @include('sections.' . $abSec . '.design-1')
    @endforeach
@endsection
