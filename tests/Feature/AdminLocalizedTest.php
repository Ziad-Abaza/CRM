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
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLocalizedTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@apex-corp.test',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_login_renders_in_english_and_arabic(): void
    {
        // English (default)
        $responseEn = $this->withSession(['locale' => 'en'])->get(route('admin.login'));
        $responseEn->assertStatus(200);
        $responseEn->assertSee('dir="ltr"', false);
        $responseEn->assertSee('lang="en"', false);
        $responseEn->assertSee(__('auth.email_label', [], 'en'));
        $responseEn->assertSee(__('auth.password_label', [], 'en'));

        // Arabic
        $responseAr = $this->withSession(['locale' => 'ar'])->get(route('admin.login'));
        $responseAr->assertStatus(200);
        $responseAr->assertSee('dir="rtl"', false);
        $responseAr->assertSee('lang="ar"', false);
        $responseAr->assertSee(__('auth.email_label', [], 'ar'));
        $responseAr->assertSee(__('auth.password_label', [], 'ar'));
        $responseAr->assertSee(__('auth.sign_in', [], 'ar'));
    }

    public function test_admin_dashboard_renders_localized_navigation_and_headers(): void
    {
        // English
        $responseEn = $this->actingAs($this->admin)->withSession(['locale' => 'en'])->get(route('admin.dashboard'));
        $responseEn->assertStatus(200);
        $responseEn->assertSee('dir="ltr"', false);
        $responseEn->assertSee(__('admin.nav.dashboard', [], 'en'));
        $responseEn->assertSee(__('admin.nav.leads', [], 'en'));
        $responseEn->assertSee(__('admin.nav.services', [], 'en'));

        // Arabic
        $responseAr = $this->actingAs($this->admin)->withSession(['locale' => 'ar'])->get(route('admin.dashboard'));
        $responseAr->assertStatus(200);
        $responseAr->assertSee('dir="rtl"', false);
        $responseAr->assertSee(__('admin.nav.dashboard', [], 'ar'));
        $responseAr->assertSee(__('admin.nav.leads', [], 'ar'));
        $responseAr->assertSee(__('admin.nav.services', [], 'ar'));
    }

    public function test_admin_can_switch_locale_via_switch_route(): void
    {
        $switchResp = $this->actingAs($this->admin)->get(route('locale.switch', ['locale' => 'ar']));
        $switchResp->assertRedirect();
        $switchResp->assertSessionHas('locale', 'ar');

        // Following request has Arabic active
        $response = $this->actingAs($this->admin)->withSession(['locale' => 'ar'])->get(route('admin.dashboard'));
        $response->assertSee('dir="rtl"', false);
        $response->assertSee(__('admin.nav.portal_name', [], 'ar'));
    }

    public function test_admin_can_create_and_update_service_with_bilingual_inputs(): void
    {
        $payload = [
            'title' => [
                'en' => 'Cloud Migration Advisory',
                'ar' => 'استشارات الهجرة السحابية',
            ],
            'short_description' => [
                'en' => 'End-to-end multi-cloud advisory and architecture.',
                'ar' => 'استشارات متكاملة للهجرة السحابية وبنية الأنظمة.',
            ],
            'description' => [
                'en' => 'Detailed cloud migration strategy and execution roadmap.',
                'ar' => 'استراتيجية تفصيلية وخارطة طريق لتنفيذ الهجرة السحابية.',
            ],
            'features' => [
                'en' => ['Multi-cloud Strategy', 'Zero Downtime'],
                'ar' => ['استراتيجية متعددة السحابات', 'انعدام فترة التوقف'],
            ],
            'icon' => 'cloud',
            'order' => 1,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), $payload);
        $response->assertRedirect(route('admin.services.index'));

        $service = Service::firstOrFail();
        $this->assertEquals('Cloud Migration Advisory', $service->getTranslation('title', 'en'));
        $this->assertEquals('استشارات الهجرة السحابية', $service->getTranslation('title', 'ar'));
        $this->assertEquals('End-to-end multi-cloud advisory and architecture.', $service->getTranslation('short_description', 'en'));
        $this->assertEquals('استشارات متكاملة للهجرة السحابية وبنية الأنظمة.', $service->getTranslation('short_description', 'ar'));

        // Update with modified bilingual values
        $updatePayload = [
            'title' => [
                'en' => 'Enterprise Cloud Modernization',
                'ar' => 'تحديث البنية السحابية المؤسسية',
            ],
            'short_description' => [
                'en' => 'Updated English summary.',
                'ar' => 'ملخص عربي محدث.',
            ],
            'features' => [
                'en' => ['Kubernetes Deployment'],
                'ar' => ['نشر كوبرنيتس'],
            ],
            'is_active' => '1',
        ];

        $updateResp = $this->actingAs($this->admin)->put(route('admin.services.update', $service), $updatePayload);
        $updateResp->assertRedirect(route('admin.services.index'));

        $service->refresh();
        $this->assertEquals('Enterprise Cloud Modernization', $service->getTranslation('title', 'en'));
        $this->assertEquals('تحديث البنية السحابية المؤسسية', $service->getTranslation('title', 'ar'));
    }

    public function test_admin_can_create_and_update_pricing_plan_with_bilingual_inputs(): void
    {
        $payload = [
            'name' => [
                'en' => 'Enterprise Retainer',
                'ar' => 'باقة المؤسسات',
            ],
            'price' => '4999.00',
            'currency' => 'USD',
            'billing_period' => [
                'en' => 'month',
                'ar' => 'شهرياً',
            ],
            'description' => [
                'en' => 'Dedicated engineering squad.',
                'ar' => 'فريق هندسي مخصص.',
            ],
            'features' => [
                'en' => ['Weekly Sprints', 'SOC2 Compliance'],
                'ar' => ['دورات عمل أسبوعية', 'توافق مع معايير SOC2'],
            ],
            'whatsapp_message' => [
                'en' => 'Hello, I want the Enterprise Retainer.',
                'ar' => 'مرحباً، أود الاشتراك في باقة المؤسسات.',
            ],
            'is_featured' => '1',
            'is_active' => '1',
            'order' => 1,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.pricing.store'), $payload);
        $response->assertRedirect(route('admin.pricing.index'));

        $plan = PricingPlan::firstOrFail();
        $this->assertEquals('Enterprise Retainer', $plan->getTranslation('name', 'en'));
        $this->assertEquals('باقة المؤسسات', $plan->getTranslation('name', 'ar'));
    }

    public function test_admin_can_create_and_update_portfolio_with_bilingual_inputs(): void
    {
        $category = PortfolioCategory::create([
            'name' => ['en' => 'Fintech', 'ar' => 'التقنية المالية'],
            'slug' => 'fintech',
            'order' => 1,
        ]);

        $payload = [
            'category_id' => $category->id,
            'title' => [
                'en' => 'Digital Banking Platform',
                'ar' => 'منصة الخدمات المصرفية الرقمية',
            ],
            'client' => 'Saudi Gulf Bank',
            'summary' => [
                'en' => 'Reduced transaction latency by 60%',
                'ar' => 'تقليل زمن استجابة العمليات بنسبة 60%',
            ],
            'content' => [
                'en' => 'Complete modern cloud infrastructure rollout.',
                'ar' => 'نشر كامل للبنية التحتية السحابية الحديثة.',
            ],
            'technologies' => ['PHP 8.3', 'Laravel 11', 'PostgreSQL'],
            'is_featured' => '1',
            'is_active' => '1',
            'order' => 1,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.portfolio.store'), $payload);
        $response->assertRedirect(route('admin.portfolio.index'));

        $portfolio = Portfolio::firstOrFail();
        $this->assertEquals('Digital Banking Platform', $portfolio->getTranslation('title', 'en'));
        $this->assertEquals('منصة الخدمات المصرفية الرقمية', $portfolio->getTranslation('title', 'ar'));
    }

    public function test_admin_can_create_and_update_testimonials_team_stats_faqs_with_bilingual_inputs(): void
    {
        // 1. Testimonial
        $testResp = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
            'client_name' => 'Fahad Al-Otaibi',
            'client_role' => [
                'en' => 'Chief Technology Officer',
                'ar' => 'الرئيس التنفيذي للتكنولوجيا',
            ],
            'company' => 'Riyadh Ventures',
            'content' => [
                'en' => 'Outstanding system performance and delivery.',
                'ar' => 'أداء متميز في تسليم المشروع وتطوير النظام.',
            ],
            'rating' => 5,
            'is_active' => '1',
        ]);
        $testResp->assertRedirect(route('admin.testimonials.index'));
        $testimonial = Testimonial::firstOrFail();
        $this->assertEquals('Chief Technology Officer', $testimonial->getTranslation('client_role', 'en'));
        $this->assertEquals('الرئيس التنفيذي للتكنولوجيا', $testimonial->getTranslation('client_role', 'ar'));

        // 2. Team Member
        $teamResp = $this->actingAs($this->admin)->post(route('admin.team.store'), [
            'name' => [
                'en' => 'Dr. Ziad Abaza',
                'ar' => 'د. زياد أباظة',
            ],
            'role' => [
                'en' => 'Principal Enterprise Architect',
                'ar' => 'كبير مهندسي النظم المؤسسية',
            ],
            'bio' => [
                'en' => 'Expert in distributed cloud architecture.',
                'ar' => 'خبير في البنى السحابية الموزعة.',
            ],
            'email' => 'ziad@apex.test',
            'is_active' => '1',
        ]);
        $teamResp->assertRedirect(route('admin.team.index'));
        $member = TeamMember::firstOrFail();
        $this->assertEquals('Dr. Ziad Abaza', $member->getTranslation('name', 'en'));
        $this->assertEquals('د. زياد أباظة', $member->getTranslation('name', 'ar'));

        // 3. Stats Counter
        $statsResp = $this->actingAs($this->admin)->post(route('admin.stats.store'), [
            'label' => [
                'en' => 'Enterprise Transformations',
                'ar' => 'تحول رقمي مؤسسي',
            ],
            'value' => '250',
            'suffix' => '+',
            'is_active' => '1',
        ]);
        $statsResp->assertRedirect(route('admin.stats.index'));
        $stat = StatsCounter::firstOrFail();
        $this->assertEquals('Enterprise Transformations', $stat->getTranslation('label', 'en'));
        $this->assertEquals('تحول رقمي مؤسسي', $stat->getTranslation('label', 'ar'));

        // 4. FAQ
        $faqResp = $this->actingAs($this->admin)->post(route('admin.faqs.store'), [
            'question' => [
                'en' => 'What is the deployment timeline?',
                'ar' => 'ما هو الجدول الزمني للنشر؟',
            ],
            'answer' => [
                'en' => 'Deployments typically take 2-4 weeks.',
                'ar' => 'تستغرق عمليات النشر عادة من أسبوعين إلى 4 أسابيع.',
            ],
            'category' => [
                'en' => 'General',
                'ar' => 'عام',
            ],
            'is_active' => '1',
        ]);
        $faqResp->assertRedirect(route('admin.faqs.index'));
        $faq = Faq::firstOrFail();
        $this->assertEquals('What is the deployment timeline?', $faq->getTranslation('question', 'en'));
        $this->assertEquals('ما هو الجدول الزمني للنشر؟', $faq->getTranslation('question', 'ar'));
    }

    public function test_admin_content_sections_save_and_retrieve_bilingual_settings(): void
    {
        $settingService = app(SettingService::class);

        // Update Hero Section
        $heroResp = $this->actingAs($this->admin)->put(route('admin.content.hero.update'), [
            'hero_badge' => [
                'en' => 'Digital Acceleration',
                'ar' => 'التسريع الرقمي',
            ],
            'hero_title' => [
                'en' => 'Scale High-Performance Systems',
                'ar' => 'تطوير وتوسيع الأنظمة عالية الأداء',
            ],
            'hero_subtitle' => [
                'en' => 'We design enterprise architectures.',
                'ar' => 'نصمم بنى تحتية مؤسسية متقدمة.',
            ],
            'hero_cta_text' => [
                'en' => 'Start Consultation',
                'ar' => 'ابدأ الاستشارة',
            ],
            'hero_cta_whatsapp_message' => [
                'en' => 'Hello, I want an advisory consultation.',
                'ar' => 'مرحباً، أود حجز جلسة استشارية.',
            ],
            'hero_rating_score' => '4.9/5.0',
            'hero_rating_count' => [
                'en' => '200+ Enterprise Clients',
                'ar' => 'أكثر من 200 عميل مؤسسي',
            ],
        ]);
        $heroResp->assertRedirect(route('admin.content.hero'));

        $this->assertEquals('Scale High-Performance Systems', $settingService->get('hero_title', null, 'en'));
        $this->assertEquals('تطوير وتوسيع الأنظمة عالية الأداء', $settingService->get('hero_title', null, 'ar'));

        // Update About Section
        $aboutResp = $this->actingAs($this->admin)->put(route('admin.content.about.update'), [
            'about_title' => [
                'en' => 'Engineered for Global Excellence',
                'ar' => 'مصمم لتحقيق التميز المؤسسي العالمي',
            ],
            'about_description' => [
                'en' => 'Our strategic frameworks empower high-growth organizations.',
                'ar' => 'أطر العمل الاستراتيجية لدينا تدعم المؤسسات سريعة النمو.',
            ],
            'about_bullet_1' => [
                'en' => 'Cloud Engineering',
                'ar' => 'هندسة السحابة',
            ],
            'about_bullet_2' => [
                'en' => 'CRM Integration',
                'ar' => 'تكامل إدارة علاقات العملاء',
            ],
            'about_bullet_3' => [
                'en' => '99.99% SLA',
                'ar' => 'ضمان توافر بنسبة 99.99%',
            ],
        ]);
        $aboutResp->assertRedirect(route('admin.content.about'));

        $this->assertEquals('Engineered for Global Excellence', $settingService->get('about_title', null, 'en'));
        $this->assertEquals('مصمم لتحقيق التميز المؤسسي العالمي', $settingService->get('about_title', null, 'ar'));
    }

    public function test_management_index_views_render_localized_tables_and_filters(): void
    {
        $routes = [
            'admin.leads.index',
            'admin.audit-logs.index',
            'admin.branding.index',
            'admin.services.index',
            'admin.portfolio.index',
            'admin.pricing.index',
            'admin.testimonials.index',
            'admin.team.index',
            'admin.stats.index',
            'admin.faqs.index',
        ];

        foreach ($routes as $route) {
            $respAr = $this->actingAs($this->admin)->withSession(['locale' => 'ar'])->get(route($route));
            $respAr->assertStatus(200);
            $respAr->assertSee('dir="rtl"', false);
        }
    }
}
