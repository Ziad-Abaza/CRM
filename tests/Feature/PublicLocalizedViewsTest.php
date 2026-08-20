<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\Service;
use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLocalizedViewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultCompanySeeder::class);
    }

    public function test_en_homepage_renders_ltr_and_english_typography_and_seo(): void
    {
        $response = $this->get('/en');

        $response->assertOk()
            ->assertViewIs('public.home');

        $content = $response->getContent();

        // 1. HTML attributes: lang="en" and dir="ltr"
        $this->assertStringContainsString('lang="en"', $content);
        $this->assertStringContainsString('dir="ltr"', $content);

        // 2. Google Font: Plus Jakarta Sans
        $this->assertStringContainsString('Plus+Jakarta+Sans', $content);

        // 3. SEO & OpenGraph tags
        $this->assertStringContainsString('<meta property="og:locale" content="en_US">', $content);
        $this->assertStringContainsString('hreflang="en"', $content);
        $this->assertStringContainsString('hreflang="ar"', $content);
        $this->assertStringContainsString('hreflang="x-default"', $content);

        // 4. English Navigation
        $response->assertSee(__('ui.nav.services', [], 'en'))
            ->assertSee(__('ui.nav.case_studies', [], 'en'))
            ->assertSee(__('ui.nav.pricing', [], 'en'))
            ->assertSee(__('ui.nav.about', [], 'en'))
            ->assertSee(__('ui.nav.faqs', [], 'en'));

        // 5. English Hero Content
        $response->assertSee(setting('hero_badge', __('frontend.hero.badge', [], 'en'), 'en'))
            ->assertSee(setting('hero_title', __('frontend.hero.title', [], 'en'), 'en'));

        // 6. Language switcher to Arabic exists
        $this->assertStringContainsString(switch_locale_url('ar'), $content);
        $response->assertSee('العربية');
    }

    public function test_ar_homepage_renders_rtl_and_arabic_typography_and_seo(): void
    {
        $response = $this->get('/ar');

        $response->assertOk()
            ->assertViewIs('public.home');

        $content = $response->getContent();

        // 1. HTML attributes: lang="ar" and dir="rtl"
        $this->assertStringContainsString('lang="ar"', $content);
        $this->assertStringContainsString('dir="rtl"', $content);

        // 2. Google Font: Cairo
        $this->assertStringContainsString('Cairo', $content);

        // 3. SEO & OpenGraph tags
        $this->assertStringContainsString('<meta property="og:locale" content="ar_SA">', $content);
        $this->assertStringContainsString('hreflang="en"', $content);
        $this->assertStringContainsString('hreflang="ar"', $content);
        $this->assertStringContainsString('hreflang="x-default"', $content);

        // 4. Arabic Navigation
        $response->assertSee(__('ui.nav.services', [], 'ar'))
            ->assertSee(__('ui.nav.case_studies', [], 'ar'))
            ->assertSee(__('ui.nav.pricing', [], 'ar'))
            ->assertSee(__('ui.nav.about', [], 'ar'))
            ->assertSee(__('ui.nav.faqs', [], 'ar'));

        // 5. Arabic Hero Content
        $response->assertSee(setting('hero_badge', __('frontend.hero.badge', [], 'ar'), 'ar'))
            ->assertSee(setting('hero_title', __('frontend.hero.title', [], 'ar'), 'ar'));

        // 6. Language switcher to English exists
        $this->assertStringContainsString(switch_locale_url('en'), $content);
        $response->assertSee('English');
    }

    public function test_service_detail_page_renders_localized_content_and_attributes(): void
    {
        $service = Service::where('is_active', true)->firstOrFail();

        // EN Request
        $enResponse = $this->get('/en/services/' . $service->slug);
        $enResponse->assertOk()
            ->assertViewIs('public.service-detail');

        $enContent = $enResponse->getContent();
        $this->assertStringContainsString('dir="ltr"', $enContent);
        $this->assertStringContainsString('lang="en"', $enContent);
        $enResponse->assertSee($service->getTranslation('title', 'en'))
            ->assertSee(__('ui.nav.home', [], 'en'))
            ->assertSee(__('ui.nav.services', [], 'en'))
            ->assertSee(__('frontend.services.request_quote', [], 'en'));

        // AR Request
        $arResponse = $this->get('/ar/services/' . $service->slug);
        $arResponse->assertOk()
            ->assertViewIs('public.service-detail');

        $arContent = $arResponse->getContent();
        $this->assertStringContainsString('dir="rtl"', $arContent);
        $this->assertStringContainsString('lang="ar"', $arContent);
        $arResponse->assertSee($service->getTranslation('title', 'ar'))
            ->assertSee(__('ui.nav.home', [], 'ar'))
            ->assertSee(__('ui.nav.services', [], 'ar'))
            ->assertSee(__('frontend.services.request_quote', [], 'ar'));
    }

    public function test_portfolio_detail_page_renders_localized_content_and_attributes(): void
    {
        $portfolio = Portfolio::with('category')->where('is_active', true)->firstOrFail();

        // EN Request
        $enResponse = $this->get('/en/portfolio/' . $portfolio->slug);
        $enResponse->assertOk()
            ->assertViewIs('public.portfolio-detail');

        $enContent = $enResponse->getContent();
        $this->assertStringContainsString('dir="ltr"', $enContent);
        $this->assertStringContainsString('lang="en"', $enContent);
        $enResponse->assertSee($portfolio->getTranslation('title', 'en'))
            ->assertSee(__('ui.nav.home', [], 'en'))
            ->assertSee(__('ui.nav.case_studies', [], 'en'));

        // AR Request
        $arResponse = $this->get('/ar/portfolio/' . $portfolio->slug);
        $arResponse->assertOk()
            ->assertViewIs('public.portfolio-detail');

        $arContent = $arResponse->getContent();
        $this->assertStringContainsString('dir="rtl"', $arContent);
        $this->assertStringContainsString('lang="ar"', $arContent);
        $arResponse->assertSee($portfolio->getTranslation('title', 'ar'))
            ->assertSee(__('ui.nav.home', [], 'ar'))
            ->assertSee(__('ui.nav.case_studies', [], 'ar'));
    }

    public function test_language_switchers_present_in_desktop_mobile_and_footer(): void
    {
        $response = $this->get('/en');
        $response->assertOk();

        $content = $response->getContent();

        // Check language switch links to 'ar'
        $this->assertStringContainsString(switch_locale_url('ar'), $content);
        $response->assertSee('العربية');

        // Check footer has language switch link
        $this->assertStringContainsString('footer', strtolower($content));
    }

    public function test_whatsapp_widgets_are_localized_in_arabic(): void
    {
        $response = $this->get('/ar');
        $response->assertOk();

        // Arabic floating WhatsApp widget text
        $response->assertSee(__('frontend.whatsapp.chat_header_title', [], 'ar'))
            ->assertSee(__('frontend.hero.consult_cta', [], 'ar'));
    }
}
