<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderDateRangeFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_from_to_date_filter_shows_only_that_ranges_orders(): void
    {
        $admin = User::create([
            'name' => 'Boss', 'email' => 'boss@test.bd', 'password' => 'secret123',
            'permissions' => array_keys(User::PERMISSIONS),
        ]);

        $mk = function (string $code, string $name) {
            $o = Order::create([
                'order_code' => $code, 'customer_name' => $name, 'phone' => '0170000000' . rand(1, 9),
                'address' => 'x', 'area' => 'inside', 'payment_method' => 'cod',
                'subtotal' => 100, 'discount' => 0, 'vat_total' => 0, 'shipping_cost' => 80,
                'total' => 180, 'status' => 'pending',
            ]);
            // created_at fillable na — direct DB te set korte hoy
            \Illuminate\Support\Facades\DB::table('orders')->where('id', $o->id)->update([
                'created_at' => $name === 'Old' ? now()->subMonths(2) : now(),
            ]);
            return $o;
        };

        $mk('T-OLD-1', 'Old');
        $mk('T-NOW-1', 'Now1');
        $mk('T-NOW-2', 'Now2');

        $from = now()->subDays(2)->toDateString();
        $to = now()->toDateString();

        $html = $this->actingAs($admin)
            ->get(route('admin.orders.index', ['from' => $from, 'to' => $to]))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('T-NOW-1', $html);
        $this->assertStringContainsString('T-NOW-2', $html);
        $this->assertStringNotContainsString('T-OLD-1', $html);

        // range chara sob ashe
        $html2 = $this->actingAs($admin)->get(route('admin.orders.index'))->getContent();
        $this->assertStringContainsString('T-OLD-1', $html2);

        // summary: ei range e 2 ta order, 360 tk
        $this->assertStringContainsString('৳' . number_format(360), $html);
    }
}
