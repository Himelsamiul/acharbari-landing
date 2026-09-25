<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /** Public complaint submit (fetch JSON from the landing modal). */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|min:10|max:15',
            'description' => 'required|string|max:2000',
            'order_code' => 'nullable|string|max:30',
        ]);

        Complaint::create($data);

        return response()->json([
            'message' => 'কমপ্লেইন গৃহীত হয়েছে — আমাদের টিম শীঘ্রই আপনার সাথে যোগাযোগ করবে।',
        ]);
    }
}
