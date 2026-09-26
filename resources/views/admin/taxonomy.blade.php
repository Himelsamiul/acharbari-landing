@extends('layouts.admin')

@section('title', 'ক্যাটাগরি ও ব্র্যান্ড')
@section('page_title', 'ক্যাটাগরি ও ব্র্যান্ড')
@section('page_sub', 'প্রোডাক্টের ক্যাটাগরি ও ব্র্যান্ড ম্যানেজমেন্ট')

@section('content')
    @if ($errors->any())
        <div class="alert-success" style="background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.3);color:#dc2626">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start" class="tax-grid">
        <div class="card">
            <h3>ক্যাটাগরি</h3>
            <p class="desc">প্রোডাক্টের ক্যাটাগরি (আচার, মধু ও ঘি…)</p>
            <table class="tbl">
                <thead><tr><th>নাম</th><th>Key</th><th>প্রোডাক্ট</th><th></th></tr></thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr>
                            <td><b>{{ $cat->name }}</b> <span style="color:#8b7355">({{ $cat->name_en }})</span></td>
                            <td><code>{{ $cat->key }}</code></td>
                            <td>{{ $cat->products_count }}টি</td>
                            <td>
                                <div style="display:flex;gap:6px;align-items:center">
                                    @if ($cat->is_active)<span class="pill ok">চালু</span>
                                    @else<span class="pill red">বন্ধ</span>@endif
                                    <form method="POST" action="{{ route('admin.taxonomy.category.toggle', $cat) }}">
                                        @csrf
                                        <button class="btn-icon" type="submit" title="{{ $cat->is_active ? 'বন্ধ করুন' : 'চালু করুন' }}">
                                            <i class="fa-solid {{ $cat->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.taxonomy.category.destroy', $cat) }}"
                                        onsubmit="return confirm('ক্যাটাগরি মুছবেন?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-icon" type="submit"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form method="POST" action="{{ route('admin.taxonomy.category.store') }}" style="margin-top:16px">
                @csrf
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <input class="a-input" style="flex:1;min-width:120px" name="name" placeholder="নাম (বাংলা)" required>
                    <input class="a-input" style="flex:1;min-width:120px" name="name_en" placeholder="Name (English)" required>
                    <input class="a-input" style="flex:1;min-width:100px" name="key" placeholder="key (english)" required>
                    <button class="a-btn"><i class="fa-solid fa-plus"></i> যোগ</button>
                </div>
            </form>
        </div>

        <div class="card">
            <h3>ব্র্যান্ড</h3>
            <p class="desc">প্রোডাক্টের ব্র্যান্ড</p>
            <table class="tbl">
                <thead><tr><th>নাম</th><th>প্রোডাক্ট</th><th></th></tr></thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td><b>{{ $brand->name }}</b></td>
                            <td>{{ $brand->products_count }}টি</td>
                            <td>
                                <div style="display:flex;gap:6px;align-items:center">
                                    @if ($brand->is_active)<span class="pill ok">চালু</span>
                                    @else<span class="pill red">বন্ধ</span>@endif
                                    <form method="POST" action="{{ route('admin.taxonomy.brand.toggle', $brand) }}">
                                        @csrf
                                        <button class="btn-icon" type="submit" title="{{ $brand->is_active ? 'বন্ধ করুন' : 'চালু করুন' }}">
                                            <i class="fa-solid {{ $brand->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.taxonomy.brand.destroy', $brand) }}"
                                        onsubmit="return confirm('ব্র্যান্ড মুছবেন?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-icon" type="submit"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form method="POST" action="{{ route('admin.taxonomy.brand.store') }}" style="margin-top:16px">
                @csrf
                <div style="display:flex;gap:8px">
                    <input class="a-input" style="flex:1" name="name" placeholder="ব্র্যান্ডের নাম" required>
                    <button class="a-btn"><i class="fa-solid fa-plus"></i> যোগ</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @media (max-width: 900px) { .tax-grid { grid-template-columns: 1fr !important; } }
    </style>
@endsection
