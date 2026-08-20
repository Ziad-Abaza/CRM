@extends('layouts.admin')

@section('title', 'Add Testimonial')
@section('page_title', 'Testimonials / New')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Add Client Testimonial</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Register executive endorsement and review details.</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to Testimonials
        </a>
    </div>

    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="client_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Client Full Name <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="client_name" 
                       name="client_name" 
                       value="{{ old('client_name') }}" 
                       required 
                       placeholder="e.g. Sarah Jenkins" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('client_name') border-rose-500 @enderror">
                @error('client_name') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="client_role" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Job Title / Role
                </label>
                <input type="text" 
                       id="client_role" 
                       name="client_role" 
                       value="{{ old('client_role') }}" 
                       placeholder="e.g. Chief Technology Officer" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="company" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Company Name
                </label>
                <input type="text" 
                       id="company" 
                       name="company" 
                       value="{{ old('company') }}" 
                       placeholder="e.g. Horizon Fintech Global" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="rating" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Star Rating (1-5) <span class="text-rose-400">*</span>
                </label>
                <select name="rating" id="rating" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="5" {{ old('rating', '5') == 5 ? 'selected' : '' }}>5 Stars - Exceptional</option>
                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars - Great</option>
                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars - Average</option>
                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Stars - Fair</option>
                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Star - Poor</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Client Photo / Avatar
                </label>
                <input type="file" 
                       name="avatar" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
            </div>

            <div class="sm:col-span-3">
                <label for="content" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Testimonial Quote <span class="text-rose-400">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="4" 
                          required 
                          placeholder="Quote describing the outcome, ROI, or strategic impact..." 
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('content') border-rose-500 @enderror">{{ old('content') }}</textarea>
                @error('content') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Toggles & Order -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Order Index
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', 0) }}" 
                       min="0" 
                       class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-100 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">Feature on Home Carousel</span>
                </label>
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-100 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">Active / Live</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.testimonials.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-slate-900 dark:text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                Create Testimonial
            </button>
        </div>
    </form>
</div>
@endsection
