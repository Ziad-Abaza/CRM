<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AdminAuthAndSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear(RateLimiter::class);
    }

    public function test_security_headers_are_present_in_responses(): void
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->assertHeader('Content-Security-Policy');
    }

    public function test_login_page_renders_successfully_with_corporate_branding(): void
    {
        $settingService = app(SettingService::class);
        $settingService->set('company_name', 'Acme MegaCorp');

        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertSee('Acme MegaCorp');
        $response->assertSee('Enterprise CRM Administration Portal');
        $response->assertSee('Sign in to Admin');
    }

    public function test_active_admin_can_login_successfully_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'auth.login.success',
        ]);
    }

    public function test_inactive_admin_cannot_login(): void
    {
        $admin = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'is_active' => false,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'auth.login.denied_role_or_inactive',
        ]);
    }

    public function test_non_admin_role_cannot_login_to_admin_portal(): void
    {
        $user = User::factory()->create([
            'email' => 'staff@example.com',
            'password' => bcrypt('password123'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'staff@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'auth.login.denied_role_or_inactive',
        ]);
    }

    public function test_invalid_credentials_fail_and_log_failed_attempt(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'auth.login.failed',
        ]);
    }

    public function test_login_rate_limiter_throttles_after_five_failed_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.submit'), [
                'email' => 'bruteforce@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // 6th attempt should be throttled
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'bruteforce@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'auth.login.throttled',
        ]);
    }

    public function test_unauthenticated_user_cannot_access_protected_admin_routes(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_unauthenticated_api_request_to_admin_route_returns_401(): void
    {
        $response = $this->getJson(route('admin.dashboard'));

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_authenticated_admin_can_access_protected_admin_routes(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('System Performance');
    }

    public function test_admin_can_logout_and_audit_log_is_recorded(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'action' => 'auth.logout',
        ]);
    }
}
