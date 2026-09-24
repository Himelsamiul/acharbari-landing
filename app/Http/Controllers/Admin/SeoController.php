<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        return view('admin.seo', [
            'title' => Setting::get('seo_title', 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ'),
            'desc' => Setting::get('seo_desc', 'ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনি — প্রিজারভেটিভ মুক্ত, ক্যাশ অন ডেলিভারিতে সারা বাংলাদেশে হোম ডেলিভারি।'),
            'keywords' => Setting::get('seo_keywords', 'deshi achar, mango pickle, আচারবাড়ি, homemade pickle BD, sundarban honey, deshi ghee, tamarind chutney, achar online BD, খাঁটি মধু, দেশি ঘি'),
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'seo_title' => 'required|string|max:150',
            'seo_desc' => 'required|string|max:400',
            'seo_keywords' => 'required|string|max:500',
        ]);

        Setting::setMany([
            'seo_title' => $data['seo_title'],
            'seo_desc' => $data['seo_desc'],
            'seo_keywords' => $data['seo_keywords'],
        ]);

        return back()->with('success', 'SEO সেটিংস সেভ হয়েছে — ল্যান্ডিং পেজ ও সার্চ ইঞ্জিনে প্রয়োগ হবে।');
    }
}
