<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Admin & team management lives in the one admin panel:
 * - the platform owner sees and manages every account;
 * - a client admin sees everyone in their own team (its head and the whole
 *   tree under it), never the owner, and can grant at most what they hold;
 * - they manage only the accounts they (and their team) created — anything
 *   else 404s.
 */
class TeamHierarchyTest extends TestCase
{
    use RefreshDatabase;

    private const TEAM_ALL = ['view', 'create', 'edit', 'delete'];

    private function owner(): User
    {
        return User::create([
            'name' => 'Platform Owner', 'email' => User::PLATFORM_OWNER_EMAIL,
            'password' => 'secret123', 'role' => User::ROLE_SUPER_ADMIN, 'is_active' => true,
        ]);
    }

    private function admin(string $email, array $perms, ?User $creator = null): User
    {
        return User::create([
            'name' => ucfirst(strtok($email, '@')), 'email' => $email, 'password' => 'secret123',
            'role' => User::ROLE_ADMIN, 'permissions' => $perms, 'is_active' => true,
            'created_by' => $creator?->id,
        ]);
    }

    /** Himel: a client admin who may manage a team and see orders. */
    private function himel(): User
    {
        return $this->admin('himel@client.bd', ['team' => ['*'], 'orders' => ['view']]);
    }

    public function test_owner_sees_every_admin(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();
        $this->admin('staff@client.bd', ['orders' => ['view']], $himel);

        $this->actingAs($owner)->get(route('admin.admins.index'))->assertOk()
            ->assertSee(User::PLATFORM_OWNER_EMAIL)
            ->assertSee('himel@client.bd')
            ->assertSee('staff@client.bd');
    }

    public function test_client_admin_sees_only_self_and_own_team_never_the_owner(): void
    {
        $this->owner();
        $himel = $this->himel();
        $this->admin('staff@client.bd', ['orders' => ['view']], $himel);
        $this->admin('karim@other.bd', ['team' => ['*']]); // another client

        $this->actingAs($himel)->get(route('admin.admins.index'))->assertOk()
            ->assertSee('himel@client.bd')
            ->assertSee('staff@client.bd')
            ->assertDontSee(User::PLATFORM_OWNER_EMAIL)
            ->assertDontSee('Platform Owner')
            ->assertDontSee('karim@other.bd')
            ->assertDontSee('সুপার অ্যাডমিন');
    }

    public function test_teammates_see_each_other_but_manage_only_what_they_created(): void
    {
        $this->owner();
        $himel = $this->himel();
        $lead = $this->admin('lead@client.bd', ['team' => ['*'], 'orders' => ['view']], $himel);
        $peer = $this->admin('peer@client.bd', ['orders' => ['view']], $himel);
        $junior = $this->admin('junior@client.bd', ['orders' => ['view']], $lead);
        $karim = $this->admin('karim@other.bd', ['team' => ['*']]); // another client
        $this->admin('kstaff@other.bd', ['orders' => ['view']], $karim);

        // the employee sees the head who created them, their peers and their own team
        $this->actingAs($lead)->get(route('admin.admins.index'))->assertOk()
            ->assertSee('himel@client.bd')
            ->assertSee('peer@client.bd')
            ->assertSee('junior@client.bd')
            ->assertSee('শুধু দেখা')
            ->assertSee(route('admin.admins.edit', $junior))
            ->assertDontSee(route('admin.admins.edit', $himel))
            ->assertDontSee(route('admin.admins.edit', $peer))
            ->assertDontSee(User::PLATFORM_OWNER_EMAIL)
            ->assertDontSee('Platform Owner')
            ->assertDontSee('সুপার অ্যাডমিন')
            ->assertDontSee('karim@other.bd')
            ->assertDontSee('kstaff@other.bd');

        // seeing is not managing — the head and peers stay out of reach
        foreach ([$himel, $peer] as $target) {
            $this->actingAs($lead)->get(route('admin.admins.edit', $target))->assertNotFound();
            $this->actingAs($lead)->post(route('admin.admins.password', $target), ['password' => 'newpass99'])->assertNotFound();
            $this->actingAs($lead)->post(route('admin.admins.toggle', $target))->assertNotFound();
            $this->actingAs($lead)->delete(route('admin.admins.destroy', $target))->assertNotFound();
        }
        $this->actingAs($lead)->get(route('admin.admins.edit', $junior))->assertOk();

        $this->assertTrue($himel->fresh()->is_active);
        $this->assertDatabaseHas('users', ['id' => $peer->id]);

        // the head still sees the whole team
        $this->actingAs($himel)->get(route('admin.admins.index'))->assertOk()
            ->assertSee('lead@client.bd')
            ->assertSee('peer@client.bd')
            ->assertSee('junior@client.bd')
            ->assertDontSee('karim@other.bd');
    }

