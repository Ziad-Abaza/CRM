@extends('layouts.admin')

@section('title', __('admin.content.about_title'))
@section('page_title', __('admin.nav.about_section'))

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.content.about_title') }}</h1>
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

    <form method="POST" action="{{ route('admin.content.about.update') }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- English Fields -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div>
                <label for="about_title_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Section Title (English) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="about_title_en" 
                       name="about_title[en]" 
                       value="{{ old('about_title.en', is_array($settings['about_title']) ? ($settings['about_title']['en'] ?? '') : $settings['about_title']) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="about_description_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Primary Story / Overview (English) <span class="text-rose-500">*</span>
                </label>
                <textarea id="about_description_en" 
                          name="about_description[en]" 
                          rows="4" 
                          required 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('about_description.en', is_array($settings['about_description']) ? ($settings['about_description']['en'] ?? '') : $settings['about_description']) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div>
                    <label for="about_bullet_1_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Key Point 1 (English)
                    </label>
                    <input type="text" 
                           id="about_bullet_1_en" 
                           name="about_bullet_1[en]" 
                           value="{{ old('about_bullet_1.en', is_array($settings['about_bullet_1']) ? ($settings['about_bullet_1']['en'] ?? '') : $settings['about_bullet_1']) }}" 
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="about_bullet_2_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Key Point 2 (English)
                    </label>
                    <input type="text" 
                           id="about_bullet_2_en" 
                           name="about_bullet_2[en]" 
                           value="{{ old('about_bullet_2.en', is_array($settings['about_bullet_2']) ? ($settings['about_bullet_2']['en'] ?? '') : $settings['about_bullet_2']) }}" 
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="about_bullet_3_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Key Point 3 (English)
                    </label>
                    <input type="text" 
                           id="about_bullet_3_en" 
                           name="about_bullet_3[en]" 
                           value="{{ old('about_bullet_3.en', is_array($settings['about_bullet_3']) ? ($settings['about_bullet_3']['en'] ?? '') : $settings['about_bullet_3']) }}" 
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <!-- Arabic Fields -->
        <div x-show="langTab === 'ar'" x-cloak class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_ar') }}</span>
            </div>

            <div>
                <label for="about_title_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    عنوان القسم (العربية) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="about_title_ar" 
                       name="about_title[ar]" 
                       value="{{ old('about_title.ar', is_array($settings['about_title']) ? ($settings['about_title']['ar'] ?? '') : $settings['about_title']) }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="about_description_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    القصة والرؤية المؤسسية (العربية) <span class="text-rose-500">*</span>
                </label>
                <textarea id="about_description_ar" 
                          name="about_description[ar]" 
                          rows="4" 
                          required 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('about_description.ar', is_array($settings['about_description']) ? ($settings['about_description']['ar'] ?? '') : $settings['about_description']) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div>
                    <label for="about_bullet_1_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        النقطة المميزة 1 (العربية)
                    </label>
                    <input type="text" 
                           id="about_bullet_1_ar" 
                           name="about_bullet_1[ar]" 
                           value="{{ old('about_bullet_1.ar', is_array($settings['about_bullet_1']) ? ($settings['about_bullet_1']['ar'] ?? '') : $settings['about_bullet_1']) }}" 
                           dir="rtl"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="about_bullet_2_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        النقطة المميزة 2 (العربية)
                    </label>
                    <input type="text" 
                           id="about_bullet_2_ar" 
                           name="about_bullet_2[ar]" 
                           value="{{ old('about_bullet_2.ar', is_array($settings['about_bullet_2']) ? ($settings['about_bullet_2']['ar'] ?? '') : $settings['about_bullet_2']) }}" 
                           dir="rtl"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="about_bullet_3_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        النقطة المميزة 3 (العربية)
                    </label>
                    <input type="text" 
                           id="about_bullet_3_ar" 
                           name="about_bullet_3[ar]" 
                           value="{{ old('about_bullet_3.ar', is_array($settings['about_bullet_3']) ? ($settings['about_bullet_3']['ar'] ?? '') : $settings['about_bullet_3']) }}" 
                           dir="rtl"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
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
