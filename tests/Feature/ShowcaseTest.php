<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\IndustryPack;
use App\Http\Controllers\Admin\ThemeLibrary;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Services\ShowcaseSync;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowcaseTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::create([
            'name' => 'Platform Owner', 'email' => 'owner@test.bd', 'password' => 'secret123',
            'role' => User::ROLE_SUPER_ADMIN, 'is_active' => true,
        ]);
    }

    private function storeAdmin(): User
    {
        return User::create([
            'name' => 'Store Admin', 'email' => 'store@test.bd', 'password' => 'secret123',
            'role' => User::ROLE_ADMIN, 'is_active' => true,
            'permissions' => [
                'orders' => ['*'],
                'customers' => ['*'],
                'dashboard' => ['*'],
            ],
        ]);
    }

    private function orderPayload(int $productId, array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Showcase Buyer',
            'phone' => '01712345678',
            'address' => 'House 12, Road 5, Dhaka',
            'area' => 'inside',
            'payment_method' => 'cod',
            'items' => json_encode([['id' => $productId, 'qty' => 1]]),
        ], $overrides);
    }

    /* ================= Showcase gallery ================= */

    public function test_showcase_gallery_renders_all_ten_designs_with_prices(): void
    {
        $res = $this->get(route('showcase.index'))->assertOk();

        foreach (IndustryPack::all() as $key => $pack) {
            $res->assertSee($pack['name_bn'])->assertSee($pack['name_en']);
            $res->assertSee('/showcase/' . $key); // live-demo link
            // oi design er demo admin credential card e dekhabe
            $res->assertSee(\App\Services\ShowcaseSync::demoAdminEmail($key));
        }

        // pack price (৯,৯৯০ via bn_num) + the landing-design product row price
        $res->assertSee('৳ ' . bn_num(number_format(9990)));
        $this->assertSame(10, substr_count($res->getContent(), 'sc-card-cover'));
    }

    public function test_sync_creates_a_full_access_demo_admin_per_genre(): void
    {
        (new ShowcaseSync)->run();

        foreach (IndustryPack::keys() as $genre) {
            $u = User::where('email', \App\Services\ShowcaseSync::demoAdminEmail($genre))->first();
            $this->assertNotNull($u, "demo admin for {$genre}");
            $this->assertSame(User::ROLE_ADMIN, $u->role);
            $this->assertTrue((bool) $u->is_active);
            // full module access — demo visitor can see/try everything
            $this->assertContains('*', $u->permissions['orders'] ?? []);
            $this->assertTrue(\Illuminate\Support\Facades\Hash::check(\App\Services\ShowcaseSync::DEMO_ADMIN_PASSWORD, $u->password));

            // credential diye asol admin panel e login o kaj kore
            $this->post(route('admin.login.attempt'), [
                'email' => $u->email,
                'password' => \App\Services\ShowcaseSync::DEMO_ADMIN_PASSWORD,
            ])->assertRedirect(route('admin.dashboard'));
            $this->post(route('admin.logout'));
        }
    }

    /* ================= Genre demo pages ================= */

    public function test_each_genre_demo_renders_with_its_theme_and_copy(): void
    {
        foreach (IndustryPack::keys() as $genre) {
            $pack = IndustryPack::all()[$genre];
            $theme = ThemeLibrary::get($pack['theme']);

            $res = $this->get(route('showcase.demo', $genre))->assertOk();

            // per-request genre theme tokens (store theme is irrelevant)
            $res->assertSee('--ds-primary: ' . $theme['primary']);
            // pack copy + fictional demo brand — never the store's settings
            $res->assertSee($pack['content']['hero_s1_main'][0]);
            $res->assertSee($pack['brand_bn']);
            $res->assertSee($pack['name_bn']);
        }
    }

    public function test_unknown_genre_demo_is_404(): void
    {
        $this->get(route('showcase.demo', 'crypto'))->assertNotFound();
    }

    /* ================= Sync ================= */

    public function test_sync_creates_demo_products_and_landing_rows_idempotently(): void
    {
        (new ShowcaseSync)->run();
        (new ShowcaseSync)->run(); // idempotent

        foreach (IndustryPack::keys() as $genre) {
            $slugs = array_column(IndustryPack::products($genre), 'slug');

            $this->assertSame(6, Product::whereIn('slug', $slugs)->count(), "genre {$genre} demo products");

            $lp = Product::where('slug', 'lp-' . $genre)->first();
            $this->assertNotNull($lp, "lp-{$genre} row exists");
            $this->assertSame('showcase', $lp->industry);
            $this->assertEquals(9990, $lp->price);
            $this->assertSame(0, $lp->stock); // unlimited per the clamp logic
            $this->assertTrue($lp->is_active);
        }

        // 6 demo rows per genre + 1 landing-design row each, no more no less
        $this->assertSame(70, Product::count());
    }

    /* ================= Order routing: landing → super admin ================= */

    public function test_landing_design_order_lands_in_super_panel_only(): void
    {
        (new ShowcaseSync)->run();
        $super = $this->superAdmin();
        $admin = $this->storeAdmin();

        $lp = Product::where('slug', 'lp-fashion')->first();
        $this->post(route('order.store'), $this->orderPayload($lp->id))
            ->assertRedirect(route('order.success', Order::latest('id')->first()->order_code));

        $order = Order::latest('id')->first();
        $this->assertSame(Order::SOURCE_LANDING, $order->source);
        $this->assertEquals(9990, $order->subtotal); // re-priced from the DB row
        $this->assertSame('ল্যান্ডিং পেজ — ' . IndustryPack::all()['fashion']['name_bn'], $order->items->first()->product_name);

        // admin bell stays silent for landing orders
        $this->assertSame(0, OrderNotification::where('order_id', $order->id)->count());

        // super panel: listed + visible
        $this->actingAs($super)->get(route('super.orders.index'))
            ->assertOk()->assertSee($order->order_code);
        $this->actingAs($super)->get(route('super.orders.show', $order))->assertOk();

        // client admin panel: orders index/show, dashboard, customers — all blind to it
        // (before the super status update, whose flash message names the order code)
        $this->actingAs($admin)->get(route('admin.orders.index'))->assertOk()->assertDontSee($order->order_code);
        $this->actingAs($admin)->get(route('admin.orders.show', $order))->assertNotFound();
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertDontSee($order->order_code);
        $this->actingAs($admin)->get(route('admin.customers'))->assertOk()->assertDontSee('01712345678');

        // super status action works on landing orders
        $this->actingAs($super)->post(route('super.orders.status', $order), ['status' => 'processing'])
            ->assertRedirect();
        $this->assertSame('processing', $order->fresh()->status);
    }

    /* ================= Order routing: demo product → admin ================= */

    public function test_demo_product_order_stays_in_admin_panel_with_stock_decrement(): void
    {
        (new ShowcaseSync)->run();
        $super = $this->superAdmin();
        $admin = $this->storeAdmin();

        // fashion demo product — NOT the active industry (default organic)
        $demo = Product::where('slug', 'demo-fashion-1')->first();
        $this->assertNotNull($demo);
        $this->assertSame('fashion', $demo->industry);
        $stockBefore = $demo->stock;

        $this->post(route('order.store'), $this->orderPayload($demo->id))->assertRedirect();

        $order = Order::latest('id')->first();
        $this->assertSame(Order::SOURCE_STORE, $order->source);
        $this->assertSame($stockBefore - 1, $demo->fresh()->stock); // normal stock flow

        // admin bell rings for store orders
        $this->assertSame(1, OrderNotification::where('order_id', $order->id)->count());

        // client admin panel owns it
        $this->actingAs($admin)->get(route('admin.orders.index'))
            ->assertOk()->assertSee($order->order_code);
        $this->actingAs($admin)->get(route('admin.orders.show', $order))->assertOk();

        // super landing panel never sees store orders
        $this->actingAs($super)->get(route('super.orders.index'))
            ->assertOk()->assertDontSee($order->order_code);
        $this->actingAs($super)->get(route('super.orders.show', $order))->assertNotFound();
    }

    /* ================= Genre-bound demo admin panel ================= */

    public function test_bound_demo_admin_logs_into_their_genres_panel(): void
    {
        (new ShowcaseSync)->run();

        // fashion card er link: login page e email prefilled (known demo email only)
        $this->get(route('admin.login', ['email' => \App\Services\ShowcaseSync::demoAdminEmail('fashion')]))
            ->assertOk()->assertSee('value="demo.fashion@khorak.shop"', false);
        $this->get(route('admin.login', ['email' => 'random@x.com']))
            ->assertOk()->assertDontSee('value="random@x.com"', false);

        $fashionAdmin = User::where('email', \App\Services\ShowcaseSync::demoAdminEmail('fashion'))->first();
        $this->assertSame('fashion', $fashionAdmin->industry);

        // guests keep the global store (checked BEFORE actingAs — actingAs sticks)
        $this->get('/')->assertOk()->assertDontSee(IndustryPack::all()['fashion']['brand_bn']);
        $super = $this->superAdmin();
        $this->actingAs($super)->get(route('admin.dashboard'))->assertOk()
            ->assertDontSee(IndustryPack::all()['fashion']['brand_bn']);

        // dashboard renders as the fashion store (brand via sandbox overlay;
        // the admin chrome itself stays theme-neutral by design)
        $html = $this->actingAs($fashionAdmin)->get(route('admin.dashboard'))
            ->assertOk()->getContent();
        $this->assertStringContainsString(IndustryPack::all()['fashion']['brand_bn'], $html);

        // product catalogue scoped to fashion only
        $this->actingAs($fashionAdmin)->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('প্রিমিয়াম এমব্রয়ডারি পাঞ্জাবি')
            ->assertDontSee('কাচ্চি বিরিয়ানি');

        // the logged-in admin's own landing view is their genre's
        $home = $this->actingAs($fashionAdmin)->get('/')->assertOk()->getContent();
        $this->assertStringContainsString(IndustryPack::all()['fashion']['content']['hero_s1_main'][0], $home);
        $this->assertStringContainsString('--ds-primary: ' . ThemeLibrary::get('fashion')['primary'], $home);
    }

    public function test_bound_admin_settings_writes_are_sandboxed_away_from_the_real_store(): void
    {
        (new ShowcaseSync)->run();
        $fashionAdmin = User::where('email', \App\Services\ShowcaseSync::demoAdminEmail('fashion'))->first();
        $travelAdmin = User::where('email', \App\Services\ShowcaseSync::demoAdminEmail('travel'))->first();

        $settingsBefore = Setting::all()->pluck('value', 'key')->all();
        $homeBefore = preg_replace('/csrf-token" content="[^"]+"/', 'csrf', $this->get('/')->getContent());

        // demo admin "optimizes" the theme + hero copy — panel save flow
        // (theme save contract: theme_id + theme_json, like the theme page)
        $this->actingAs($fashionAdmin)->post(route('admin.settings.theme.save'), [
            'theme_id' => 'jamun',
            'theme_json' => json_encode(ThemeLibrary::get('jamun')),
        ])->assertRedirect();

        $fashionAdmin = $fashionAdmin->fresh();
        $blob = json_decode((string) $fashionAdmin->demo_settings, true);
        $this->assertSame('jamun', $blob['theme_id'] ?? null, 'sandbox blob carries the edit');

        // real store untouched: settings table row-for-row (guest home is
        // derived from settings + products, both untouched — snapshot is the
        // proof; a mid-test guest fetch would still be actingAs'd, so we
        // verify via the DB + the other demo admin's view instead)
        $this->assertSame($settingsBefore, Setting::all()->pluck('value', 'key')->all());

        // other demo admins unaffected — travel still renders travel
        $travelHome = $this->actingAs($travelAdmin)->get('/')->assertOk()->getContent();
        $this->assertStringContainsString('--ds-primary: ' . ThemeLibrary::get('travel')['primary'], $travelHome);
        $this->assertStringNotContainsString('--ds-primary: ' . ThemeLibrary::get('jamun')['primary'], $travelHome);

        // fashion admin er nijer view e sandbox edit live
        $fashionHome = $this->actingAs($fashionAdmin->fresh())->get('/')->assertOk()->getContent();
        $this->assertStringContainsString('--ds-primary: ' . ThemeLibrary::get('jamun')['primary'], $fashionHome);

        // reset command restores pack defaults
        $this->artisan('showcase:reset', ['genre' => 'fashion']);
        $this->assertNull($fashionAdmin->fresh()->demo_settings);
        $this->assertStringContainsString(
            '--ds-primary: ' . ThemeLibrary::get('fashion')['primary'],
            $this->actingAs($fashionAdmin->fresh())->get('/')->assertOk()->getContent()
        );
    }

    /* ================= Store independence ================= */

    public function test_visiting_showcase_and_demo_pages_changes_no_settings_and_no_home_render(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $settingsBefore = Setting::all()->pluck('value', 'key')->all();
        $homeBefore = preg_replace('/csrf-token" content="[^"]+"/', 'csrf', $this->get('/')->getContent());

        $this->get(route('showcase.index'))->assertOk();
        $this->get(route('showcase.demo', 'travel'))->assertOk();
        $this->get(route('showcase.demo', 'organic'))->assertOk();

        $settingsAfter = Setting::all()->pluck('value', 'key')->all();
        $homeAfter = preg_replace('/csrf-token" content="[^"]+"/', 'csrf', $this->get('/')->getContent());

        $this->assertSame($settingsBefore, $settingsAfter);
        $this->assertSame($homeBefore, $homeAfter);
    }

    public function test_demo_page_shows_products_even_after_clear_industry_deactivated_them(): void
    {
        // clearIndustry() deactivates ALL demo-* rows — the demo pages must
        // still sell them (sync re-activates), while the storefront keeps
        // hiding non-active genres via the industry scope
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        Product::where('slug', 'like', 'demo-%')->update(['is_active' => false]);

        $this->get(route('showcase.demo', 'travel'))->assertOk()
            ->assertSee('কক্সবাজার ৩দিন ২রাত');

        $this->assertTrue((bool) Product::where('slug', 'demo-travel-1')->first()->is_active);

        // storefront stays blind to them (default active industry = organic)
        $this->get('/')->assertOk()->assertDontSee('কক্সবাজার ৩দিন ২রাত');
    }

    public function test_showcase_rows_never_appear_on_the_storefront(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        (new ShowcaseSync)->run();

        foreach (['/', '/products'] as $url) {
            $html = $this->get($url)->assertOk()->getContent();

            // landing-design rows are invisible everywhere on the storefront
            $this->assertStringNotContainsString('ল্যান্ডিং পেজ —', $html);
            $this->assertStringNotContainsString('Landing Page — ', $html);

            // non-active genres' demo products stay hidden (default active = organic)
            foreach (['fashion' => 'প্রিমিয়াম এমব্রয়ডারি পাঞ্জাবি', 'travel' => 'কক্সবাজার ৩দিন ২রাত'] as $genre => $name) {
                $this->assertStringNotContainsString($name, $html, "{$genre} demo product leaked onto {$url}");
            }
        }
    }
}
