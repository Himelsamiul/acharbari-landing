<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManualPaymentTest extends TestCase
{
    use RefreshDatabase;

    private function makeProduct(): Product
    {
        return Product::create([
            'slug' => 'manual-pay-achar',
            'name' => 'টেস্ট আচার',
            'name_en' => 'Test Achar',
            'category' => 'আচার',
            'category_en' => 'Pickles',
            'category_key' => 'pickle',
            'industry' => 'organic',
            'brand' => 'আচারবাড়ি',
            'unit' => 'gm',
            'stock' => 50,
            'barcode' => 'TST-0002',
            'price' => 400,
            'old_price' => 500,
            'image' => 'assets/img/prod_mango.jpg',
            'sort_order' => 1,
            'vat_percent' => 5,
            'is_active' => true,
        ]);
    }

    private function enableManual(): void
    {
        \App\Models\Setting::setMany([
            'manual_payment_enabled' => '1',
            'manual_bkash_number' => '01711111111',
        ]);
    }

    private function payload(Product $p, array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Manual User',
            'phone' => '01700000002',
            'address' => 'House 5, Dhaka',
            'area' => 'inside',
            'payment_method' => 'manual',
            'items' => json_encode([['id' => $p->id, 'qty' => 1]]),
        ], $overrides);
    }

    public function test_manual_order_without_trxid_is_rejected(): void
    {
        $this->enableManual();
        $p = $this->makeProduct();

        $this->post(route('order.store'), $this->payload($p))
            ->assertSessionHasErrors(['payment_ref']);
    }

    public function test_manual_order_with_trxid_stores_pending_and_txn(): void
    {
        $this->enableManual();
        $p = $this->makeProduct();

        $this->post(route('order.store'), $this->payload($p, ['payment_ref' => 'TRX123ABC']))
            ->assertRedirect();

        $order = Order::where('phone', '01700000002')->latest('id')->first();
        $this->assertNotNull($order);
        $this->assertSame('manual', $order->payment_method);
        // manual shuru te pending — admin TrxID verify kore paid kore
        $this->assertSame('pending', $order->payment_status);
        $this->assertSame('TRX123ABC', $order->payment_txn_id);
    }

    public function test_manual_option_hidden_when_disabled(): void
    {
        // toggle off thakle manual method server-o accept kore na
        \App\Models\Setting::set('manual_payment_enabled', '');
        $p = $this->makeProduct();

        $this->post(route('order.store'), $this->payload($p, ['payment_ref' => 'TRX123ABC']))
            ->assertSessionHasErrors(['payment_method']);
    }

    public function test_cod_order_has_no_payment_status_or_txn(): void
    {
        $this->enableManual();
        $p = $this->makeProduct();

        $this->post(route('order.store'), $this->payload($p, [
            'payment_method' => 'cod',
            'payment_ref' => 'SHOULD_BE_IGNORED',
        ]))->assertRedirect();

        $order = Order::where('phone', '01700000002')->latest('id')->first();
        $this->assertSame('cod', $order->payment_method);
        $this->assertNull($order->payment_status);
        $this->assertNull($order->payment_txn_id);
    }

    public function test_admin_can_mark_manual_payment_paid(): void
    {
        $this->enableManual();
        $p = $this->makeProduct();

        $this->post(route('order.store'), $this->payload($p, ['payment_ref' => 'TRX123ABC']))
            ->assertRedirect();

        $order = Order::where('phone', '01700000002')->latest('id')->first();

        // admin user perm soho — admin panel er test auth helper nai, tai route direct call
        $this->actingAsAdmin()->post(route('admin.orders.payment', $order), ['status' => 'paid'])
            ->assertRedirect();

        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame('TRX123ABC', $order->fresh()->payment_txn_id);
    }

    /** Admin panel e perm:orders middleware — full-permission admin banai. */
    private function actingAsAdmin(): self
    {
        $user = \App\Models\User::create([
            'name' => 'Test Admin',
            'email' => 'admin-test@example.com',
            'password' => bcrypt('secret123'),
            'permissions' => array_keys(\App\Models\User::PERMISSIONS),
        ]);

        return $this->actingAs($user);
    }
}
