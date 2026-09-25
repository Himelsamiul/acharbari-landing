@extends('layouts.admin')

@section('title', 'robots.txt')
@section('page_title', 'robots.txt')
@section('page_sub', 'সার্চ ইঞ্জিন বটের জন্য নিয়ম কন্ট্রোল করুন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-robot"></i>
        <span>লাইভ ফাইল: <a href="{{ url('/robots.txt') }}" target="_blank" style="color:#047857;font-weight:700">{{ url('/robots.txt') }}</a> — সেভ করলেই সাথে সাথে প্রয়োগ হবে। <b>Disallow</b> মানে ওই পাথ গুগল ইনডেক্স করবে না।</span>
    </div>

    <div class="card" style="max-width:820px">
        <h3><i class="fa-solid fa-file-code"></i> robots.txt এডিটর</h3>
        <p class="desc">ডিফল্ট: সব পেজ Allow, /admin Disallow, sitemap লিংক</p>
        <form method="POST" action="{{ route('admin.robots.save') }}">
            @csrf
            <textarea class="a-input mono" name="robots_txt" rows="12" spellcheck="false" style="font-family:Consolas,Monaco,monospace;font-size:13px;line-height:1.7">{{ $robots }}</textarea>
            <div style="display:flex;gap:10px;margin-top:14px;flex-wrap:wrap">
                <button class="a-btn"><i class="fa-solid fa-floppy-disk"></i> সেভ করুন</button>
                <a class="a-btn ghost" href="{{ url('/robots.txt') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> লাইভ দেখুন</a>
            </div>
        </form>
    </div>
@endsection
