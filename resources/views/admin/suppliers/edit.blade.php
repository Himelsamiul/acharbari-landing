@extends('layouts.admin')

@section('title', 'সাপ্লায়ার এডিট — ' . $supplier->name)
@section('page_title', 'সাপ্লায়ার এডিট — ' . $supplier->name)
@section('page_sub', 'সাপ্লায়ারের তথ্য হালনাগাদ করুন')

@section('content')
    <div class="card" style="max-width:760px">
        <h3><i class="fa-solid fa-pen"></i> সাপ্লায়ার তথ্য</h3>
        <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}">
            @csrf
            @method('PUT')
            <div class="fgrid">
                <div class="a-field">
                    <label>সাপ্লায়ারের নাম *</label>
                    <input class="a-input" name="name" value="{{ old('name', $supplier->name) }}" required>
                </div>
                <div class="a-field">
                    <label>কোম্পানি / দোকান</label>
                    <input class="a-input" name="company" value="{{ old('company', $supplier->company) }}">
                </div>
                <div class="a-field">
                    <label>মোবাইল</label>
                    <input class="a-input" name="phone" value="{{ old('phone', $supplier->phone) }}">
                </div>
                <div class="a-field">
                    <label>ঠিকানা</label>
                    <input class="a-input" name="address" value="{{ old('address', $supplier->address) }}">
                </div>
            </div>
            <div class="a-field">
                <label>নোট</label>
                <input class="a-input" name="note" value="{{ old('note', $supplier->note) }}">
            </div>
            <div style="display:flex;gap:10px;margin-top:10px">
                <button class="a-btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> আপডেট করুন</button>
                <a class="a-btn ghost" href="{{ route('admin.suppliers') }}">বাতিল</a>
            </div>
        </form>
    </div>
@endsection
