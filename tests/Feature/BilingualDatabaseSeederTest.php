<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Setting;
use App\Models\StatsCounter;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Services\SettingService;
use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BilingualDatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    protected SettingService $settingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultCompanySeeder::class);
        $this->settingService = app(SettingService::class);
    }

    protected function tearDown(): void
    {
        app()->setLocale('en');
        parent::tearDown();
    }

    public function test_settings_are_seeded_with_bilingual_translations(): void
    {
        // English
        app()->setLocale('en');
        $this->assertSame('Apex Corporate Solutions', setting('site_name'));
        $this->assertSame('Enterprise Growth Architecture & Scalable Advisory', setting('company_tagline'));
        $this->assertSame('Enterprise Strategic Advisory', setting('hero_badge'));
        $this->assertSame('Accelerate Enterprise Scale with Predictable Precision', setting('hero_title'));
        $this->assertStringContainsString('Apex Corporate Solutions partners with institutional leaders', setting('hero_subtitle'));
        $this->assertSame('Consult via WhatsApp', setting('hero_cta_text'));
        $this->assertStringContainsString('250+ Fortune 1000', setting('hero_rating_count'));
        $this->assertSame('Decades of Institutional Rigor in Modern Markets', setting('about_title'));
        $this->assertStringContainsString('Founded by veteran operational architects', setting('about_description'));
        $this->assertStringContainsString('Direct partner-level engagement', setting('about_bullet_1'));
        $this->assertStringContainsString('Proprietary digital workflow frameworks', setting('about_bullet_2'));
        $this->assertStringContainsString('Uncompromising compliance protocols', setting('about_bullet_3'));
        $this->assertStringContainsString('Apex Corporate Solutions | Strategic Enterprise Advisory', setting('seo_meta_title'));
        $this->assertStringContainsString('Leading corporate advisory', setting('seo_meta_description'));
        $this->assertStringContainsString('Apex Corporate Solutions delivers high-impact management consulting', setting('footer_about'));

        // Arabic
        app()->setLocale('ar');
        $this->assertSame('أبيكس للحلول المؤسسية', setting('site_name'));
        $this->assertSame('معمارية النمو المؤسسي والاستشارات الاستراتيجية المتقدمة', setting('company_tagline'));
        $this->assertSame('الاستشارات الاستراتيجية للمؤسسات', setting('hero_badge'));
        $this->assertSame('تسريع التوسع المؤسسي بدقة وكفاءة قابلة للتنبؤ', setting('hero_title'));
        $this->assertStringContainsString('تتعاون أبيكس للحلول المؤسسية مع القادة التنفيذيين', setting('hero_subtitle'));
        $this->assertSame('استشر خبرائنا عبر واتساب', setting('hero_cta_text'));
        $this->assertStringContainsString('أكثر من 250 عميلاً', setting('hero_rating_count'));
        $this->assertSame('عقود من الصرامة والخبرة المؤسسية في الأسواق الحديثة', setting('about_title'));
        $this->assertStringContainsString('تأسست أبيكس على يد نخبة من مهندسي العمليات', setting('about_description'));
        $this->assertStringContainsString('مشاركة مباشرة على مستوى الشركاء التنفيذيين', setting('about_bullet_1'));
        $this->assertStringContainsString('منهجيات سير عمل رقمية مبتكرة', setting('about_bullet_2'));
        $this->assertStringContainsString('بروتوكولات امتثال صارمة', setting('about_bullet_3'));
        $this->assertStringContainsString('أبيكس للحلول المؤسسية | الاستشارات الاستراتيجية', setting('seo_meta_title'));
        $this->assertStringContainsString('الريادة في الاستشارات المؤسسية', setting('seo_meta_description'));
        $this->assertStringContainsString('تقدم أبيكس للحلول المؤسسية استشارات إدارية', setting('footer_about'));
    }

    public function test_services_are_seeded_with_bilingual_data(): void
    {
        $services = Service::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(6, $services->count());

        $firstService = Service::where('slug', 'enterprise-digital-modernization')->firstOrFail();

        // English
        app()->setLocale('en');
        $this->assertSame('Enterprise Digital Modernization', $firstService->title);
        $this->assertSame('Re-architect legacy workflows into secure, high-throughput cloud operations.', $firstService->short_description);
        $this->assertStringContainsString('mission-critical infrastructure', $firstService->description);
        $this->assertIsArray($firstService->features);
        $this->assertContains('Cloud Infrastructure Architecture & Migration', $firstService->features);

        // Arabic
        app()->setLocale('ar');
        $this->assertSame('التحول الرقمي وتحديث الأنظمة للمؤسسات', $firstService->title);
        $this->assertSame('إعادة هندسة مسارات العمل الموروثة وتحويلها إلى بنية سحابية آمنة وعالية الأداء.', $firstService->short_description);
        $this->assertStringContainsString('البنية التحتية الحيوية', $firstService->description);
        $this->assertIsArray($firstService->features);
        $this->assertContains('هندسة البنية التحتية السحابية والترحيل السلس', $firstService->features);

        // Verify all services have non-empty bilingual fields
        foreach ($services as $service) {
            $this->assertNotEmpty($service->getTranslation('title', 'en'));
            $this->assertNotEmpty($service->getTranslation('title', 'ar'));
            $this->assertNotEmpty($service->getTranslation('short_description', 'en'));
            $this->assertNotEmpty($service->getTranslation('short_description', 'ar'));
            $this->assertNotEmpty($service->getTranslation('description', 'en'));
            $this->assertNotEmpty($service->getTranslation('description', 'ar'));
            $this->assertNotEmpty($service->getTranslation('features', 'en'));
            $this->assertNotEmpty($service->getTranslation('features', 'ar'));
        }
    }

    public function test_portfolio_categories_and_items_are_seeded_with_bilingual_data(): void
    {
        $categories = PortfolioCategory::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(3, $categories->count());

        $modernizationCat = PortfolioCategory::where('slug', 'digital-modernization')->firstOrFail();

        app()->setLocale('en');
        $this->assertSame('Digital Modernization', $modernizationCat->name);
        $this->assertStringContainsString('cloud', strtolower($modernizationCat->description));

        app()->setLocale('ar');
        $this->assertSame('التحول الرقمي وتحديث النظم', $modernizationCat->name);
        $this->assertStringContainsString('السحابي', $modernizationCat->description);

        $portfolios = Portfolio::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(6, $portfolios->count());

        $vantageItem = Portfolio::where('slug', 'fintech-core-migration-vantage-capital')->firstOrFail();

        app()->setLocale('en');
        $this->assertSame('Fintech Core Migration for Vantage Capital', $vantageItem->title);
        $this->assertSame('Vantage Capital Markets', $vantageItem->client);
        $this->assertStringContainsString('$1.2B transaction ledger', $vantageItem->summary);
        $this->assertStringContainsString('monolithic ledger system', $vantageItem->content);

        app()->setLocale('ar');
        $this->assertSame('ترحيل البنية المصرفية الأساسية لشركة فانتاج كابيتال', $vantageItem->title);
        $this->assertSame('أسواق فانتاج كابيتال المالية', $vantageItem->client);
        $this->assertStringContainsString('1.2 مليار دولار', $vantageItem->summary);
        $this->assertStringContainsString('دفتر الأستاذ الأحادي', $vantageItem->content);

        foreach ($portfolios as $item) {
            $this->assertNotEmpty($item->getTranslation('title', 'en'));
            $this->assertNotEmpty($item->getTranslation('title', 'ar'));
            $this->assertNotEmpty($item->getTranslation('client', 'en'));
            $this->assertNotEmpty($item->getTranslation('client', 'ar'));
            $this->assertNotEmpty($item->getTranslation('summary', 'en'));
            $this->assertNotEmpty($item->getTranslation('summary', 'ar'));
            $this->assertNotEmpty($item->getTranslation('content', 'en'));
            $this->assertNotEmpty($item->getTranslation('content', 'ar'));
        }
    }

    public function test_pricing_plans_are_seeded_with_bilingual_data(): void
    {
        $plans = PricingPlan::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(3, $plans->count());

        $growthPlan = PricingPlan::where('slug', 'operational-growth')->firstOrFail();

        app()->setLocale('en');
        $this->assertSame('Operational Growth', $growthPlan->name);
        $this->assertSame('month', $growthPlan->billing_period);
        $this->assertStringContainsString('hands-on operational transformation', $growthPlan->description);
        $this->assertContains('Full workflow automation & system integrations', $growthPlan->features);

        app()->setLocale('ar');
        $this->assertSame('النمو التشغيلي والتوسع', $growthPlan->name);
        $this->assertSame('شهرياً', $growthPlan->billing_period);
        $this->assertStringContainsString('تحول تشغيلي شامل وعملي', $growthPlan->description);
        $this->assertContains('أتمتة شاملة لمسارات العمل وتكامل الأنظمة', $growthPlan->features);

        foreach ($plans as $plan) {
            $this->assertNotEmpty($plan->getTranslation('name', 'en'));
            $this->assertNotEmpty($plan->getTranslation('name', 'ar'));
            $this->assertNotEmpty($plan->getTranslation('billing_period', 'en'));
            $this->assertNotEmpty($plan->getTranslation('billing_period', 'ar'));
            $this->assertNotEmpty($plan->getTranslation('description', 'en'));
            $this->assertNotEmpty($plan->getTranslation('description', 'ar'));
            $this->assertNotEmpty($plan->getTranslation('features', 'en'));
            $this->assertNotEmpty($plan->getTranslation('features', 'ar'));
        }
    }

    public function test_testimonials_are_seeded_with_bilingual_data(): void
    {
        $testimonials = Testimonial::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(4, $testimonials->count());

        $vance = $testimonials->firstWhere('order', 1);
        $this->assertNotNull($vance);

        app()->setLocale('en');
        $this->assertSame('Eleanor Vance', $vance->client_name);
        $this->assertSame('Chief Technology Officer', $vance->client_role);
        $this->assertSame('Vantage Capital Markets', $vance->company);
        $this->assertStringContainsString('migrated our core transactional ledger', $vance->content);

        app()->setLocale('ar');
        $this->assertSame('إليانور فانس', $vance->client_name);
        $this->assertSame('المدير التنفيذي للتكنولوجيا', $vance->client_role);
        $this->assertSame('أسواق فانتاج كابيتال المالية', $vance->company);
        $this->assertStringContainsString('ترحيل نظام دفتر الأستاذ الأساسي', $vance->content);

        foreach ($testimonials as $t) {
            $this->assertNotEmpty($t->getTranslation('client_name', 'en'));
            $this->assertNotEmpty($t->getTranslation('client_name', 'ar'));
            $this->assertNotEmpty($t->getTranslation('client_role', 'en'));
            $this->assertNotEmpty($t->getTranslation('client_role', 'ar'));
            $this->assertNotEmpty($t->getTranslation('company', 'en'));
            $this->assertNotEmpty($t->getTranslation('company', 'ar'));
            $this->assertNotEmpty($t->getTranslation('content', 'en'));
            $this->assertNotEmpty($t->getTranslation('content', 'ar'));
        }
    }

    public function test_team_members_are_seeded_with_bilingual_data(): void
    {
        $members = TeamMember::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(4, $members->count());

        $sterling = $members->firstWhere('order', 1);
        $this->assertNotNull($sterling);

        app()->setLocale('en');
        $this->assertSame('David Sterling', $sterling->name);
        $this->assertSame('Managing Partner & Head of Strategy', $sterling->role);
        $this->assertStringContainsString('Former McKinsey partner', $sterling->bio);

        app()->setLocale('ar');
        $this->assertSame('ديفيد ستيرلينغ', $sterling->name);
        $this->assertSame('الشريك الإداري ورئيس قسم الاستراتيجية', $sterling->role);
        $this->assertStringContainsString('شريك سابق في ماكنزي', $sterling->bio);

        foreach ($members as $member) {
            $this->assertNotEmpty($member->getTranslation('name', 'en'));
            $this->assertNotEmpty($member->getTranslation('name', 'ar'));
            $this->assertNotEmpty($member->getTranslation('role', 'en'));
            $this->assertNotEmpty($member->getTranslation('role', 'ar'));
            $this->assertNotEmpty($member->getTranslation('bio', 'en'));
            $this->assertNotEmpty($member->getTranslation('bio', 'ar'));
        }
    }

    public function test_stats_counters_and_faqs_are_seeded_with_bilingual_data(): void
    {
        $stats = StatsCounter::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(4, $stats->count());

        $firstStat = $stats->firstWhere('order', 1);
        $this->assertNotNull($firstStat);

        app()->setLocale('en');
        $this->assertSame('Capital Assets Advised', $firstStat->label);

        app()->setLocale('ar');
        $this->assertSame('أصول رأس مالية تحت الاستشارة', $firstStat->label);

        foreach ($stats as $stat) {
            $this->assertNotEmpty($stat->getTranslation('label', 'en'));
            $this->assertNotEmpty($stat->getTranslation('label', 'ar'));
        }

        $faqs = Faq::query()->active()->ordered()->get();
        $this->assertGreaterThanOrEqual(6, $faqs->count());

        $firstFaq = $faqs->firstWhere('order', 1);
        $this->assertNotNull($firstFaq);

        app()->setLocale('en');
        $this->assertSame('How does Apex initiate an advisory or transformation engagement?', $firstFaq->question);
        $this->assertStringContainsString('2-week structured diagnostic sprint', $firstFaq->answer);

        app()->setLocale('ar');
        $this->assertSame('كيف تبدأ أبيكس مهمة استشارية أو برنامج تحول مؤسسي؟', $firstFaq->question);
        $this->assertStringContainsString('مرحلة تشخيصية منظمة لمدة أسبوعين', $firstFaq->answer);

        foreach ($faqs as $faq) {
            $this->assertNotEmpty($faq->getTranslation('question', 'en'));
            $this->assertNotEmpty($faq->getTranslation('question', 'ar'));
            $this->assertNotEmpty($faq->getTranslation('answer', 'en'));
            $this->assertNotEmpty($faq->getTranslation('answer', 'ar'));
        }
    }
}
