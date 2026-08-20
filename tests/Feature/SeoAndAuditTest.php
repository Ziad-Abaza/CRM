<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoAndAuditTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@corporate.test',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_sitemap_xml_returns_valid_xml_with_dynamic_routes(): void
    {
        $service = Service::create([
            'title' => 'Cloud Migration',
            'slug' => 'cloud-migration',
            'short_description' => 'Migrate workloads seamlessly.',
            'is_active' => true,
        ]);

        $inactiveService = Service::create([
            'title' => 'Deprecated Service',
            'slug' => 'deprecated-service',
            'short_description' => 'No longer provided.',
            'is_active' => false,
        ]);

        $category = PortfolioCategory::create([
            'name' => 'Fintech',
            'slug' => 'fintech',
        ]);

        $portfolio = Portfolio::create([
            'category_id' => $category->id,
            'title' => 'Global Bank Transformation',
            'slug' => 'global-bank-transformation',
            'client_name' => 'Apex Bank',
            'description' => 'Full digital overhaul.',
            'is_active' => true,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        
        $content = $response->getContent();
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertStringContainsString(url('/'), $content);
        $this->assertStringContainsString(route('service.detail', $service->slug), $content);
        $this->assertStringContainsString(route('portfolio.detail', $portfolio->slug), $content);
        
        // Inactive items must not be indexed
        $this->assertStringNotContainsString('deprecated-service', $content);
    }

    public function test_robots_txt_returns_proper_directives_and_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        
        $content = $response->getContent();
        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Allow: /', $content);
        $this->assertStringContainsString('Disallow: /admin/', $content);
        $this->assertStringContainsString('Disallow: /api/', $content);
        $this->assertStringContainsString('Disallow: /whatsapp/redirect', $content);
        $this->assertStringContainsString('Sitemap: ' . url('/sitemap.xml'), $content);
    }

    public function test_public_layout_renders_schema_org_and_opengraph_tags(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('"@type": "Organization"', false);
        $response->assertSee('"@type": "WebSite"', false);
        $response->assertSee('property="og:type"', false);
        $response->assertSee('name="twitter:card"', false);
        $response->assertSee('rel="canonical"', false);
    }

    public function test_unauthenticated_user_cannot_access_audit_logs(): void
    {
        $response = $this->get('/admin/audit-logs');
        $response->assertRedirect('/admin/login');

        $exportResponse = $this->get('/admin/audit-logs/export');
        $exportResponse->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_audit_logs_explorer_and_filter_records(): void
    {
        AuditLog::create([
            'user_id' => $this->admin->id,
            'action' => 'created',
            'auditable_type' => Service::class,
            'auditable_id' => 10,
            'old_values' => null,
            'new_values' => ['title' => 'New AI Architecture'],
            'ip_address' => '192.168.1.100',
            'user_agent' => 'PHPUnit Browser Agent',
        ]);

        AuditLog::create([
            'user_id' => $this->admin->id,
            'action' => 'deleted',
            'auditable_type' => Portfolio::class,
            'auditable_id' => 25,
            'old_values' => ['title' => 'Old Project'],
            'new_values' => null,
            'ip_address' => '10.0.0.1',
            'user_agent' => 'PHPUnit Browser Agent',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/audit-logs');
        $response->assertStatus(200);
        $response->assertSee('System Audit & Security Logs', false);
        $response->assertSee('created');
        $response->assertSee('deleted');
        $response->assertSee('Service');
        $response->assertSee('Portfolio');
        $response->assertSee('192.168.1.100');

        // Test Filter by Action
        $filterResponse = $this->actingAs($this->admin)->get('/admin/audit-logs?action=created');
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('192.168.1.100');
        $filterResponse->assertDontSee('10.0.0.1');

        // Test Filter by Search Keyword
        $searchResponse = $this->actingAs($this->admin)->get('/admin/audit-logs?search=10.0.0.1');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('10.0.0.1');
        $searchResponse->assertDontSee('192.168.1.100');
    }

    public function test_admin_can_export_audit_logs_as_csv(): void
    {
        AuditLog::create([
            'user_id' => $this->admin->id,
            'action' => 'updated',
            'auditable_type' => Service::class,
            'auditable_id' => 12,
            'old_values' => ['title' => 'Old Title'],
            'new_values' => ['title' => 'New Title'],
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 Test',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/audit-logs/export');

        $response->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment; filename=', (string)$response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('audit-logs-', (string)$response->headers->get('Content-Disposition'));

        $content = $response->streamedContent();
        $this->assertStringContainsString('User Name', $content);
        $this->assertStringContainsString('UPDATED', $content);
        $this->assertStringContainsString('Service', $content);
        $this->assertStringContainsString('admin@corporate.test', $content);
    }
}
