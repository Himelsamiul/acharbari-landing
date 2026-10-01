<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Redirect;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Puro admin sidebar — prottekta page render test (500/blade bug dhora).
 * Full-permission admin (admin@khorak.shop) diye — jate Debug panel-o dhake.
 */
class AdminSidebarSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsSuperAdmin(): self
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@khorak.shop'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('secret123'),
                'permissions' => array_keys(User::PERMISSIONS),
            ]
        );

        return $this->actingAs($user);
    }

    private function seedData(): array
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        // nijer product (seeder product e industry field nai — forIndustry filter e pore na)
        $product = Product::create([
            'slug' => 'smoke-achar', 'name' => 'Smoke Achar', 'name_en' => 'Smoke Achar',
            'category' => 'আচার', 'category_en' => 'Pickles', 'category_key' => 'pickle',
            'industry' => 'organic', 'brand' => 'আচারবাড়ি', 'unit' => 'pcs', 'stock' => 10,
            'barcode' => 'ABP-7777', 'price' => 150, 'old_price' => 200,
            'image' => 'assets/img/prod_mango.jpg', 'sort_order' => 1, 'vat_percent' => 0,
            'is_active' => true,
        ]);

        // ekta order (checkout flow diye — items/relations soho)
        $this->post(route('order.store'), [
            'customer_name' => 'Smoke User', 'phone' => '01700000007', 'address' => 'Dhaka',
            'area' => 'inside', 'payment_method' => 'cod',
            'items' => json_encode([['id' => $product->id, 'qty' => 1]]),
        ])->assertRedirect();
        $order = Order::latest('id')->first();

        $supplier = Supplier::create(['name' => 'Smoke Supplier', 'phone' => '01900000000', 'is_active' => true]);
        Coupon::create(['code' => 'SMOKE10', 'percent' => 10, 'is_active' => true]);
        Complaint::create(['name' => 'Smoke Complainer', 'phone' => '01700000008', 'description' => 'test']);
        Redirect::create(['from_path' => 'old-page', 'to_url' => 'https://khorak.shop', 'status_code' => 301, 'is_active' => true]);

        return ['product' => $product, 'order' => $order, 'supplier' => $supplier];
    }

    public function test_every_admin_sidebar_page_renders(): void
    {
        $this->actingAsSuperAdmin();
        ['product' => $product, 'order' => $order, 'supplier' => $supplier] = $this->seedData();

        $pages = [
            // dashboard + orders
            route('admin.dashboard'),
            route('admin.orders.index'),
            route('admin.orders.show', $order),
            // landing content group
            route('admin.settings.content'),
            route('admin.settings.sections'),
            route('admin.settings.brand'),
            route('admin.settings.theme'),
            // seo group
            route('admin.seo'),
            route('admin.robots'),
            route('admin.sitemap'),
            route('admin.redirects.index'),
            route('admin.settings.tracking'),
            // payment + pathao + delivery
            route('admin.settings.payment'),
            route('admin.settings.pathao'),
            route('admin.settings.delivery'),
            // products + taxonomy
            route('admin.products.index'),
            route('admin.products.create'),
            route('admin.products.show', $product),
            route('admin.products.edit', $product),
            route('admin.taxonomy'),
            // ops pages
            route('admin.customers'),
            route('admin.customers.export', ['type' => 'csv']),
            route('admin.customers.export', ['type' => 'pdf']),
            route('admin.suppliers'),
            route('admin.suppliers.show', $supplier),
            route('admin.suppliers.edit', $supplier),
            route('admin.coupons'),
            route('admin.reviews'),
            route('admin.complaints'),
            route('admin.module', 'coupons'),
            route('admin.admins.index'),
            route('admin.account'),
            // debug — super admin email e 200
            route('admin.debug'),
        ];

        foreach ($pages as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_debug_panel_hidden_from_other_admins(): void
    {
        // onno kono admin — Debug na sidebar e, na route e
        $user = User::firstOrCreate(
            ['email' => 'other-admin@example.com'],
            [
                'name' => 'Other Admin',
                'password' => bcrypt('secret123'),
                'permissions' => array_keys(User::PERMISSIONS),
            ]
        );

        $this->actingAs($user)->get(route('admin.debug'))->assertNotFound();
    }
}
