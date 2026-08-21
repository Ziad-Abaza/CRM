<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BrandingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index(): View
    {
        $settings = [
            // General Identity
            'site_name' => $this->settingService->get('site_name', config('app.name', 'Aegis')),
            'company_tagline' => $this->settingService->get('company_tagline', 'Enterprise Growth Architecture'),
            'company_logo' => $this->settingService->get('company_logo'),
            'company_favicon' => $this->settingService->get('company_favicon'),
            'default_currency' => $this->settingService->get('default_currency', config('crm.currency', config('app.currency', 'USD'))),
            'default_locale' => $this->settingService->get('default_locale', config('locales.default', 'en')),

            // Theme Mode & Geometry
            'theme_mode' => $this->settingService->get('theme_mode', 'toggle_allowed'),
            'active_theme_default' => $this->settingService->get('active_theme_default', 'dark'),
            'typography_font' => $this->settingService->get('typography_font', 'Plus Jakarta Sans'),
            'typography_font_heading' => $this->settingService->get('typography_font_heading', 'Plus Jakarta Sans'),
            'radius_card' => $this->settingService->get('radius_card', '1rem'),
            'radius_button' => $this->settingService->get('radius_button', '0.75rem'),
            'radius_input' => $this->settingService->get('radius_input', '0.75rem'),

            // Dark Mode Tokens
            'dark_bg_body' => $this->settingService->get('dark_bg_body', '#030712'),
            'dark_bg_surface' => $this->settingService->get('dark_bg_surface', '#0f172a'),
            'dark_bg_card' => $this->settingService->get('dark_bg_card', '#0f172a'),
            'dark_bg_input' => $this->settingService->get('dark_bg_input', '#020617'),
            'dark_text_primary' => $this->settingService->get('dark_text_primary', '#f8fafc'),
            'dark_text_muted' => $this->settingService->get('dark_text_muted', '#94a3b8'),
            'dark_border_subtle' => $this->settingService->get('dark_border_subtle', '#1e293b'),
            'dark_border_highlight' => $this->settingService->get('dark_border_highlight', '#334155'),
            'dark_primary_color' => $this->settingService->get('dark_primary_color', '#2563eb'),
            'dark_secondary_color' => $this->settingService->get('dark_secondary_color', '#4f46e5'),
            'dark_accent_color' => $this->settingService->get('dark_accent_color', '#10b981'),

            // Light Mode Tokens
            'light_bg_body' => $this->settingService->get('light_bg_body', '#f8fafc'),
            'light_bg_surface' => $this->settingService->get('light_bg_surface', '#f1f5f9'),
            'light_bg_card' => $this->settingService->get('light_bg_card', '#ffffff'),
            'light_bg_input' => $this->settingService->get('light_bg_input', '#ffffff'),
            'light_text_primary' => $this->settingService->get('light_text_primary', '#0f172a'),
            'light_text_muted' => $this->settingService->get('light_text_muted', '#64748b'),
            'light_border_subtle' => $this->settingService->get('light_border_subtle', '#e2e8f0'),
            'light_border_highlight' => $this->settingService->get('light_border_highlight', '#cbd5e1'),
            'light_primary_color' => $this->settingService->get('light_primary_color', '#1d4ed8'),
            'light_secondary_color' => $this->settingService->get('light_secondary_color', '#4338ca'),
            'light_accent_color' => $this->settingService->get('light_accent_color', '#059669'),

            // Legacy compatibility
            'primary_color' => $this->settingService->get('primary_color', '#0f172a'),
            'secondary_color' => $this->settingService->get('secondary_color', '#1e293b'),
            'accent_color' => $this->settingService->get('accent_color', '#2563eb'),
        ];

        return view('admin.branding.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $hexRegex = 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';

        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'company_tagline' => ['nullable', 'string', 'max:255'],
            'default_currency' => ['nullable', 'string', 'max:10'],
            'default_locale' => ['nullable', 'string', 'in:en,ar'],
            'theme_mode' => ['nullable', 'string', 'in:toggle_allowed,dark_only,light_only,system'],
            'active_theme_default' => ['nullable', 'string', 'in:dark,light'],
            'typography_font' => ['nullable', 'string', 'max:50'],
            'typography_font_heading' => ['nullable', 'string', 'max:50'],
            'radius_card' => ['nullable', 'string', 'max:20'],
            'radius_button' => ['nullable', 'string', 'max:20'],
            'radius_input' => ['nullable', 'string', 'max:20'],

            // Dark Mode
            'dark_bg_body' => ['nullable', 'string', $hexRegex],
            'dark_bg_surface' => ['nullable', 'string', $hexRegex],
            'dark_bg_card' => ['nullable', 'string', $hexRegex],
            'dark_bg_input' => ['nullable', 'string', $hexRegex],
            'dark_text_primary' => ['nullable', 'string', $hexRegex],
            'dark_text_muted' => ['nullable', 'string', $hexRegex],
            'dark_border_subtle' => ['nullable', 'string', $hexRegex],
            'dark_border_highlight' => ['nullable', 'string', $hexRegex],
            'dark_primary_color' => ['nullable', 'string', $hexRegex],
            'dark_secondary_color' => ['nullable', 'string', $hexRegex],
            'dark_accent_color' => ['nullable', 'string', $hexRegex],

            // Light Mode
            'light_bg_body' => ['nullable', 'string', $hexRegex],
            'light_bg_surface' => ['nullable', 'string', $hexRegex],
            'light_bg_card' => ['nullable', 'string', $hexRegex],
            'light_bg_input' => ['nullable', 'string', $hexRegex],
            'light_text_primary' => ['nullable', 'string', $hexRegex],
            'light_text_muted' => ['nullable', 'string', $hexRegex],
            'light_border_subtle' => ['nullable', 'string', $hexRegex],
            'light_border_highlight' => ['nullable', 'string', $hexRegex],
            'light_primary_color' => ['nullable', 'string', $hexRegex],
            'light_secondary_color' => ['nullable', 'string', $hexRegex],
            'light_accent_color' => ['nullable', 'string', $hexRegex],

            // Legacy fallbacks
            'primary_color' => ['nullable', 'string', $hexRegex],
            'secondary_color' => ['nullable', 'string', $hexRegex],
            'accent_color' => ['nullable', 'string', $hexRegex],

            // File uploads
            'logo' => ['nullable', 'file', 'max:4096', 'extensions:png,jpg,jpeg,svg,webp,gif'],
            'company_logo' => ['nullable', 'file', 'max:4096', 'extensions:png,jpg,jpeg,svg,webp,gif'],
            'favicon' => ['nullable', 'file', 'max:2048', 'extensions:ico,png,svg,webp,jpg,jpeg,gif'],
            'company_favicon' => ['nullable', 'file', 'max:2048', 'extensions:ico,png,svg,webp,jpg,jpeg,gif'],
        ]);

        // Identity & Global Config
        $this->settingService->set('site_name', $validated['site_name'], 'branding');
        if (isset($validated['company_tagline'])) {
            $this->settingService->set('company_tagline', $validated['company_tagline'], 'branding');
        }
        if (!empty($validated['default_currency'])) {
            $this->settingService->set('default_currency', $validated['default_currency'], 'branding');
        }
        if (!empty($validated['default_locale'])) {
            $this->settingService->set('default_locale', $validated['default_locale'], 'branding');
        }

        // Theme Engine Tokens
        $themeKeys = [
            'theme_mode', 'active_theme_default', 'typography_font', 'typography_font_heading',
            'radius_card', 'radius_button', 'radius_input',
            'dark_bg_body', 'dark_bg_surface', 'dark_bg_card', 'dark_bg_input',
            'dark_text_primary', 'dark_text_muted', 'dark_border_subtle', 'dark_border_highlight',
            'dark_primary_color', 'dark_secondary_color', 'dark_accent_color',
            'light_bg_body', 'light_bg_surface', 'light_bg_card', 'light_bg_input',
            'light_text_primary', 'light_text_muted', 'light_border_subtle', 'light_border_highlight',
            'light_primary_color', 'light_secondary_color', 'light_accent_color',
            'primary_color', 'secondary_color', 'accent_color',
        ];

        foreach ($themeKeys as $key) {
            if (!empty($validated[$key])) {
                $this->settingService->set($key, $validated[$key], 'theme');
            }
        }

        // Sync legacy primary and accent if dark tokens are provided
        if (!empty($validated['dark_primary_color'])) {
            $this->settingService->set('primary_color', $validated['dark_primary_color'], 'theme');
        }
        if (!empty($validated['dark_accent_color'])) {
            $this->settingService->set('accent_color', $validated['dark_accent_color'], 'theme');
        }

        // File uploads
        $logoUpload = $request->file('logo') ?? $request->file('company_logo');
        if ($logoUpload) {
            $path = $logoUpload->store('branding', 'public');
            $this->settingService->set('company_logo', Storage::url($path), 'branding');
        }

        $faviconUpload = $request->file('favicon') ?? $request->file('company_favicon');
        if ($faviconUpload) {
            $path = $faviconUpload->store('branding', 'public');
            $this->settingService->set('company_favicon', Storage::url($path), 'branding');
        }

        // Audit Trail
        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_branding_settings',
            'details' => [
                'updated_fields' => array_keys($validated),
                'ip' => $request->ip(),
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.branding.index')->with('success', 'Corporate branding, visual themes, and dual light/dark tokens updated successfully.');
    }

    public function reset(): RedirectResponse
    {
        $defaults = [
            'theme_mode' => 'toggle_allowed',
            'active_theme_default' => 'dark',
            'typography_font' => 'Plus Jakarta Sans',
            'typography_font_heading' => 'Plus Jakarta Sans',
            'radius_card' => '1rem',
            'radius_button' => '0.75rem',
            'radius_input' => '0.75rem',

            // Dark
            'dark_bg_body' => '#030712',
            'dark_bg_surface' => '#0f172a',
            'dark_bg_card' => '#0f172a',
            'dark_bg_input' => '#020617',
            'dark_text_primary' => '#f8fafc',
            'dark_text_muted' => '#94a3b8',
            'dark_border_subtle' => '#1e293b',
            'dark_border_highlight' => '#334155',
            'dark_primary_color' => '#2563eb',
            'dark_secondary_color' => '#4f46e5',
            'dark_accent_color' => '#10b981',

            // Light
            'light_bg_body' => '#f8fafc',
            'light_bg_surface' => '#f1f5f9',
            'light_bg_card' => '#ffffff',
            'light_bg_input' => '#ffffff',
            'light_text_primary' => '#0f172a',
            'light_text_muted' => '#64748b',
            'light_border_subtle' => '#e2e8f0',
            'light_border_highlight' => '#cbd5e1',
            'light_primary_color' => '#1d4ed8',
            'light_secondary_color' => '#4338ca',
            'light_accent_color' => '#059669',

            'primary_color' => '#0F172A',
            'accent_color' => '#2563EB',
        ];

        foreach ($defaults as $key => $value) {
            $this->settingService->set($key, $value, 'theme');
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'reset_theme_settings',
            'details' => ['status' => 'restored_factory_defaults'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.branding.index')->with('success', 'Visual theme and color tokens reset to factory defaults.');
    }
}
