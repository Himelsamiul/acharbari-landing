<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectionVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_hides_disabled_sections(): void
    {
        Setting::set('sections_hidden', json_encode(['promises']));

        $this->get('/')
            ->assertOk()
            // lukano section render hoy nai
            ->assertDontSee('id="ds-promise"', false)
            // baki section thake
            ->assertSee('id="ds-why"', false);
    }

    public function test_all_sections_visible_by_default(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('id="ds-promise"', false)
            ->assertSee('id="ds-why"', false);
    }

    public function test_checkout_and_unknown_keys_never_hide(): void
    {
        // checkout = order form — kokhono luke na; bogus key-o ignore
        Setting::set('sections_hidden', json_encode(['promises', 'checkout', 'bogus']));

        $this->assertFalse(ab_section_active('promises'));
        $this->assertTrue(ab_section_active('checkout'));
        $this->assertTrue(ab_section_active('bogus'));
    }
}
