@extends('layouts.admin')

@section('title', '301 Redirects')
@section('page_title', '301 Redirects')
@section('page_sub', 'পুরনো URL থেকে নতুন URL-এ রিডাইরেক্ট ম্যানেজ করুন')

@section('content')
    <div class="note-banner">
        <i class="fa-solid fa-rotate"></i>
        <span>পুরনো লিংক বদলালে বা প্রোডাক্ট সরালে SEO জুস হারাতে না চাইলে এখানে 301 রিডাইরেক্ট যোগ করুন। <b>From</b> হবে সাইটের ভেতরের পাথ (যেমন <code>/old-page</code>), <b>To</b> পাথ বা পুরো URL দুটোই চলবে।</span>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-plus"></i> নতুন রিডাইরেক্ট</h3>
        <form method="POST" action="{{ route('admin.redirects.store') }}">
            @csrf
            <div class="fgrid" style="grid-template-columns:1fr 1fr 130px auto;align-items:end" id="redGrid">
                <div class="a-field">
                    <label>From (পুরনো পাথ)</label>
                    <input class="a-input" name="from_path" placeholder="/old-page" required maxlength="300">
                </div>
                <div class="a-field">
                    <label>To (নতুন URL)</label>
                    <input class="a-input" name="to_url" placeholder="/products অথবা https://…" required maxlength="500">
                </div>
                <div class="a-field">
                    <label>কোড</label>
                    <select class="a-input" name="status_code">
                        <option value="301">301 (স্থায়ী)</option>
                        <option value="302">302 (সাময়িক)</option>
                    </select>
                </div>
                <div class="a-field">
                    <button class="a-btn" style="width:100%"><i class="fa-solid fa-plus"></i> যোগ</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <h3><i class="fa-solid fa-list"></i> রিডাইরেক্ট তালিকা ({{ $redirects->count() }})</h3>
        <p class="desc">চালু/বন্ধ টগল করতে সুইচ বাটন চাপুন</p>
        @if ($redirects->isEmpty())
            <p style="text-align:center;color:#8b7355;font-size:13px;padding:24px 0">এখনো কোনো রিডাইরেক্ট নেই।</p>
        @else
            <table class="tbl">
                <thead>
                    <tr><th>From</th><th>To</th><th>কোড</th><th>স্ট্যাটাস</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($redirects as $r)
                        <tr>
                            <td><code>{{ $r->from_path }}</code></td>
                            <td><b>{{ $r->to_url }}</b></td>
                            <td><span class="pill {{ $r->status_code === 301 ? 'ok' : 'info' }}">{{ $r->status_code }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.redirects.toggle', $r) }}">
                                    @csrf
                                    <button type="submit" class="pill {{ $r->is_active ? 'ok' : 'mut' }}" style="border:none;cursor:pointer;font-family:inherit">
                                        {{ $r->is_active ? 'চালু' : 'বন্ধ' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.redirects.destroy', $r) }}" onsubmit="return confirm('রিডাইরেক্টটি মুছে ফেলবেন?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="মুছুন"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <style>
        @media (max-width: 900px) { #redGrid { grid-template-columns: 1fr 1fr !important; } }
        @media (max-width: 520px) { #redGrid { grid-template-columns: 1fr !important; } }
    </style>
@endsection
