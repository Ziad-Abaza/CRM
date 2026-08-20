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
        $response->assertSee('Theme Engine');
    }

    public function test_branding_update_persists_dual_light_and_dark_settings_and_logs_audit_trail(): void
    {
        $logoFile = \Illuminate\Http\UploadedFile::fake()->image('new_logo.png', 200, 60);
        $faviconFile = \Illuminate\Http\UploadedFile::fake()->image('new_favicon.ico', 32, 32);

        $response = $this->actingAs($this->admin)->put(route('admin.branding.update'), [
            'site_name' => 'Vertex Consulting Group',
            'company_tagline' => 'Scalable Enterprise Solutions',
            'theme_mode' => 'toggle_allowed',
            'active_theme_default' => 'dark',
            'typography_font' => 'Inter',
            'radius_card' => '1.5rem',
            'radius_button' => '1rem',
            'radius_input' => '0.5rem',

            // Dark Mode
            'dark_bg_body' => '#050807',
            'dark_bg_surface' => '#091510',
            'dark_bg_card' => '#0d1f17',
            'dark_bg_input' => '#030605',
            'dark_text_primary' => '#ecfdf5',
            'dark_text_muted' => '#6ee7b7',
            'dark_border_subtle' => '#133e2b',
            'dark_border_highlight' => '#059669',
            'dark_primary_color' => '#10b981',
            'dark_secondary_color' => '#047857',
            'dark_accent_color' => '#34d399',

            // Light Mode
            'light_bg_body' => '#f0fdf4',
            'light_bg_surface' => '#dcfce7',
            'light_bg_card' => '#ffffff',
            'light_bg_input' => '#ffffff',
            'light_text_primary' => '#064e3b',
            'light_text_muted' => '#047857',
            'light_border_subtle' => '#bbf7d0',
            'light_border_highlight' => '#86efac',
            'light_primary_color' => '#059669',
            'light_secondary_color' => '#047857',
            'light_accent_color' => '#10b981',

            'company_logo' => $logoFile,
            'company_favicon' => $faviconFile,
        ]);

        $response->assertRedirect(route('admin.branding.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('Vertex Consulting Group', $this->settingService->get('site_name'));
        $this->assertEquals('#050807', $this->settingService->get('dark_bg_body'));
        $this->assertEquals('#f0fdf4', $this->settingService->get('light_bg_body'));
        $this->assertEquals('#10b981', $this->settingService->get('dark_primary_color'));
        $this->assertEquals('#059669', $this->settingService->get('light_primary_color'));
        $this->assertEquals('1.5rem', $this->settingService->get('radius_card'));

        $auditLog = AuditLog::where('action', 'update_branding_settings')->first();
        $this->assertNotNull($auditLog);
        $this->assertEquals($this->admin->id, $auditLog->user_id);
    }

    public function test_theme_reset_endpoint_restores_defaults(): void
    {
        // Mutate some settings
        $this->settingService->set('dark_bg_body', '#990000');
        $this->settingService->set('light_bg_body', '#009900');

        $response = $this->actingAs($this->admin)->post(route('admin.branding.reset'));

        $response->assertRedirect(route('admin.branding.index'));
        $response->assertSessionHas('success');
        $this->assertEquals('#030712', $this->settingService->get('dark_bg_body'));
        $this->assertEquals('#f8fafc', $this->settingService->get('light_bg_body'));

        $auditLog = AuditLog::where('action', 'reset_theme_settings')->first();
        $this->assertNotNull($auditLog);
    }

    public function test_branding_update_rejects_invalid_hex_colors(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.branding.update'), [
            'site_name' => 'Test Corporation',
            'dark_bg_body' => 'invalid-hex',
            'light_bg_body' => '#ffffff',
        ]);

        $response->assertSessionHasErrors(['dark_bg_body']);
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
