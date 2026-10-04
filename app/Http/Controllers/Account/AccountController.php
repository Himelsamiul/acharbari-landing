<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Customer area (/account): profile edit + my orders.
 */
class AccountController extends Controller
{
    public function profile()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->take(5)->get();

        return view('account.profile', compact('orders'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => ['required', 'string', 'min:10', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'address' => 'nullable|string|max:500',
        ], [
            'phone.unique' => 'এই মোবাইল নম্বরে অন্য একটি অ্যাকাউন্ট আছে।',
        ]);

        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->address = $data['address'] ?? '';
        $user->save();

        return back()->with('success', 'প্রোফাইল আপডেট হয়েছে।');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|max:100|confirmed',
        ], [
            'password.confirmed' => 'নতুন পাসওয়ার্ড দুটি মিলছে না।',
        ]);

        if (! Hash::check($data['current_password'], $request->user()->password)) {
            return back()->withErrors(['current_password' => 'বর্তমান পাসওয়ার্ডটি সঠিক নয়।']);
        }

        $request->user()->password = $data['password']; // hashed by the model cast
        $request->user()->save();

        return back()->with('success', 'পাসওয়ার্ড পরিবর্তন হয়েছে।');
    }

    /** আমার অর্ডারসমূহ — orders linked via user_id, newest first. */
    public function orders()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);

        return view('account.orders', compact('orders'));
    }
}
