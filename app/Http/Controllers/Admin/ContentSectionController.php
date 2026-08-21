<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentSectionController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function hero(): View
    {
        $settings = [
            'hero_badge' => [
                'en' => $this->settingService->get('hero_badge', 'Enterprise Digital Acceleration', 'en'),
                'ar' => $this->settingService->get('hero_badge', 'التسريع الرقمي المؤسسي', 'ar'),
            ],
            'hero_title' => [
                'en' => $this->settingService->get('hero_title', 'Scale High-Performance Systems with Precision', 'en'),
                'ar' => $this->settingService->get('hero_title', 'تطوير وتوسيع الأنظمة عالية الأداء بدقة واحترافية', 'ar'),
            ],
            'hero_subtitle' => [
                'en' => $this->settingService->get('hero_subtitle', 'We design, build, and optimize enterprise-grade technology and corporate strategies.', 'en'),
                'ar' => $this->settingService->get('hero_subtitle', 'نصمم ونبني ونطور التقنيات والاستراتيجيات المؤسسية عالية الكفاءة.', 'ar'),
            ],
            'hero_cta_text' => [
                'en' => $this->settingService->get('hero_cta_text', 'Start Executive Consultation', 'en'),
                'ar' => $this->settingService->get('hero_cta_text', 'ابدأ الاستشارة التنفيذية', 'ar'),
            ],
            'hero_cta_whatsapp_message' => [
                'en' => $this->settingService->get('hero_cta_whatsapp_message', 'Hello, I would like to schedule an executive advisory consultation.', 'en'),
                'ar' => $this->settingService->get('hero_cta_whatsapp_message', 'مرحباً، أود حجز جلسة استشارية تنفيذية.', 'ar'),
            ],
            'hero_rating_score' => $this->settingService->get('hero_rating_score', '4.9/5.0'),
            'hero_rating_count' => [
                'en' => $this->settingService->get('hero_rating_count', 'Over 200+ Enterprise Transformations', 'en'),
                'ar' => $this->settingService->get('hero_rating_count', 'أكثر من 200+ تحول مؤسسي ناجح', 'ar'),
            ],
        ];

        return view('admin.content.hero', compact('settings'));
    }

    public function updateHero(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => ['required'],
            'hero_title' => ['required'],
            'hero_subtitle' => ['required'],
            'hero_cta_text' => ['required'],
            'hero_cta_whatsapp_message' => ['required'],
            'hero_rating_score' => ['nullable', 'string', 'max:50'],
            'hero_rating_count' => ['nullable'],
        ]);

        foreach ($validated as $key => $val) {
            $this->settingService->set($key, $val, 'hero');
        }

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_hero_section',
            'details' => ['updated_fields' => array_keys($validated)],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.content.hero')->with('success', __('admin.messages.saved_successfully'));
    }

    public function about(): View
    {
        $settings = [
            'about_title' => [
                'en' => $this->settingService->get('about_title', 'Engineered for Global Enterprise Excellence', 'en'),
                'ar' => $this->settingService->get('about_title', 'مصمم لتحقيق التميز المؤسسي العالمي', 'ar'),
            ],
            'about_description' => [
                'en' => $this->settingService->get('about_description', 'Our strategic advisory frameworks empower high-growth organizations with agile technology architectures.', 'en'),
                'ar' => $this->settingService->get('about_description', 'أطر العمل الاستشارية الاستراتيجية لدينا تدعم المؤسسات سريعة النمو ببنى تكنولوجية مرنة.', 'ar'),
            ],
            'about_bullet_1' => [
                'en' => $this->settingService->get('about_bullet_1', 'Enterprise Cloud & Data Engineering', 'en'),
                'ar' => $this->settingService->get('about_bullet_1', 'هندسة السحابة والبيانات المؤسسية', 'ar'),
            ],
            'about_bullet_2' => [
                'en' => $this->settingService->get('about_bullet_2', 'Automated Lead & CRM Integration', 'en'),
                'ar' => $this->settingService->get('about_bullet_2', 'تكامل آلي لإدارة العملاء المحتملين والـ CRM', 'ar'),
            ],
            'about_bullet_3' => [
                'en' => $this->settingService->get('about_bullet_3', '99.99% Guaranteed SLA Deployments', 'en'),
                'ar' => $this->settingService->get('about_bullet_3', 'ضمان اتفاقية مستوى خدمة 99.99%', 'ar'),
            ],
        ];

        return view('admin.content.about', compact('settings'));
    }

    public function updateAbout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'about_title' => ['required'],
            'about_description' => ['required'],
            'about_bullet_1' => ['nullable'],
            'about_bullet_2' => ['nullable'],
            'about_bullet_3' => ['nullable'],
        ]);

        foreach ($validated as $key => $val) {
            $this->settingService->set($key, $val, 'about');
        }

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_about_section',
            'details' => ['updated_fields' => array_keys($validated)],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.content.about')->with('success', __('admin.messages.saved_successfully'));
    }

    public function contact(): View
    {
        $settings = [
            'whatsapp_number' => $this->settingService->get('whatsapp_number', '+12345678901'),
            'whatsapp_default_message' => [
                'en' => $this->settingService->get('whatsapp_default_message', 'Hello, I would like to inquire about your services.', 'en'),
                'ar' => $this->settingService->get('whatsapp_default_message', 'مرحباً، أود الاستفسار عن خدماتكم الاستشارية.', 'ar'),
            ],
            'contact_email' => $this->settingService->get('contact_email', 'contact@corporate.test'),
            'contact_phone' => $this->settingService->get('contact_phone', '+1 (555) 019-2834'),
            'contact_address' => [
                'en' => $this->settingService->get('contact_address', '100 Enterprise Way, Suite 500, San Francisco, CA', 'en'),
                'ar' => $this->settingService->get('contact_address', 'طريق الملك فهد، الرياض، المملكة العربية السعودية', 'ar'),
            ],
        ];

        return view('admin.content.contact', compact('settings'));
    }

    public function updateContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'whatsapp_number' => ['required', 'string', 'regex:/^\+[1-9]\d{1,14}$/'],
            'whatsapp_default_message' => ['required'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_address' => ['required'],
        ]);

        foreach ($validated as $key => $val) {
            $this->settingService->set($key, $val, 'contact');
        }

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_contact_section',
            'details' => ['updated_fields' => array_keys($validated)],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.content.contact')->with('success', __('admin.messages.saved_successfully'));
    }

    public function seo(): View
    {
        $appName = config('app.name', 'Aegis');
        $settings = [
            'seo_meta_title' => [
                'en' => $this->settingService->get('seo_meta_title', $appName . ' | Enterprise Transformation', 'en'),
                'ar' => $this->settingService->get('seo_meta_title', $appName . ' | التحول الرقمي والاستشارات', 'ar'),
            ],
            'seo_meta_description' => [
                'en' => $this->settingService->get('seo_meta_description', 'High-impact enterprise digital consulting, high throughput architecture, and corporate acceleration solutions.', 'en'),
                'ar' => $this->settingService->get('seo_meta_description', 'استشارات رقمية مؤسسية عالية التأثير، بنية تحتية فائقة الأداء، وحلول تسريع الأعمال.', 'ar'),
            ],
            'seo_meta_keywords' => [
                'en' => $this->settingService->get('seo_meta_keywords', 'consulting, enterprise solutions, digital transformation, crm architecture', 'en'),
                'ar' => $this->settingService->get('seo_meta_keywords', 'استشارات, حلول مؤسسية, تحول رقمي, بنية إدارة علاقات العملاء', 'ar'),
            ],
        ];

        return view('admin.content.seo', compact('settings'));
    }

    public function updateSeo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seo_meta_title' => ['required'],
            'seo_meta_description' => ['required'],
            'seo_meta_keywords' => ['nullable'],
        ]);

        foreach ($validated as $key => $val) {
            $this->settingService->set($key, $val, 'seo');
        }

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_seo_section',
            'details' => ['updated_fields' => array_keys($validated)],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.content.seo')->with('success', __('admin.messages.saved_successfully'));
    }

    public function footer(): View
    {
        $appName = config('app.name', 'Aegis');
        $settings = [
            'footer_about' => [
                'en' => $this->settingService->get('footer_about', 'Delivering tier-one corporate digital transformation and revenue acceleration engines globally.', 'en'),
                'ar' => $this->settingService->get('footer_about', 'تقديم حلول التحول الرقمي المؤسسي من الفئة الأولى ومحركات تسريع الإيرادات عالمياً.', 'ar'),
            ],
            'footer_copyright' => [
                'en' => $this->settingService->get('footer_copyright', '© ' . date('Y') . ' ' . $appName . '. All rights reserved.', 'en'),
                'ar' => $this->settingService->get('footer_copyright', '© ' . date('Y') . ' ' . $appName . '. جميع الحقوق محفوظة.', 'ar'),
            ],
            'social_linkedin' => $this->settingService->get('social_linkedin', 'https://linkedin.com/company/enterprise'),
            'social_twitter' => $this->settingService->get('social_twitter', 'https://twitter.com/enterprise'),
        ];

        return view('admin.content.footer', compact('settings'));
    }

    public function updateFooter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'footer_about' => ['required'],
            'footer_copyright' => ['required'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_twitter' => ['nullable', 'url', 'max:255'],
        ]);

        foreach ($validated as $key => $val) {
            $this->settingService->set($key, $val, 'footer');
        }

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_footer_section',
            'details' => ['updated_fields' => array_keys($validated)],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.content.footer')->with('success', __('admin.messages.saved_successfully'));
    }
}
