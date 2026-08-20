@extends('layouts.admin')

@section('title', 'Edit FAQ Entry')
@section('page_title', 'FAQs / Edit')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Edit FAQ Entry</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Update response and categorization details.</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to FAQs
        </a>
    </div>

    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="question" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Question <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="question" 
                       name="question" 
                       value="{{ old('question', $faq->question) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('question') border-rose-500 @enderror">
                @error('question') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Category Tag (Optional)
                </label>
                <input type="text" 
                       id="category" 
                       name="category" 
                       value="{{ old('category', $faq->category) }}" 
                       placeholder="e.g. Security, Architecture, Pricing, Process" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="answer" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Detailed Answer <span class="text-rose-400">*</span>
                </label>
                <textarea id="answer" 
                          name="answer" 
                          rows="5" 
                          required 
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('answer') border-rose-500 @enderror">{{ old('answer', $faq->answer) }}</textarea>
                @error('answer') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t border-slate-200 dark:border-slate-800 pt-6">
                <div>
                    <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Display Order
                    </label>
                    <input type="number" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', $faq->order) }}" 
                       min="0" 
                           class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex items-center pt-6">
                    <label class="relative flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-100 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">Active / Visible</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-slate-900 dark:text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                Update FAQ
            </button>
        </div>
    </form>
</div>
@endsection
