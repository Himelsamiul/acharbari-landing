<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index()
    {
        return view('admin.redirects', ['redirects' => Redirect::latest()->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'from_path' => 'required|string|max:300',
            'to_url' => 'required|string|max:500',
            'status_code' => 'required|in:301,302',
        ]);

        $data['from_path'] = '/' . trim(parse_url($data['from_path'], PHP_URL_PATH) ?: $data['from_path'], '/ ');
        $data['is_active'] = true;

        Redirect::updateOrCreate(['from_path' => $data['from_path']], $data);

        return back()->with('success', 'রিডাইরেক্ট সেভ হয়েছে — ' . $data['from_path'] . ' → ' . $data['to_url']);
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        return back()->with('success', 'রিডাইরেক্ট মুছে ফেলা হয়েছে।');
    }

    public function toggle(Redirect $redirect)
    {
        $redirect->update(['is_active' => ! $redirect->is_active]);
        return back()->with('success', $redirect->is_active ? 'রিডাইরেক্ট চালু করা হয়েছে।' : 'রিডাইরেক্ট বন্ধ করা হয়েছে।');
    }
}
