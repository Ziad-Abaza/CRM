@extends('layouts.admin')

@section('title', __('ui.buttons.edit') . ': FAQ')
@section('page_title', __('admin.faqs.title'))

@php
    $questionTrans = $faq->getTranslations('question');
    $answerTrans = $faq->getTranslations('answer');
    $categoryTrans = $faq->getTranslations('category');
@endphp

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('ui.buttons.edit') }}: FAQ #{{ $faq->id }}</h1>
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
            <a href="{{ route('admin.faqs.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
                &larr; {{ __('ui.buttons.back') }}
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <!-- English Tab -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div>
                <label for="question_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Question (English) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="question_en" 
                       name="question[en]" 
                       value="{{ old('question.en', $questionTrans['en'] ?? $faq->question) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="answer_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Detailed Answer (English) <span class="text-rose-400">*</span>
                </label>
                <textarea id="answer_en" 
                          name="answer[en]" 
                          rows="4" 
                          required 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('answer.en', $answerTrans['en'] ?? $faq->answer) }}</textarea>
            </div>

            <div>
                <label for="category_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Category Tag (English)
                </label>
                <input type="text" 
                       id="category_en" 
                       name="category[en]" 
                       value="{{ old('category.en', $categoryTrans['en'] ?? $faq->category) }}" 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Arabic Tab -->
        <div x-show="langTab === 'ar'" x-cloak class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_ar') }}</span>
            </div>

            <div>
                <label for="question_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    السؤال (العربية) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="question_ar" 
                       name="question[ar]" 
                       value="{{ old('question.ar', $questionTrans['ar'] ?? '') }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="answer_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    الإجابة التفصيلية (العربية) <span class="text-rose-400">*</span>
                </label>
                <textarea id="answer_ar" 
                          name="answer[ar]" 
                          rows="4" 
                          required 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('answer.ar', $answerTrans['ar'] ?? '') }}</textarea>
            </div>

            <div>
                <label for="category_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    تصنيف السؤال (العربية)
                </label>
                <input type="text" 
                       id="category_ar" 
                       name="category[ar]" 
                       value="{{ old('category.ar', $categoryTrans['ar'] ?? '') }}" 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Global Fields -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.faqs.order_label') }}
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $faq->order) }}" 
                       min="0" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.faqs.is_active_label') }}</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">{{ __('ui.buttons.cancel') }}</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                {{ __('ui.buttons.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
