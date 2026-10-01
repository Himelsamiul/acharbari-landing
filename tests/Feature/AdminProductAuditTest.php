<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductAuditTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): self
    {
        $user = User::firstOrCreate(
            ['email' => 'admin-products@example.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('secret123'),
                'permissions' => array_keys(User::PERMISSIONS),
            ]
        );

        return $this->actingAs($user);
    }

    private function seedCategory(): void
    {
        \App\Models\Category::create(['key' => 'pickle', 'name' => 'আচার', 'name_en' => 'Pickles', 'is_active' => true]);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Audit Achar', 'name_en' => 'Audit Achar',
            'category_key' => 'pickle', 'unit' => 'pcs',
            'stock' => 5, 'price' => 100, 'is_active' => '1',
        ], $overrides);
    }

    public function test_auto_barcodes_stay_unique_even_with_manual_ones(): void
    {
        $this->actingAsAdmin();
        $this->seedCategory();

        // admin nije ekta "future" barcode bosiye rakhlo — purano logic 500 korto
        Product::create([
            'slug' => 'manual-bc', 'name' => 'Manual BC', 'name_en' => 'Manual BC',
            'category' => 'x', 'category_en' => 'x', 'category_key' => 'pickle',
            'industry' => 'organic', 'unit' => 'pcs', 'stock' => 1, 'price' => 10,
            'barcode' => 'ABP-0002', 'image' => 'assets/img/prod_mango.jpg', 'is_active' => true,
        ]);

        $this->post(route('admin.products.store'), $this->payload())->assertRedirect();

        $new = Product::latest('id')->first();
        $this->assertStringStartsWith('ABP-', $new->barcode);
        // duita product er barcode kokhono same na
        $this->assertNotSame('ABP-0002', $new->barcode);
        $this->assertSame(2, Product::count());
    }

    public function test_destroy_removes_uploaded_image_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/old.jpg', 'imagedata');

        $this->actingAsAdmin();
        $product = Product::create([
            'slug' => 'img-del', 'name' => 'ImgDel', 'name_en' => 'ImgDel',
            'category' => 'x', 'category_en' => 'x', 'category_key' => 'pickle',
            'industry' => 'organic', 'unit' => 'pcs', 'stock' => 1, 'price' => 10,
            'barcode' => 'ABP-9001', 'image' => 'storage/products/old.jpg', 'is_active' => true,
        ]);

        $this->delete(route('admin.products.destroy', $product))->assertRedirect();

        $this->assertNull(Product::find($product->id));
        Storage::disk('public')->assertMissing('products/old.jpg');
    }

    public function test_updating_image_replaces_old_uploaded_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/old.jpg', 'olddata');

        $this->actingAsAdmin();
        $this->seedCategory();
        $product = Product::create([
            'slug' => 'img-replace', 'name' => 'ImgRep', 'name_en' => 'ImgRep',
            'category' => 'x', 'category_en' => 'x', 'category_key' => 'pickle',
            'industry' => 'organic', 'unit' => 'pcs', 'stock' => 1, 'price' => 10,
            'barcode' => 'ABP-9002', 'image' => 'storage/products/old.jpg', 'is_active' => true,
        ]);

        // notun image upload — update route PUT e chole
        $this->put(route('admin.products.update', $product), $this->payload([
            'image' => \Illuminate\Http\Testing\File::fake()->image('new.jpg'),
        ]))->assertRedirect();

        Storage::disk('public')->assertMissing('products/old.jpg');
        $product->refresh();
        $this->assertStringStartsWith('storage/products/', $product->image);
        $this->assertNotSame('storage/products/old.jpg', $product->image);
    }
}
