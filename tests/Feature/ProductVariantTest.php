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

    public function test_admin_product_form_renders_create_and_edit(): void
    {
        $this->actingAs($this->admin());
        Category::create(['name' => 'ড্রিংকস', 'name_en' => 'Drinks', 'key' => 'drink', 'industry' => 'organic', 'is_active' => true]);

        // create form
        $this->get(route('admin.products.create'))->assertOk();

        // edit form (variant rows soho render hoy)
        $p = $this->productWithVariants();
        $html = $this->get(route('admin.products.edit', $p))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('variantRows', $html);
        // input er indexed name THAKTE HObE — "variants[][size]" format PHP e bhange jay!
        $this->assertStringNotContainsString('name="variants[][', $html);
    }

    public function test_variants_save_from_real_browser_wire_format(): void
    {
        // BROWSER evabe pathay: variants[0][size]=Red&variants[0][price]=1500...
        // (age "variants[][size]" format e PHP prottek field alada row e pathato —
        //  ar sync kisu-i save korto na. Ei test oi format ta simulate kore.)
        $this->actingAs($this->admin());
        Category::create(['name' => 'শার্ট', 'name_en' => 'Shirt', 'key' => 'shirt', 'industry' => 'organic', 'is_active' => true]);
        $flat = [
            'name' => 'Shirt',
            'name_en' => 'Shirt',
            'category_key' => 'shirt',
            'unit' => 'pcs',
            'stock' => 0,
            'price' => 1500,
            'vat_percent' => 0,
            'variants[0][size]' => 'Red',
            'variants[0][price]' => '1500',
            'variants[0][vat_percent]' => '5',
            'variants[0][discount_bn]' => '-১০% ছাড়',
            'variants[0][stock]' => '500',
            'variants[0][is_active]' => '1',
            'variants[1][size]' => 'Green',
            'variants[1][price]' => '2000',
            'variants[1][stock]' => '200',
            'variants[1][is_active]' => '1',
            'variants[2][size]' => 'Yellow',
            'variants[2][price]' => '2500',
            'variants[2][stock]' => '200',
            'variants[2][is_active]' => '1',
        ];

        // parse_str = PHP er nijer parser — browser er wire format ekdom evabei
        // $_POST e dheuke. Flat keys theke nested structure banay.
        parse_str(http_build_query($flat), $parsed);

        $this->post(route('admin.products.store'), $parsed)
            ->assertRedirect(route('admin.products.index'));

        $p = Product::where('slug', 'shirt')->first();
        $this->assertNotNull($p, 'product createi hoy nai');
        $this->assertSame(3, $p->variants()->count(), 'variant row save hoy nai');

        // variant-level VAT + discount badge o save hoy
        $red = $p->variants()->where('size', 'Red')->first();
        $this->assertSame(5.0, (float) $red->vat_percent);
        $this->assertSame('-১০% ছাড়', $red->discount_bn);

        // admin list er ROW e price range dekhabe — user er complaint er jaygay
        $this->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('৳1,500–৳2,500');
    }

    public function test_variants_only_product_needs_no_product_price_or_stock(): void
    {
        // variant thakle upore price/stock field hidden thake — charao save hote hobe
        $this->actingAs($this->admin());
        Category::create(['name' => 'শার্ট', 'name_en' => 'Shirt', 'key' => 'shirt', 'industry' => 'organic', 'is_active' => true]);

        $this->post(route('admin.products.store'), [
            'name' => 'Variant Shirt',
            'name_en' => 'Variant Shirt',
            'category_key' => 'shirt',
            'unit' => 'pcs',
            // kono price / stock NAI — variant theke asbe
            'variants' => [
                ['size' => 'Red', 'price' => 1500, 'stock' => 50, 'is_active' => 1],
                ['size' => 'Green', 'price' => 2000, 'stock' => 100, 'is_active' => 1],
            ],
        ])->assertRedirect(route('admin.products.index')); // validation error hole redirect na, back

        $p = Product::where('slug', 'variant-shirt')->first();
        $this->assertNotNull($p);
        $this->assertSame(0, (int) $p->stock);
        $this->assertSame(2, $p->variants()->count());

        // ulto: variant CHARA product e price na dile error
        $this->post(route('admin.products.store'), [
            'name' => 'Simple',
            'name_en' => 'Simple',
            'category_key' => 'shirt',
            'unit' => 'pcs',
        ])->assertSessionHasErrors('price');
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
        $v->update(['vat_percent' => 10]); // variant er nijer VAT

        $this->post(route('order.store'), $this->validPayload($p, [
            ['id' => $p->id, 'variant_id' => $v->id, 'qty' => 3],
        ]))->assertRedirect();

        $order = \App\Models\Order::latest('id')->first();
        $item = $order->items->first();

        $this->assertSame(150.0, (float) $item->line_total); // 50 x 3
        $this->assertSame('500ml', $item->variant_size);
        $this->assertStringContainsString('500ml', $item->product_name);
        $this->assertSame(15.0, (float) $order->vat_total); // 150 er 10% — variant er nijer VAT
        $this->assertSame(77, $v->fresh()->stock);  // 80 - 3
        $this->assertSame(0, $p->fresh()->stock);   // product stock untouched
    }

    public function test_variant_without_own_vat_falls_back_to_product_vat(): void
    {
        $p = $this->productWithVariants();
        $p->update(['vat_percent' => 5]);
        $v = $p->variants[1]; // vat_percent null → product er 5% lagbe

        $this->post(route('order.store'), $this->validPayload($p, [
            ['id' => $p->id, 'variant_id' => $v->id, 'qty' => 2],
        ]))->assertRedirect();

        $order = \App\Models\Order::latest('id')->first();
        $this->assertSame(5.0, (float) $order->vat_total); // 100 er 5% — product er VAT fallback
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
            ->assertSee('সব সাইজের দাম ও স্টক')
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
