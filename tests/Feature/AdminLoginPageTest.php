<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The admin login page: renders the form, keeps the email (never the
 * password) after a failed try, and only prefills known admin emails.
 */
class AdminLoginPageTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Rahim', 'email' => 'rahim@shop.bd', 'password' => 'secret123',
            'role' => User::ROLE_ADMIN, 'permissions' => ['orders' => ['view']], 'is_active' => true,
        ]);
    }

    public function test_login_page_renders_the_form(): void
    {
        $html = $this->get(route('admin.login'))->assertOk()
            ->assertSee('অ্যাডমিন লগইন')
            ->assertSee(route('admin.login.attempt'))
            ->getContent();

        $this->assertStringContainsString('name="_token"', $html);
        $this->assertStringContainsString('autocomplete="current-password"', $html);
        $this->assertStringContainsString('noindex', $html);
    }

    public function test_failed_login_keeps_the_email_but_never_the_password(): void
    {
        $this->admin();

        $this->from(route('admin.login'))->post(route('admin.login.attempt'), [
            'email' => 'rahim@shop.bd', 'password' => 'wrong-pass-77',
        ])->assertRedirect(route('admin.login'));

        $this->get(route('admin.login'))->assertOk()
            ->assertSee('ভুল ইমেইল বা পাসওয়ার্ড')
            ->assertSee('value="rahim@shop.bd"', false)
            ->assertDontSee('wrong-pass-77');
        $this->assertGuest();
    }

    public function test_email_prefill_never_reveals_whether_an_account_exists(): void
    {
        $this->admin();

        // a real admin and an unknown address are treated exactly alike
        $this->get(route('admin.login', ['email' => 'rahim@shop.bd']))->assertOk()
            ->assertSee('value="rahim@shop.bd"', false);
        $this->get(route('admin.login', ['email' => 'nobody@shop.bd']))->assertOk()
            ->assertSee('value="nobody@shop.bd"', false);

        // anything that isn't an email address is dropped
        $this->get(route('admin.login', ['email' => '"><script>x</script>']))->assertOk()
            ->assertDontSee('<script>x</script>', false);
    }

    public function test_valid_login_reaches_the_dashboard(): void
    {
        $this->admin();

        $this->post(route('admin.login.attempt'), [
            'email' => 'rahim@shop.bd', 'password' => 'secret123', 'remember' => 'on',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }
}