    public function test_team_never_reaches_up_to_the_owner(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();
        $emp = $this->admin('emp@client.bd', ['team' => ['view']], $himel);

        // even if a head's row points at the owner, the team stops at the head
        $himel->forceFill(['created_by' => $owner->id])->save();

        $this->assertTrue($emp->teamRoot()->is($himel));
        $this->assertNotContains($owner->id, $emp->visibleTeamIds());

        $this->actingAs($emp)->get(route('admin.admins.index'))->assertOk()
            ->assertSee('himel@client.bd')
            ->assertDontSee(User::PLATFORM_OWNER_EMAIL)
            ->assertDontSee('Platform Owner');
    }

    public function test_client_admin_without_team_grant_is_forbidden(): void
    {
        $rahim = $this->admin('rahim@client.bd', ['orders' => ['view']]);

        $this->actingAs($rahim)->get(route('admin.admins.index'))->assertForbidden();
        $this->actingAs($rahim)->get(route('admin.dashboard'))->assertOk()
            ->assertDontSee('অ্যাডমিন ম্যানেজমেন্ট');
    }

    public function test_sidebar_offers_admin_management_with_team_grant(): void
    {
        $this->actingAs($this->himel())->get(route('admin.dashboard'))->assertOk()
            ->assertSee('অ্যাডমিন ম্যানেজমেন্ট');
    }

    public function test_client_admin_creates_employee_linked_to_himself_and_capped(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();

        $this->actingAs($himel)->post(route('admin.admins.store'), [
            'name' => 'Employee', 'email' => 'emp@client.bd', 'password' => 'secret123',
            'preset' => 'full',
            // tampering attempts — all ignored
            'role' => User::ROLE_SUPER_ADMIN, 'created_by' => $owner->id, 'is_protected' => 1,
        ])->assertRedirect();

        $emp = User::where('email', 'emp@client.bd')->firstOrFail();
        $this->assertSame(User::ROLE_ADMIN, $emp->role);
        $this->assertSame($himel->id, $emp->created_by);
        $this->assertFalse($emp->is_protected);
        // "full" was capped to what Himel holds
        $this->assertTrue($emp->hasPermission('orders.view'));
        $this->assertTrue($emp->hasPermission('team.create'));
        $this->assertFalse($emp->hasPermission('orders.delete'));
        $this->assertFalse($emp->hasPermission('products.view'));
    }

    public function test_owner_provisioned_admin_carries_no_creator_link(): void
    {
        $this->actingAs($this->owner())->post(route('admin.admins.store'), [
            'name' => 'Client', 'email' => 'client@shop.bd', 'password' => 'secret123', 'preset' => 'full',
        ])->assertRedirect();

        $client = User::where('email', 'client@shop.bd')->firstOrFail();
        $this->assertNull($client->created_by);
        $this->assertTrue($client->hasPermission('products.delete'));
    }

    public function test_client_admin_cannot_reach_the_owner_account(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();

        $this->actingAs($himel)->get(route('admin.admins.edit', $owner))->assertNotFound();
        $this->actingAs($himel)->put(route('admin.admins.update', $owner), [
            'name' => 'Hacked', 'email' => 'hacked@x.bd',
        ])->assertNotFound();
        $this->actingAs($himel)->post(route('admin.admins.password', $owner), ['password' => 'newpass99'])->assertNotFound();
        $this->actingAs($himel)->post(route('admin.admins.toggle', $owner))->assertNotFound();
        $this->actingAs($himel)->delete(route('admin.admins.destroy', $owner))->assertNotFound();

        $owner->refresh();
        $this->assertSame(User::PLATFORM_OWNER_EMAIL, $owner->email);
        $this->assertTrue($owner->is_active);
    }

    public function test_client_admin_cannot_touch_another_clients_team(): void
    {
        $himel = $this->himel();
        $karim = $this->admin('karim@other.bd', ['team' => ['*']]);
        $karimStaff = $this->admin('kstaff@other.bd', ['orders' => ['view']], $karim);

        $this->actingAs($himel)->get(route('admin.admins.edit', $karim))->assertNotFound();
        $this->actingAs($himel)->get(route('admin.admins.edit', $karimStaff))->assertNotFound();
        $this->actingAs($himel)->delete(route('admin.admins.destroy', $karimStaff))->assertNotFound();

        $this->assertDatabaseHas('users', ['id' => $karimStaff->id]);
    }

