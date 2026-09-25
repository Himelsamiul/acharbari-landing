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
}
