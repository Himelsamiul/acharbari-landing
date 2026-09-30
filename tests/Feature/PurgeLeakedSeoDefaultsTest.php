<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurgeLeakedSeoDefaultsTest extends TestCase
{
    use RefreshDatabase;

    private function runPurge(): void
    {
        $migration = include database_path('migrations/2024_01_11_000100_purge_leaked_acharbari_seo_defaults.php');
        $migration->up();
    }

    public function test_leaked_acharbari_defaults_are_removed_for_other_business(): void
    {
        // onno business (jemon amrongbd.com) — brand customized
        Setting::setMany([
            'brand_bn1' => 'আমরন্গ', 'brand_bn2' => '',
            'seo_title' => 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ',
            'seo_desc' => 'ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনি — প্রিজার্ভেটিভ মুক্ত, ক্যাশ অন ডেলিভারিতে সারা বাংলাদেশে হোম ডেলিভারি।',
            'seo_keywords' => 'deshi achar, mango pickle, আচারবাড়ি, homemade pickle BD, sundarban honey',
        ]);

        $this->runPurge();

        $this->assertFalse(Setting::has('seo_title'));
        $this->assertFalse(Setting::has('seo_desc'));
        $this->assertFalse(Setting::has('seo_keywords'));
        // brand setting nijei thakbe
        $this->assertSame('আমরন্গ', Setting::get('brand_bn1'));
    }

    public function test_acharbari_site_keeps_its_own_values(): void
    {
        // khorak.shop — AcharBari brand, default gulo intended
        Setting::setMany([
            'brand_bn1' => 'আচার', 'brand_bn2' => 'বাড়ি',
            'seo_title' => 'আচারবাড়ি — ঘরে তৈরি খাঁটি দেশি আচার ও প্রিজার্ভ',
            'seo_desc' => 'ঘরে তৈরি খাঁটি দেশি আচার, মধু, ঘি ও চাটনি — প্রিজার্ভেটিভ মুক্ত, ক্যাশ অন ডেলিভারিতে সারা বাংলাদেশে হোম ডেলিভারি।',
        ]);

        $this->runPurge();

        $this->assertTrue(Setting::has('seo_title'));
        $this->assertTrue(Setting::has('seo_desc'));
    }

    public function test_custom_values_of_other_business_are_untouched(): void
    {
        Setting::setMany([
            'brand_bn1' => 'আমরন্গ', 'brand_bn2' => '',
            'seo_title' => 'আমরন্গ — বিশ্বস্ত অনলাইন শপ',
            'seo_desc' => 'আমরন্গ থেকে অর্ডার করুন নিরাপদে।',
        ]);

        $this->runPurge();

        $this->assertSame('আমরন্গ — বিশ্বস্ত অনলাইন শপ', Setting::get('seo_title'));
        $this->assertSame('আমরন্গ থেকে অর্ডার করুন নিরাপদে।', Setting::get('seo_desc'));
    }

    public function test_dynamic_seo_defaults_use_brand_name(): void
    {
        Setting::setMany(['brand_bn1' => 'আমরন্গ', 'brand_bn2' => '']);

        $this->assertSame('আমরন্গ', ab_seo_default_title());
        $this->assertStringContainsString('আমরন্গ', ab_seo_default_desc());
        $this->assertStringNotContainsString('আচারবাড়ি', ab_seo_default_desc());
    }

    public function test_landing_title_comes_from_seo_setting(): void
    {
        // admin SEO Settings e ja likha hoy tab-title o og:title sei hoy —
        // home page ar nijer moto hardcoded title chapay na
        Setting::set('seo_title', 'Khoraq — Organic Food in Bangladesh');

        $this->get('/')
            ->assertOk()
            ->assertSee('<title>Khoraq — Organic Food in Bangladesh</title>', false);
    }
}
