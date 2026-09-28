<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_pdf_and_csv_export_download(): void
    {
        $admin = User::create([
            'name' => 'Boss', 'email' => 'boss@test.bd', 'password' => 'secret123',
            'permissions' => array_keys(User::PERMISSIONS),
        ]);

        $prod = \App\Models\Product::create([
            'slug' => 'test-rice', 'name' => 'কালো চাল', 'name_en' => 'Black Rice',
            'category' => 'চাল', 'category_en' => 'Rice', 'category_key' => 'rice',
            'industry' => 'organic', 'unit' => 'kg', 'stock' => 10, 'price' => 336,
            'image' => 'assets/img/prod_mango.jpg', 'vat_percent' => 0, 'is_active' => true,
        ]);
        $o = Order::create([
            'order_code' => 'T-EXP-1', 'customer_name' => 'Samuil Alam Himel', 'phone' => '01581102625',
            'address' => 'x', 'area' => 'inside', 'payment_method' => 'cod',
            'subtotal' => 336, 'discount' => 0, 'vat_total' => 0, 'shipping_cost' => 80,
            'total' => 416, 'status' => 'pending',
        ]);
        $o->items()->create(['product_id' => $prod->id, 'product_name' => 'কালো চাল', 'price' => 336, 'quantity' => 1, 'line_total' => 336]);

        // CSV
        $res = $this->actingAs($admin)->get(route('admin.customers.export', ['type' => 'csv']));
        $res->assertOk();
        $this->assertStringContainsString('T-EXP-1', $res->streamedContent());

        // PDF (dompdf render — font soho)
        $res2 = $this->actingAs($admin)->get(route('admin.customers.export', ['type' => 'pdf']));
        $res2->assertOk();
        $this->assertStringStartsWith('%PDF', $res2->getContent());

        // date filter: bhitore na hole khali report er error
        $this->actingAs($admin)
            ->get(route('admin.customers.export', ['type' => 'csv', 'from' => '2020-01-01', 'to' => '2020-01-02']))
            ->assertSessionHasErrors('report');
    }
}
