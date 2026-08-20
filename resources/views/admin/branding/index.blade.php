@extends('layouts.admin')

@section('title', 'Branding & Theme Customizer')
@section('page_title', 'Branding & Theme')

@section('content')
<div x-data="{ 
    siteName: '{{ addslashes($settings['site_name'] ?? '') }}',
    tagline: '{{ addslashes($settings['company_tagline'] ?? '') }}',
    primaryColor: '{{ $settings['primary_color'] ?? '#0f172a' }}',
    accentColor: '{{ $settings['accent_color'] ?? '#3b82f6' }}',
    logoPreview: '{{ $settings['company_logo'] ?? '' }}',
    faviconPreview: '{{ $settings['company_favicon'] ?? '' }}',
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
}" class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Branding & Live Theme Customizer</h1>
            <p class="text-sm text-slate-400 mt-1">Configure company identity, brand assets, color palette, and preview real-time changes.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.branding.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        @method('PUT')

        <!-- Left Form Column -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Identity Details -->
            <div class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-6 shadow-xl space-y-5">
                <div class="border-b border-slate-800 pb-3">
                    <h2 class="text-base font-bold text-white">Company Identity</h2>
                    <p class="text-xs text-slate-400">Core names and brand expressions displayed on public pages</p>
                </div>

                <div>
                    <label for="site_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Company / Brand Name <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="site_name"
                           name="site_name"
                           x-model="siteName"
                           required
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm @error('site_name') border-rose-500 @enderror">
                    @error('site_name')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="company_tagline" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Company Tagline / Subtitle
                    </label>
                    <input type="text" 
                           id="company_tagline"
                           name="company_tagline"
                           x-model="tagline"
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
            </div>

            <!-- Visual Color Palette -->
            <div class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-6 shadow-xl space-y-5">
                <div class="border-b border-slate-800 pb-3">
                    <h2 class="text-base font-bold text-white">Color Palette & Accents</h2>
                    <p class="text-xs text-slate-400">Controls contrast levels, buttons, and high-impact UI highlights</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Primary Color -->
                    <div>
                        <label for="primary_color" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Primary Background / Deep Color <span class="text-rose-400">*</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="color" 
                                   id="primary_color_picker" 
                                   x-model="primaryColor" 
                                   class="h-10 w-12 rounded-lg bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" 
                                   id="primary_color" 
                                   name="primary_color" 
                                   x-model="primaryColor" 
                                   required 
                                   pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                   class="flex-1 px-4 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white font-mono text-sm uppercase focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('primary_color') border-rose-500 @enderror">
                        </div>
                        @error('primary_color')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Accent Color -->
                    <div>
                        <label for="accent_color" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Accent / Interactive Color <span class="text-rose-400">*</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="color" 
                                   id="accent_color_picker" 
                                   x-model="accentColor" 
                                   class="h-10 w-12 rounded-lg bg-transparent border-0 cursor-pointer p-0">
                            <input type="text" 
                                   id="accent_color" 
                                   name="accent_color" 
                                   x-model="accentColor" 
                                   required 
                                   pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                   class="flex-1 px-4 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white font-mono text-sm uppercase focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('accent_color') border-rose-500 @enderror">
                        </div>
                        @error('accent_color')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Brand Assets / File Uploads -->
            <div class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-6 shadow-xl space-y-5">
                <div class="border-b border-slate-800 pb-3">
                    <h2 class="text-base font-bold text-white">Brand Assets & Media</h2>
                    <p class="text-xs text-slate-400">High-resolution logo and site favicon (MIME checked)</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Logo Upload -->
                    <div>
                        <label for="company_logo" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Company Logo (SVG, PNG, WebP, JPG)
                        </label>
                        <input type="file" 
                               id="company_logo" 
                               name="company_logo" 
                               accept=".svg,.png,.jpg,.jpeg,.webp,image/*" 
                               @change="updateLogoPreview"
                               class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-indigo-300 hover:file:bg-slate-700 cursor-pointer">
                        @error('company_logo')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Favicon Upload -->
                    <div>
                        <label for="company_favicon" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                            Favicon (.ico, PNG, SVG, WebP)
                        </label>
                        <input type="file" 
                               id="company_favicon" 
                               name="company_favicon" 
                               accept=".ico,.png,.svg,.webp,.jpg,.jpeg,image/*" 
                               @change="updateFaviconPreview"
                               class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-indigo-300 hover:file:bg-slate-700 cursor-pointer">
                        @error('company_favicon')
                            <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Save Brand Configuration</span>
                </button>
            </div>
        </div>

        <!-- Right Live Preview Column -->
        <div class="lg:col-span-5 space-y-6">
            <div class="sticky top-24 space-y-6">
                <!-- Preview Card -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">Live Visual Simulation</h3>
                        </div>
                        <span class="text-[10px] font-mono text-slate-400">Alpine.js State</span>
                    </div>

                    <!-- Simulated Hero Card Preview -->
                    <div class="rounded-xl p-6 border transition-all duration-200" 
                         :style="`background-color: ${primaryColor}; border-color: rgba(255,255,255,0.1);`">
                        
                        <!-- Mini Nav in simulation -->
                        <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4">
                            <div class="flex items-center gap-2.5">
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" alt="Logo" class="h-6 w-auto object-contain">
                                </template>
                                <template x-if="!logoPreview">
                                    <div class="h-6 w-6 rounded-md bg-white/10 flex items-center justify-center text-white text-[10px] font-bold"
                                         x-text="siteName ? siteName.substring(0,2).toUpperCase() : 'AP'"></div>
                                </template>
                                <span class="font-bold text-xs text-white tracking-tight" x-text="siteName || 'Apex Corporate'"></span>
                            </div>
                            <span class="text-[10px] text-slate-300 font-mono px-2 py-0.5 rounded bg-white/10">Navbar</span>
                        </div>

                        <!-- Mini Hero in simulation -->
                        <div class="space-y-3">
                            <div class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold text-white tracking-wide"
                                 :style="`background-color: ${accentColor}33; border: 1px solid ${accentColor}66; color: #fff;`">
                                Enterprise Strategic Advisory
                            </div>
                            <h4 class="text-base font-extrabold text-white leading-tight">
                                High-Throughput Corporate Scaling Solutions
                            </h4>
                            <p class="text-xs text-slate-300 leading-relaxed" x-text="tagline || 'Enterprise Growth Architecture & Scalable Advisory'"></p>

                            <!-- Interactive Button Preview -->
                            <div class="pt-2">
                                <button type="button" 
                                        class="px-4 py-2 rounded-lg text-xs font-bold text-white shadow-md transition flex items-center gap-1.5"
                                        :style="`background-color: ${accentColor};`">
                                    <span>Consult via WhatsApp</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Color Values Reference -->
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="p-3 bg-slate-950/60 rounded-xl border border-slate-800">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Primary Base</span>
                            <span class="font-mono font-bold text-white" x-text="primaryColor"></span>
                        </div>
                        <div class="p-3 bg-slate-950/60 rounded-xl border border-slate-800">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Interactive Accent</span>
                            <span class="font-mono font-bold text-white" x-text="accentColor"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
