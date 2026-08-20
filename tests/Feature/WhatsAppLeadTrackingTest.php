<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use App\Models\WhatsAppLeadClick;
use App\Services\SettingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsAppLeadTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected SettingService $settingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@apexcorporate.test',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->settingService = app(SettingService::class);
        $this->settingService->set('whatsapp_number', '+1 (555) 019-2834', 'contact');
        $this->settingService->set('whatsapp_default_message', 'Default corporate inquiry message.', 'contact');
    }

    public function test_public_api_tracks_lead_click_and_anonymizes_ip(): void
    {
        $payload = [
            'source_page' => '/services/enterprise-digital-modernization',
            'button_location' => 'service_detail_cta',
            'prefilled_message' => 'I am interested in Enterprise Modernization services.',
            'referrer' => 'https://google.com/search',
            'country' => 'US',
        ];

        $response = $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.42'])
            ->postJson(route('api.whatsapp.track'), $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'lead_id',
                'whatsapp_url',
            ]);

        $this->assertDatabaseHas('whatsapp_lead_clicks', [
            'source_page' => '/services/enterprise-digital-modernization',
            'button_location' => 'service_detail_cta',
            'prefilled_message' => 'I am interested in Enterprise Modernization services.',
            'ip_address' => '198.51.100.0', // Last octet masked
            'country' => 'US',
        ]);

        $responseData = $response->json();
        $this->assertStringContainsString('https://wa.me/15550192834', $responseData['whatsapp_url']);
        $this->assertStringContainsString(rawurlencode('I am interested in Enterprise Modernization services.'), $responseData['whatsapp_url']);
    }

    public function test_public_api_uses_default_message_and_number_if_not_specified(): void
    {
        $response = $this->postJson(route('api.whatsapp.track'), []);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $lead = WhatsAppLeadClick::latest('id')->first();
        $this->assertNotNull($lead);
        $this->assertEquals('Default corporate inquiry message.', $lead->prefilled_message);
        $this->assertEquals('general_cta', $lead->button_location);
    }

    public function test_whatsapp_redirect_endpoint_logs_lead_and_redirects(): void
    {
        $response = $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.19'])
            ->get(route('whatsapp.redirect', [
                'button_location' => 'hero_cta',
                'message' => 'Executive Consultation Request',
                'source_page' => '/home',
            ]));

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');
        $this->assertStringContainsString('https://wa.me/15550192834', $targetUrl);
        $this->assertStringContainsString(rawurlencode('Executive Consultation Request'), $targetUrl);

        $this->assertDatabaseHas('whatsapp_lead_clicks', [
            'button_location' => 'hero_cta',
            'prefilled_message' => 'Executive Consultation Request',
            'ip_address' => '203.0.113.0',
            'source_page' => '/home',
        ]);
    }

    public function test_guest_is_redirected_away_from_admin_leads_dashboard(): void
    {
        $this->get(route('admin.leads.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.leads.export'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_leads_dashboard_with_telemetry_metrics(): void
    {
        // Seed leads
        WhatsAppLeadClick::create([
            'source_page' => '/pricing',
            'button_location' => 'pricing_tier_growth',
            'prefilled_message' => 'Growth plan inquiry',
            'ip_address' => '10.0.0.0',
            'created_at' => Carbon::now(),
        ]);

        WhatsAppLeadClick::create([
            'source_page' => '/',
            'button_location' => 'floating_widget',
            'prefilled_message' => 'Strategy session request',
            'ip_address' => '10.0.0.0',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.leads.index'));

        $response->assertOk()
            ->assertViewIs('admin.leads.index')
            ->assertViewHasAll([
                'leads',
                'totalClicks',
                'todayClicks',
                'thisWeekClicks',
                'thisMonthClicks',
                'locationBreakdown',
                'dailyTrends',
            ])
            ->assertSee('WhatsApp CRM Leads', false)
            ->assertSee('Growth plan inquiry')
            ->assertSee('Strategy session request');
    }

    public function test_admin_can_filter_leads_by_button_location_and_search(): void
    {
        $leadA = WhatsAppLeadClick::create([
            'source_page' => '/services/modernization',
            'button_location' => 'service_modernization_cta',
            'prefilled_message' => 'Target Alpha Message',
            'ip_address' => '1.2.3.0',
        ]);

        $leadB = WhatsAppLeadClick::create([
            'source_page' => '/pricing',
            'button_location' => 'pricing_enterprise_cta',
            'prefilled_message' => 'Target Beta Message',
            'ip_address' => '4.5.6.0',
        ]);

        // Filter by location
        $responseLocation = $this->actingAs($this->admin)->get(route('admin.leads.index', [
            'button_location' => 'service_modernization_cta',
        ]));

        $responseLocation->assertOk()
            ->assertSee('Target Alpha Message')
            ->assertDontSee('Target Beta Message');

        // Search by keyword
        $responseSearch = $this->actingAs($this->admin)->get(route('admin.leads.index', [
            'search' => 'Beta',
        ]));

        $responseSearch->assertOk()
            ->assertSee('Target Beta Message')
            ->assertDontSee('Target Alpha Message');
    }

    public function test_admin_can_export_leads_to_csv(): void
    {
        WhatsAppLeadClick::create([
            'source_page' => '/case-studies',
            'button_location' => 'case_study_cta',
            'prefilled_message' => 'Case study inquiry for export test',
            'ip_address' => '192.0.2.0',
            'referrer' => 'https://linkedin.com',
            'country' => 'US',
            'user_agent' => 'Mozilla/5.0 TestBrowser',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.leads.export'));

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));

        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

        $this->assertStringContainsString('Button Location', $content);
        $this->assertStringContainsString('Prefilled Message', $content);
        $this->assertStringContainsString('case_study_cta', $content);
        $this->assertStringContainsString('Case study inquiry for export test', $content);
    }

    public function test_admin_can_delete_lead_and_audit_trail_is_recorded(): void
    {
        $lead = WhatsAppLeadClick::create([
            'source_page' => '/contact',
            'button_location' => 'contact_page_cta',
            'prefilled_message' => 'Lead to be deleted',
            'ip_address' => '10.0.0.0',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.leads.destroy', $lead));

        $response->assertRedirect(route('admin.leads.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('whatsapp_lead_clicks', [
            'id' => $lead->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'delete_whatsapp_lead_click',
            'auditable_type' => WhatsAppLeadClick::class,
            'auditable_id' => $lead->id,
            'user_id' => $this->admin->id,
        ]);
    }
}
