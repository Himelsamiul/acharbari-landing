<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::latest()->paginate(20);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function toggle(Complaint $complaint)
    {
        $complaint->update(['is_resolved' => ! $complaint->is_resolved]);

        return back()->with('success', $complaint->is_resolved ? 'কমপ্লেইন সমাধান হয়েছে।' : 'কমপ্লেইন আবার খোলা হয়েছে।');
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return back()->with('success', 'কমপ্লেইন মুছে ফেলা হয়েছে।');
    }
}
