<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(string $paymentMethod = 'bkash', string $paymentStatus = 'pending'): Order
    {
        $p = Product::create([
            'slug' => 'gw-achar', 'name' => 'টেস্ট আচার', 'name_en' => 'Test Achar',
            'category' => 'আচার', 'category_en' => 'Pickles', 'category_key' => 'pickle',
            'industry' => 'organic', 'brand' => 'আচারবাড়ি', 'unit' => 'gm', 'stock' => 10,
            'barcode' => 'TST-0005', 'price' => 200, 'old_price' => 250,
            'image' => 'assets/img/prod_mango.jpg', 'sort_order' => 1, 'vat_percent' => 0,
            'is_active' => true,
        ]);

        $this->post(route('order.store'), [
            'customer_name' => 'GW User', 'phone' => '01712345678', 'address' => 'Dhaka',
            'area' => 'inside', 'payment_method' => $paymentMethod,
            'items' => json_encode([['id' => $p->id, 'qty' => 1]]),
        ])->assertRedirect();

        $order = Order::latest('id')->first();
        if ($paymentStatus !== 'pending') {
            $order->update(['payment_status' => $paymentStatus]);
        }

        return $order;
    }

    private function enableBkash(): void
    {
        Setting::setMany([
            'online_payment_enabled' => '1', 'bkash_enabled' => '1', 'bkash_mode' => 'sandbox',
            'bkash_app_key' => 'testkey', 'bkash_app_secret' => 'testsecret',
            'bkash_username' => 'testuser', 'bkash_password' => 'testpass',
        ]);
    }

    public function test_bkash_network_failure_returns_null_gracefully(): void
    {
        // bKash down (connection exception) — 500 na, graceful null
        $this->enableBkash();
        Http::fake(fn () => throw new \Exception('connection refused'));

        $this->assertNull(\App\Services\Payment\BkashGateway::grantToken());
    }

    public function test_create_payment_returns_null_when_token_fails(): void
    {
        $this->enableBkash();
        $order = $this->makeOrder();

        Http::fake(['*token/grant*' => Http::response(['status' => 'FAILED'], 401)]);

        $this->assertNull(\App\Services\Payment\BkashGateway::createPayment($order, 'https://x.test/cb'));
    }

    public function test_create_payment_returns_url_on_success(): void
    {
        $this->enableBkash();
        $order = $this->makeOrder();

        Http::fake([
            '*token/grant*' => Http::response(['id_token' => 'TOK123']),
            '*checkout/create' => Http::response(['paymentID' => 'P1', 'bkashURL' => 'https://bkash.test/pay']),
        ]);

        $result = \App\Services\Payment\BkashGateway::createPayment($order, 'https://x.test/cb');

        $this->assertNotNull($result);
        $this->assertSame('P1', $result['paymentID']);
        $this->assertSame('https://bkash.test/pay', $result['bkashURL']);
    }

    public function test_paid_order_never_flips_to_failed_on_callback(): void
    {
        // order age paid — tarpor khali callback (execute fail) asle failed e nambe na
        $this->enableBkash();
        $order = $this->makeOrder('bkash', 'paid');

        Http::fake(['*' => Http::response(['status' => 'FAILED'], 500)]);

        $this->get(route('payment.callback.bkash', ['code' => $order->order_code, 'status' => 'success', 'paymentID' => 'P1']))
            ->assertRedirect();

        $this->assertSame('paid', $order->fresh()->payment_status);
    }

    public function test_unpaid_pending_order_marks_failed_on_bad_callback(): void
    {
        $this->enableBkash();
        $order = $this->makeOrder('bkash', 'pending');

        Http::fake(['*' => Http::response(['status' => 'FAILED'], 500)]);

        $this->get(route('payment.callback.bkash', ['code' => $order->order_code, 'status' => 'failure']))
            ->assertRedirect();

        $this->assertSame('failed', $order->fresh()->payment_status);
    }
}
