@extends('layouts.admin')

@section('title', 'Add Case Study')
@section('page_title', 'Portfolio / New')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Create Case Study</h1>
            <p class="text-sm text-slate-400 mt-1">Publish an enterprise success story and implementation architecture.</p>
        </div>
        <a href="{{ route('admin.portfolio.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to Portfolio
        </a>
    </div>

    <form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data" class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Case Study Title <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required 
                       placeholder="e.g. Global Fintech Cloud Modernization & ISO27001 Pipeline" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('title') border-rose-500 @enderror">
                @error('title') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Category
                </label>
                <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="client" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Client / Partner Organization
                </label>
                <input type="text" 
                       id="client" 
                       name="client" 
                       value="{{ old('client') }}" 
                       placeholder="e.g. Fortune 500 Financial Corp" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="slug" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Slug (Auto-generated if empty)
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug') }}" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="completion_date" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Completion Date
                </label>
                <input type="date" 
                       id="completion_date" 
                       name="completion_date" 
                       value="{{ old('completion_date') }}" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-2">
                <label for="website_url" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Live Case Study / Reference URL
                </label>
                <input type="url" 
                       id="website_url" 
                       name="website_url" 
                       value="{{ old('website_url') }}" 
                       placeholder="https://example.com/project" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-2">
                <label for="summary" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Executive Summary
                </label>
                <textarea id="summary" 
                          name="summary" 
                          rows="2" 
                          placeholder="Brief 2-3 line overview highlighting the core problem and quantitative results achieved..." 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('summary') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label for="content" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Full Case Study Narrative
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="5" 
                          placeholder="Detailed challenge, technical architecture design, migration execution, and final metrics..." 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('content') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Cover / Preview Image
                </label>
                <input type="file" 
                       name="image" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
            </div>
        </div>

        <!-- Tech Stack Alpine.js Manager -->
        <div class="border-t border-slate-800 pt-6 space-y-4" x-data="{ techs: {{ json_encode(old('technologies', ['Laravel 11', 'TailwindCSS', 'PostgreSQL', 'Docker'])) }} }">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider">Technology Stack</h2>
                    <p class="text-xs text-slate-400">Frameworks, languages, and cloud providers utilized.</p>
                </div>
                <button type="button" @click="techs.push('')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-400 bg-indigo-950/60 border border-indigo-800/60 hover:bg-indigo-900/60 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Add Technology</span>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <template x-for="(tech, index) in techs" :key="index">
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               :name="'technologies[' + index + ']'" 
                               x-model="techs[index]" 
                               placeholder="e.g. AWS ECS / Fargate" 
                               class="flex-1 px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-xs focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="techs.splice(index, 1)" class="p-2 text-slate-500 hover:text-rose-400 rounded-lg hover:bg-slate-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Toggles & Ordering -->
        <div class="border-t border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Display Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', 0) }}" 
                       min="0" 
                       class="w-full px-4 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Feature on Home</span>
                </label>
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Active / Published</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.portfolio.index') }}" class="px-5 py-2.5 rounded-xl text-slate-400 hover:text-white text-sm transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                Save Case Study
            </button>
        </div>
    </form>
</div>
@endsection
