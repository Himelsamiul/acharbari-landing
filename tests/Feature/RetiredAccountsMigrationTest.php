<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The deploy removes the retired showcase demo admins and the seeded sample
 * manager — and nothing else: look-alike real accounts, customers and
 * delete-locked rows stay.
 */
class RetiredAccountsMigrationTest extends TestCase
{
    use RefreshDatabase;

    private function account(string $email, string $role, ?string $industry = null, bool $protected = false): User
    {
        $user = User::create([
            'name' => strtok($email, '@'), 'email' => $email, 'password' => 'secret123',
            'role' => $role, 'permissions' => $role === User::ROLE_ADMIN ? ['orders' => ['view']] : null,
            'is_active' => true, 'is_protected' => $protected,
        ]);
        $user->forceFill(['industry' => $industry])->save(); // how the old showcase tagged its demo admins

        return $user;
    }

    private function migrate(string $file): void
    {
        (require database_path("migrations/$file"))->up();
    }

    public function test_only_generated_showcase_admins_are_removed(): void
    {
        $demo = $this->account('demo.fashion@khorak.shop', User::ROLE_ADMIN, 'fashion');
        $lookAlike = $this->account('demo.sales@khorak.shop', User::ROLE_ADMIN);
        $customer = $this->account('demo.buyer@khorak.shop', User::ROLE_CUSTOMER);
        $locked = $this->account('demo.beauty@khorak.shop', User::ROLE_ADMIN, 'beauty', true);
        DB::table('sessions')->insert(['id' => 'demo-session', 'user_id' => $demo->id, 'payload' => '', 'last_activity' => time()]);

        $this->migrate('2024_01_17_000100_remove_demo_showcase_admins.php');

        $this->assertDatabaseMissing('users', ['id' => $demo->id]);
        $this->assertDatabaseMissing('sessions', ['id' => 'demo-session']);
        foreach ([$lookAlike, $customer, $locked] as $kept) {
            $this->assertDatabaseHas('users', ['id' => $kept->id]);
        }
    }

    public function test_seeded_manager_is_removed_unless_delete_locked(): void
    {
        $manager = $this->account('manager@khorak.shop', User::ROLE_ADMIN);
        $this->migrate('2024_01_17_000200_remove_seeded_manager_admin.php');
        $this->assertDatabaseMissing('users', ['id' => $manager->id]);

        $locked = $this->account('manager@khorak.shop', User::ROLE_ADMIN, null, true);
        $this->migrate('2024_01_17_000200_remove_seeded_manager_admin.php');
        $this->assertDatabaseHas('users', ['id' => $locked->id]);
    }

    public function test_a_retired_demo_login_is_turned_away_before_the_migration_runs(): void
    {
        $demo = $this->account('demo.fashion@khorak.shop', User::ROLE_ADMIN, 'fashion');
        $this->actingAs($demo)->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
        $this->assertGuest();

        // a real admin with a look-alike address is not affected
        $real = $this->account('demo.sales@khorak.shop', User::ROLE_ADMIN);
        $this->actingAs($real)->get(route('admin.dashboard'))->assertOk();
    }
}
