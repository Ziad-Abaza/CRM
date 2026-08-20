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
            'hero_badge' => $this->settingService->get('hero_badge', 'Enterprise Digital Acceleration'),
            'hero_title' => $this->settingService->get('hero_title', 'Scale High-Performance Systems with Precision'),
            'hero_subtitle' => $this->settingService->get('hero_subtitle', 'We design, build, and optimize enterprise-grade technology and corporate strategies.'),
            'hero_cta_text' => $this->settingService->get('hero_cta_text', 'Start Executive Consultation'),
            'hero_cta_whatsapp_message' => $this->settingService->get('hero_cta_whatsapp_message', 'Hello, I would like to schedule an executive advisory consultation.'),
            'hero_rating_score' => $this->settingService->get('hero_rating_score', '4.9/5.0'),
            'hero_rating_count' => $this->settingService->get('hero_rating_count', 'Over 200+ Enterprise Transformations'),
        ];

        return view('admin.content.hero', compact('settings'));
    }

    public function updateHero(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => ['required', 'string', 'max:100'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:500'],
            'hero_cta_text' => ['required', 'string', 'max:100'],
            'hero_cta_whatsapp_message' => ['required', 'string', 'max:500'],
            'hero_rating_score' => ['nullable', 'string', 'max:50'],
            'hero_rating_count' => ['nullable', 'string', 'max:100'],
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

        return redirect()->route('admin.content.hero')->with('success', 'Hero section updated successfully.');
    }

    public function about(): View
    {
        $settings = [
            'about_title' => $this->settingService->get('about_title', 'Engineered for Global Enterprise Excellence'),
            'about_description' => $this->settingService->get('about_description', 'Our strategic advisory frameworks empower high-growth organizations with agile technology architectures.'),
            'about_bullet_1' => $this->settingService->get('about_bullet_1', 'Enterprise Cloud & Data Engineering'),
            'about_bullet_2' => $this->settingService->get('about_bullet_2', 'Automated Lead & CRM Integration'),
            'about_bullet_3' => $this->settingService->get('about_bullet_3', '99.99% Guaranteed SLA Deployments'),
        ];

        return view('admin.content.about', compact('settings'));
    }

    public function updateAbout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'about_title' => ['required', 'string', 'max:255'],
            'about_description' => ['required', 'string', 'max:1000'],
            'about_bullet_1' => ['nullable', 'string', 'max:255'],
            'about_bullet_2' => ['nullable', 'string', 'max:255'],
            'about_bullet_3' => ['nullable', 'string', 'max:255'],
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

        return redirect()->route('admin.content.about')->with('success', 'About section updated successfully.');
    }

    public function contact(): View
    {
        $settings = [
            'whatsapp_number' => $this->settingService->get('whatsapp_number', '+12345678901'),
            'whatsapp_default_message' => $this->settingService->get('whatsapp_default_message', 'Hello, I would like to inquire about your services.'),
            'contact_email' => $this->settingService->get('contact_email', 'contact@corporate.test'),
            'contact_phone' => $this->settingService->get('contact_phone', '+1 (555) 019-2834'),
            'contact_address' => $this->settingService->get('contact_address', '100 Enterprise Way, Suite 500, San Francisco, CA'),
        ];

        return view('admin.content.contact', compact('settings'));
    }

    public function updateContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'whatsapp_number' => ['required', 'string', 'regex:/^\+[1-9]\d{1,14}$/'],
            'whatsapp_default_message' => ['required', 'string', 'max:500'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_address' => ['required', 'string', 'max:255'],
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

        return redirect()->route('admin.content.contact')->with('success', 'Contact and WhatsApp profile updated successfully.');
    }

    public function seo(): View
    {
        $settings = [
            'seo_meta_title' => $this->settingService->get('seo_meta_title', 'Apex Corporate Solutions | Enterprise Transformation'),
            'seo_meta_description' => $this->settingService->get('seo_meta_description', 'High-impact enterprise digital consulting, high throughput architecture, and corporate acceleration solutions.'),
            'seo_meta_keywords' => $this->settingService->get('seo_meta_keywords', 'consulting, enterprise solutions, digital transformation, crm architecture'),
        ];

        return view('admin.content.seo', compact('settings'));
    }

    public function updateSeo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'seo_meta_title' => ['required', 'string', 'max:255'],
            'seo_meta_description' => ['required', 'string', 'max:500'],
            'seo_meta_keywords' => ['nullable', 'string', 'max:500'],
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

        return redirect()->route('admin.content.seo')->with('success', 'SEO metadata updated successfully.');
    }

    public function footer(): View
    {
        $settings = [
            'footer_about' => $this->settingService->get('footer_about', 'Delivering tier-one corporate digital transformation and revenue acceleration engines globally.'),
            'footer_copyright' => $this->settingService->get('footer_copyright', '© 2026 Apex Corporate Solutions. All rights reserved.'),
            'social_linkedin' => $this->settingService->get('social_linkedin', 'https://linkedin.com/company/apex-corporate'),
            'social_twitter' => $this->settingService->get('social_twitter', 'https://twitter.com/apex_corporate'),
        ];

        return view('admin.content.footer', compact('settings'));
    }

    public function updateFooter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'footer_about' => ['required', 'string', 'max:500'],
            'footer_copyright' => ['required', 'string', 'max:255'],
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

        return redirect()->route('admin.content.footer')->with('success', 'Footer content and social links updated successfully.');
    }
}
