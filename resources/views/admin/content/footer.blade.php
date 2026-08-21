@extends('layouts.admin')

@section('title', __('admin.content.footer_title'))
@section('page_title', __('admin.nav.footer_section'))

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.content.footer_title') }}</h1>
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

    <form method="POST" action="{{ route('admin.content.footer.update') }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- English Fields -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div>
                <label for="footer_about_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Footer About Synopsis (English) <span class="text-rose-500">*</span>
                </label>
                <textarea id="footer_about_en" 
                          name="footer_about[en]" 
                          rows="3" 
                          required 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('footer_about.en', is_array($settings['footer_about']) ? ($settings['footer_about']['en'] ?? '') : $settings['footer_about']) }}</textarea>
            </div>

            <div>
                <label for="footer_copyright_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Copyright Notice (English) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="footer_copyright_en" 
                       name="footer_copyright[en]" 
                       value="{{ old('footer_copyright.en', is_array($settings['footer_copyright']) ? ($settings['footer_copyright']['en'] ?? '') : $settings['footer_copyright']) }}" 
                       required 
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
                <label for="footer_about_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    نبذة التذييل (العربية) <span class="text-rose-500">*</span>
                </label>
                <textarea id="footer_about_ar" 
                          name="footer_about[ar]" 
                          rows="3" 
                          required 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('footer_about.ar', is_array($settings['footer_about']) ? ($settings['footer_about']['ar'] ?? '') : $settings['footer_about']) }}</textarea>
            </div>

            <div>
                <label for="footer_copyright_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    حقوق النشر (العربية) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="footer_copyright_ar" 
                       name="footer_copyright[ar]" 
                       value="{{ old('footer_copyright.ar', is_array($settings['footer_copyright']) ? ($settings['footer_copyright']['ar'] ?? '') : $settings['footer_copyright']) }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Social Channels &amp; Links</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="social_linkedin" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        LinkedIn Profile URL
                    </label>
                    <input type="url" 
                           id="social_linkedin" 
                           name="social_linkedin" 
                           value="{{ old('social_linkedin', $settings['social_linkedin']) }}" 
                           placeholder="https://linkedin.com/company/yourcompany"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('social_linkedin') border-rose-500 @enderror">
                    @error('social_linkedin') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="social_twitter" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Twitter / X Profile URL
                    </label>
                    <input type="url" 
                           id="social_twitter" 
                           name="social_twitter" 
                           value="{{ old('social_twitter', $settings['social_twitter']) }}" 
                           placeholder="https://x.com/yourcompany"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('social_twitter') border-rose-500 @enderror">
                    @error('social_twitter') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
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
