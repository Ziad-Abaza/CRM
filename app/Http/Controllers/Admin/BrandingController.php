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
            'site_name' => $this->settingService->get('site_name', 'Apex Corporate Solutions'),
            'company_tagline' => $this->settingService->get('company_tagline', 'Enterprise Growth Architecture'),
            'primary_color' => $this->settingService->get('primary_color', '#0f172a'),
            'secondary_color' => $this->settingService->get('secondary_color', '#1e293b'),
            'accent_color' => $this->settingService->get('accent_color', '#3b82f6'),
            'typography_font' => $this->settingService->get('typography_font', 'Plus Jakarta Sans'),
            'company_logo' => $this->settingService->get('company_logo'),
            'company_favicon' => $this->settingService->get('company_favicon'),
        ];

        return view('admin.branding.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'company_tagline' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'accent_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'typography_font' => ['nullable', 'string', 'max:50'],
            'logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'company_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,svg', 'max:1024'],
            'company_favicon' => ['nullable', 'file', 'mimes:ico,png,svg', 'max:1024'],
        ]);

        $this->settingService->set('site_name', $validated['site_name'], 'branding');
        if (isset($validated['company_tagline'])) {
            $this->settingService->set('company_tagline', $validated['company_tagline'], 'branding');
        }

        $this->settingService->set('primary_color', $validated['primary_color'], 'theme');
        if (isset($validated['secondary_color'])) {
            $this->settingService->set('secondary_color', $validated['secondary_color'], 'theme');
        }
        $this->settingService->set('accent_color', $validated['accent_color'], 'theme');

        if (isset($validated['typography_font'])) {
            $this->settingService->set('typography_font', $validated['typography_font'], 'theme');
        }

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

        return redirect()->route('admin.branding.index')->with('success', 'Corporate branding and visual theme updated successfully.');
    }
}
