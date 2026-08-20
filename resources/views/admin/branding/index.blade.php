@extends('layouts.admin')

@section('title', 'Theme Engine & Branding Customizer')
@section('page_title', 'Theme & Branding')

@section('content')
<div x-data="{
    activeTab: 'dark',
    previewMode: 'dark',
    
    // Identity
    siteName: '{{ addslashes($settings['site_name'] ?? '') }}',
    tagline: '{{ addslashes($settings['company_tagline'] ?? '') }}',
    logoPreview: '{{ $settings['company_logo'] ?? '' }}',
    faviconPreview: '{{ $settings['company_favicon'] ?? '' }}',

    // Global Theme & Geometry
    themeMode: '{{ $settings['theme_mode'] ?? 'toggle_allowed' }}',
    activeThemeDefault: '{{ $settings['active_theme_default'] ?? 'dark' }}',
    typographyFont: '{{ $settings['typography_font'] ?? 'Plus Jakarta Sans' }}',
    typographyFontHeading: '{{ $settings['typography_font_heading'] ?? 'Plus Jakarta Sans' }}',
    radiusCard: '{{ $settings['radius_card'] ?? '1rem' }}',
    radiusButton: '{{ $settings['radius_button'] ?? '0.75rem' }}',
    radiusInput: '{{ $settings['radius_input'] ?? '0.75rem' }}',

    // Dark Mode Tokens
    darkBgBody: '{{ $settings['dark_bg_body'] ?? '#030712' }}',
    darkBgSurface: '{{ $settings['dark_bg_surface'] ?? '#0f172a' }}',
    darkBgCard: '{{ $settings['dark_bg_card'] ?? '#0f172a' }}',
    darkBgInput: '{{ $settings['dark_bg_input'] ?? '#020617' }}',
    darkTextPrimary: '{{ $settings['dark_text_primary'] ?? '#f8fafc' }}',
    darkTextMuted: '{{ $settings['dark_text_muted'] ?? '#94a3b8' }}',
    darkBorderSubtle: '{{ $settings['dark_border_subtle'] ?? '#1e293b' }}',
    darkBorderHighlight: '{{ $settings['dark_border_highlight'] ?? '#334155' }}',
    darkPrimaryColor: '{{ $settings['dark_primary_color'] ?? '#2563eb' }}',
    darkSecondaryColor: '{{ $settings['dark_secondary_color'] ?? '#4f46e5' }}',
    darkAccentColor: '{{ $settings['dark_accent_color'] ?? '#10b981' }}',

    // Light Mode Tokens
    lightBgBody: '{{ $settings['light_bg_body'] ?? '#f8fafc' }}',
    lightBgSurface: '{{ $settings['light_bg_surface'] ?? '#f1f5f9' }}',
    lightBgCard: '{{ $settings['light_bg_card'] ?? '#ffffff' }}',
    lightBgInput: '{{ $settings['light_bg_input'] ?? '#ffffff' }}',
    lightTextPrimary: '{{ $settings['light_text_primary'] ?? '#0f172a' }}',
    lightTextMuted: '{{ $settings['light_text_muted'] ?? '#64748b' }}',
    lightBorderSubtle: '{{ $settings['light_border_subtle'] ?? '#e2e8f0' }}',
    lightBorderHighlight: '{{ $settings['light_border_highlight'] ?? '#cbd5e1' }}',
    lightPrimaryColor: '{{ $settings['light_primary_color'] ?? '#1d4ed8' }}',
    lightSecondaryColor: '{{ $settings['light_secondary_color'] ?? '#4338ca' }}',
    lightAccentColor: '{{ $settings['light_accent_color'] ?? '#059669' }}',

    // Presets definitions
    presets: {
        midnight: {
            name: 'Executive Midnight (Default)',
            darkBgBody: '#030712',
            darkBgSurface: '#0f172a',
            darkBgCard: '#0f172a',
            darkBgInput: '#020617',
            darkTextPrimary: '#f8fafc',
            darkTextMuted: '#94a3b8',
            darkBorderSubtle: '#1e293b',
            darkBorderHighlight: '#334155',
            darkPrimaryColor: '#2563eb',
            darkSecondaryColor: '#4f46e5',
            darkAccentColor: '#10b981',
            lightBgBody: '#f8fafc',
            lightBgSurface: '#f1f5f9',
            lightBgCard: '#ffffff',
            lightBgInput: '#ffffff',
            lightTextPrimary: '#0f172a',
            lightTextMuted: '#64748b',
            lightBorderSubtle: '#e2e8f0',
            lightBorderHighlight: '#cbd5e1',
            lightPrimaryColor: '#1d4ed8',
            lightSecondaryColor: '#4338ca',
            lightAccentColor: '#059669',
            typographyFont: 'Plus Jakarta Sans',
            radiusCard: '1rem',
            radiusButton: '0.75rem'
        },
        obsidian: {
            name: 'Obsidian Emerald',
            darkBgBody: '#050807',
            darkBgSurface: '#091510',
            darkBgCard: '#0d1f17',
            darkBgInput: '#030605',
            darkTextPrimary: '#ecfdf5',
            darkTextMuted: '#6ee7b7',
            darkBorderSubtle: '#133e2b',
            darkBorderHighlight: '#059669',
            darkPrimaryColor: '#10b981',
            darkSecondaryColor: '#047857',
            darkAccentColor: '#34d399',
            lightBgBody: '#f0fdf4',
            lightBgSurface: '#dcfce7',
            lightBgCard: '#ffffff',
            lightBgInput: '#ffffff',
            lightTextPrimary: '#064e3b',
            lightTextMuted: '#047857',
            lightBorderSubtle: '#bbf7d0',
            lightBorderHighlight: '#86efac',
            lightPrimaryColor: '#059669',
            lightSecondaryColor: '#047857',
            lightAccentColor: '#10b981',
            typographyFont: 'Plus Jakarta Sans',
            radiusCard: '1rem',
            radiusButton: '0.75rem'
        },
        nordic: {
            name: 'Nordic Slate & Violet',
            darkBgBody: '#0b0f19',
            darkBgSurface: '#111827',
            darkBgCard: '#1f2937',
            darkBgInput: '#090d16',
            darkTextPrimary: '#f3f4f6',
            darkTextMuted: '#9ca3af',
            darkBorderSubtle: '#374151',
            darkBorderHighlight: '#4b5563',
            darkPrimaryColor: '#7c3aed',
            darkSecondaryColor: '#6366f1',
            darkAccentColor: '#ec4899',
            lightBgBody: '#f9fafb',
            lightBgSurface: '#f3f4f6',
            lightBgCard: '#ffffff',
            lightBgInput: '#ffffff',
            lightTextPrimary: '#111827',
            lightTextMuted: '#4b5563',
            lightBorderSubtle: '#e5e7eb',
            lightBorderHighlight: '#d1d5db',
            lightPrimaryColor: '#6d28d9',
            lightSecondaryColor: '#4f46e5',
            lightAccentColor: '#db2777',
            typographyFont: 'Inter',
            radiusCard: '0.75rem',
            radiusButton: '0.5rem'
        },
        sapphire: {
            name: 'Corporate Sapphire',
            darkBgBody: '#020d18',
            darkBgSurface: '#081c2f',
            darkBgCard: '#0d2842',
            darkBgInput: '#01080f',
            darkTextPrimary: '#f0f9ff',
            darkTextMuted: '#7dd3fc',
            darkBorderSubtle: '#164065',
            darkBorderHighlight: '#0284c7',
            darkPrimaryColor: '#0284c7',
            darkSecondaryColor: '#0369a1',
            darkAccentColor: '#38bdf8',
            lightBgBody: '#f0f9ff',
            lightBgSurface: '#e0f2fe',
            lightBgCard: '#ffffff',
            lightBgInput: '#ffffff',
            lightTextPrimary: '#0c4a6e',
            lightTextMuted: '#0369a1',
            lightBorderSubtle: '#bae6fd',
            lightBorderHighlight: '#7dd3fc',
            lightPrimaryColor: '#0284c7',
            lightSecondaryColor: '#0369a1',
            lightAccentColor: '#0ea5e9',
            typographyFont: 'Plus Jakarta Sans',
            radiusCard: '1rem',
            radiusButton: '0.75rem'
        }
    },

    applyPreset(key) {
        const p = this.presets[key];
        if (!p) return;
        Object.keys(p).forEach(k => {
            if (this.hasOwnProperty(k)) {
                this[k] = p[k];
            }
        });
    },

    updateLogoPreview(event) {
        const file = event.target.files[0];
        if (file) {
            this.logoPreview = URL.createObjectURL(file);
        }
    },
    updateFaviconPreview(event) {
        const file = event.target.files[0];
        if (file) {
            this.faviconPreview = URL.createObjectURL(file);
        }
    }
}" class="space-y-6 sm:space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">Theme Engine &amp; Visual Identity</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-0.5 sm:mt-1">Full control of dual Light/Dark color systems, typography, geometry, presets, and live simulation.</p>
        </div>

        <!-- Reset Button Action -->
        <form method="POST" action="{{ route('admin.branding.reset') }}" onsubmit="return confirm('Reset all visual theme tokens back to default settings?');">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-rose-900/60 text-slate-300 hover:text-rose-200 border border-slate-700 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Reset to Factory Defaults</span>
            </button>
        </form>
    </div>

    <!-- Presets Quick Bar -->
    <div class="p-3.5 sm:p-4 rounded-xl bg-slate-900/90 border border-slate-800 shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-300">Quick Theme Presets:</span>
            <span class="text-[11px] text-slate-400">Click to apply palette instantly</span>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button type="button" @click="applyPreset('midnight')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-blue-300 border border-blue-500/30 transition">
                Executive Midnight
            </button>
            <button type="button" @click="applyPreset('obsidian')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-emerald-300 border border-emerald-500/30 transition">
                Obsidian Emerald
            </button>
            <button type="button" @click="applyPreset('nordic')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-purple-300 border border-purple-500/30 transition">
                Nordic Violet
            </button>
            <button type="button" @click="applyPreset('sapphire')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-sky-300 border border-sky-500/30 transition">
                Corporate Sapphire
            </button>
        </div>
    </div>

    <!-- Main Editor & Live Preview Grid -->
    <form method="POST" action="{{ route('admin.branding.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        @csrf
        @method('PUT')

        <!-- Left Form Column with Config Tabs -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Navigation Tabs -->
            <div class="flex flex-wrap items-center gap-1.5 p-1 bg-slate-900 border border-slate-800 rounded-xl">
                <button type="button" @click="activeTab = 'dark'" :class="activeTab === 'dark' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                    🌙 Dark Mode Tokens
                </button>
                <button type="button" @click="activeTab = 'light'" :class="activeTab === 'light' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                    ☀️ Light Mode Tokens
                </button>
                <button type="button" @click="activeTab = 'typography'" :class="activeTab === 'typography' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                    📐 Geometry &amp; Fonts
                </button>
                <button type="button" @click="activeTab = 'brand'" :class="activeTab === 'brand' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                    🏢 Company Assets
                </button>
            </div>

            <!-- Tab 1: Dark Mode Tokens -->
            <div x-show="activeTab === 'dark'" x-cloak class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="border-b border-slate-800 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-white">Dark Mode Spectrum</h2>
                        <p class="text-xs text-slate-400">Tokens applied when visitor or system is in Dark Mode</p>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300 text-[10px] font-mono font-bold">Dark Palette</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <!-- Body BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Base Background</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkBgBody" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_bg_body" x-model="darkBgBody" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Surface BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Surface / Secondary BG</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkBgSurface" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_bg_surface" x-model="darkBgSurface" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Card BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Card / Component BG</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkBgCard" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_bg_card" x-model="darkBgCard" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Input BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Input Background</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkBgInput" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_bg_input" x-model="darkBgInput" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Primary Text -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Primary Headings/Text</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkTextPrimary" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_text_primary" x-model="darkTextPrimary" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Muted Text -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Muted Body Text</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkTextMuted" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_text_muted" x-model="darkTextMuted" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Border Subtle -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Border Subtle</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkBorderSubtle" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_border_subtle" x-model="darkBorderSubtle" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Accent / Brand Primary -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Primary Brand Brand Accent</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkPrimaryColor" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_primary_color" x-model="darkPrimaryColor" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Accent Interactive -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">CTA Action Accent (WhatsApp)</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="darkAccentColor" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="dark_accent_color" x-model="darkAccentColor" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Light Mode Tokens -->
            <div x-show="activeTab === 'light'" x-cloak class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="border-b border-slate-800 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-white">Light Mode Spectrum</h2>
                        <p class="text-xs text-slate-400">Tokens applied when visitor or system is in Light Mode</p>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-300 text-[10px] font-mono font-bold">Light Palette</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <!-- Light Body BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Base Background</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightBgBody" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_bg_body" x-model="lightBgBody" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Surface BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Surface / Secondary BG</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightBgSurface" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_bg_surface" x-model="lightBgSurface" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Card BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Card / Component BG</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightBgCard" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_bg_card" x-model="lightBgCard" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Input BG -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Input Background</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightBgInput" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_bg_input" x-model="lightBgInput" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Primary Text -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Primary Headings/Text</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightTextPrimary" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_text_primary" x-model="lightTextPrimary" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Muted Text -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Muted Body Text</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightTextMuted" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_text_muted" x-model="lightTextMuted" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Border Subtle -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Border Subtle</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightBorderSubtle" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_border_subtle" x-model="lightBorderSubtle" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Primary Brand -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Primary Brand Accent</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightPrimaryColor" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_primary_color" x-model="lightPrimaryColor" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>

                    <!-- Light Accent Interactive -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">CTA Action Accent (WhatsApp)</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="lightAccentColor" class="h-8 w-10 rounded bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" name="light_accent_color" x-model="lightAccentColor" class="flex-1 px-3 py-1.5 bg-slate-950/60 border border-slate-800 rounded-lg text-white font-mono uppercase text-xs">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Geometry & Fonts -->
            <div x-show="activeTab === 'typography'" x-cloak class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="border-b border-slate-800 pb-3">
                    <h2 class="text-sm sm:text-base font-bold text-white">Geometry, Radii &amp; Typography</h2>
                    <p class="text-xs text-slate-400">Controls corner roundness, input styles, and font family hierarchy</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <!-- Theme Mode Behavior -->
                    <div class="sm:col-span-2">
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Public Theme Switcher Mode</label>
                        <select name="theme_mode" x-model="themeMode" class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-lg text-white text-xs">
                            <option value="toggle_allowed">Allow Visitor Light/Dark Toggle (Default)</option>
                            <option value="dark_only">Lock to Dark Mode Only</option>
                            <option value="light_only">Lock to Light Mode Only</option>
                            <option value="system">Follow Visitor OS Theme (System)</option>
                        </select>
                    </div>

                    <!-- Default Theme Initial -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Initial Default Theme</label>
                        <select name="active_theme_default" x-model="activeThemeDefault" class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-lg text-white text-xs">
                            <option value="dark">Dark Theme Initial</option>
                            <option value="light">Light Theme Initial</option>
                        </select>
                    </div>

                    <!-- Typography Body Font -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Typography Font Family</label>
                        <select name="typography_font" x-model="typographyFont" class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-lg text-white text-xs">
                            <option value="Plus Jakarta Sans">Plus Jakarta Sans (Modern Editorial)</option>
                            <option value="Inter">Inter (Clean High-Density)</option>
                            <option value="Manrope">Manrope (Geometric Modern)</option>
                            <option value="Space Grotesk">Space Grotesk (Tech Modern)</option>
                            <option value="Outfit">Outfit (Clean Executive)</option>
                        </select>
                    </div>

                    <!-- Card Radius -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Card Border Radius</label>
                        <select name="radius_card" x-model="radiusCard" class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-lg text-white text-xs">
                            <option value="0.5rem">Subtle (8px)</option>
                            <option value="0.75rem">Medium (12px)</option>
                            <option value="1rem">Modern (16px - Default)</option>
                            <option value="1.5rem">Pill Soft (24px)</option>
                            <option value="0rem">Sharp Squared (0px)</option>
                        </select>
                    </div>

                    <!-- Button Radius -->
                    <div>
                        <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Button Border Radius</label>
                        <select name="radius_button" x-model="radiusButton" class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-lg text-white text-xs">
                            <option value="0.5rem">Subtle (8px)</option>
                            <option value="0.75rem">Medium (12px - Default)</option>
                            <option value="1rem">Soft (16px)</option>
                            <option value="9999px">Full Pill (Pill)</option>
                            <option value="0rem">Sharp Squared (0px)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Brand Identity & Media -->
            <div x-show="activeTab === 'brand'" x-cloak class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-5 sm:p-6 shadow-xl space-y-4">
                <div class="border-b border-slate-800 pb-3">
                    <h2 class="text-sm sm:text-base font-bold text-white">Company Identity &amp; Assets</h2>
                    <p class="text-xs text-slate-400">Core company name, tagline, and brand marks</p>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label for="site_name" class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">
                            Company Name <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" id="site_name" name="site_name" x-model="siteName" required class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-lg text-white text-xs">
                    </div>

                    <div>
                        <label for="company_tagline" class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">
                            Company Tagline
                        </label>
                        <input type="text" id="company_tagline" name="company_tagline" x-model="tagline" class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-lg text-white text-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-800">
                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Company Logo</label>
                            <input type="file" name="company_logo" accept=".svg,.png,.jpg,.jpeg,.webp,image/*" @change="updateLogoPreview" class="w-full text-[11px] text-slate-400 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-indigo-300 hover:file:bg-slate-700 cursor-pointer">
                        </div>

                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-300 mb-1">Favicon (.ico, PNG, SVG)</label>
                            <input type="file" name="company_favicon" accept=".ico,.png,.svg,.webp,.jpg,.jpeg,image/*" @change="updateFaviconPreview" class="w-full text-[11px] text-slate-400 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-indigo-300 hover:file:bg-slate-700 cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2 flex items-center justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Visual Theme Configuration</span>
                </button>
            </div>

        </div>

        <!-- Right Live Preview Column -->
        <div class="lg:col-span-5 space-y-4">
            <div class="sticky top-20 space-y-4">
                
                <!-- Live Simulation Card Container -->
                <div class="rounded-2xl border shadow-2xl p-5 space-y-4 backdrop-blur-xl transition-all duration-300"
                     :style="`background-color: ${previewMode === 'dark' ? darkBgBody : lightBgBody}; border-color: ${previewMode === 'dark' ? darkBorderSubtle : lightBorderSubtle}; font-family: '${typographyFont}', sans-serif;`">
                    
                    <!-- Simulation Controller Header -->
                    <div class="flex items-center justify-between pb-3 border-b"
                         :style="`border-color: ${previewMode === 'dark' ? darkBorderSubtle : lightBorderSubtle};`">
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[11px] font-bold uppercase tracking-wider"
                                  :style="`color: ${previewMode === 'dark' ? darkTextPrimary : lightTextPrimary};`">
                                Live Interactive Preview
                            </span>
                        </div>

                        <!-- Mode Switcher in Preview -->
                        <div class="flex items-center gap-1 p-0.5 rounded-lg border"
                             :style="`background-color: ${previewMode === 'dark' ? darkBgSurface : lightBgSurface}; border-color: ${previewMode === 'dark' ? darkBorderSubtle : lightBorderSubtle};`">
                            <button type="button" 
                                    @click="previewMode = 'dark'" 
                                    :class="previewMode === 'dark' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold transition">
                                🌙 Dark
                            </button>
                            <button type="button" 
                                    @click="previewMode = 'light'" 
                                    :class="previewMode === 'light' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-600'"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold transition">
                                ☀️ Light
                            </button>
                        </div>
                    </div>

                    <!-- Simulated Navbar in Box -->
                    <div class="px-3.5 py-2.5 rounded-xl border flex items-center justify-between"
                         :style="`background-color: ${previewMode === 'dark' ? darkBgSurface : lightBgSurface}; border-color: ${previewMode === 'dark' ? darkBorderSubtle : lightBorderSubtle}; border-radius: ${radiusCard};`">
                        <div class="flex items-center gap-2">
                            <template x-if="logoPreview">
                                <img :src="logoPreview" alt="Logo" class="h-5 w-auto object-contain">
                            </template>
                            <template x-if="!logoPreview">
                                <div class="h-6 w-6 rounded-md flex items-center justify-center text-white text-[10px] font-bold"
                                     :style="`background-color: ${previewMode === 'dark' ? darkPrimaryColor : lightPrimaryColor};`"
                                     x-text="siteName ? siteName.substring(0,2).toUpperCase() : 'AP'"></div>
                            </template>
                            <span class="font-bold text-xs"
                                  :style="`color: ${previewMode === 'dark' ? darkTextPrimary : lightTextPrimary};`"
                                  x-text="siteName || 'Apex Corporate'"></span>
                        </div>
                        <span class="text-[9px] px-2 py-0.5 rounded border"
                              :style="`background-color: ${previewMode === 'dark' ? darkBgInput : lightBgInput}; border-color: ${previewMode === 'dark' ? darkBorderSubtle : lightBorderSubtle}; color: ${previewMode === 'dark' ? darkTextMuted : lightTextMuted};`">
                            Navigation Anchor
                        </span>
                    </div>

                    <!-- Simulated Hero Card -->
                    <div class="p-4 rounded-xl border space-y-3"
                         :style="`background-color: ${previewMode === 'dark' ? darkBgCard : lightBgCard}; border-color: ${previewMode === 'dark' ? darkBorderSubtle : lightBorderSubtle}; border-radius: ${radiusCard};`">
                        <div class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold"
                             :style="`background-color: ${(previewMode === 'dark' ? darkPrimaryColor : lightPrimaryColor)}22; color: ${previewMode === 'dark' ? darkPrimaryColor : lightPrimaryColor};`">
                            Enterprise Advisory
                        </div>
                        
                        <h4 class="text-sm font-extrabold leading-snug"
                            :style="`color: ${previewMode === 'dark' ? darkTextPrimary : lightTextPrimary};`">
                            Accelerate Enterprise Velocity with Predictable Scale
                        </h4>

                        <p class="text-[11px] leading-relaxed line-clamp-2"
                           :style="`color: ${previewMode === 'dark' ? darkTextMuted : lightTextMuted};`"
                           x-text="tagline || 'Enterprise Growth Architecture & Scalable Advisory'"></p>

                        <!-- Simulated CTA Button -->
                        <div class="pt-1 flex items-center gap-2">
                            <button type="button" 
                                    class="px-3 py-1.5 text-xs font-bold text-white flex items-center gap-1.5 shadow-sm transition"
                                    :style="`background-color: ${previewMode === 'dark' ? darkAccentColor : lightAccentColor}; border-radius: ${radiusButton};`">
                                <span>Consult on WhatsApp</span>
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.27-2.42 5.83s-3.63 2.42-5.82 2.42c-1.42 0-2.82-.37-4.06-1.07l-.29-.17-3.02.79.81-2.94-.19-.3A8.216 8.216 0 013.8 11.91c0-4.54 3.7-8.24 8.25-8.24z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Simulated Form Input -->
                    <div class="p-3.5 rounded-xl border space-y-2"
                         :style="`background-color: ${previewMode === 'dark' ? darkBgSurface : lightBgSurface}; border-color: ${previewMode === 'dark' ? darkBorderSubtle : lightBorderSubtle}; border-radius: ${radiusCard};`">
                        <label class="block text-[10px] font-semibold uppercase tracking-wider"
                               :style="`color: ${previewMode === 'dark' ? darkTextMuted : lightTextMuted};`">
                            Simulated Input Component
                        </label>
                        <input type="text" readonly value="enterprise.compliance.portal" class="w-full px-3 py-1.5 text-xs font-mono border"
                               :style="`background-color: ${previewMode === 'dark' ? darkBgInput : lightBgInput}; border-color: ${previewMode === 'dark' ? darkBorderHighlight : lightBorderHighlight}; color: ${previewMode === 'dark' ? darkTextPrimary : lightTextPrimary}; border-radius: ${radiusInput};`">
                    </div>

                </div>

            </div>
        </div>
    </form>
</div>
@endsection
