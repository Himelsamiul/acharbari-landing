<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    /* ================= helpers ================= */

    private function superAdmin(): User
    {
        return User::factory()->superAdmin()->create(['password' => Hash::make('password')])->refresh();
    }

    private function admin(array $permissions = []): User
    {
        return User::factory()->admin($permissions)->create(['password' => Hash::make('password')])->refresh();
    }

    private function customer(array $attributes = []): User
    {
        return User::factory()->customer(array_merge(['password' => Hash::make('password')], $attributes))->create()->refresh();
    }

    /* ================= role firewall ================= */

    public function test_super_admin_can_access_everything(): void
    {
        $super = $this->superAdmin();

        $this->actingAs($super)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($super)->get(route('admin.orders.index'))->assertOk();
        $this->actingAs($super)->get(route('admin.coupons'))->assertOk();
        $this->actingAs($super)->get(route('admin.products.index'))->assertOk();
        $this->actingAs($super)->get(route('super.overview'))->assertOk();
        $this->actingAs($super)->get(route('super.admins.index'))->assertOk();
    }

    public function test_admin_without_permissions_sees_dashboard_but_nothing_else(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.orders.index'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.coupons'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.products.index'))->assertForbidden();
    }

    public function test_admin_with_orders_view_only_sees_orders_but_not_coupons(): void
    {
        $admin = $this->admin(['orders' => ['view']]);

        $this->actingAs($admin)->get(route('admin.orders.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.coupons'))->assertForbidden();
    }

    public function test_customer_is_rejected_everywhere_on_admin(): void
    {
        $customer = $this->customer();

        $this->actingAs($customer)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($customer)->get(route('admin.orders.index'))->assertForbidden();
        $this->actingAs($customer)->get(route('admin.coupons'))->assertForbidden();
        $this->actingAs($customer)->get(route('super.overview'))->assertForbidden();
    }

    public function test_super_area_rejects_plain_admin(): void
    {
        $admin = $this->admin(['orders' => '*']);

        $this->actingAs($admin)->get(route('super.overview'))->assertForbidden();
        $this->actingAs($admin)->get(route('super.admins.index'))->assertForbidden();
    }

    /* ================= guest redirects ================= */

    public function test_guests_on_admin_urls_are_sent_to_admin_login(): void
    {
        $this->get(route('admin.orders.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_guests_on_account_urls_are_sent_to_storefront_login(): void
    {
        $this->get(route('account'))->assertRedirect(route('login'));
        $this->get(route('account.orders'))->assertRedirect(route('login'));
    }

    /* ================= 403 page is Bengali ================= */

    public function test_forbidden_renders_bengali_error_page(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->get(route('admin.coupons'));

        $response->assertForbidden();
        $response->assertSee('অনুমতি নেই', false);
    }

    /* ================= login flows ================= */

    public function test_customer_is_rejected_at_admin_login(): void
    {
        $customer = $this->customer(['email' => 'cust@example.com']);

        $response = $this->post(route('admin.login.attempt'), [
            'email' => $customer->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
        // the error is the Bengali "admins only" message
        $errors = session('errors')->getBag('default')->all();
        $this->assertStringContainsString('শুধু অ্যাডমিনদের জন্য', (string) $errors[0]);
    }

    public function test_admin_can_login_at_admin_login(): void
    {
        $admin = $this->admin(['orders' => ['view']]);

        $response = $this->post(route('admin.login.attempt'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_super_admin_lands_in_super_overview_after_admin_login(): void
    {
        $super = $this->superAdmin();

        $response = $this->post(route('admin.login.attempt'), [
            'email' => $super->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($super);
        $response->assertRedirect(route('super.overview'));
    }

    public function test_customer_can_register_and_login_with_phone(): void
    {
        $this->post(route('register.attempt'), [
            'name' => 'কামরুল হাসান',
            'phone' => '01712345678',
            'email' => null,
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $user = User::where('phone', '01712345678')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->isCustomer());
        $this->assertNull($user->email);

        // phone login on the storefront
        $this->post(route('logout')); // clear the auto-login from registration
        $this->post(route('login.attempt'), [
            'login' => '01712345678',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->get(route('account'))->assertOk();
    }

    public function test_customer_can_login_with_email(): void
    {
        $customer = $this->customer(['email' => 'cust@example.com']);

        $this->post(route('login.attempt'), [
            'login' => 'cust@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($customer);
    }

    /* ================= permission matrix on a real action ================= */

    public function test_order_status_update_follows_the_matrix(): void
    {
        $order = Order::create([
            'order_code' => 'AB-TEST01',
            'customer_name' => 'টেস্ট গ্রাহক',
            'phone' => '01712345678',
            'address' => 'ঢাকা',
            'area' => 'inside',
            'payment_method' => 'cod',
            'total' => 500,
            'status' => 'pending',
        ]);

        $admin = $this->admin(['orders' => ['status_update']]);

        // granted → status change works
        $this->actingAs($admin)
            ->post(route('admin.orders.status', $order), ['status' => 'processing'])
            ->assertRedirect();
        $this->assertEquals('processing', $order->fresh()->status);

        // revoked → blocked
        $admin->permissions = ['orders' => ['view']];
        $admin->save();

        $this->actingAs($admin)
            ->post(route('admin.orders.status', $order), ['status' => 'shipped'])
            ->assertForbidden();
        $this->assertEquals('processing', $order->fresh()->status);
    }

    public function test_super_panel_can_create_scoped_admin(): void
    {
        $super = $this->superAdmin();

        $this->actingAs($super)->post(route('super.admins.store'), [
            'name' => 'ক্লায়েন্ট অ্যাডমিন',
            'email' => 'client@example.com',
            'password' => 'secret123',
            'preset' => 'orders_only',
        ])->assertRedirect();

        $client = User::where('email', 'client@example.com')->first();
        $this->assertNotNull($client);
        $this->assertTrue($client->isAdmin());
        $this->assertEquals(['view', 'status_update'], $client->permissions['orders']);
        $this->assertFalse($client->hasPermission('coupons.view'));
        $this->assertTrue($client->hasPermission('orders.view'));
    }

    public function test_permission_matrix_page_renders_and_saves(): void
    {
        $super = $this->superAdmin();
        $client = $this->admin();

        // edit page renders the matrix (all modules × features + presets)
        $this->actingAs($super)->get(route('super.admins.edit', $client))
            ->assertOk()
            ->assertSee('অনুমতি ম্যাট্রিক্স', false)
            ->assertSee('স্টোর ম্যানেজার', false);

        // grant ONLY orders.view + products.view via the matrix form
        $this->actingAs($super)->put(route('super.admins.update', $client), [
            'name' => $client->name,
            'email' => $client->email,
            'permissions' => [
                'orders' => ['view'],
                'products' => ['view'],
            ],
        ])->assertRedirect(route('super.admins.index'));

        $client->refresh();
        $this->assertEquals(['view'], $client->permissions['orders']);
        $this->assertTrue($client->hasPermission('products.view'));
        $this->assertFalse($client->hasPermission('products.delete'));

        // unknown modules/features are stripped by the whitelist
        $this->actingAs($super)->put(route('super.admins.update', $client), [
            'name' => $client->name,
            'email' => $client->email,
            'permissions' => [
                'orders' => ['view', 'made_up_feature'],
                'not_a_module' => ['view'],
            ],
        ])->assertRedirect(route('super.admins.index'));

        $client->refresh();
        $this->assertEquals(['view'], $client->permissions['orders']);
        $this->assertArrayNotHasKey('not_a_module', $client->permissions);
    }

    public function test_super_admin_cannot_delete_self(): void
    {
        $super = $this->superAdmin();

        $this->actingAs($super)->delete(route('super.admins.destroy', $super))
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('users', ['id' => $super->id]);
    }

    public function test_inactive_admin_is_logged_out(): void
    {
        $admin = $this->admin(['orders' => ['view']]);
        $admin->is_active = false;
        $admin->save();

        $response = $this->actingAs($admin)->get(route('admin.orders.index'));

        $this->assertGuest();
        $response->assertRedirect(route('admin.login'));
    }

    /* ================= theme: feature-granular reference module ================= */

    public function test_theme_feature_scoping(): void
    {
        // fonts (and view) only — every other theme card/action stays closed
        $admin = $this->admin(['theme' => ['view', 'fonts']]);

        $this->actingAs($admin)->get(route('admin.settings.theme'))
            ->assertOk()
            ->assertSee('হেডিং ফন্ট', false)
            ->assertDontSee('উৎসব অটো-শিডিউল', false)
            ->assertDontSee('সারপ্রাইজ থিম', false); // custom-colors card markup

        // granted mutation succeeds (fonts endpoint answers JSON)
        $this->actingAs($admin)
            ->post(route('admin.settings.theme.fonts'), ['font_heading' => '', 'font_body' => 'jakarta'])
            ->assertOk();

        // every other theme mutation stays forbidden
        $this->actingAs($admin)->post(route('admin.settings.theme.festive'), ['rows' => []])->assertForbidden();
        $this->actingAs($admin)->post(route('admin.settings.theme.custom'), [
            'primary' => '#000000', 'dark' => '#000000', 'accent' => '#000000',
        ])->assertForbidden();
        $this->actingAs($admin)->post(route('admin.settings.theme.reset'))->assertForbidden();
        $this->actingAs($admin)->post(route('admin.settings.theme'), [
            'theme_id' => 'herbal', 'theme_json' => '{}',
        ])->assertForbidden();
        // industry re-skin needs its own grant (super-admin shortcut not required)
        $this->actingAs($admin)->post(route('admin.settings.industry.apply'), [
            'industry' => 'herbal', 'mode' => 'visual',
        ])->assertForbidden();
    }

    public function test_theme_industry_preset_is_grantable_and_applies(): void
    {
        $admin = $this->admin(['theme' => ['view', 'industry_preset']]);

        $this->actingAs($admin)->get(route('admin.settings.theme'))
            ->assertOk()
            ->assertSee('ইন্ডাস্ট্রি প্রিসেট', false);

        $this->actingAs($admin)->post(route('admin.settings.industry.clear'))->assertOk();
    }

    public function test_view_only_admin_sees_theme_page_without_mutation_cards(): void
    {
        $admin = $this->admin(['theme' => ['view']]);

        $this->actingAs($admin)->get(route('admin.settings.theme'))
            ->assertOk()
            ->assertDontSee('রেডিমেড থিম', false)
            ->assertDontSee('হেডিং ফন্ট', false)
            ->assertDontSee('লাইভ প্রিভিউ', false);
    }

    /* ================= legacy grants: the split-module migration ================= */

    public function test_legacy_edit_grants_are_migrated_to_star(): void
    {
        $admin = $this->admin([
            'theme' => ['edit'],
            'payment' => ['edit'],
            'tracking' => ['edit'],
            'content' => ['edit'],
            'orders' => ['view'], // non-split module — must stay untouched
        ]);

        // re-run the data migration exactly as the deploy flow would
        $migration = require database_path('migrations/2024_01_08_000300_migrate_split_module_edit_permissions.php');
        $migration->up();

        $admin->refresh();
        $this->assertEquals(['*'], $admin->permissions['theme']);
        $this->assertEquals(['*'], $admin->permissions['payment']);
        $this->assertEquals(['*'], $admin->permissions['tracking']);
        $this->assertEquals(['*'], $admin->permissions['content']);
        $this->assertEquals(['view'], $admin->permissions['orders']);

        // a former full editor passes every new granular check
        $this->assertTrue($admin->hasPermission('theme.fonts'));
        $this->assertTrue($admin->hasPermission('theme.festive'));
        $this->assertTrue($admin->hasPermission('theme.industry_preset'));
        $this->assertTrue($admin->hasPermission('payment.nagad_edit'));
        $this->assertTrue($admin->hasPermission('tracking.tiktok'));
        $this->assertTrue($admin->hasPermission('content.footer'));
        $this->assertFalse($admin->hasPermission('coupons.view'));

        // idempotent — a second run changes nothing
        $migration->up();
        $admin->refresh();
        $this->assertEquals(['*'], $admin->permissions['theme']);
    }

    /* ================= presets & matrix roundtrip with the new keys ================= */

    public function test_store_manager_preset_grants_visual_theme_but_not_site_wide_tools(): void
    {
        $super = $this->superAdmin();

        $this->actingAs($super)->post(route('super.admins.store'), [
            'name' => 'স্টোর ম্যানেজার',
            'email' => 'store@example.com',
            'password' => 'secret123',
            'preset' => 'store_manager',
        ])->assertRedirect();

        $client = User::where('email', 'store@example.com')->first();

        // day-to-day look tweaks are in the package…
        $this->assertTrue($client->hasPermission('theme.view'));
        $this->assertTrue($client->hasPermission('theme.ready_made'));
        $this->assertTrue($client->hasPermission('theme.custom_colors'));
        $this->assertTrue($client->hasPermission('theme.fonts'));
        $this->assertTrue($client->hasPermission('theme.reset'));
        // …festival scheduling and the whole-site industry re-skin are not
        $this->assertFalse($client->hasPermission('theme.festive'));
        $this->assertFalse($client->hasPermission('theme.industry_preset'));

        // store operations stay fully granted
        $this->assertTrue($client->hasPermission('orders.view'));
        $this->assertTrue($client->hasPermission('orders.delete'));
        $this->assertTrue($client->hasPermission('products.delete'));

        $this->actingAs($client)->get(route('admin.settings.theme'))->assertOk();
        $this->actingAs($client)->post(route('admin.settings.theme.festive'), ['rows' => []])->assertForbidden();
    }

    public function test_matrix_select_all_on_theme_collapses_to_star(): void
    {
        $super = $this->superAdmin();
        $client = $this->admin();

        $allFeatures = array_keys(config('permissions.modules.theme.features'));

        $this->actingAs($super)->put(route('super.admins.update', $client), [
            'name' => $client->name,
            'email' => $client->email,
            'permissions' => ['theme' => $allFeatures],
        ])->assertRedirect(route('super.admins.index'));

        $client->refresh();
        $this->assertEquals(['*'], $client->permissions['theme']);
        $this->assertTrue($client->hasPermission('theme.industry_preset'));
        $this->assertTrue($client->hasPermission('theme.live_preview'));

        // partial grant keeps exactly the ticked features
        $this->actingAs($super)->put(route('super.admins.update', $client), [
            'name' => $client->name,
            'email' => $client->email,
            'permissions' => ['theme' => ['view', 'fonts']],
        ])->assertRedirect(route('super.admins.index'));

        $client->refresh();
        $this->assertEquals(['view', 'fonts'], $client->permissions['theme']);
        $this->assertTrue($client->hasPermission('theme.fonts'));
        $this->assertFalse($client->hasPermission('theme.festive'));
    }

    /* ================= sidebar follows the matrix ================= */

    public function test_sidebar_hides_theme_link_without_any_theme_grant(): void
    {
        $admin = $this->admin(['orders' => ['view']]);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('থিম কালার', false);
    }

    public function test_sidebar_shows_theme_link_for_view_only_admin(): void
    {
        $admin = $this->admin(['theme' => ['view']]);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('থিম কালার', false);
    }

    /* ================= payment + tracking splits ================= */

    public function test_payment_gateway_scoping(): void
    {
        $admin = $this->admin(['payment' => ['view', 'bkash_edit']]);

        $this->actingAs($admin)->get(route('admin.settings.payment'))->assertOk();

        // granted gateway saves, others stay closed
        $this->actingAs($admin)->post(route('admin.settings.payment.bkash'), [
            'bkash_enabled' => '1', 'bkash_mode' => 'sandbox',
        ])->assertRedirect();
        $this->actingAs($admin)->post(route('admin.settings.payment.toggle'), [
            'online_payment_enabled' => '1',
        ])->assertForbidden();
        $this->actingAs($admin)->post(route('admin.settings.payment.nagad'), [])->assertForbidden();
    }

    public function test_tracking_pixel_scoping_is_per_pixel(): void
    {
        $admin = $this->admin(['tracking' => ['view', 'fb']]);

        $this->actingAs($admin)->get(route('admin.settings.tracking'))
            ->assertOk()
            ->assertSee('Facebook Pixel', false)
            ->assertDontSee('TikTok Pixel', false);

        $this->actingAs($admin)->post(route('admin.settings.tracking.save', 'fb'), [
            'value' => '1234567890', 'enabled' => '1',
        ])->assertRedirect();
        $this->actingAs($admin)->post(route('admin.settings.tracking.save', 'tiktok'), [
            'value' => 'X',
        ])->assertForbidden();

        // unknown keys never reach pixels_json — not even for the super admin
        $this->actingAs($this->superAdmin())->post(route('admin.settings.tracking.save', 'made_up'), [
            'value' => 'X',
        ])->assertForbidden();
    }
}
