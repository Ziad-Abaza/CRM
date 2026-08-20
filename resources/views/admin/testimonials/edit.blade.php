@extends('layouts.admin')

@section('title', __('ui.buttons.edit') . ': ' . $testimonial->client_name)
@section('page_title', __('admin.testimonials.title'))

@php
    $roleTrans = $testimonial->getTranslations('client_role');
    $companyTrans = $testimonial->getTranslations('company');
    $contentTrans = $testimonial->getTranslations('content');
@endphp

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('ui.buttons.edit') }}: {{ $testimonial->client_name }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('admin.content.switch_tab_notice') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="inline-flex items-center gap-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-1 rounded-xl shadow-sm text-xs">
                <button type="button" @click="langTab = 'en'" :class="langTab === 'en' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    {{ __('admin.content.bilingual_tab_en') }}
                </button>
                <button type="button" @click="langTab = 'ar'" :class="langTab === 'ar' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    {{ __('admin.content.bilingual_tab_ar') }}
                </button>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
                &larr; {{ __('ui.buttons.back') }}
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <!-- English Tab -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="client_role_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Job Title / Position (English)
                    </label>
                    <input type="text" 
                           id="client_role_en" 
                           name="client_role[en]" 
                           value="{{ old('client_role.en', $roleTrans['en'] ?? $testimonial->client_role) }}" 
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="company_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Company / Organization (English)
                    </label>
                    <input type="text" 
                           id="company_en" 
                           name="company[en]" 
                           value="{{ old('company.en', $companyTrans['en'] ?? $testimonial->company) }}" 
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="content_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Testimonial Statement (English) <span class="text-rose-400">*</span>
                </label>
                <textarea id="content_en" 
                          name="content[en]" 
                          rows="4" 
                          required 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('content.en', $contentTrans['en'] ?? $testimonial->content) }}</textarea>
            </div>
        </div>

        <!-- Arabic Tab -->
        <div x-show="langTab === 'ar'" x-cloak class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_ar') }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="client_role_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        المسمى الوظيفي (العربية)
                    </label>
                    <input type="text" 
                           id="client_role_ar" 
                           name="client_role[ar]" 
                           value="{{ old('client_role.ar', $roleTrans['ar'] ?? '') }}" 
                           dir="rtl"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="company_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        الشركة / المؤسسة (العربية)
                    </label>
                    <input type="text" 
                           id="company_ar" 
                           name="company[ar]" 
                           value="{{ old('company.ar', $companyTrans['ar'] ?? '') }}" 
                           dir="rtl"
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="content_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    نص التوصية والشهادة (العربية) <span class="text-rose-400">*</span>
                </label>
                <textarea id="content_ar" 
                          name="content[ar]" 
                          rows="4" 
                          required 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('content.ar', $contentTrans['ar'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Global Fields -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="client_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.testimonials.name_label') }} <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="client_name" 
                       name="client_name" 
                       value="{{ old('client_name', $testimonial->client_name) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="rating" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.testimonials.rating_label') }} <span class="text-rose-400">*</span>
                </label>
                <select name="rating" id="rating" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 Stars</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.testimonials.avatar_label') }}
                </label>
                @if($testimonial->avatar)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $testimonial->avatar }}" alt="{{ $testimonial->client_name }}" class="w-12 h-12 rounded-full object-cover border border-slate-700">
                    </div>
                @endif
                <input type="file" 
                       name="avatar" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-500 dark:text-slate-400 file:me-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
            </div>

            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.testimonials.order_label') }}
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $testimonial->order) }}" 
                       min="0" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-2 flex flex-wrap items-center gap-6 pt-2">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.testimonials.is_featured_label') }}</span>
                </label>

                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.testimonials.is_active_label') }}</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.testimonials.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">{{ __('ui.buttons.cancel') }}</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                {{ __('ui.buttons.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
