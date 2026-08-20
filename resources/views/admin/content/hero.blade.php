@extends('layouts.admin')

@section('title', __('admin.content.hero_title'))
@section('page_title', __('admin.nav.hero_section'))

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.content.hero_title') }}</h1>
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

    <form method="POST" action="{{ route('admin.content.hero.update') }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- English Fields -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div>
                <label for="hero_badge_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Eyebrow / Badge Text (English) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="hero_badge_en" 
                       name="hero_badge[en]"
                       value="{{ old('hero_badge.en', is_array($settings['hero_badge']) ? ($settings['hero_badge']['en'] ?? '') : $settings['hero_badge']) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="hero_title_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Hero Main Headline (English) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="hero_title_en"
                       name="hero_title[en]"
                       value="{{ old('hero_title.en', is_array($settings['hero_title']) ? ($settings['hero_title']['en'] ?? '') : $settings['hero_title']) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="hero_subtitle_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Hero Subtitle / Description (English) <span class="text-rose-500">*</span>
                </label>
                <textarea id="hero_subtitle_en" 
                          name="hero_subtitle[en]"
                          rows="3" 
                          required 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('hero_subtitle.en', is_array($settings['hero_subtitle']) ? ($settings['hero_subtitle']['en'] ?? '') : $settings['hero_subtitle']) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="hero_cta_text_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        CTA Button Label (English) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="hero_cta_text_en"
                           name="hero_cta_text[en]" 
                           value="{{ old('hero_cta_text.en', is_array($settings['hero_cta_text']) ? ($settings['hero_cta_text']['en'] ?? '') : $settings['hero_cta_text']) }}" 
                           required 
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="hero_cta_whatsapp_message_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        WhatsApp Message (English) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="hero_cta_whatsapp_message_en" 
                           name="hero_cta_whatsapp_message[en]"
                           value="{{ old('hero_cta_whatsapp_message.en', is_array($settings['hero_cta_whatsapp_message']) ? ($settings['hero_cta_whatsapp_message']['en'] ?? '') : $settings['hero_cta_whatsapp_message']) }}" 
                           required 
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="hero_rating_count_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Rating Label (English)
                </label>
                <input type="text" 
                       id="hero_rating_count_en" 
                       name="hero_rating_count[en]" 
                       value="{{ old('hero_rating_count.en', is_array($settings['hero_rating_count']) ? ($settings['hero_rating_count']['en'] ?? '') : $settings['hero_rating_count']) }}" 
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
                <label for="hero_badge_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    النص الترويجي العلوي (العربية) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="hero_badge_ar" 
                       name="hero_badge[ar]"
                       value="{{ old('hero_badge.ar', is_array($settings['hero_badge']) ? ($settings['hero_badge']['ar'] ?? '') : $settings['hero_badge']) }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="hero_title_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    العنوان الرئيسي (العربية) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="hero_title_ar"
                       name="hero_title[ar]"
                       value="{{ old('hero_title.ar', is_array($settings['hero_title']) ? ($settings['hero_title']['ar'] ?? '') : $settings['hero_title']) }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="hero_subtitle_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    الوصف التفصيلي (العربية) <span class="text-rose-500">*</span>
                </label>
                <textarea id="hero_subtitle_ar" 
                          name="hero_subtitle[ar]"
                          rows="3" 
                          required 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('hero_subtitle.ar', is_array($settings['hero_subtitle']) ? ($settings['hero_subtitle']['ar'] ?? '') : $settings['hero_subtitle']) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="hero_cta_text_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        نص زر الإجراء (العربية) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="hero_cta_text_ar"
                           name="hero_cta_text[ar]" 
                           value="{{ old('hero_cta_text.ar', is_array($settings['hero_cta_text']) ? ($settings['hero_cta_text']['ar'] ?? '') : $settings['hero_cta_text']) }}" 
                           required 
                           dir="rtl"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="hero_cta_whatsapp_message_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        رسالة واتساب المعبأة مسبقاً (العربية) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="hero_cta_whatsapp_message_ar" 
                           name="hero_cta_whatsapp_message[ar]"
                           value="{{ old('hero_cta_whatsapp_message.ar', is_array($settings['hero_cta_whatsapp_message']) ? ($settings['hero_cta_whatsapp_message']['ar'] ?? '') : $settings['hero_cta_whatsapp_message']) }}" 
                           required 
                           dir="rtl"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="hero_rating_count_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    وصف التقييم / العملاء (العربية)
                </label>
                <input type="text" 
                       id="hero_rating_count_ar" 
                       name="hero_rating_count[ar]" 
                       value="{{ old('hero_rating_count.ar', is_array($settings['hero_rating_count']) ? ($settings['hero_rating_count']['ar'] ?? '') : $settings['hero_rating_count']) }}" 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Global Field (Rating Score) -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
            <div class="max-w-xs">
                <label for="hero_rating_score" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Rating Score (e.g. 4.9/5.0)
                </label>
                <input type="text" 
                       id="hero_rating_score" 
                       name="hero_rating_score" 
                       value="{{ old('hero_rating_score', $settings['hero_rating_score']) }}" 
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
