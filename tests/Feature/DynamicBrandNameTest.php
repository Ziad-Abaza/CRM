<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\User;
use App\Services\SettingService;
use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicBrandNameTest extends TestCase
{
    use RefreshDatabase;

    protected SettingService $settingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultCompanySeeder::class);
        $this->settingService = app(SettingService::class);
    }

    public function test_app_name_helper_falls_back_to_config_when_setting_is_null(): void
    {
        config(['app.name' => 'Aegis']);
        $this->settingService->set('site_name', null, 'branding');

        $this->assertSame('Aegis', app_name('en'));
        $this->assertSame('Aegis', app_name('ar'));
    }

    public function test_app_name_helper_returns_localized_setting_value(): void
    {
        $this->settingService->set('site_name', [
            'en' => 'Aegis Enterprise Solutions',
            'ar' => 'إيجيس للحلول المؤسسية',
        ], 'branding', 'json');

        $this->assertSame('Aegis Enterprise Solutions', app_name('en'));
        $this->assertSame('إيجيس للحلول المؤسسية', app_name('ar'));
    }

    public function test_translation_t_helper_automatically_interpolates_brand_token(): void
    {
        $this->settingService->set('site_name', [
            'en' => 'Aegis Advisory',
            'ar' => 'استشارات إيجيس',
        ], 'branding', 'json');

        app()->setLocale('en');
        $this->assertStringContainsString('Aegis Advisory', t('frontend.hero.subtitle'));
        $this->assertStringContainsString('Aegis Advisory', t('frontend.about.why_apex'));
        $this->assertStringContainsString('Aegis Advisory', t('seo.default_title'));

        app()->setLocale('ar');
        $this->assertStringContainsString('استشارات إيجيس', t('frontend.hero.subtitle'));
        $this->assertStringContainsString('استشارات إيجيس', t('frontend.about.why_apex'));
    }

    public function test_changing_brand_name_immediately_updates_public_homepage_and_meta(): void
    {
        $this->settingService->set('site_name', [
            'en' => 'Aegis Global',
            'ar' => 'إيجيس العالمية',
        ], 'branding', 'json');

        $this->settingService->set('seo_meta_title', null, 'seo');

        // English Homepage
        $enResponse = $this->get('/en');
        $enResponse->assertOk()
            ->assertSee('Aegis Global')
            ->assertDontSee('Apex Corporate Solutions');

        // Arabic Homepage
        $arResponse = $this->get('/ar');
        $arResponse->assertOk()
            ->assertSee('إيجيس العالمية')
            ->assertDontSee('أبيكس للحلول المؤسسية');
    }

    public function test_service_and_portfolio_pages_reflect_dynamic_brand_name(): void
    {
        $this->settingService->set('site_name', [
            'en' => 'Aegis Dynamics',
            'ar' => 'إيجيس ديناميكس',
        ], 'branding', 'json');

        $service = Service::firstOrFail();
        $portfolio = Portfolio::firstOrFail();

        // English service detail
        $enService = $this->get('/en/services/' . $service->slug);
        $enService->assertOk()
            ->assertSee('Aegis Dynamics')
            ->assertDontSee('Apex Corporate Solutions');

        // Arabic service detail
        $arService = $this->get('/ar/services/' . $service->slug);
        $arService->assertOk()
            ->assertSee('إيجيس ديناميكس');

        // English portfolio detail
        $enPortfolio = $this->get('/en/portfolio/' . $portfolio->slug);
        $enPortfolio->assertOk()
            ->assertSee('Aegis Dynamics');
    }

    public function test_admin_portal_layout_reflects_dynamic_brand_name(): void
    {
        $this->settingService->set('site_name', [
            'en' => 'Aegis Corp',
            'ar' => 'شركة إيجيس',
        ], 'branding', 'json');

        $admin = User::first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertOk()
            ->assertSee('Aegis Corp')
            ->assertDontSee('Apex Corporate');
    }

    public function test_footer_about_and_copyright_render_dynamically(): void
    {
        $this->settingService->set('site_name', [
            'en' => 'Aegis Retainer Corp',
            'ar' => 'إيجيس للاستبقاء المؤسسي',
        ], 'branding', 'json');

        $this->settingService->set('footer_about', null, 'footer');
        $this->settingService->set('footer_copyright', null, 'footer');

        $enResponse = $this->get('/en');
        $enResponse->assertOk()
            ->assertSee('Aegis Retainer Corp');

        $arResponse = $this->get('/ar');
        $arResponse->assertOk()
            ->assertSee('إيجيس للاستبقاء المؤسسي');
    }
}
