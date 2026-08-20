<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBrandingAndContentTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected SettingService $settingService;

    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Storage::fake('public');

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->settingService = app(SettingService::class);
    }

    public function test_dashboard_displays_correct_metrics(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('System Performance');
    }

    public function test_branding_page_renders_with_current_settings(): void
    {
        $this->settingService->set('site_name', 'Aces Advisory Group');
        $response = $this->actingAs($this->admin)->get(route('admin.branding.index'));
        $response->assertOk();
        $response->assertSee('Aces Advisory Group');
    }

    public function test_branding_update_persists_settings_and_logs_audit_trail(): void
    {
        $logoFile = \Illuminate\Http\UploadedFile::fake()->image('new_logo.png', 200, 60);
        $faviconFile = \Illuminate\Http\UploadedFile::fake()->image('new_favicon.ico', 32, 32);

        $response = $this->actingAs($this->admin)->put(route('admin.branding.update'), [
            'site_name' => 'Vertex Consulting Group',
            'primary_color' => '#0b66b1',
            'secondary_color' => '#111827',
            'accent_color' => '#f59e0b',
            'typography_font' => 'Inter',
            'logo' => $logoFile,
            'favicon' => $faviconFile,
        ]);

        $response->assertRedirect(route('admin.branding.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('Vertex Consulting Group', $this->settingService->get('site_name'));
        $this->assertEquals('#0b66b1', $this->settingService->get('primary_color'));

        $auditLog = AuditLog::where('action', 'update_branding_settings')->first();
        $this->assertNotNull($auditLog);
        $this->assertEquals($this->admin->id, $auditLog->user_id);
    }

    public function test_branding_update_rejects_invalid_hex_colors(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.branding.update'), [
            'site_name' => 'Test Corporation',
            'primary_color' => 'invalid-hex',
            'secondary_color' => '#111827',
            'accent_color' => '#f59e0b',
            'typography_font' => 'Inter',
        ]);

        $response->assertSessionHasErrors(['primary_color']);
    }

    public function test_hero_section_update_and_audit_logging(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.content.hero.update'), [
            'hero_badge' => 'Premium Advisory 2026',
            'hero_title' => 'Transforming Global Enterprises',
            'hero_subtitle' => 'We provide strategic solutions for modern leaders.',
            'hero_cta_text' => 'Talk to an Expert',
            'hero_cta_whatsapp_message' => 'Hello, I would like an executive consultation.',
            'hero_rating_score' => '4.9/5.0',
            'hero_rating_count' => '300+ Enterprise Clients',
        ]);

        $response->assertRedirect(route('admin.content.hero'));
        $response->assertSessionHas('success');
        $this->assertEquals('Premium Advisory 2026', $this->settingService->get('hero_badge'));
        $this->assertEquals('update_hero_section', AuditLog::firstOrFail()->action);
    }

    public function test_about_section_update_and_audit_logging(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.content.about.update'), [
            'about_title' => 'Over 15 Years of Excellence',
            'about_description' => 'Our corporate journey has powered 500+ global expansions.',
            'about_bullet_1' => 'Strategic Pillar 1',
            'about_bullet_2' => 'Strategic Pillar 2',
            'about_bullet_3' => 'Strategic Pillar 3',
        ]);

        $response->assertRedirect(route('admin.content.about'));
        $response->assertSessionHas('success');
        $this->assertEquals('Over 15 Years of Excellence', $this->settingService->get('about_title'));
        $this->assertEquals('update_about_section', AuditLog::firstOrFail()->action);
    }

    public function test_contact_and_whatsapp_section_update_validates_international_phone(): void
    {
        $badResponse = $this->actingAs($this->admin)->put(route('admin.content.contact.update'), [
            'whatsapp_number' => 'invalid-number',
            'whatsapp_default_message' => 'Hello',
            'contact_email' => 'info@aces.com',
            'contact_phone' => '+1 555 555 5555',
            'contact_address' => '123 Financial St',
        ]);

        $badResponse->assertSessionHasErrors(['whatsapp_number']);

        $validResponse = $this->actingAs($this->admin)->put(route('admin.content.contact.update'), [
            'whatsapp_number' => '+97133445566',
            'whatsapp_default_message' => 'General inquiry',
            'contact_email' => 'headquarters@aces.com',
            'contact_phone' => '+971 50 000 0000',
            'contact_address' => 'Level 44, Al Saqr Tower',
        ]);

        $validResponse->assertRedirect(route('admin.content.contact'));
        $this->assertEquals('+97133445566', $this->settingService->get('whatsapp_number'));
    }

    public function test_seo_metadata_update_and_audit_logging(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.content.seo.update'), [
            'seo_meta_title' => 'Aces Advisory | Enterprise Transformation',
            'seo_meta_description' => 'Leading business consultancy specializing in acceleration.',
            'seo_meta_keywords' => 'consulting, advisory, finance',
        ]);

        $response->assertRedirect(route('admin.content.seo'));
        $response->assertSessionHas('success');
        $this->assertEquals('Aces Advisory | Enterprise Transformation', $this->settingService->get('seo_meta_title'));
    }

    public function test_footer_and_social_update_and_audit_logging(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.content.footer.update'), [
            'footer_about' => 'Global executive consultancy.',
            'footer_copyright' => '2026 Aces Corporation. All rights reserved.',
            'social_linkedin' => 'https://linkedin.com/company/aces',
            'social_twitter' => 'https://x.com/aces',
        ]);

        $response->assertRedirect(route('admin.content.footer'));
        $response->assertSessionHas('success');
        $this->assertEquals('Global executive consultancy.', $this->settingService->get('footer_about'));
    }
}
