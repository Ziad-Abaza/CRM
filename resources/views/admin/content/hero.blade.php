@extends('layouts.admin')

@section('title', 'Hero Section Manager')
@section('page_title', 'Hero Section')

@section('content')
<div class="max-w-4l space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Hero Section Configuration</h1>
        <p class="text-sm text-slate-400 mt-1">Configure primary headline, value proposition, rating proof badge, and main WhatsApp CTA.</p>
    </div>

    <form method="POST" action="{{ route('admin.content.hero.update') }}" class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <!-- Badge & Headline -->
        <div class="space-y-4">
            <div>
                <label for="hero_badge" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Eyebrow / Badge Text <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="hero_badge" 
                       name="hero_badge"
                       value="{{ old('hero_badge', $settings['hero_badge']) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('hero_badge') border-rose-500 @enderror">
                @error('hero_badge') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="hero_title" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Hero Main Headline <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="hero_title"
                       name="hero_title"
                       value="{{ old('hero_title', $settings['hero_title']) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('hero_title') border-rose-500 @enderror">
                @error('hero_title') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="hero_subtitle" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Hero Subtitle / Description <span class="text-rose-400">*</span>
                </label>
                <textarea id="hero_subtitle" 
                          name="hero_subtitle"
                          rows="3" 
                          required 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('hero_subtitle') border-rose-500 @enderror">{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
                @error('hero_subtitle') <p class="mt-1 text-xs text-rose-400":{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- WhatsApp Primary CTA Settings -->
        <div class="border-t border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Primary WhatsApp Action</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="hero_cta_text" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        CTA Button Label <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="hero_cta_text"
                           name="hero_cta_text" 
                           value="{{ old('hero_cta_text', $settings['hero_cta_text']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('hero_cta_text') border-rose-500 @enderror">
                    @error('hero_cta_text') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="hero_cta_whatsapp_message" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Pre-filled WhatsApp Message <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                          id="hero_cta_whatsapp_message" 
                           name="hero_cta_whatsapp_message"
                           value="{{ old('hero_cta_whatsapp_message', $settings['hero_cta_whatsapp_message']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('hero_cta_whatsapp_message') border-rose-500 @enderror">
                    @error('hero_cta_whatsapp_message') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Social Proof Stats -->
        <div class="border-t border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Rating & Social Proof Metric</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="hero_rating_score" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Rating Score (e.g. 4.9/5.0)
                    </label>
                    <input type="text" 
                           id="hero_rating_score" 
                           name="hero_rating_score" 
                           value="{{ old('hero_rating_score', $settings['hero_rating_score']) }}" 
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="hero_rating_count" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Rating / Proof Label (e.g. 250+ Enterprise Clients)
                    </label>
                    <input type="text" 
                          id="hero_rating_count" 
                          name="hero_rating_count" 
                           value="{{ old('hero_rating_count', $settings['hero_rating_count']) }}" 
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                <span>Save Hero Section</span>
            </button>
        </div>
    </form>
</div>
@endsection
