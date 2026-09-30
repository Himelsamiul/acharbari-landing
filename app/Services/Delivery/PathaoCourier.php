<?php

namespace App\Services\Delivery;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Pathao Courier API (merchant "aladdin" API) — order Pathao te pathano,
 * delivery status pull kora. Credentials: developer.pathao.com theke.
 */
class PathaoCourier
{
    public static function enabled(): bool
    {
        return Setting::get('pathao_enabled', '') === '1';
    }

    public static function baseUrl(): string
    {
        return Setting::get('pathao_mode', 'sandbox') === 'live'
            ? 'https://courier-api.pathao.com'
            : 'https://courier-api-sandbox.pathao.com';
    }

    public static function ready(): bool
    {
        return self::enabled()
            && trim((string) Setting::get('pathao_client_id', '')) !== ''
            && trim((string) Setting::get('pathao_client_secret', '')) !== ''
            && trim((string) Setting::get('pathao_username', '')) !== ''
            && trim((string) Setting::get('pathao_password', '')) !== '';
    }

    /** Access token — expire porjonto cache hoy (expires_in second). */
    public static function token(): ?string
    {
        $cacheKey = 'pathao_token_' . md5(self::baseUrl() . Setting::get('pathao_client_id', ''));

        $cached = Cache::get($cacheKey);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        try {
            $res = Http::asJson()->timeout(30)->post(self::baseUrl() . '/aladdin/api/v1/issue-token', [
                'client_id' => Setting::get('pathao_client_id'),
                'client_secret' => Setting::get('pathao_client_secret'),
                'username' => Setting::get('pathao_username'),
                'password' => Setting::get('pathao_password'),
                'grant_type' => 'password',
            ]);
        } catch (\Throwable $e) {
            report($e);

            return null;
        }

        if (! $res->successful() || empty($res->json('access_token'))) {
            return null;
        }

        $token = (string) $res->json('access_token');
        $ttl = (int) $res->json('expires_in', 86400);
        Cache::put($cacheKey, $token, max(60, $ttl - 60));

        return $token;
    }

    /** Order Pathao te pathano — consignment create. */
    public static function createDelivery(Order $order): array
    {
        $token = self::token();
        if ($token === null) {
            return ['ok' => false, 'message' => 'Pathao token nil — credentials check korun (connection test chalano jay).'];
        }

        // COD/due hole Pathao taka kole ashe; age paid hoye thakle 0
        $collect = ($order->payment_status === 'paid') ? 0 : (float) $order->total;

        try {
            $res = Http::withToken($token)->asJson()->timeout(30)->post(self::baseUrl() . '/aladdin/api/v1/orders', [
                'merchant_order_id' => $order->order_code,
                'recipient_name' => $order->customer_name,
                'recipient_phone' => $order->phone,
                'recipient_address' => trim($order->address . ($order->district ? ', ' . $order->district : '')),
                'delivery_type' => 12, // normal pickup
                'item_type' => 2, // parcel
                'item_quantity' => max(1, (int) $order->items->sum('quantity')),
                'item_weight' => 0.5,
                'amount_to_collect' => round($collect, 2),
                'item_description' => $order->items->map(fn ($i) => $i->product_name . ' x' . $i->quantity)->implode(', '),
                'special_instruction' => 'Handle with care',
            ]);
        } catch (\Throwable $e) {
            report($e);

            return ['ok' => false, 'message' => 'Pathao API e connect kora jay nai — ' . $e->getMessage()];
        }

        if (! $res->successful()) {
            return ['ok' => false, 'message' => 'Pathao order nil — ' . ($res->json('message') ?? $res->status())];
        }

        return [
            'ok' => true,
            'consignment_id' => (string) ($res->json('consignment_id') ?? ''),
            'status' => (string) ($res->json('order_status') ?? ($res->json('delivery_status') ?? 'Pending')),
            'fee' => $res->json('delivery_fee'),
        ];
    }

    /** Consignment er latest delivery status. */
    public static function deliveryStatus(string $consignmentId): ?string
    {
        $token = self::token();
        if ($token === null || $consignmentId === '') {
            return null;
        }

        try {
            $res = Http::withToken($token)->timeout(30)->get(self::baseUrl() . '/aladdin/api/v1/orders/' . urlencode($consignmentId));
        } catch (\Throwable $e) {
            report($e);

            return null;
        }

        return $res->successful() ? (string) ($res->json('delivery_status') ?? '') : null;
    }
}
