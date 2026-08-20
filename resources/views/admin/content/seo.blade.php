@extends('layouts.admin')

@section('title', 'SEO & Metadata Manager')
@section('page_title', 'SEO & Metadata')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">SEO &amp; Search Engine Optimization</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure global meta titles, search descriptions, keywords, indexing directives, and social OpenGraph parameters.</p>
    </div>

    <form method="POST" action="{{ route('admin.content.seo.update') }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label for="seo_meta_title" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                    Meta Title Tag (Global Default) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="seo_meta_title" 
                       name="seo_meta_title" 
                       value="{{ old('seo_meta_title', $settings['seo_meta_title']) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('seo_meta_title') border-rose-500 @enderror">
                @error('seo_meta_title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="seo_meta_description" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                    Meta Description <span class="text-rose-500">*</span>
                </label>
                <textarea id="seo_meta_description" 
                          name="seo_meta_description" 
                          rows="3" 
                          required 
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('seo_meta_description') border-rose-500 @enderror">{{ old('seo_meta_description', $settings['seo_meta_description']) }}</textarea>
                @error('seo_meta_description') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="seo_meta_keywords" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                    Meta Keywords (Comma separated)
                </label>
                <input type="text" 
                       id="seo_meta_keywords" 
                       name="seo_meta_keywords" 
                       value="{{ old('seo_meta_keywords', $settings['seo_meta_keywords']) }}" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-slate-900 dark:text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                <span>Save SEO Configuration</span>
            </button>
        </div>
    </form>
</div>
@endsection
