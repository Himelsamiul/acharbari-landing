<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    private function makeProduct(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'slug' => 'test-achar',
            'name' => 'টেস্ট আচার',
            'name_en' => 'Test Achar',
            'category' => 'আচার',
            'category_en' => 'Pickles',
            'category_key' => 'pickle',
            'industry' => 'organic', // migration shob row backfill kore, test-eo set korte hoy
            'brand' => 'আচারবাড়ি',
            'unit' => 'gm',
            'stock' => 50,
            'barcode' => 'TST-0001',
            'price' => 400,
            'old_price' => 500,
            'discount_bn' => '-20% ছাড়',
            'discount_en' => '-20% Off',
            'image' => 'assets/img/prod_mango.jpg',
            'rating' => 4.8,
            'reviews_count' => 10,
            'stock_badge' => 'স্টকে আছে',
            'stock_badge_en' => 'In Stock',
            'description' => 'টেস্ট বিবরণ',
            'description_en' => 'Test description',
            'sort_order' => 1,
            'vat_percent' => 5,
            'is_active' => true,
        ], $overrides));
    }

    private function validPayload(Product $p, array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Test User',
            'phone' => '01712345678',
            'address' => 'House 12, Road 5, Dhaka',
            'area' => 'inside',
            'payment_method' => 'cod',
            'items' => json_encode([['id' => $p->id, 'qty' => 2]]),
        ], $overrides);
    }

    public function test_store_requires_all_fields(): void
    {
        $this->post(route('order.store'), [])->assertSessionHasErrors([
            'customer_name', 'phone', 'address', 'area', 'payment_method', 'items',
        ]);
    }

    public function test_phone_must_be_valid_bd_mobile(): void
    {
        $p = $this->makeProduct();

        // 10 digit / bhul format — reject
        $this->post(route('order.store'), $this->validPayload($p, ['phone' => '1712345678']))
            ->assertSessionHasErrors(['phone']);
        $this->post(route('order.store'), $this->validPayload($p, ['phone' => '0171234567']))
            ->assertSessionHasErrors(['phone']);
        $this->post(route('order.store'), $this->validPayload($p, ['phone' => '03123456789']))
            ->assertSessionHasErrors(['phone']);

        // +880/880 prefix — normalize hoye 11 digit e store
        $this->post(route('order.store'), $this->validPayload($p, ['phone' => '+8801712345678']))
            ->assertRedirect();
        $order = Order::latest('id')->first();
        $this->assertSame('01712345678', $order->phone);
    }

    public function test_store_rejects_invalid_area(): void
    {
        $p = $this->makeProduct();
        $this->post(route('order.store'), $this->validPayload($p, ['area' => 'free_shipping']))
            ->assertSessionHasErrors('area');
    }

    public function test_order_totals_with_coupon_vat_and_shipping(): void
    {
        Coupon::create(['code' => 'TEST10', 'percent' => 10, 'is_active' => true]);
        $p = $this->makeProduct(); // 400 × 2 = 800

        $response = $this->post(route('order.store'), $this->validPayload($p, [
            'coupon_code' => 'test10', // case-insensitive
        ]));

        $response->assertRedirect();

        $order = Order::latest('id')->first();
        $this->assertEquals(800, $order->subtotal);
        $this->assertEquals(80, $order->discount);        // 10% of 800
        $this->assertEquals(40, $order->vat_total);       // 5% VAT
        $this->assertEquals(80, $order->shipping_cost);   // inside Dhaka
        $this->assertEquals(800 - 80 + 40 + 80, $order->total);
        $this->assertEquals('TEST10', $order->coupon_code);
    }

    public function test_invalid_coupon_is_ignored(): void
    {
        $p = $this->makeProduct();

        $this->post(route('order.store'), $this->validPayload($p, ['coupon_code' => 'FAKE50']))
            ->assertRedirect();

        $order = Order::latest('id')->first();
        $this->assertEquals(0, $order->discount);
        $this->assertNull($order->coupon_code);
    }

    public function test_stock_is_decremented_and_qty_clamped_to_stock(): void
    {
        $p = $this->makeProduct(['stock' => 3]);

        $this->post(route('order.store'), $this->validPayload($p, [
            'items' => json_encode([['id' => $p->id, 'qty' => 10]]), // more than stock
        ]))->assertRedirect();

        $order = Order::latest('id')->first();
        $this->assertEquals(3, $order->items->sum('quantity')); // clamped
        $this->assertEquals(0, $p->fresh()->stock);             // decremented
    }

    public function test_tracking_requires_matching_code_and_phone(): void
    {
        $p = $this->makeProduct();
        $this->post(route('order.store'), $this->validPayload($p));
        $order = Order::latest('id')->first();

        // correct code + correct phone → visible
        $this->get(route('track', ['code' => $order->order_code, 'phone' => '01712345678']))
            ->assertOk()
            ->assertSee($order->order_code);

        // correct code + WRONG phone → not found
        $this->get(route('track', ['code' => $order->order_code, 'phone' => '01999999999']))
            ->assertOk()
            ->assertDontSee($order->customer_name);

        // phone alone (old behaviour) → nothing
        $this->get(route('track', ['phone' => '01712345678']))
            ->assertOk()
            ->assertDontSee($order->customer_name);
    }

    public function test_order_totals_use_variant_price_and_vat(): void
    {
        $p = $this->makeProduct(['price' => 400, 'vat_percent' => 5, 'stock' => 10]);
        $p->variants()->create([
            'size' => '৫০০ গ্রাম', 'price' => 450, 'old_price' => 500,
            'vat_percent' => 10, 'stock' => 5, 'is_active' => true,
        ]);
        $variant = $p->variants->first();

        $this->post(route('order.store'), $this->validPayload($p, [
            'items' => json_encode([['id' => $p->id, 'variant_id' => $variant->id, 'qty' => 2]]),
        ]))->assertRedirect();

        $order = Order::latest('id')->first();
        $this->assertEquals(900, $order->subtotal);   // variant price 450 × 2 — product er 400 na
        $item = $order->items->first();
        $this->assertEquals(450, $item->price);
        $this->assertNotNull($item->variant_id);
        $this->assertEquals(90, $order->vat_total);   // variant er 10% VAT
        $this->assertEquals(80, $order->shipping_cost);
        $this->assertEquals(1070, $order->total);     // 900 + 90 + 80
    }
}
