<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LandingContentTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): self
    {
        $user = User::firstOrCreate(
            ['email' => 'admin-content@example.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('secret123'),
                'permissions' => array_keys(User::PERMISSIONS),
            ]
        );

        return $this->actingAs($user);
    }

    public function test_text_keys_save_and_render(): void
    {
        $this->actingAsAdmin()
            ->post(route('admin.settings.content.save'), [
                'hero_lead_bn' => 'নতুন হিরো লিড', 'hero_lead_en' => 'New hero lead',
            ])
            ->assertRedirect();

        $this->assertSame('নতুন হিরো লিড', Setting::get('hero_lead_bn'));
        $this->assertSame('New hero lead', Setting::get('hero_lead_en'));
    }

    public function test_hero_image_replace_deletes_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('content/old-hero.jpg', 'oldimagedata');
        Setting::set('hero_img1', 'storage/content/old-hero.jpg');

        $this->actingAsAdmin()
            ->post(route('admin.settings.content.save'), [
                'hero_img1' => \Illuminate\Http\Testing\File::fake()->image('new.jpg'),
            ])
            ->assertRedirect();

        Storage::disk('public')->assertMissing('content/old-hero.jpg');
        $this->assertStringStartsWith('storage/content/', (string) Setting::get('hero_img1'));
        $this->assertNotSame('storage/content/old-hero.jpg', Setting::get('hero_img1'));
    }

    public function test_broken_repeater_json_errors_and_keeps_existing_data(): void
    {
        Setting::set('faq_items', json_encode([['q' => 'প্রশ্ন?', 'a' => 'উত্তর']]));

        $this->actingAsAdmin()
            ->post(route('admin.settings.content.save'), [
                'faq_json' => '{"broken json,,,',
            ])
            ->assertSessionHasErrors('repeater');

        // bhanga JSON e data HARAY na — ager lekha ache
        $this->assertSame(
            json_encode([['q' => 'প্রশ্ন?', 'a' => 'উত্তর']]),
            Setting::get('faq_items')
        );
    }

    public function test_empty_repeater_json_restores_defaults(): void
    {
        Setting::set('faq_items', json_encode([['q' => 'পুরনো', 'a' => 'উত্তর']]));

        $this->actingAsAdmin()
            ->post(route('admin.settings.content.save'), [
                'faq_json' => '',
            ])
            ->assertRedirect();

        // khali = default e ferot (setting cleared)
        $this->assertSame('', Setting::get('faq_items'));
    }
}

class ThemeGuardTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): self
    {
        $user = User::firstOrCreate(
            ['email' => 'admin-theme@example.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('secret123'),
                'permissions' => array_keys(User::PERMISSIONS),
            ]
        );

        return $this->actingAs($user);
    }

    public function test_broken_theme_json_is_rejected_and_not_saved(): void
    {
        // valid JSON kintu theme na — agulo save hole puro site er color bhangto
        $this->actingAsAdmin()
            ->post(route('admin.settings.theme.save'), [
                'theme_id' => 'custom',
                'theme_json' => '"hello"',
            ])
            ->assertSessionHasErrors();

        $this->assertNull(Setting::get('theme_json'));
    }

    public function test_landing_falls_back_to_default_theme_on_garbage_json(): void
    {
        // DB te garbage theme_json thakleo UI bhange na — default herbal bose jay
        Setting::set('theme_json', 'garbage-not-even-json');

        $this->get('/')
            ->assertOk()
            ->assertSee('--ds-primary: #059669', false);
    }

    public function test_valid_theme_json_still_applies(): void
    {
        $theme = json_encode(\App\Http\Controllers\Admin\ThemeLibrary::get('herbal'));
        Setting::set('theme_json', $theme);

        $this->get('/')->assertOk()->assertSee('--ds-primary: #059669', false);
    }
}
