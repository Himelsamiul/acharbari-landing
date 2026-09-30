<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTimelineTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(): Order
    {
        $p = Product::create([
            'slug' => 'timeline-achar', 'name' => 'টেস্ট আচার', 'name_en' => 'Test Achar',
            'category' => 'আচার', 'category_en' => 'Pickles', 'category_key' => 'pickle',
            'industry' => 'organic', 'brand' => 'আচারবাড়ি', 'unit' => 'gm', 'stock' => 10,
            'barcode' => 'TST-0009', 'price' => 100, 'old_price' => 120,
            'image' => 'assets/img/prod_mango.jpg', 'sort_order' => 1, 'vat_percent' => 0,
            'is_active' => true,
        ]);

        $this->post(route('order.store'), [
            'customer_name' => 'Timeline User',
            'phone' => '01700000009',
            'address' => 'Dhaka',
            'area' => 'inside',
            'payment_method' => 'cod',
            'items' => json_encode([['id' => $p->id, 'qty' => 1]]),
        ])->assertRedirect();

        return Order::where('phone', '01700000009')->latest('id')->first();
    }

    private function actingAsAdmin(): self
    {
        // ekoi test e dukbar call hote pare — firstOrCreate na hole unique violation
        $user = User::firstOrCreate(
            ['email' => 'admin-timeline@example.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('secret123'),
                'permissions' => array_keys(User::PERMISSIONS),
            ]
        );

        return $this->actingAs($user);
    }

    public function test_order_creation_records_pending_history(): void
    {
        $order = $this->makeOrder();

        $this->assertSame('pending', $order->fresh()->status);
        $this->assertSame(1, $order->statusHistories()->count());
        $this->assertSame('pending', $order->statusHistories()->first()->status);
    }

    public function test_admin_status_change_is_recorded_and_shown_in_timeline(): void
    {
        $order = $this->makeOrder();

        $this->actingAsAdmin()
            ->post(route('admin.orders.status', $order), ['status' => 'processing'])
            ->assertRedirect();

        $this->actingAsAdmin()
            ->post(route('admin.orders.status', $order), ['status' => 'shipped'])
            ->assertRedirect();

        $tl = $order->fresh()->statusTimeline();
        $this->assertCount(3, $tl);
        $this->assertSame('pending', $tl[0]['status']);
        $this->assertSame('processing', $tl[1]['status']);
        $this->assertSame('shipped', $tl[2]['status']);
        $this->assertNotSame('', $tl[2]['time']);
    }

    public function test_old_order_without_history_falls_back(): void
    {
        // history chhilo na (purano order) — fallback: pending @ created + current @ updated
        $order = $this->makeOrder();
        $order->statusHistories()->delete();
        $order->update(['status' => 'shipped']);

        $tl = $order->fresh()->statusTimeline();
        $this->assertCount(2, $tl);
        $this->assertSame('pending', $tl[0]['status']);
        $this->assertSame('shipped', $tl[1]['status']);
    }

    public function test_track_page_shows_timeline(): void
    {
        $order = $this->makeOrder();

        $this->get(route('track', ['code' => $order->order_code, 'phone' => '01700000009']))
            ->assertOk()
            ->assertSee('অর্ডার স্ট্যাটাস টাইমলাইন');
    }
}
