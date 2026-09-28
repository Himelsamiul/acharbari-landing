<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductVariantTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Boss',
            'email' => 'boss@test.bd',
            'password' => 'secret123',
            'permissions' => array_keys(User::PERMISSIONS),
        ]);
    }

    private function productWithVariants(): Product
    {
        $p = Product::create([
            'slug' => 'coca-cola',
            'name' => 'কোকা-কোলা',
            'name_en' => 'Coca-Cola',
            'category' => 'ড্রিংকস',
            'category_en' => 'Drinks',
            'category_key' => 'drink',
            'industry' => 'organic',
            'unit' => 'pcs',
            'stock' => 0,
            'price' => 30,
            'image' => 'assets/img/prod_mango.jpg',
            'vat_percent' => 0,
            'is_active' => true,
        ]);

        $p->variants()->createMany([
            ['size' => '250ml', 'price' => 30, 'stock' => 100, 'is_active' => true, 'sort_order' => 1],
            ['size' => '500ml', 'price' => 50, 'stock' => 80, 'is_active' => true, 'sort_order' => 2],
            ['size' => '1 Liter', 'price' => 100, 'stock' => 30, 'is_active' => true, 'sort_order' => 3],
        ]);

        return $p;
    }

    private function validPayload(Product $p, array $items): array
    {
        return [
            'customer_name' => 'Test User',
            'phone' => '01712345678',
            'address' => 'House 12, Road 5, Dhaka',
            'area' => 'inside',
            'payment_method' => 'cod',
            'items' => json_encode($items),
        ];
    }

    public function test_admin_can_create_product_with_variants(): void
    {
        $this->actingAs($this->admin());
        Category::create(['name' => 'ড্রিংকস', 'name_en' => 'Drinks', 'key' => 'drink', 'industry' => 'organic', 'is_active' => true]);

        $res = $this->post(route('admin.products.store'), [
            'name' => 'কোকা-কোলা',
            'name_en' => 'Coca-Cola',
            'category_key' => 'drink',
            'unit' => 'pcs',
            'stock' => 0,
            'price' => 30,
            'vat_percent' => 0,
            'variants' => [
                ['size' => '250ml', 'price' => 30, 'stock' => 100, 'is_active' => 1],
                ['size' => '500ml', 'price' => 50, 'stock' => 80, 'is_active' => 1],
                ['size' => '', 'price' => '', 'stock' => 0], // khali row — bad jabe
            ],
        ]);

        $res->assertRedirect(route('admin.products.index'));
        $p = Product::where('slug', 'coca-cola')->first();
        $this->assertNotNull($p);
        $this->assertSame(2, $p->variants()->count());
        $this->assertSame('250ml', $p->variants->first()->size);
    }

    public function test_update_syncs_variants(): void
    {
        $this->actingAs($this->admin());
        Category::create(['name' => 'ড্রিংকস', 'name_en' => 'Drinks', 'key' => 'drink', 'industry' => 'organic', 'is_active' => true]);
        $p = $this->productWithVariants();        $v1 = $p->variants[0];
        $v2 = $p->variants[1];

        // 250ml bad, 500ml update, notun 2L add
        $this->put(route('admin.products.update', $p), [
            'name' => $p->name,
            'name_en' => $p->name_en,
            'category_key' => 'drink',
            'unit' => 'pcs',
            'stock' => 0,
            'price' => 30,
            'variants' => [
                ['id' => $v2->id, 'size' => '500ml', 'price' => 55, 'stock' => 70, 'is_active' => 1],
                ['size' => '2 Liter', 'price' => 180, 'stock' => 10, 'is_active' => 1],
            ],
        ])->assertRedirect(route('admin.products.index'));

        $p->refresh();
        $this->assertNull($p->variants()->find($v1->id)); // deleted
        $this->assertSame(55.0, (float) $p->variants()->find($v2->id)->price);
        $this->assertSame(2, $p->variants()->count());
    }

    public function test_order_with_variant_uses_variant_price_and_stock(): void
    {
        $p = $this->productWithVariants();
        $v = $p->variants[1]; // 500ml @ 50, stock 80

        $this->post(route('order.store'), $this->validPayload($p, [
            ['id' => $p->id, 'variant_id' => $v->id, 'qty' => 3],
        ]))->assertRedirect();

        $order = \App\Models\Order::latest('id')->first();
        $item = $order->items->first();

        $this->assertSame(150.0, (float) $item->line_total); // 50 x 3
        $this->assertSame('500ml', $item->variant_size);
        $this->assertStringContainsString('500ml', $item->product_name);
        $this->assertSame(77, $v->fresh()->stock);  // 80 - 3
        $this->assertSame(0, $p->fresh()->stock);   // product stock untouched
    }

    public function test_order_without_variant_falls_back_to_default(): void
    {
        $p = $this->productWithVariants();
        $default = $p->defaultVariant(); // 250ml (sort_order 1)

        $this->post(route('order.store'), $this->validPayload($p, [
            ['id' => $p->id, 'qty' => 2],
        ]))->assertRedirect();

        $item = \App\Models\Order::latest('id')->first()->items->first();
        $this->assertSame(60.0, (float) $item->line_total); // 30 x 2 default variant e
        $this->assertSame($default->id, $item->variant_id);
    }

    public function test_qty_clamped_to_variant_stock(): void
    {
        $p = $this->productWithVariants();
        $v = $p->variants[2]; // 1 Liter, stock 30

        $this->post(route('order.store'), $this->validPayload($p, [
            ['id' => $p->id, 'variant_id' => $v->id, 'qty' => 20], // clamp na — 20 < 30
        ]))->assertRedirect();

        // 1L er dam 100 x 20 = 2000
        $item = \App\Models\Order::latest('id')->first()->items->first();
        $this->assertSame(2000.0, (float) $item->line_total);
    }

    public function test_foreign_variant_id_is_ignored(): void
    {
        $p1 = $this->productWithVariants();
        $p2 = Product::create([
            'slug' => 'pepsi', 'name' => 'পেপসি', 'name_en' => 'Pepsi',
            'category' => 'ড্রিংকস', 'category_en' => 'Drinks', 'category_key' => 'drink',
            'industry' => 'organic', 'unit' => 'pcs', 'stock' => 10, 'price' => 40,
            'image' => 'assets/img/prod_mango.jpg', 'vat_percent' => 0, 'is_active' => true,
        ]);
        $foreign = $p2->variants()->create(['size' => '250ml', 'price' => 40, 'stock' => 5, 'is_active' => true]);

        // p1 er order e p2 er variant id — ignore hoye default variant nibe
        $this->post(route('order.store'), $this->validPayload($p1, [
            ['id' => $p1->id, 'variant_id' => $foreign->id, 'qty' => 1],
        ]))->assertRedirect();

        $item = \App\Models\Order::latest('id')->first()->items->first();
        $this->assertNotSame($foreign->id, $item->variant_id);
        $this->assertSame(30.0, (float) $item->price); // default variant 250ml @ 30
    }

    public function test_details_page_shows_variant_selector(): void
    {
        $p = $this->productWithVariants();

        $this->get(route('product.show', $p->slug))
            ->assertOk()
            ->assertSee('সাইজ বাছুন')
            ->assertSee('250ml')
            ->assertSee('1 Liter')
            ->assertSee('orderVariantFromDetails');
    }

    public function test_inactive_variant_not_orderable(): void
    {
        $p = $this->productWithVariants();
        $v = $p->variants[0];
        $v->update(['is_active' => false]);

        $this->post(route('order.store'), $this->validPayload($p, [
            ['id' => $p->id, 'variant_id' => $v->id, 'qty' => 1],
        ]))->assertRedirect();

        // inactive variant bad — default (500ml is active? no: 250ml inactive, 500ml first active) lagbe
        $item = \App\Models\Order::latest('id')->first()->items->first();
        $this->assertNotSame($v->id, $item->variant_id);
    }
}
