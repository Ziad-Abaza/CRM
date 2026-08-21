<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\SettingService;
use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GlobalSettingsAndI18nModulesTest extends TestCase
{
    use RefreshDatabase;

    protected SettingService $settingService;
    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultCompanySeeder::class);
        $this->settingService = app(SettingService::class);
        $this->adminUser = User::first();
    }

    public function test_navbar_renders_responsive_classes_and_logical_properties(): void
    {
        // English View
        $enResponse = $this->get('/en');
        $enResponse->assertOk()
            ->assertSee('hidden lg:flex items-center', false)
            ->assertSee('flex lg:hidden items-center', false)
            ->assertSee('absolute end-0', false);

        // Arabic View
        $arResponse = $this->get('/ar');
        $arResponse->assertOk()
            ->assertSee('hidden lg:flex items-center', false)
            ->assertSee('flex lg:hidden items-center', false)
            ->assertSee('absolute end-0', false);
    }

    public function test_centralized_currency_configuration_and_formatting(): void
    {
        $this->settingService->set('default_currency', 'SAR', 'branding');

        $this->assertSame('SAR', app_currency());
        $this->assertSame('15,000 SAR', format_currency(15000, 'SAR', 'ar'));
        $this->assertSame('SAR 15,000', format_currency(15000, 'SAR', 'en'));
        $this->assertSame('$15,000', format_currency(15000, 'USD', 'en'));

        // Reset to USD
        $this->settingService->set('default_currency', 'USD', 'branding');
        $this->assertSame('USD', app_currency());
    }

    public function test_centralized_locale_configuration_metadata(): void
    {
        $supported = config('locales.supported');
        $this->assertArrayHasKey('en', $supported);
        $this->assertArrayHasKey('ar', $supported);

        $this->assertSame('ltr', $supported['en']['direction']);
        $this->assertSame('rtl', $supported['ar']['direction']);

        $this->assertContains('ar', config('locales.rtl_locales'));
    }

    public function test_admin_can_update_hero_content_bilingually(): void
    {
        $response = $this->actingAs($this->adminUser)->put(route('admin.content.hero.update'), [
            'hero_badge' => [
                'en' => 'Global Advisory',
                'ar' => 'استشارات دولية',
            ],
            'hero_title' => [
                'en' => 'Accelerating Enterprise Scale',
                'ar' => 'تسريع التوسع المؤسسي',
            ],
            'hero_subtitle' => [
                'en' => 'Leading institutional transformation across global markets.',
                'ar' => 'قيادة التحول المؤسسي عبر الأسواق العالمية.',
            ],
            'hero_cta_text' => [
                'en' => 'Get Started',
                'ar' => 'ابدأ الآن',
            ],
            'hero_cta_whatsapp_message' => [
                'en' => 'Hello team, I would like to get started.',
                'ar' => 'مرحباً، أود البدء معكم.',
            ],
            'hero_rating_count' => [
                'en' => '500+ Enterprises',
                'ar' => 'أكثر من 500 مؤسسة',
            ],
            'hero_rating_score' => '4.95',
        ]);

        $response->assertRedirect(route('admin.content.hero'))
            ->assertSessionHas('success');

        app()->setLocale('en');
        $this->assertSame('Global Advisory', setting('hero_badge'));
        $this->assertSame('Accelerating Enterprise Scale', setting('hero_title'));

        app()->setLocale('ar');
        $this->assertSame('استشارات دولية', setting('hero_badge'));
        $this->assertSame('تسريع التوسع المؤسسي', setting('hero_title'));
    }

    public function test_admin_can_update_about_content_bilingually(): void
    {
        $response = $this->actingAs($this->adminUser)->put(route('admin.content.about.update'), [
            'about_title' => [
                'en' => 'Decades of Advisory Excellence',
                'ar' => 'عقود من التميز الاستشاري',
            ],
            'about_description' => [
                'en' => 'Empowering modern enterprises with strategic guidance.',
                'ar' => 'تمكين المؤسسات الحديثة بالتوجيه الاستراتيجي المتقدم.',
            ],
            'about_bullet_1' => [
                'en' => 'Partner-led execution',
                'ar' => 'تنفيذ بقيادة الشركاء',
            ],
            'about_bullet_2' => [
                'en' => 'High speed turnaround',
                'ar' => 'سرعة إنجاز استثنائية',
            ],
            'about_bullet_3' => [
                'en' => 'Proven ROI',
                'ar' => 'عائد استثماري مثبت',
            ],
        ]);

        $response->assertRedirect(route('admin.content.about'))
            ->assertSessionHas('success');

        app()->setLocale('en');
        $this->assertSame('Decades of Advisory Excellence', setting('about_title'));

        app()->setLocale('ar');
        $this->assertSame('عقود من التميز الاستشاري', setting('about_title'));
    }

    public function test_admin_can_update_branding_with_default_currency_and_locale(): void
    {
        $response = $this->actingAs($this->adminUser)->put(route('admin.branding.update'), [
            'site_name' => 'Aegis Global Holdings',
            'company_tagline' => 'Strategic Growth Advisory',
            'default_currency' => 'EUR',
            'default_locale' => 'ar',
            'theme_mode' => 'toggle_allowed',
            'active_theme_default' => 'dark',
        ]);

        $response->assertRedirect(route('admin.branding.index'))
            ->assertSessionHas('success');

        $this->assertSame('Aegis Global Holdings', setting('site_name'));
        $this->assertSame('EUR', setting('default_currency'));
        $this->assertSame('ar', setting('default_locale'));
    }
}
