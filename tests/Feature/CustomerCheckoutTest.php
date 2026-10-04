<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerCheckoutTest extends TestCase
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
            'industry' => 'organic',
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
            'vat_percent' => 0,
            'is_active' => true,
        ], $overrides));
    }

    private function payload(Product $p, array $overrides = []): array
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

    public function test_logged_in_customer_checkout_links_user_id(): void
    {
        $customer = User::factory()->customer([
            'password' => Hash::make('password'),
            'name' => 'রেজিস্টার্ড গ্রাহক',
            'phone' => '01712345678',
            'address' => 'প্রোফাইল ঠিকানা, ঢাকা',
        ])->create()->refresh();

        $p = $this->makeProduct();

        // profile prefills the checkout fields when they come back empty
        $response = $this->actingAs($customer)->post(route('order.store'), $this->payload($p, [
            'customer_name' => '',
            'phone' => '',
            'address' => '',
        ]));

        $response->assertRedirect();

        $order = Order::latest('id')->first();
        $this->assertSame($customer->id, $order->user_id);
        $this->assertEquals('রেজিস্টার্ড গ্রাহক', $order->customer_name);
        $this->assertEquals('01712345678', $order->phone);
        $this->assertEquals('প্রোফাইল ঠিকানা, ঢাকা', $order->address);

        // the order shows up in the customer's account area
        $this->actingAs($customer)->get(route('account.orders'))
            ->assertOk()
            ->assertSee($order->order_code);
    }

    public function test_guest_checkout_stays_unlinked(): void
    {
        $p = $this->makeProduct();

        $this->post(route('order.store'), $this->payload($p))->assertRedirect();

        $order = Order::latest('id')->first();
        $this->assertNull($order->user_id);
        $this->assertEquals('Test User', $order->customer_name);
    }

    public function test_admin_account_orders_are_not_mixed_into_customer_area(): void
    {
        $admin = User::factory()->admin()->create(['password' => Hash::make('password')]);

        $this->actingAs($admin)->get(route('account'))
            ->assertRedirect(route('admin.dashboard'));
    }
}
