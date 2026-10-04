<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Permission system tests — 3-role architecture (daief's system):
 * super_admin / admin (module.feature map) / customer.
 * Legacy flat-permission creation (permissions array, no role) is bridged in
 * the User model — staff() here exercises that path on purpose.
 */
class AdminPermissionTest extends TestCase
{
    use RefreshDatabase;

    private function superAdmin(): User
    {
        return User::create([
            'name' => 'Boss',
            'email' => 'boss@test.bd',
            'password' => 'secret123',
            'role' => User::ROLE_SUPER_ADMIN,
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

    public function test_plain_admin_cannot_open_super_panel(): void
    {
        $staff = $this->staff(['orders']);
        $this->actingAs($staff)
            ->get(route('super.admins.index'))
            ->assertForbidden();
    }

    public function test_super_panel_lists_admins_with_visible_emails(): void
    {
        $boss = $this->superAdmin();
        $staff = $this->staff(['orders']);

        $html = $this->actingAs($boss)
            ->get(route('super.admins.index'))
            ->assertOk()
            ->getContent();

        // email visible (mask na) — duijon e list e
        $this->assertStringContainsString('boss@test.bd', $html);
        $this->assertStringContainsString('staff@test.bd', $html);
    }

    public function test_super_can_update_other_admin_permission_matrix(): void
    {
        $boss = $this->superAdmin();
        $staff = $this->staff(['orders']);

        $this->actingAs($boss)
            ->put(route('super.admins.update', $staff), [
                'name' => 'Staff',
                'email' => 'staff@test.bd',
                'permissions' => [
                    'orders' => ['view', 'status_update'],
                    'products' => ['view', 'edit'],
                ],
            ])
            ->assertRedirect();

        $fresh = $staff->fresh();
        $this->assertTrue($fresh->hasPermission('orders.view'));
        $this->assertTrue($fresh->hasPermission('products.edit'));
        $this->assertFalse($fresh->hasPermission('products.delete'));
        $this->assertFalse($fresh->hasPermission('complaints.view'));
    }

    public function test_super_can_reset_other_admin_password(): void
    {
        $boss = $this->superAdmin();
        $staff = $this->staff(['orders']);

        $this->actingAs($boss)
            ->post(route('super.admins.password', $staff), ['password' => 'newpass99'])
            ->assertRedirect();

        $this->assertTrue(Hash::check('newpass99', $staff->fresh()->password));
    }

    public function test_super_cannot_deactivate_or_delete_self(): void
    {
        $boss = $this->superAdmin();

        $this->actingAs($boss)
            ->post(route('super.admins.toggle', $boss))
            ->assertSessionHasErrors('admin');

        $this->actingAs($boss)
            ->delete(route('super.admins.destroy', $boss))
            ->assertSessionHasErrors('admin');

        $this->assertDatabaseHas('users', ['id' => $boss->id]);
        $this->assertTrue($boss->fresh()->is_active);
    }

    public function test_super_can_delete_another_admin(): void
    {
        $boss = $this->superAdmin();
        $staff = $this->staff(['orders']);

        $this->actingAs($boss)
            ->delete(route('super.admins.destroy', $staff))
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $staff->id]);
    }

    public function test_deactivated_admin_cannot_log_in(): void
    {
        $boss = $this->superAdmin();
        $staff = $this->staff(['orders']);

        $this->actingAs($boss)
            ->post(route('super.admins.toggle', $staff))
            ->assertRedirect();
        $this->assertFalse($staff->fresh()->is_active);

        $this->post(route('admin.login.attempt'), [
            'email' => 'staff@test.bd',
            'password' => 'secret123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
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
