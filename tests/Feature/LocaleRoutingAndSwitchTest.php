<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\Service;
use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleRoutingAndSwitchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultCompanySeeder::class);
    }

    public function test_root_url_redirects_to_default_locale_en(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/en');
    }

    public function test_root_url_redirects_to_locale_from_session(): void
    {
        $response = $this->withSession(['locale' => 'ar'])->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/ar');
    }

    public function test_root_url_redirects_to_locale_from_cookie(): void
    {
        $response = $this->withCookie('apex_locale', 'ar')->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/ar');
    }

    public function test_root_url_redirects_to_locale_from_accept_language_header(): void
    {
        $response = $this->withHeader('Accept-Language', 'ar,en-US;q=0.9,en;q=0.8')->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/ar');
    }

    public function test_en_and_ar_homepages_respond_with_200(): void
    {
        $enResponse = $this->get('/en');
        $enResponse->assertOk()
            ->assertViewIs('public.home');

        $arResponse = $this->get('/ar');
        $arResponse->assertOk()
            ->assertViewIs('public.home');
    }

    public function test_invalid_locale_returns_404(): void
    {
        $response = $this->get('/de');
        $response->assertNotFound();

        $responseWithSubpath = $this->get('/fr/services/enterprise-digital-modernization');
        $responseWithSubpath->assertNotFound();
    }

    public function test_service_detail_page_loads_for_all_supported_locales(): void
    {
        $service = Service::where('is_active', true)->firstOrFail();

        $enResponse = $this->get('/en/services/' . $service->slug);
        $enResponse->assertOk()
            ->assertViewIs('public.service-detail')
            ->assertSee($service->title);

        $arResponse = $this->get('/ar/services/' . $service->slug);
        $arResponse->assertOk()
            ->assertViewIs('public.service-detail')
            ->assertSee($service->title);
    }

    public function test_portfolio_detail_page_loads_for_all_supported_locales(): void
    {
        $portfolio = Portfolio::where('is_active', true)->firstOrFail();

        $enResponse = $this->get('/en/portfolio/' . $portfolio->slug);
        $enResponse->assertOk()
            ->assertViewIs('public.portfolio-detail')
            ->assertSee($portfolio->title);

        $arResponse = $this->get('/ar/portfolio/' . $portfolio->slug);
        $arResponse->assertOk()
            ->assertViewIs('public.portfolio-detail')
            ->assertSee($portfolio->title);
    }

    public function test_locale_switch_sets_session_and_cookie_and_redirects(): void
    {
        $response = $this->get('/locale/ar');

        $response->assertStatus(302);
        $response->assertRedirect('/ar');
        $response->assertSessionHas('locale', 'ar');
        $response->assertCookie('apex_locale', 'ar');
    }

    public function test_locale_switch_preserves_internal_referer_path_and_changes_locale_segment(): void
    {
        $service = Service::where('is_active', true)->firstOrFail();
        $referer = url('/en/services/' . $service->slug);

        $response = $this->from($referer)->get('/locale/ar');

        $response->assertStatus(302);
        $response->assertRedirect('/ar/services/' . $service->slug);
        $response->assertSessionHas('locale', 'ar');
        $response->assertCookie('apex_locale', 'ar');
    }

    public function test_locale_switch_with_invalid_locale_returns_404(): void
    {
        $response = $this->get('/locale/invalid-locale');

        $response->assertNotFound();
    }

    public function test_sitemap_xml_contains_all_supported_locales_for_pages(): void
    {
        $service = Service::where('is_active', true)->firstOrFail();
        $portfolio = Portfolio::where('is_active', true)->firstOrFail();

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');

        $content = $response->getContent();

        // Check homepages for en and ar
        $this->assertStringContainsString(url('/en'), $content);
        $this->assertStringContainsString(url('/ar'), $content);

        // Check service detail for en and ar
        $this->assertStringContainsString(url('/en/services/' . $service->slug), $content);
        $this->assertStringContainsString(url('/ar/services/' . $service->slug), $content);

        // Check portfolio detail for en and ar
        $this->assertStringContainsString(url('/en/portfolio/' . $portfolio->slug), $content);
        $this->assertStringContainsString(url('/ar/portfolio/' . $portfolio->slug), $content);
    }

    public function test_locale_switch_preserves_admin_referer_path(): void
    {
        $adminReferer = url('/admin/dashboard');

        $response = $this->from($adminReferer)->get('/locale/ar');

        $response->assertStatus(302);
        $response->assertRedirect($adminReferer);
        $response->assertSessionHas('locale', 'ar');
        $response->assertCookie('apex_locale', 'ar');
    }

    public function test_view_shares_locale_direction_and_rtl_status(): void
    {
        $enResponse = $this->get('/en');
        $enResponse->assertOk();
        $this->assertEquals('en', view()->shared('currentLocale'));
        $this->assertEquals('ltr', view()->shared('localeDirection'));
        $this->assertFalse(view()->shared('isRtl'));

        $arResponse = $this->get('/ar');
        $arResponse->assertOk();
        $this->assertEquals('ar', view()->shared('currentLocale'));
        $this->assertEquals('rtl', view()->shared('localeDirection'));
        $this->assertTrue(view()->shared('isRtl'));
    }

    public function test_inactive_service_with_locale_prefix_returns_404(): void
    {
        $service = Service::create([
            'title' => 'Secret Inactive Service',
            'slug' => 'secret-inactive-service',
            'short_description' => 'Draft',
            'description' => 'Draft description',
            'is_active' => false,
            'order' => 99,
        ]);

        $response = $this->get('/en/services/' . $service->slug);
        $response->assertNotFound();

        $arResponse = $this->get('/ar/services/' . $service->slug);
        $arResponse->assertNotFound();
    }
}
