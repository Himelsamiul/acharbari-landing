<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Nagad Payment Gateway (PGW) — redirect checkout with RSA-signed payloads.
 *
 * Flow: initialize (returns a payment URL) -> customer pays on Nagad ->
 * Nagad redirects to our callback -> complete -> status Success.
 *
 * Credentials are admin-managed settings (sandbox or live):
 *   nagad_mode, nagad_merchant_id, nagad_public_key (from Nagad),
 *   nagad_private_key (yours — Nagad holds the matching public key)
 */
class NagadGateway
{
    public static function enabled(): bool
    {
        return ab_online_payment() && Setting::get('nagad_enabled', '') === '1';
    }

    public static function configured(): bool
    {
        foreach (['nagad_merchant_id', 'nagad_public_key', 'nagad_private_key'] as $key) {
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
        return Setting::get('nagad_mode', 'sandbox') === 'live'
            ? 'https://merchant.api.pgw.nagad.com.bd'
            : 'http://merchant.api.sandbox.nagad.com.bd';
    }

    /** Normalize a pasted base64 key body into a full PEM string. */
    private static function pem(string $raw, bool $private): string
    {
        $raw = trim($raw);

        if (str_contains($raw, '-----BEGIN')) {
            return $raw;
        }

        $body = preg_replace('/\s+/', '', $raw);
        $lines = wordwrap($body, 64, "\n", true);
        $type = $private ? 'PRIVATE KEY' : 'PUBLIC KEY';

        return "-----BEGIN {$type}-----\n{$lines}\n-----END {$type}-----";
    }

    private static function publicKey()
    {
        return openssl_pkey_get_public(self::pem(trim((string) Setting::get('nagad_public_key', '')), false));
    }

    private static function privateKey()
    {
        return openssl_pkey_get_private(self::pem(trim((string) Setting::get('nagad_private_key', '')), true));
    }

    /** RSA-encrypt JSON with Nagad's public key (base64). */
    private static function encrypt(array $payload): ?string
    {
        $key = self::publicKey();
        if (! $key || ! openssl_public_encrypt(json_encode($payload), $encrypted, $key, OPENSSL_PKCS1_PADDING)) {
            return null;
        }

        return base64_encode($encrypted);
    }

    /** RSA-sign JSON with the merchant private key (base64). */
    private static function sign(array $payload): ?string
    {
        $key = self::privateKey();
        if (! $key || ! openssl_sign(json_encode($payload), $signature, $key, OPENSSL_ALGO_SHA256)) {
            return null;
        }

        return base64_encode($signature);
    }

    /** RSA-decrypt Nagad's response payload with the merchant private key. */
    private static function decrypt(string $base64): ?array
    {
        $key = self::privateKey();
        $raw = base64_decode($base64, true);

        if (! $key || $raw === false || ! openssl_private_decrypt($raw, $decrypted, $key, OPENSSL_PKCS1_PADDING)) {
            return null;
        }

        return json_decode($decrypted, true) ?: null;
    }

    /**
     * Start a checkout; returns the Nagad payment URL to redirect to, or null.
     */
    public static function initialize(Order $order, string $callbackUrl): ?string
    {
        $merchantId = trim((string) Setting::get('nagad_merchant_id', ''));
        $dateTime = now()->format('YmdHis');
        $orderId = $order->order_code;

        $sensitiveData = self::encrypt([
            'merchantId' => $merchantId,
            'dateTime' => $dateTime,
            'orderId' => $orderId,
            'challenge' => bin2hex(random_bytes(16)),
        ]);
        $signature = self::sign([
            'merchantId' => $merchantId,
            'dateTime' => $dateTime,
            'orderId' => $orderId,
        ]);

        if ($sensitiveData === null || $signature === null) {
            Log::error('Nagad key handling failed', ['order' => $orderId]);

            return null;
        }

        $response = Http::asJson()->timeout(30)->post(self::baseUrl() . '/api/dfs/check-out/initialize', [
            'accountMode' => '0011',
            'merchantId' => $merchantId,
            'datetime' => $dateTime,
            'orderId' => $orderId,
            'sensitiveData' => $sensitiveData,
            'signature' => $signature,
            'callbackURL' => $callbackUrl,
        ]);

        $data = $response->json() ?? [];

        if ($response->failed() || empty($data['sensitiveData'])) {
            Log::error('Nagad initialize failed', ['order' => $orderId, 'body' => $data]);

            return null;
        }

        $decrypted = self::decrypt($data['sensitiveData']);
        $url = $decrypted['paymentURL'] ?? ($decrypted['callBackUrl'] ?? null);

        if (! $url) {
            Log::error('Nagad initialize: no payment URL', ['order' => $orderId, 'body' => $data]);

            return null;
        }

        return $url;
    }

    /** Verify + finalize a payment after the callback; returns trxID or null. */
    public static function complete(Order $order, string $paymentRefId): ?array
    {
        $merchantId = trim((string) Setting::get('nagad_merchant_id', ''));

        $signature = self::sign([
            'merchantId' => $merchantId,
            'paymentRefId' => $paymentRefId,
        ]);

        if ($signature === null) {
            Log::error('Nagad complete: signing failed', ['order' => $order->order_code]);

            return null;
        }

        $response = Http::asJson()->timeout(30)->post(self::baseUrl() . '/api/dfs/check-out/complete', [
            'merchantId' => $merchantId,
            'paymentRefId' => $paymentRefId,
            'signature' => $signature,
        ]);

        $data = $response->json() ?? [];
        $decrypted = isset($data['sensitiveData']) ? self::decrypt($data['sensitiveData']) : $data;

        $status = strtoupper((string) ($decrypted['status'] ?? ''));
        if ($response->failed() || $status !== 'SUCCESS') {
            Log::warning('Nagad complete not successful', ['order' => $order->order_code, 'body' => $data]);

            return null;
        }

        return ['trxID' => (string) ($decrypted['issuerPaymentDateTime'] ?? $paymentRefId)];
    }
}
