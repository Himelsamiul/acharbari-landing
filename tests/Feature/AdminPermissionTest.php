<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPermissionTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::create([
            'name' => 'Boss',
            'email' => 'boss@test.bd',
            'password' => 'secret123',
            'permissions' => array_keys(User::PERMISSIONS),
        ]);
    }

    private function staff(array $perms): User
    {
        return User::create([
            'name' => 'Staff',
            'email' => 'staff@test.bd',
            'password' => 'secret123',
            'permissions' => $perms,
        ]);
    }

    public function test_staff_blocked_from_admin_management(): void
    {
        $staff = $this->staff(['orders']);
        $this->actingAs($staff)
            ->get(route('admin.admins.index'))
            ->assertForbidden();
    }

    public function test_staff_with_perm_can_access_granted_route(): void
    {
        $staff = $this->staff(['orders']);
        $this->actingAs($staff)
            ->get(route('admin.orders.index'))
            ->assertOk();
    }

    public function test_sidebar_hides_unpermitted_sections(): void
    {
        $staff = $this->staff(['orders']);
        $html = $this->actingAs($staff)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->getContent();

        // order link ase, admin-management link nai (sidebar label diye check)
        $this->assertStringContainsString('অর্ডারসমূহ', $html);
        $this->assertStringNotContainsString('অ্যাডমিন ম্যানেজমেন্ট', $html);
    }

    public function test_email_is_masked_in_admin_list(): void
    {
        $boss = $this->superAdmin();
        $this->actingAs($boss)
            ->get(route('admin.admins.index'))
            ->assertOk()
            ->assertSee('b***@t***.bd') // boss@test.bd masked
            ->assertDontSee('boss@test.bd');
    }

    public function test_cannot_edit_own_permissions(): void
    {
        $boss = $this->superAdmin();
        $this->actingAs($boss)
            ->put(route('admin.admins.update', $boss), ['permissions' => ['orders']])
            ->assertSessionHasErrors('admin');
    }

    public function test_super_can_update_other_admin_permissions(): void
    {
        $boss = $this->superAdmin();
        $staff = $this->staff(['orders']);

        $this->actingAs($boss)
            ->put(route('admin.admins.update', $staff), ['permissions' => ['orders', 'products']])
            ->assertRedirect();

        $this->assertSame(['orders', 'products'], $staff->fresh()->permissions);
    }

    public function test_super_can_reset_other_admin_password(): void
    {
        $boss = $this->superAdmin();
        $staff = $this->staff(['orders']);

        $this->actingAs($boss)
            ->put(route('admin.admins.update', $staff), ['permissions' => ['orders'], 'password' => 'newpass99'])
            ->assertRedirect();

        $this->assertTrue(Hash::check('newpass99', $staff->fresh()->password));
    }

    public function test_self_delete_allowed_when_other_admins_exist(): void
    {
        $boss = $this->superAdmin();
        $this->staff(['orders']);

        $this->actingAs($boss)
            ->delete(route('admin.admins.destroy', $boss))
            ->assertRedirect(route('admin.login'));

        $this->assertDatabaseMissing('users', ['id' => $boss->id]);
        $this->assertGuest();
    }

    public function test_last_admin_cannot_be_deleted(): void
    {
        $boss = $this->superAdmin();

        $this->actingAs($boss)
            ->delete(route('admin.admins.destroy', $boss))
            ->assertSessionHasErrors('admin');

        $this->assertDatabaseHas('users', ['id' => $boss->id]);
    }

    public function test_own_password_change_works(): void
    {
        $staff = $this->staff(['orders']);

        // bhul current password
        $this->actingAs($staff)
            ->post(route('admin.account.password'), [
                'current_password' => 'wrong-pass',
                'password' => 'newpass99',
                'password_confirmation' => 'newpass99',
            ])
            ->assertSessionHasErrors('current_password');

        // thik current password
        $this->actingAs($staff)
            ->post(route('admin.account.password'), [
                'current_password' => 'secret123',
                'password' => 'newpass99',
                'password_confirmation' => 'newpass99',
            ])
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('newpass99', $staff->fresh()->password));
    }
}
