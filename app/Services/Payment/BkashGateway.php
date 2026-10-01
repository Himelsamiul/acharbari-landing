<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * bKash Tokenized Checkout (PGW) — mode 0011.
 *
 * Flow: grant token -> create payment (returns bkashURL) -> customer pays on
 * bKash -> bKash redirects to our callback -> execute payment -> trxID.
 *
 * Credentials are admin-managed settings (sandbox or live):
 *   bkash_mode, bkash_app_key, bkash_app_secret, bkash_username, bkash_password
 */
class BkashGateway
{
    public static function enabled(): bool
    {
        return ab_online_payment() && Setting::get('bkash_enabled', '') === '1';
    }

    public static function configured(): bool
    {
        foreach (['bkash_app_key', 'bkash_app_secret', 'bkash_username', 'bkash_password'] as $key) {
            if (trim((string) Setting::get($key, '')) === '') {
                return false;
            }
        }

        return true;
    }

    public static function ready(): bool
    {
        return self::enabled() && self::configured();
    }

    public static function baseUrl(): string
    {
        return Setting::get('bkash_mode', 'sandbox') === 'live'
            ? 'https://tokenized.pay.bka.sh/v1.2.0-beta'
            : 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
    }

    /** Global (basic-auth) headers sent with every call. */
    private static function headers(): array
    {
        return [
            'username' => trim((string) Setting::get('bkash_username', '')),
            'password' => trim((string) Setting::get('bkash_password', '')),
            'app_key' => trim((string) Setting::get('bkash_app_key', '')),
            'app_secret' => trim((string) Setting::get('bkash_app_secret', '')),
            'Content-Type' => 'application/json',
        ];
    }

    /** JSON POST with auth — network exception hole null (checkout 500 na hoy). */
    private static function post(string $path, string $token, array $body): ?\Illuminate\Http\Client\Response
    {
        try {
            return Http::asJson()
                ->withHeaders(self::headers() + ['Authorization' => $token])
                ->timeout(30)
                ->post(self::baseUrl() . '/' . $path, $body);
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }

    /** Grant token (cached ~55 min; bKash tokens live 1 hour). */
    public static function grantToken(): ?string
    {
        // credentials er hash cache key te — key/secret bodlale purano token ar chole na
        $cacheKey = 'bkash_id_token_' . Setting::get('bkash_mode', 'sandbox') . '_' . substr(md5(
            Setting::get('bkash_app_key', '') . '|' . Setting::get('bkash_app_secret', '') . '|' .
            Setting::get('bkash_username', '') . '|' . Setting::get('bkash_password', '')
        ), 0, 10);

        $cached = Cache::get($cacheKey);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        try {
            $response = Http::asJson()
                ->withHeaders(self::headers())
                ->timeout(30)
                ->post(self::baseUrl() . '/tokenized/checkout/token/grant', [
                    'app_key' => trim((string) Setting::get('bkash_app_key', '')),
                    'app_secret' => trim((string) Setting::get('bkash_app_secret', '')),
                ]);
        } catch (\Throwable $e) {
            report($e); // network down / DNS fail — checkout 500 na hoye graceful fail koruk

            return null;
        }

        $data = $response->json() ?? [];

        if ($response->failed() || empty($data['id_token'])) {
            Log::error('bKash grant token failed', ['status' => $response->status(), 'body' => $response->json()]);

            return null;
        }

        Cache::put($cacheKey, $data['id_token'], now()->addMinutes(55));

        return $data['id_token'];
    }

    /** Create a checkout payment; returns ['paymentID' => …, 'bkashURL' => …] or null. */
    public static function createPayment(Order $order, string $callbackUrl): ?array
    {
        $token = self::grantToken();
        if ($token === null) {
            return null;
        }

        $response = self::post('tokenized/checkout/create', $token, [
            'mode' => '0011',
            'payerReference' => $order->phone,
            'callbackURL' => $callbackUrl,
            'amount' => number_format($order->total, 2, '.', ''),
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $order->order_code,
        ]);

        if ($response === null) {
            return null;
        }

        $data = $response->json() ?? [];

        if ($response->failed() || empty($data['paymentID']) || empty($data['bkashURL'])) {
            Log::error('bKash create payment failed', ['order' => $order->order_code, 'body' => $response->json()]);

            return null;
        }

        return ['paymentID' => $data['paymentID'], 'bkashURL' => $data['bkashURL']];
    }

    /** Execute a created payment; returns ['trxID' => …] or null. */
    public static function executePayment(string $paymentID): ?array
    {
        $token = self::grantToken();
        if ($token === null) {
            return null;
        }

        $response = self::post('tokenized/checkout/execute', $token, [
            'paymentID' => $paymentID,
        ]);

        if ($response === null) {
            return null;
        }

        $data = $response->json() ?? [];

        // "pendingTransaction" just means the customer is still completing it on bKash
        if ($response->failed() || (($data['transactionStatus'] ?? '') !== 'Completed')) {
            Log::warning('bKash execute not completed', ['paymentID' => $paymentID, 'body' => $data]);

            return null;
        }

        return ['trxID' => $data['trxID'] ?? '', 'amount' => $data['amount'] ?? null];
    }

    /** Query payment status (verification without side effects). */
    public static function queryPayment(string $paymentID): ?array
    {
        $token = self::grantToken();
        if ($token === null) {
            return null;
        }

        $response = self::post('tokenized/checkout/payment/status', $token, [
            'paymentID' => $paymentID,
        ]);

        return ($response !== null && $response->successful()) ? ($response->json() ?? null) : null;
    }
}
