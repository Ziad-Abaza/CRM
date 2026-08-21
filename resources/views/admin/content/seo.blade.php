@extends('layouts.admin')

@section('title', __('admin.content.seo_title'))
@section('page_title', __('admin.nav.seo_metadata'))

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.content.seo_title') }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('admin.content.switch_tab_notice') }}</p>
        </div>

        <!-- Language Tabs -->
        <div class="inline-flex items-center gap-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-1 rounded-xl shadow-sm text-xs">
            <button type="button" @click="langTab = 'en'" :class="langTab === 'en' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                {{ __('admin.content.bilingual_tab_en') }}
            </button>
            <button type="button" @click="langTab = 'ar'" :class="langTab === 'ar' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                {{ __('admin.content.bilingual_tab_ar') }}
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.content.seo.update') }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- English Fields -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div>
                <label for="seo_meta_title_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.content.seo_meta_title_label') }} ({{ __('admin.content.bilingual_tab_en') }}) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="seo_meta_title_en" 
                       name="seo_meta_title[en]" 
                       value="{{ old('seo_meta_title.en', is_array($settings['seo_meta_title']) ? ($settings['seo_meta_title']['en'] ?? '') : $settings['seo_meta_title']) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="seo_meta_description_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.content.seo_meta_desc_label') }} ({{ __('admin.content.bilingual_tab_en') }}) <span class="text-rose-500">*</span>
                </label>
                <textarea id="seo_meta_description_en" 
                          name="seo_meta_description[en]" 
                          rows="3" 
                          required 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('seo_meta_description.en', is_array($settings['seo_meta_description']) ? ($settings['seo_meta_description']['en'] ?? '') : $settings['seo_meta_description']) }}</textarea>
            </div>

            <div>
                <label for="seo_meta_keywords_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.content.seo_keywords_label') }} ({{ __('admin.content.bilingual_tab_en') }})
                </label>
                <input type="text" 
                       id="seo_meta_keywords_en" 
                       name="seo_meta_keywords[en]" 
                       value="{{ old('seo_meta_keywords.en', is_array($settings['seo_meta_keywords']) ? ($settings['seo_meta_keywords']['en'] ?? '') : $settings['seo_meta_keywords']) }}" 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Arabic Fields -->
        <div x-show="langTab === 'ar'" x-cloak class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_ar') }}</span>
            </div>

            <div>
                <label for="seo_meta_title_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.content.seo_meta_title_label') }} ({{ __('admin.content.bilingual_tab_ar') }}) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="seo_meta_title_ar" 
                       name="seo_meta_title[ar]" 
                       value="{{ old('seo_meta_title.ar', is_array($settings['seo_meta_title']) ? ($settings['seo_meta_title']['ar'] ?? '') : $settings['seo_meta_title']) }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="seo_meta_description_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.content.seo_meta_desc_label') }} ({{ __('admin.content.bilingual_tab_ar') }}) <span class="text-rose-500">*</span>
                </label>
                <textarea id="seo_meta_description_ar" 
                          name="seo_meta_description[ar]" 
                          rows="3" 
                          required 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('seo_meta_description.ar', is_array($settings['seo_meta_description']) ? ($settings['seo_meta_description']['ar'] ?? '') : $settings['seo_meta_description']) }}</textarea>
            </div>

            <div>
                <label for="seo_meta_keywords_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.content.seo_keywords_label') }} ({{ __('admin.content.bilingual_tab_ar') }})
                </label>
                <input type="text" 
                       id="seo_meta_keywords_ar" 
                       name="seo_meta_keywords[ar]" 
                       value="{{ old('seo_meta_keywords.ar', is_array($settings['seo_meta_keywords']) ? ($settings['seo_meta_keywords']['ar'] ?? '') : $settings['seo_meta_keywords']) }}" 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                <span>{{ __('ui.buttons.save_changes') }}</span>
            </button>
        </div>
    </form>
</div>
@endsection
