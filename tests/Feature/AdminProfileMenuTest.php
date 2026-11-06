<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The top-right profile chip opens a menu: who you are, your account,
 * password, the store, and logout.
 */
class AdminProfileMenuTest extends TestCase
{
    use RefreshDatabase;

    private function admin(array $perms): User
    {
        return User::create([
            'name' => 'Samiul Alam Himel', 'email' => 'himel@client.bd', 'password' => 'secret123',
            'role' => User::ROLE_ADMIN, 'permissions' => $perms, 'is_active' => true,
        ]);
    }

    public function test_profile_chip_opens_a_working_menu(): void
    {
        $this->actingAs($this->admin(['orders' => ['view'], 'team' => ['view']]))
            ->get(route('admin.dashboard'))->assertOk()
            ->assertSee('id="userDrop"', false)
            ->assertSee('aria-controls="userDrop"', false)
            ->assertSee('>SA<', false)
            ->assertSee('himel@client.bd')
            ->assertSee(route('admin.account').'#password')
            ->assertSee(route('admin.logout'))
            ->assertSee('স্বাগতম, Samiul Alam Himel');
    }

    public function test_menu_hides_admin_management_without_the_team_grant(): void
    {
        $html = $this->actingAs($this->admin(['orders' => ['view']]))
            ->get(route('admin.dashboard'))->assertOk()->getContent();

        $this->assertStringNotContainsString(route('admin.admins.index'), $html);
    }

    public function test_confirm_dialogs_render_titles_as_text(): void
    {
        $this->actingAs($this->admin(['orders' => ['view']]))
            ->get(route('admin.dashboard'))->assertOk()
            ->assertSee('titleText: o.title', false)
            ->assertDontSee('title: o.title', false);
    }
}
