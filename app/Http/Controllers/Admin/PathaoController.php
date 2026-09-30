<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Services\Delivery\PathaoCourier;
use Illuminate\Http\Request;

/** Pathao Courier API — credentials setup + order pathano + delivery status. */
class PathaoController extends Controller
{
    public function page()
    {
        return view('admin.pathao', [
            'settings' => Setting::allCached(),
            'sentOrders' => Order::whereNotNull('pathao_consignment_id')
                ->latest('id')->limit(30)->get(),
            'ready' => PathaoCourier::ready(),
        ]);
    }

    public function saveSettings(Request $request)
    {
        $data = $request->validate([
            'pathao_enabled' => 'nullable|boolean',
            'pathao_mode' => 'nullable|in:sandbox,live',
            'pathao_client_id' => 'nullable|string|max:120',
            'pathao_client_secret' => 'nullable|string|max:190',
            'pathao_username' => 'nullable|string|max:60',
            'pathao_password' => 'nullable|string|max:120',
        ]);

        Setting::setMany([
            'pathao_enabled' => $request->boolean('pathao_enabled') ? '1' : '',
            'pathao_mode' => $data['pathao_mode'] ?? 'sandbox',
            'pathao_client_id' => trim($data['pathao_client_id'] ?? ''),
            'pathao_client_secret' => trim($data['pathao_client_secret'] ?? ''),
            'pathao_username' => trim($data['pathao_username'] ?? ''),
            'pathao_password' => trim($data['pathao_password'] ?? ''),
        ]);

        return back()->with('success', 'Pathao API settings save hoyeche।');
    }

    /** Connection test — token issue kore dekhe. */
    public function testConnection()
    {
        if (! PathaoCourier::enabled()) {
            return back()->with('error', 'আগে Pathao চালু করুন।');
        }

        // purano cache-bad token muchhe fresh test
        cache()->forget('pathao_token_' . md5(PathaoCourier::baseUrl() . Setting::get('pathao_client_id', '')));

        if (PathaoCourier::token() !== null) {
            return back()->with('success', 'সংযোগ ঠিক আছে — Pathao token পাওয়া গেছে (' . (Setting::get('pathao_mode') === 'live' ? 'LIVE' : 'SANDBOX') . ')।');
        }

        return back()->with('error', 'সংযোগ ব্যর্থ — client ID/secret/username/password মিলিয়ে আবার দেখুন।');
    }

    /** Order ta Pathao te pathano. */
    public function sendOrder(Request $request, Order $order)
    {
        if (! PathaoCourier::ready()) {
            return back()->with('error', 'Pathao API কনফিগার করা নেই — আগে credentials বসান।');
        }

        if ($order->pathao_consignment_id) {
            return back()->with('error', 'এই অর্ডারটা ইতিমধ্যে Pathao তে গেছে (' . $order->pathao_consignment_id . ')।');
        }

        $result = PathaoCourier::createDelivery($order->load('items'));

        if (! $result['ok']) {
            return back()->with('error', $result['message']);
        }

        $order->update([
            'pathao_consignment_id' => $result['consignment_id'],
            'pathao_status' => $result['status'],
        ]);

        return back()->with('success', 'Pathao তে পাঠানো হয়েছে — Consignment: ' . $result['consignment_id']);
    }

    /** Pathao theke fresh delivery status ene save. */
    public function refreshStatus(Request $request, Order $order)
    {
        if (! $order->pathao_consignment_id) {
            return back()->with('error', 'এই অর্ডারটা এখনো Pathao তে যায়নি।');
        }

        $status = PathaoCourier::deliveryStatus($order->pathao_consignment_id);

        if ($status === null || $status === '') {
            return back()->with('error', 'Status আনা যায়নি — একটু পরে আবার চেষ্টা করুন।');
        }

        $order->update(['pathao_status' => $status]);

        return back()->with('success', 'Delivery status: ' . $status);
    }
}