    public function test_client_admin_cannot_escalate_through_his_own_account(): void
    {
        $himel = $this->himel();

        $this->actingAs($himel)->get(route('admin.admins.edit', $himel))->assertNotFound();
        $this->actingAs($himel)->put(route('admin.admins.update', $himel), [
            'name' => 'Himel', 'email' => 'himel@client.bd',
            'permissions' => ['products' => ['view', 'create', 'edit', 'delete']],
        ])->assertNotFound();

        $this->assertFalse($himel->fresh()->hasPermission('products.view'));
    }

    public function test_client_admin_cannot_grant_more_than_he_holds(): void
    {
        $himel = $this->himel();
        $emp = $this->admin('emp@client.bd', ['orders' => ['view']], $himel);

        $this->actingAs($himel)->put(route('admin.admins.update', $emp), [
            'name' => 'Emp', 'email' => 'emp@client.bd',
            'permissions' => [
                'orders' => ['view', 'delete'],                       // delete: Himel lacks it
                'products' => ['view', 'create', 'edit', 'delete'],   // whole module Himel lacks
            ],
        ])->assertRedirect(route('admin.admins.index'));

        $emp->refresh();
        $this->assertTrue($emp->hasPermission('orders.view'));
        $this->assertFalse($emp->hasPermission('orders.delete'));
        $this->assertFalse($emp->hasPermission('products.view'));
    }

    public function test_owner_cannot_lift_an_employee_above_their_creator(): void
    {
        $owner = $this->owner();
        $himel = $this->himel(); // team.* + orders.view
        $emp = $this->admin('emp@client.bd', ['orders' => ['view']], $himel);

        // the owner's matrix for Himel's employee offers only what Himel holds
        $this->actingAs($owner)->get(route('admin.admins.edit', $emp))->assertOk()
            ->assertSee('name="permissions[orders][]"', false)
            ->assertDontSee('name="permissions[products][]"', false);

        $this->actingAs($owner)->put(route('admin.admins.update', $emp), [
            'name' => 'Emp', 'email' => 'emp@client.bd',
            'permissions' => ['orders' => ['view', 'delete'], 'products' => ['view', 'edit']],
        ])->assertRedirect();

        $emp->refresh();
        $this->assertTrue($emp->hasPermission('orders.view'));
        $this->assertFalse($emp->hasPermission('orders.delete'));
        $this->assertFalse($emp->hasPermission('products.view'));

        // an account the owner provisioned is still the owner's to shape freely
        $this->actingAs($owner)->put(route('admin.admins.update', $himel), [
            'name' => 'Himel', 'email' => 'himel@client.bd',
            'permissions' => ['products' => ['*'], 'team' => ['*']],
        ])->assertRedirect();
        $this->assertTrue($himel->fresh()->hasPermission('products.delete'));
    }

    public function test_hidden_and_missing_accounts_answer_the_same(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();
        $rahim = $this->admin('rahim@client.bd', ['orders' => ['view']]); // no team grant
        $missing = '/admin/admin-management/' . ($owner->id + 999) . '/edit';

        // with team access: the owner's account and a missing one are the same plain 404
        $hidden = $this->actingAs($himel)->getJson(route('admin.admins.edit', $owner))->assertNotFound();
        $absent = $this->actingAs($himel)->getJson($missing)->assertNotFound();
        $this->assertSame($hidden->json('message'), $absent->json('message'));

        // without it: the same 403 whether the account exists or not
        $this->actingAs($rahim)->get(route('admin.admins.edit', $owner))->assertForbidden();
        $this->actingAs($rahim)->get($missing)->assertForbidden();
    }

    public function test_shrinking_a_creator_shrinks_their_team(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();
        $emp = $this->admin('emp@client.bd', ['orders' => ['view'], 'team' => ['view']], $himel);

        // the owner takes "orders" away from Himel
        $this->actingAs($owner)->put(route('admin.admins.update', $himel), [
            'name' => 'Himel', 'email' => 'himel@client.bd',
            'permissions' => ['team' => self::TEAM_ALL],
        ])->assertRedirect();

        $emp->refresh();
        $this->assertFalse($emp->hasPermission('orders.view'));
        $this->assertTrue($emp->hasPermission('team.view'));
    }

