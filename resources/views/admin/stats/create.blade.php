@extends('layouts.admin')

@section('title', 'Add Metric Counter')
@section('page_title', 'Stats / New')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Create Metric Counter</h1>
            <p class="text-sm text-slate-400 mt-1">Add quantitative milestone or performance statistic.</p>
        </div>
        <a href="{{ route('admin.stats.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to Stats
        </a>
    </div>

    <form method="POST" action="{{ route('admin.stats.store') }}" class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="label" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Metric Label / Description <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="label" 
                       name="label" 
                       value="{{ old('label') }}" 
                       required 
                       placeholder="e.g. Enterprise Transformations Completed" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('label') border-rose-500 @enderror">
                @error('label') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="value" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Primary Numerical Value <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="value" 
                       name="value" 
                       value="{{ old('value') }}" 
                       required 
                       placeholder="e.g. 250 or 99.99" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm font-mono focus:ring-2 focus:ring-indigo-500 @error('value') border-rose-500 @enderror">
                @error('value') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="suffix" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Unit / Suffix (e.g. +, %, M, k)
                </label>
                <input type="text" 
                       id="suffix" 
                       name="suffix" 
                       value="{{ old('suffix', '+') }}" 
                       placeholder="+, %, M, k, /5.0" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm font-mono focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="icon" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Icon Identifier
                </label>
                <input type="text" 
                       id="icon" 
                       name="icon" 
                       value="{{ old('icon', 'trending-up') }}" 
                       placeholder="e.g. chart-bar, shield, users, check-circle" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Display Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', 0) }}" 
                       min="0" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-2 flex items-center pt-2">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Active / Visible on Counter Bar</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.stats.index') }}" class="px-5 py-2.5 rounded-xl text-slate-400 hover:text-white text-sm transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                Create Statistic
            </button>
        </div>
    </form>
</div>
@endsection
