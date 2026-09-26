<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:30|unique:coupons,code',
            'percent' => 'required|integer|min:1|max:90',
            'expires_at' => 'nullable|date|after:now',
        ]);

        // normalize: strip all whitespace + uppercase so customers can type
        // the code with or without spaces ("ACHAR 10" and "ACHAR10" match)
        $code = strtoupper(preg_replace('/\s+/', '', $data['code']));

        Coupon::create([
            'code' => $code,
            'percent' => $data['percent'],
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        return back()->with('success', 'কুপন "' . $code . '" তৈরি হয়েছে।');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => ! $coupon->is_active]);

        return back()->with('success', $coupon->is_active ? 'কুপন চালু হয়েছে।' : 'কুপন বন্ধ হয়েছে।');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('success', 'কুপন মুছে ফেলা হয়েছে।');
    }
}