    public function test_nested_team_is_visible_and_moves_up_when_its_creator_is_removed(): void
    {
        $himel = $this->himel();
        $lead = $this->admin('lead@client.bd', ['team' => ['*'], 'orders' => ['view']], $himel);
        $junior = $this->admin('junior@client.bd', ['orders' => ['view']], $lead);

        $this->actingAs($himel)->get(route('admin.admins.index'))->assertOk()->assertSee('junior@client.bd');
        $this->actingAs($himel)->get(route('admin.admins.edit', $junior))->assertOk();

        $this->actingAs($himel)->delete(route('admin.admins.destroy', $lead))->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $lead->id]);
        $this->assertSame($himel->id, $junior->fresh()->created_by);
    }

    public function test_delete_lock_is_owner_only(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();
        $emp = $this->admin('emp@client.bd', ['orders' => ['view']], $himel);

        // to a client admin the lock control doesn't exist
        $this->actingAs($himel)->post(route('admin.admins.protect', $emp))->assertNotFound();

        $this->actingAs($owner)->post(route('admin.admins.protect', $emp))->assertRedirect();
        $this->assertTrue($emp->fresh()->is_protected);

        $this->actingAs($himel)->delete(route('admin.admins.destroy', $emp))->assertSessionHasErrors('admin');
        $this->assertDatabaseHas('users', ['id' => $emp->id]);

        // another super admin is not the owner either
        $other = User::create([
            'name' => 'Other Super', 'email' => 'other@super.bd', 'password' => 'secret123',
            'role' => User::ROLE_SUPER_ADMIN, 'is_active' => true,
        ]);
        $this->actingAs($other)->delete(route('admin.admins.destroy', $emp))->assertSessionHasErrors('admin');
        $this->assertDatabaseHas('users', ['id' => $emp->id]);

        $this->actingAs($owner)->delete(route('admin.admins.destroy', $emp))->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $emp->id]);
    }

    public function test_profile_save_keeps_permissions_and_an_empty_matrix_clears_them(): void
    {
        $owner = $this->owner();
        $client = $this->admin('client@shop.bd', ['orders' => ['view']]);

        // profile-only form (no permissions, no matrix marker) must not wipe grants
        $this->actingAs($owner)->put(route('admin.admins.update', $client), [
            'name' => 'Renamed', 'email' => 'client@shop.bd',
        ])->assertRedirect();
        $this->assertTrue($client->fresh()->hasPermission('orders.view'));

        // an all-unchecked matrix save clears them
        $this->actingAs($owner)->put(route('admin.admins.update', $client), [
            'name' => 'Renamed', 'email' => 'client@shop.bd', 'matrix' => 1,
        ])->assertRedirect();
        $this->assertFalse($client->fresh()->hasPermission('orders.view'));
    }

    public function test_full_access_admins_get_team_management_on_upgrade(): void
    {
        $others = array_values(array_diff(array_keys(config('permissions.modules')), ['team']));
        $full = $this->admin('full@client.bd', array_fill_keys($others, ['*']));
        $partial = $this->admin('partial@client.bd', ['orders' => ['*']]);

        (require database_path('migrations/2024_01_18_000200_grant_team_to_full_access_admins.php'))->up();

        $this->assertTrue($full->fresh()->hasPermission('team.create'));
        $this->assertFalse($partial->fresh()->hasPermission('team.view'));
    }

    public function test_legacy_and_spelled_out_full_access_keep_full_access(): void
    {
        // the oldest "all sections" shape: a flat list with the pre-rename keys
        $legacy = $this->admin('legacy@client.bd', array_keys(User::PERMISSIONS));
        $this->assertTrue($legacy->hasPermission('brand_settings.edit'));
        $this->assertTrue($legacy->hasPermission('team.create'));

        // the same list without the old 'admins' key — upgraded through the rename map
        $noAdmins = $this->admin('noadmins@client.bd', array_values(array_diff(array_keys(User::PERMISSIONS), ['admins'])));

        // every module but team, one of them spelled out feature by feature
        $modules = config('permissions.modules');
        $perms = array_fill_keys(array_diff(array_keys($modules), ['team']), ['*']);
        $perms['orders'] = array_keys($modules['orders']['features']);
        $spelled = $this->admin('spelled@client.bd', $perms);

        (require database_path('migrations/2024_01_18_000200_grant_team_to_full_access_admins.php'))->up();

        $this->assertTrue($noAdmins->fresh()->hasPermission('team.create'));
        $this->assertTrue($noAdmins->fresh()->hasPermission('brand_settings.edit'));
        $this->assertTrue($spelled->fresh()->hasPermission('team.create'));
    }

    public function test_account_names_render_as_text_not_code(): void
    {
        $owner = $this->owner();
        $himel = $this->himel();
        $this->admin('evil@client.bd', ['orders' => ['view']], $himel)
            ->forceFill(['name' => '\'); alert(1); (\'<script>x</script>'])->save();

        $html = $this->actingAs($owner)->get(route('admin.admins.index'))->assertOk()->getContent();

        $this->assertStringNotContainsString('<script>x</script>', $html);
        $this->assertStringNotContainsString("swConfirmSubmit(event, '", $html);
    }
}
