<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\StatsCounter;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Services\SettingService;
use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFrontendTest extends TestCase
{
    use RefreshDatabase;

    protected SettingService $settingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultCompanySeeder::class);
        $this->settingService = app(SettingService::class);
    }

    public function test_homepage_loads_successfully_with_corporate_sections_and_200_status(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertViewIs('public.home')
            ->assertSee('Apex Corporate Solutions')
            ->assertSee('Accelerate Enterprise Scale with Predictable Precision')
            ->assertSee('Enterprise Digital Modernization')
            ->assertSee('Strategic Advisory')
            ->assertSee('Decades of Institutional Rigor in Modern Markets')
            ->assertSee('David Sterling')
            ->assertSee('Frequently Asked Questions')
            ->assertSee('Consult via WhatsApp');
    }

    public function test_dynamic_css_variables_and_google_fonts_are_injected_in_head(): void
    {
        $this->settingService->set('primary_color', '#112233', 'branding');
        $this->settingService->set('accent_color', '#445566', 'branding');
        $this->settingService->set('typography_font', 'Inter', 'branding');

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('--brand-primary: #112233;', false)
            ->assertSee('--brand-accent: #445566;', false)
            ->assertSee("--font-heading: 'Inter'", false)
            ->assertSee('fonts.googleapis.com/css2?family=Inter', false);
    }

    public function test_service_detail_page_loads_active_service_and_shows_details(): void
    {
        $service = Service::where('slug', 'enterprise-digital-modernization')->firstOrFail();

        $response = $this->get(route('service.detail', $service->slug));

        $response->assertOk()
            ->assertViewIs('public.service-detail')
            ->assertSee($service->title)
            ->assertSee($service->short_description)
            ->assertSee('Request Scope & Quotation')
            ->assertSee('Consult Managing Partner');
    }

    public function test_inactive_service_detail_page_returns_404(): void
    {
        $service = Service::create([
            'title' => 'Secret Draft Service',
            'slug' => 'secret-draft-service',
            'short_description' => 'Draft service description',
            'description' => 'Detailed draft description',
            'is_active' => false,
            'order' => 99,
        ]);

        $response = $this->get(route('service.detail', $service->slug));

        $response->assertNotFound();
    }

    public function test_non_existent_service_slug_returns_404(): void
    {
        $response = $this->get(route('service.detail', 'non-existent-service-slug-xyz'));

        $response->assertNotFound();
    }

    public function test_portfolio_detail_page_loads_case_study_and_shows_tech_stack(): void
    {
        $portfolio = Portfolio::where('slug', 'fintech-core-migration-vantage-capital')->firstOrFail();

        $response = $this->get(route('portfolio.detail', $portfolio->slug));

        $response->assertOk()
            ->assertViewIs('public.portfolio-detail')
            ->assertSee($portfolio->title)
            ->assertSee($portfolio->client)
            ->assertSee('PHP 8.3')
            ->assertSee('PostgreSQL')
            ->assertSee('Inquire About Similar Architecture');
    }

    public function test_inactive_portfolio_detail_page_returns_404(): void
    {
        $category = PortfolioCategory::first();
        $portfolio = Portfolio::create([
            'category_id' => $category->id,
            'title' => 'Unpublished M&A Study',
            'slug' => 'unpublished-ma-study',
            'client' => 'Confidential Corp',
            'summary' => 'Internal testing case study',
            'content' => 'Full draft content description.',
            'is_active' => false,
            'order' => 99,
        ]);

        $response = $this->get(route('portfolio.detail', $portfolio->slug));

        $response->assertNotFound();
    }

    public function test_non_existent_portfolio_slug_returns_404(): void
    {
        $response = $this->get(route('portfolio.detail', 'non-existent-portfolio-case-study'));

        $response->assertNotFound();
    }

    public function test_whatsapp_ctas_and_floating_widget_are_rendered_with_tracking_attributes(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('api/track-whatsapp-lead', false)
            ->assertSee('whatsapp/redirect', false)
            ->assertSee('floating_widget', false)
            ->assertSee('hero_primary', false)
            ->assertSee('Direct WhatsApp Channel', false);
    }
}
