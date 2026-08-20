<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Setting;
use App\Models\StatsCounter;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WhatsAppLeadClick;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelsAndMigrationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_model_crud_and_scopes_and_casts(): void
    {
        $setting1 = Setting::create([
            'key' => 'site_title',
            'value' => 'Apex Solutions',
            'group' => 'branding',
            'type' => 'string',
            'is_public' => true,
        ]);

        $setting2 = Setting::create([
            'key' => 'secret_api_key',
            'value' => 'secret123',
            'group' => 'system',
            'type' => 'string',
            'is_public' => false,
        ]);

        $this->assertDatabaseHas('settings', ['key' => 'site_title']);
        $this->assertTrue($setting1->is_public);
        $this->assertFalse($setting2->is_public);

        $brandingSettings = Setting::group('branding')->get();
        $this->assertCount(1, $brandingSettings);
        $this->assertEquals('site_title', $brandingSettings->first()->key);

        $publicSettings = Setting::public()->get();
        $this->assertCount(1, $publicSettings);
        $this->assertEquals('site_title', $publicSettings->first()->key);
    }

    public function test_service_model_crud_and_scopes_and_casts(): void
    {
        $service1 = Service::create([
            'title' => 'Cloud Migration',
            'slug' => 'cloud-migration',
            'short_description' => 'Seamless cloud onboarding',
            'description' => 'Detailed enterprise migration steps',
            'icon' => 'cloud-icon',
            'image' => 'images/cloud.jpg',
            'features' => ['Zero Downtime', 'AWS & Azure Support', 'Security Audit'],
            'order' => 2,
            'is_active' => true,
        ]);

        $service2 = Service::create([
            'title' => 'Legacy Maintenance',
            'slug' => 'legacy-maintenance',
            'order' => 1,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('services', ['slug' => 'cloud-migration']);
        $this->assertIsArray($service1->features);
        $this->assertEquals('Zero Downtime', $service1->features[0]);
        $this->assertIsInt($service1->order);
        $this->assertIsBool($service1->is_active);

        $activeServices = Service::active()->ordered()->get();
        $this->assertCount(1, $activeServices);
        $this->assertEquals('cloud-migration', $activeServices->first()->slug);

        $allOrdered = Service::ordered()->get();
        $this->assertEquals('legacy-maintenance', $allOrdered->first()->slug);
    }

    public function test_pricing_plan_model_crud_and_scopes_and_casts(): void
    {
        $plan1 = PricingPlan::create([
            'name' => 'Growth Plan',
            'slug' => 'growth-plan',
            'price' => 199.50,
            'currency' => 'USD',
            'billing_period' => 'month',
            'description' => 'Ideal for scaling organizations',
            'features' => ['Unlimited WhatsApp Clicks', '24/7 SLA', 'Custom Branding'],
            'is_featured' => true,
            'is_active' => true,
            'order' => 1,
            'whatsapp_message' => 'Hi, I want the Growth Plan',
        ]);

        $plan2 = PricingPlan::create([
            'name' => 'Legacy Plan',
            'slug' => 'legacy-plan',
            'price' => 99.00,
            'is_featured' => false,
            'is_active' => false,
            'order' => 2,
        ]);

        $this->assertDatabaseHas('pricing_plans', ['slug' => 'growth-plan']);
        $this->assertEquals('199.50', $plan1->price);
        $this->assertIsArray($plan1->features);
        $this->assertTrue($plan1->is_featured);
        $this->assertTrue($plan1->is_active);
        $this->assertIsInt($plan1->order);

        $featuredPlans = PricingPlan::featured()->get();
        $this->assertCount(1, $featuredPlans);
        $this->assertEquals('growth-plan', $featuredPlans->first()->slug);

        $activePlans = PricingPlan::active()->get();
        $this->assertCount(1, $activePlans);
    }

    public function test_portfolio_category_and_portfolio_relationships_and_casts(): void
    {
        $category = PortfolioCategory::create([
            'name' => 'FinTech Solutions',
            'slug' => 'fintech-solutions',
            'description' => 'Banking and payment systems',
            'order' => 1,
            'is_active' => true,
        ]);

        $portfolio = Portfolio::create([
            'category_id' => $category->id,
            'title' => 'Global Pay Gateway',
            'slug' => 'global-pay-gateway',
            'client' => 'Apex Pay Ltd',
            'completion_date' => Carbon::parse('2026-05-15'),
            'summary' => 'Multi-currency payment engine',
            'content' => 'Full case study of architecture...',
            'image' => 'portfolio/cover.png',
            'gallery' => ['portfolio/shot1.png', 'portfolio/shot2.png'],
            'technologies' => ['Laravel', 'PostgreSQL', 'TailwindCSS'],
            'website_url' => 'https://example.com',
            'is_featured' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        $this->assertInstanceOf(PortfolioCategory::class, $portfolio->category);
        $this->assertEquals('FinTech Solutions', $portfolio->category->name);
        $this->assertCount(1, $category->portfolios);
        $this->assertEquals('Global Pay Gateway', $category->portfolios->first()->title);

        $this->assertInstanceOf(Carbon::class, $portfolio->completion_date);
        $this->assertEquals('2026-05-15', $portfolio->completion_date->format('Y-m-d'));
        $this->assertIsArray($portfolio->gallery);
        $this->assertIsArray($portfolio->technologies);
        $this->assertTrue($portfolio->is_featured);
        $this->assertTrue($portfolio->is_active);
        $this->assertIsInt($portfolio->order);
        $this->assertIsInt($portfolio->category_id);
    }

    public function test_testimonial_model_crud_and_scopes_and_casts(): void
    {
        $testimonial = Testimonial::create([
            'client_name' => 'Sarah Jenkins',
            'client_role' => 'CTO',
            'company' => 'Nexus Health',
            'avatar' => 'avatars/sarah.jpg',
            'content' => 'Outstanding delivery and seamless WhatsApp onboarding workflow.',
            'rating' => 5,
            'is_featured' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        $this->assertDatabaseHas('testimonials', ['client_name' => 'Sarah Jenkins']);
        $this->assertIsInt($testimonial->rating);
        $this->assertEquals(5, $testimonial->rating);
        $this->assertTrue($testimonial->is_featured);
        $this->assertTrue($testimonial->is_active);
        $this->assertIsInt($testimonial->order);

        $activeTestimonials = Testimonial::active()->featured()->ordered()->get();
        $this->assertCount(1, $activeTestimonials);
    }

    public function test_team_member_model_crud_and_scopes_and_casts(): void
    {
        $member = TeamMember::create([
            'name' => 'David Vance',
            'role' => 'Lead Solutions Architect',
            'bio' => '12+ years building enterprise SaaS platforms.',
            'photo' => 'team/david.jpg',
            'social_links' => [
                'linkedin' => 'https://linkedin.com/in/davidvance',
                'github' => 'https://github.com/davidvance',
            ],
            'email' => 'david@apexsolutions.example',
            'phone' => '+15550198273',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('team_members', ['name' => 'David Vance']);
        $this->assertIsArray($member->social_links);
        $this->assertEquals('https://linkedin.com/in/davidvance', $member->social_links['linkedin']);
        $this->assertIsInt($member->order);
        $this->assertTrue($member->is_active);

        $members = TeamMember::active()->ordered()->get();
        $this->assertCount(1, $members);
    }

    public function test_stats_counter_model_crud_and_scopes_and_casts(): void
    {
        $counter = StatsCounter::create([
            'label' => 'Enterprise Clients',
            'value' => '150',
            'suffix' => '+',
            'icon' => 'building-office',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('stats_counters', ['label' => 'Enterprise Clients']);
        $this->assertIsInt($counter->order);
        $this->assertTrue($counter->is_active);

        $counters = StatsCounter::active()->ordered()->get();
        $this->assertCount(1, $counters);
    }

    public function test_faq_model_crud_and_scopes_and_casts(): void
    {
        $faq1 = Faq::create([
            'question' => 'How does the WhatsApp CRM workflow operate?',
            'answer' => 'Visitors click custom triggers that redirect with pre-filled context messages.',
            'category' => 'CRM & Leads',
            'order' => 1,
            'is_active' => true,
        ]);

        $faq2 = Faq::create([
            'question' => 'Can we customize color variables?',
            'answer' => 'Yes, full branding customization is available in the admin panel.',
            'category' => 'Branding',
            'order' => 2,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('faqs', ['category' => 'CRM & Leads']);
        $this->assertIsInt($faq1->order);
        $this->assertTrue($faq1->is_active);

        $crmFaqs = Faq::category('CRM & Leads')->active()->ordered()->get();
        $this->assertCount(1, $crmFaqs);
        $this->assertEquals('How does the WhatsApp CRM workflow operate?', $crmFaqs->first()->question);
    }

    public function test_whatsapp_lead_click_model_crud_and_scopes(): void
    {
        $click = WhatsAppLeadClick::create([
            'source_page' => '/services/cloud-migration',
            'button_location' => 'hero_cta',
            'prefilled_message' => 'Inquiry for Cloud Migration',
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'referrer' => 'https://google.com',
            'country' => 'US',
        ]);

        $this->assertDatabaseHas('whatsapp_lead_clicks', ['button_location' => 'hero_cta']);

        $recent = WhatsAppLeadClick::recent()->byLocation('hero_cta')->get();
        $this->assertCount(1, $recent);
        $this->assertEquals('/services/cloud-migration', $recent->first()->source_page);
    }

    public function test_audit_log_model_relationships_morph_and_casts(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@apexcorp.example',
        ]);

        $service = Service::create([
            'title' => 'DevOps Modernization',
            'slug' => 'devops-modernization',
            'order' => 1,
            'is_active' => true,
        ]);

        $audit = AuditLog::create([
            'user_id' => $user->id,
            'action' => 'created',
            'auditable_type' => Service::class,
            'auditable_id' => $service->id,
            'old_values' => null,
            'new_values' => ['title' => 'DevOps Modernization', 'is_active' => true],
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit Test Agent',
        ]);

        $this->assertDatabaseHas('audit_logs', ['action' => 'created']);
        $this->assertInstanceOf(User::class, $audit->user);
        $this->assertEquals('Admin User', $audit->user->name);
        $this->assertCount(1, $user->auditLogs);

        $this->assertInstanceOf(Service::class, $audit->auditable);
        $this->assertEquals('DevOps Modernization', $audit->auditable->title);

        $this->assertIsArray($audit->new_values);
        $this->assertEquals('DevOps Modernization', $audit->new_values['title']);
        $this->assertIsInt($audit->user_id);
        $this->assertIsInt($audit->auditable_id);

        $recentAudits = AuditLog::recent()->get();
        $this->assertCount(1, $recentAudits);
    }
}
