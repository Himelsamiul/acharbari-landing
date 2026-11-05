<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\IndustryPack;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Data-loss guard: applying / clearing an industry preset must NEVER overwrite
 * the admin's own landing content or uploaded hero images. Presets may only fill
 * EMPTY fields and change the theme colour.
 */
class IndustryPresetTest extends TestCase
{
    use RefreshDatabase;

    private function presetAdmin(): User
    {
        return User::factory()->admin(['theme' => ['view', 'industry_preset']])
            ->create(['password' => Hash::make('password')])->refresh();
    }

    public function test_full_preset_fills_blanks_but_never_overwrites_admin_content_or_images(): void
    {
        $admin = $this->presetAdmin();

        // admin's own data (non-empty) — must survive the preset
        $myReviews = json_encode([['name' => 'আমার রিভিউ', 'stars' => 5]], JSON_UNESCAPED_UNICODE);
        Setting::set('hero_chip_bn', 'আমার নিজের হিরো টেক্সট');
        Setting::set('hero_img1', 'storage/content/my-photo.jpg');
        Setting::set('reviews_items', $myReviews);
        // hero_lead_bn intentionally left empty so the preset is allowed to fill it

        $this->actingAs($admin)
            ->post(route('admin.settings.industry.apply'), ['industry' => 'organic', 'mode' => 'full'])
            ->assertOk()
            ->assertJson(['ok' => true]);

        // 1) admin-entered values are untouched
        $this->assertDatabaseHas('settings', ['key' => 'hero_chip_bn', 'value' => 'আমার নিজের হিরো টেক্সট']);
        $this->assertDatabaseHas('settings', ['key' => 'hero_img1', 'value' => 'storage/content/my-photo.jpg']);
        $this->assertDatabaseHas('settings', ['key' => 'reviews_items', 'value' => $myReviews]);

        // 2) the preset still filled the blank field + switched the theme
        $organic = IndustryPack::all()['organic'];
        $this->assertDatabaseHas('settings', ['key' => 'hero_lead_bn', 'value' => $organic['content']['hero_lead'][0]]);
        $this->assertSame('organic', Setting::get('industry'));
        $this->assertSame($organic['theme'], Setting::get('theme_id'));
    }

    public function test_visual_preset_touches_no_content_or_images(): void
    {
        $admin = $this->presetAdmin();

        Setting::set('hero_chip_bn', 'আমার নিজের হিরো টেক্সট');
        Setting::set('hero_img1', 'storage/content/my-photo.jpg');

        $this->actingAs($admin)
            ->post(route('admin.settings.industry.apply'), ['industry' => 'fashion', 'mode' => 'visual'])
            ->assertOk();

        // content + image left exactly as the admin set them
        $this->assertDatabaseHas('settings', ['key' => 'hero_chip_bn', 'value' => 'আমার নিজের হিরো টেক্সট']);
        $this->assertDatabaseHas('settings', ['key' => 'hero_img1', 'value' => 'storage/content/my-photo.jpg']);
        // visual mode writes NO demo content, even into blank fields
        $this->assertDatabaseMissing('settings', ['key' => 'hero_lead_bn']);
        // but the theme colour did change
        $this->assertSame('fashion', Setting::get('industry'));
    }

    public function test_clear_industry_keeps_admin_reviews_and_uploaded_images(): void
    {
        $admin = $this->presetAdmin();

        $myReviews = json_encode([['name' => 'আমার রিভিউ', 'stars' => 5]], JSON_UNESCAPED_UNICODE);
        Setting::set('industry', 'fashion');
        Setting::set('reviews_items', $myReviews);
        Setting::set('marquee_items', '[{"bn":"আমার মার্কি"}]');
        Setting::set('hero_img1', 'storage/content/my-photo.jpg');

        $this->actingAs($admin)
            ->post(route('admin.settings.industry.clear'))
            ->assertOk();

        // industry off, but the admin's data is NOT wiped
        $this->assertSame('', (string) Setting::get('industry'));
        $this->assertDatabaseHas('settings', ['key' => 'reviews_items', 'value' => $myReviews]);
        $this->assertDatabaseHas('settings', ['key' => 'marquee_items', 'value' => '[{"bn":"আমার মার্কি"}]']);
        $this->assertDatabaseHas('settings', ['key' => 'hero_img1', 'value' => 'storage/content/my-photo.jpg']);
    }
}
