<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Seeding is for a fresh install. Running it again on a live store must never
 * reset the owner's password or undo what the admin changed.
 */
class SeederSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_second_seed_run_keeps_everything_the_store_changed(): void
    {
        $this->seed(DatabaseSeeder::class);

        // the store makes it its own
        $owner = User::where('email', User::PLATFORM_OWNER_EMAIL)->firstOrFail();
        $owner->update(['password' => 'a-strong-new-pass']);
        Setting::setMany(['brand_bn1' => 'আমার', 'logo_path' => 'storage/logo.png', 'theme_id' => 'herbal']);
        Coupon::where('code', 'ACHAR10')->update(['is_active' => false]);
        Product::where('slug', 'mango-kuchi-achar')->update(['price' => 999, 'is_active' => false]);
        Category::where('key', 'pickle')->update(['name' => 'টক-ঝাল আচার']);

        $this->seed(DatabaseSeeder::class);

        $owner->refresh();
        $this->assertTrue(Hash::check('a-strong-new-pass', $owner->password));
        $this->assertFalse(Hash::check('admin123', $owner->password));
        $this->assertSame('আমার', Setting::get('brand_bn1'));
        $this->assertSame('storage/logo.png', Setting::get('logo_path'));
        $this->assertSame('herbal', Setting::get('theme_id'));
        $this->assertFalse(Coupon::where('code', 'ACHAR10')->value('is_active'));

        $mango = Product::where('slug', 'mango-kuchi-achar')->firstOrFail();
        $this->assertEquals(999, $mango->price);
        $this->assertFalse((bool) $mango->is_active);
        $this->assertSame('টক-ঝাল আচার', Category::where('key', 'pickle')->value('name'));
        $this->assertSame(1, User::where('email', User::PLATFORM_OWNER_EMAIL)->count());
    }

    public function test_a_fresh_seed_still_sets_up_the_starter_store(): void
    {
        $this->seed(DatabaseSeeder::class);

        $owner = User::where('email', User::PLATFORM_OWNER_EMAIL)->firstOrFail();
        $this->assertTrue($owner->isSuperAdmin());
        $this->assertSame('spice', Setting::get('theme_id'));
        $this->assertTrue((bool) Coupon::where('code', 'ACHAR10')->value('is_active'));
        $this->assertTrue((bool) Product::where('slug', 'mango-kuchi-achar')->value('is_active'));
    }

    public function test_seeding_a_live_production_store_is_skipped(): void
    {
        User::create([
            'name' => 'Owner', 'email' => 'owner@shop.bd', 'password' => 'secret123',
            'role' => User::ROLE_SUPER_ADMIN,
        ]);
        $this->app->detectEnvironment(fn () => 'production');

        (new DatabaseSeeder)->run();

        $this->assertSame(0, Product::count());
        $this->assertNull(Coupon::where('code', 'ACHAR10')->first());
        $this->assertSame(1, User::count());
    }

    public function test_the_retired_migrate_helper_is_gone_and_removed_from_servers(): void
    {
        $this->assertFileDoesNotExist(public_path('_migrate.php'));
        $this->assertContains('public/_migrate.php', $this->retiredPaths());
    }

    public function test_the_server_cleanup_list_never_names_a_live_app_file(): void
    {
        foreach ($this->retiredPaths() as $path) {
            if (str_ends_with($path, '/')) {
                // a folder goes with everything in it — only the server-only ones the
                // mirror never uploads (they stay in the repo)
                $this->assertContains($path, ['tests/', '.git/', '.github/'], "$path is not a server-only folder");
            } else {
                $this->assertFileDoesNotExist(base_path($path), "$path is still part of the app — a deploy would delete it from the servers");
            }
        }
    }

    /** Paths in deploy/retired-files.txt (comments and blank lines skipped). */
    private function retiredPaths(): array
    {
        $lines = file(base_path('deploy/retired-files.txt'), FILE_IGNORE_NEW_LINES);

        return array_values(array_filter(array_map('trim', $lines), fn ($line) => $line !== '' && $line[0] !== '#'));
    }
}
