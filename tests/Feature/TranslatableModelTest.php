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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslatableModelTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        app()->setLocale('en');
        parent::tearDown();
    }

    public function test_model_resolves_localized_string_attributes_based_on_current_locale(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
            'short_description' => ['en' => 'Custom web apps', 'ar' => 'تطبيقات ويب مخصصة'],
            'description' => ['en' => 'Full description in English', 'ar' => 'الوصف الكامل بالعربية'],
            'slug' => 'web-development',
            'order' => 1,
            'is_active' => true,
        ]);

        app()->setLocale('en');
        $this->assertSame('Web Development', $service->title);
        $this->assertSame('Custom web apps', $service->short_description);
        $this->assertSame('Full description in English', $service->description);

        app()->setLocale('ar');
        $this->assertSame('تطوير الويب', $service->title);
        $this->assertSame('تطبيقات ويب مخصصة', $service->short_description);
        $this->assertSame('الوصف الكامل بالعربية', $service->description);
    }

    public function test_model_falls_back_to_default_locale_when_translation_is_missing(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Web Development'],
            'slug' => 'web-dev-fallback',
        ]);

        app()->setLocale('ar');
        $this->assertSame('Web Development', $service->title);
    }

    public function test_model_falls_back_when_translation_is_empty_string(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Cloud Consulting', 'ar' => '   '],
            'slug' => 'cloud-consulting',
        ]);

        app()->setLocale('ar');
        $this->assertSame('Cloud Consulting', $service->title);
    }

    public function test_model_returns_plain_string_unchanged_for_backward_compatibility(): void
    {
        $service = Service::create([
            'title' => 'Legacy Plain Text Title',
            'slug' => 'legacy-title',
        ]);

        app()->setLocale('en');
        $this->assertSame('Legacy Plain Text Title', $service->title);

        app()->setLocale('ar');
        $this->assertSame('Legacy Plain Text Title', $service->title);
    }

    public function test_model_resolves_translatable_array_list_attributes(): void
    {
        $service = Service::create([
            'title' => ['en' => 'SEO Optimization', 'ar' => 'تحسين محركات البحث'],
            'slug' => 'seo-opt',
            'features' => [
                'en' => ['Keyword Research', 'On-page SEO', 'Backlink Audit'],
                'ar' => ['بحث الكلمات المفتاحية', 'التهيئة الداخلية', 'تدقيق الروابط'],
            ],
        ]);

        app()->setLocale('en');
        $this->assertSame(['Keyword Research', 'On-page SEO', 'Backlink Audit'], $service->features);

        app()->setLocale('ar');
        $this->assertSame(['بحث الكلمات المفتاحية', 'التهيئة الداخلية', 'تدقيق الروابط'], $service->features);
    }

    public function test_model_handles_legacy_flat_array_attributes(): void
    {
        $service = Service::create([
            'title' => 'Plain Service',
            'slug' => 'plain-service',
            'features' => ['Feature 1', 'Feature 2'],
        ]);

        app()->setLocale('en');
        $this->assertSame(['Feature 1', 'Feature 2'], $service->features);

        app()->setLocale('ar');
        $this->assertSame(['Feature 1', 'Feature 2'], $service->features);
    }

    public function test_get_translation_explicit_locale_and_fallback_control(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Corporate Strategy', 'ar' => 'استراتيجية الشركات'],
            'slug' => 'corporate-strategy',
        ]);

        $this->assertSame('Corporate Strategy', $service->getTranslation('title', 'en'));
        $this->assertSame('استراتيجية الشركات', $service->getTranslation('title', 'ar'));

        // Fallback enabled for non-existent locale
        $this->assertSame('Corporate Strategy', $service->getTranslation('title', 'fr', fallback: true));

        // Fallback disabled for non-existent locale
        $this->assertNull($service->getTranslation('title', 'fr', fallback: false));
    }

    public function test_set_translation_and_get_translations(): void
    {
        $service = new Service();
        $service->slug = 'managed-it';
        $service->setTranslation('title', 'en', 'Managed IT Services');
        $service->setTranslation('title', 'ar', 'خدمات تكنولوجيا المعلومات المدارة');
        $service->save();

        $fresh = $service->fresh();
        $this->assertSame([
            'en' => 'Managed IT Services',
            'ar' => 'خدمات تكنولوجيا المعلومات المدارة',
        ], $fresh->getTranslations('title'));

        $allTranslations = $fresh->getTranslations();
        $this->assertArrayHasKey('title', $allTranslations);
        $this->assertArrayHasKey('short_description', $allTranslations);
        $this->assertSame('Managed IT Services', $allTranslations['title']['en']);
    }

    public function test_model_to_array_resolves_localized_values(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Analytics Suite', 'ar' => 'جناح التحليلات'],
            'features' => [
                'en' => ['Real-time dashboard'],
                'ar' => ['لوحة معلومات فورية'],
            ],
            'slug' => 'analytics-suite',
        ]);

        app()->setLocale('en');
        $arrayEn = $service->toArray();
        $this->assertSame('Analytics Suite', $arrayEn['title']);
        $this->assertSame(['Real-time dashboard'], $arrayEn['features']);

        app()->setLocale('ar');
        $arrayAr = $service->toArray();
        $this->assertSame('جناح التحليلات', $arrayAr['title']);
        $this->assertSame(['لوحة معلومات فورية'], $arrayAr['features']);
    }

    public function test_all_translatable_models_support_localization(): void
    {
        // 1. PortfolioCategory
        $category = PortfolioCategory::create([
            'name' => ['en' => 'FinTech', 'ar' => 'التكنولوجيا المالية'],
            'description' => ['en' => 'Financial tech projects', 'ar' => 'مشاريع التكنولوجيا المالية'],
            'slug' => 'fintech',
        ]);

        // 2. Portfolio
        $portfolio = Portfolio::create([
            'category_id' => $category->id,
            'title' => ['en' => 'Banking App', 'ar' => 'تطبيق مصرفي'],
            'slug' => 'banking-app',
            'client' => ['en' => 'National Bank', 'ar' => 'البنك الوطني'],
            'summary' => ['en' => 'Modern digital banking', 'ar' => 'خدمات مصرفية رقمية حديثة'],
            'content' => ['en' => 'In-depth case study', 'ar' => 'دراسة حالة متعمقة'],
        ]);

        // 3. PricingPlan
        $plan = PricingPlan::create([
            'name' => ['en' => 'Enterprise Tier', 'ar' => 'باقة الشركات'],
            'slug' => 'enterprise-tier',
            'price' => 999.00,
            'currency' => 'USD',
            'billing_period' => ['en' => 'monthly', 'ar' => 'شهرياً'],
            'description' => ['en' => 'Full-scale enterprise support', 'ar' => 'دعم شامل للمؤسسات'],
            'features' => [
                'en' => ['Dedicated Manager', '24/7 SLA'],
                'ar' => ['مدير حساب مخصص', 'اتفاقية مستوى الخدمة 24/7'],
            ],
        ]);

        // 4. Testimonial
        $testimonial = Testimonial::create([
            'client_name' => ['en' => 'John Doe', 'ar' => 'جون دو'],
            'client_role' => ['en' => 'Chief Technology Officer', 'ar' => 'المدير التنفيذي للتكنولوجيا'],
            'company' => ['en' => 'Acme Corp', 'ar' => 'شركة أكمي'],
            'content' => ['en' => 'Outstanding work delivered!', 'ar' => 'عمل متميز تم تسليمه!'],
            'rating' => 5,
        ]);

        // 5. TeamMember
        $member = TeamMember::create([
            'name' => ['en' => 'Sarah Connor', 'ar' => 'سارة كونور'],
            'role' => ['en' => 'Lead Architect', 'ar' => 'كبير المهندسين'],
            'bio' => ['en' => 'Over 10 years experience', 'ar' => 'أكثر من 10 سنوات خبرة'],
        ]);

        // 6. StatsCounter
        $counter = StatsCounter::create([
            'label' => ['en' => 'Active Clients', 'ar' => 'عملاء نشطون'],
            'value' => '250',
            'suffix' => ['en' => '+', 'ar' => '+'],
        ]);

        // 7. Faq
        $faq = Faq::create([
            'question' => ['en' => 'How long does onboarding take?', 'ar' => 'كم يستغرق البدء بالعمل؟'],
            'answer' => ['en' => 'Typically 2 to 3 days.', 'ar' => 'عادة من يومين إلى 3 أيام.'],
        ]);

        app()->setLocale('en');
        $this->assertSame('FinTech', $category->name);
        $this->assertSame('Banking App', $portfolio->title);
        $this->assertSame('National Bank', $portfolio->client);
        $this->assertSame('Enterprise Tier', $plan->name);
        $this->assertSame('monthly', $plan->billing_period);
        $this->assertSame(['Dedicated Manager', '24/7 SLA'], $plan->features);
        $this->assertSame('John Doe', $testimonial->client_name);
        $this->assertSame('Chief Technology Officer', $testimonial->client_role);
        $this->assertSame('Sarah Connor', $member->name);
        $this->assertSame('Lead Architect', $member->role);
        $this->assertSame('Active Clients', $counter->label);
        $this->assertSame('How long does onboarding take?', $faq->question);

        app()->setLocale('ar');
        $this->assertSame('التكنولوجيا المالية', $category->name);
        $this->assertSame('تطبيق مصرفي', $portfolio->title);
        $this->assertSame('البنك الوطني', $portfolio->client);
        $this->assertSame('باقة الشركات', $plan->name);
        $this->assertSame('شهرياً', $plan->billing_period);
        $this->assertSame(['مدير حساب مخصص', 'اتفاقية مستوى الخدمة 24/7'], $plan->features);
        $this->assertSame('جون دو', $testimonial->client_name);
        $this->assertSame('المدير التنفيذي للتكنولوجيا', $testimonial->client_role);
        $this->assertSame('سارة كونور', $member->name);
        $this->assertSame('كبير المهندسين', $member->role);
        $this->assertSame('عملاء نشطون', $counter->label);
        $this->assertSame('كم يستغرق البدء بالعمل؟', $faq->question);
    }

    public function test_setting_service_resolves_suffix_localized_keys(): void
    {
        $service = app(SettingService::class);
        $service->set('hero_title_en', 'Enterprise Solutions English', 'hero', 'string');
        $service->set('hero_title_ar', 'حلول المؤسسات بالعربية', 'hero', 'string');

        app()->setLocale('en');
        $this->assertSame('Enterprise Solutions English', setting('hero_title'));
        $this->assertSame('Enterprise Solutions English', $service->get('hero_title'));

        app()->setLocale('ar');
        $this->assertSame('حلول المؤسسات بالعربية', setting('hero_title'));
        $this->assertSame('حلول المؤسسات بالعربية', $service->get('hero_title'));

        // Unsupported locale falls back to default locale (en)
        app()->setLocale('fr');
        $this->assertSame('Enterprise Solutions English', setting('hero_title'));
    }

    public function test_setting_service_resolves_json_localized_keys(): void
    {
        $service = app(SettingService::class);
        $service->set('hero_badge', [
            'en' => 'Global Leader',
            'ar' => 'رائد عالمي',
        ], 'hero', 'json');

        app()->setLocale('en');
        $this->assertSame('Global Leader', setting('hero_badge'));

        app()->setLocale('ar');
        $this->assertSame('رائد عالمي', setting('hero_badge'));

        app()->setLocale('fr');
        $this->assertSame('Global Leader', setting('hero_badge'));
    }

    public function test_setting_service_explicit_locale_parameter(): void
    {
        $service = app(SettingService::class);
        $service->set('cta_button_text', [
            'en' => 'Contact Us',
            'ar' => 'تواصل معنا',
        ], 'cta', 'json');

        app()->setLocale('en');
        $this->assertSame('تواصل معنا', setting('cta_button_text', null, 'ar'));
        $this->assertSame('Contact Us', setting('cta_button_text', null, 'en'));
        $this->assertSame('تواصل معنا', $service->get('cta_button_text', null, 'ar'));
    }

    public function test_setting_service_falls_back_when_localized_value_is_empty(): void
    {
        $service = app(SettingService::class);
        $service->set('site_tagline', [
            'en' => 'Innovating the Future',
            'ar' => '',
        ], 'branding', 'json');

        app()->setLocale('ar');
        $this->assertSame('Innovating the Future', setting('site_tagline'));
    }
}
