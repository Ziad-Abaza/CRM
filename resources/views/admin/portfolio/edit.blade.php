@extends('layouts.admin')

@section('title', __('admin.portfolio.table_title') . ': ' . $portfolio->title)
@section('page_title', __('admin.portfolio.table_title'))

@php
    $titleTrans = $portfolio->getTranslations('title');
    $summaryTrans = $portfolio->getTranslations('summary');
    $contentTrans = $portfolio->getTranslations('content');
@endphp

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ 
    langTab: 'en',
    tech_items: {{ json_encode(old('technologies', $portfolio->technologies ?: ['Laravel', 'PostgreSQL'])) }}
}">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('ui.buttons.edit') }}: {{ $portfolio->title }}</h1>
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
            <a href="{{ route('admin.portfolio.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
                &larr; {{ __('ui.buttons.back') }}
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.portfolio.update', $portfolio) }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <!-- English Tab -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div>
                <label for="title_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Project Title (English) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="title_en" 
                       name="title[en]" 
                       value="{{ old('title.en', $titleTrans['en'] ?? $portfolio->title) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="summary_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Project Summary (English)
                </label>
                <textarea id="summary_en" 
                          name="summary[en]" 
                          rows="2" 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('summary.en', $summaryTrans['en'] ?? $portfolio->summary) }}</textarea>
            </div>

            <div>
                <label for="content_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Case Study Details (English)
                </label>
                <textarea id="content_en" 
                          name="content[en]" 
                          rows="4" 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('content.en', $contentTrans['en'] ?? $portfolio->content) }}</textarea>
            </div>
        </div>

        <!-- Arabic Tab -->
        <div x-show="langTab === 'ar'" x-cloak class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_ar') }}</span>
            </div>

            <div>
                <label for="title_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    عنوان المشروع (العربية) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="title_ar" 
                       name="title[ar]" 
                       value="{{ old('title.ar', $titleTrans['ar'] ?? '') }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="summary_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    ملخص المشروع (العربية)
                </label>
                <textarea id="summary_ar" 
                          name="summary[ar]" 
                          rows="2" 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('summary.ar', $summaryTrans['ar'] ?? '') }}</textarea>
            </div>

            <div>
                <label for="content_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    تفاصيل دراسة الحالة (العربية)
                </label>
                <textarea id="content_ar" 
                          name="content[ar]" 
                          rows="4" 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('content.ar', $contentTrans['ar'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Global Details -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.portfolio.category_label') }}
                </label>
                <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">{{ __('ui.filter.all') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $portfolio->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="client" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.portfolio.client_label') }}
                </label>
                <input type="text" 
                       id="client" 
                       name="client" 
                       value="{{ old('client', $portfolio->client) }}" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="slug" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    URL Slug
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug', $portfolio->slug) }}" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="website_url" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.portfolio.url_label') }}
                </label>
                <input type="url" 
                       id="website_url" 
                       name="website_url" 
                       value="{{ old('website_url', $portfolio->website_url) }}" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.portfolio.image_label') }}
                </label>
                @if($portfolio->image)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $portfolio->image }}" alt="{{ $portfolio->title }}" class="w-16 h-12 rounded-xl object-cover border border-slate-700">
                    </div>
                @endif
                <input type="file" 
                       name="image" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-500 dark:text-slate-400 file:me-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
            </div>

            <!-- Tech Stack Array -->
            <div class="sm:col-span-2 border-t border-slate-200 dark:border-slate-800 pt-4 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        {{ __('admin.portfolio.tech_label') }}
                    </label>
                    <button type="button" @click="tech_items.push('')" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800/60 hover:bg-indigo-100 transition">
                        + {{ __('ui.buttons.add') }}
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <template x-for="(tech, index) in tech_items" :key="index">
                        <div class="flex items-center gap-1">
                            <input type="text" 
                                   :name="'technologies[' + index + ']'" 
                                   x-model="tech_items[index]" 
                                   class="flex-1 px-3 py-1.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-lg text-slate-900 dark:text-white text-xs font-mono focus:ring-2 focus:ring-indigo-500">
                            <button type="button" @click="tech_items.splice(index, 1)" class="p-1.5 text-slate-400 hover:text-rose-500 rounded" aria-label="{{ __('ui.buttons.delete') }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.portfolio.order_label') }}
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $portfolio->order) }}" 
                       min="0" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex flex-wrap items-center gap-6 pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.portfolio.is_featured_label') }}</span>
                </label>

                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $portfolio->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.portfolio.is_active_label') }}</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.portfolio.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">{{ __('ui.buttons.cancel') }}</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                {{ __('ui.buttons.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
