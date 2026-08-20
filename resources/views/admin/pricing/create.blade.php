@extends('layouts.admin')

@section('title', 'Add Pricing Tier')
@section('page_title', 'Pricing / New')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Create Pricing Plan</h1>
            <p class="text-sm text-slate-400 mt-1">Configure plan parameters, feature deliverables, and WhatsApp engagement triggers.</p>
        </div>
        <a href="{{ route('admin.pricing.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to Pricing
        </a>
    </div>

    <form method="POST" action="{{ route('admin.pricing.store') }}" class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="sm:col-span-2">
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Plan Name <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       placeholder="e.g. Growth Acceleration" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('name') border-rose-500 @enderror">
                @error('name') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Slug
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug') }}" 
                       placeholder="auto-generated" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Numeric Price <span class="text-rose-400">*</span>
                </label>
                <input type="number" 
                       step="0.01" 
                       id="price" 
                       name="price" 
                       value="{{ old('price', '2499.00') }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm font-mono focus:ring-2 focus:ring-indigo-500 @error('price') border-rose-500 @enderror">
                @error('price') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="currency" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Currency <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="currency" 
                       name="currency" 
                       value="{{ old('currency', 'USD') }}" 
                       required 
                       placeholder="USD, EUR, GBP, SAR" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm font-mono focus:ring-2 focus:ring-indigo-500">
                @error('currency') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="billing_period" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Billing Period <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="billing_period" 
                       name="billing_period" 
                       value="{{ old('billing_period', 'month') }}" 
                       required 
                       placeholder="month, quarter, project, year" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                @error('billing_period') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-3">
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Tier Summary / Audience
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="2" 
                          placeholder="Targeted at scaling startups requiring full-stack DevOps and dedicated product engineering..." 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <div class="sm:col-span-3">
                <label for="whatsapp_message" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Custom WhatsApp Pre-Filled Inquiry Message
                </label>
                <input type="text" 
                       id="whatsapp_message" 
                       name="whatsapp_message" 
                       value="{{ old('whatsapp_message') }}" 
                       placeholder="e.g. Hello! I'm interested in starting with the Growth Acceleration tier." 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <!-- Plan Features List Manager -->
        <div class="border-t border-slate-800 pt-6 space-y-4" x-data="{ items: {{ json_encode(old('features', ['Dedicated Lead Architect', 'Weekly Sprint Review', 'Priority 4-hr SLA SLA response', 'Unlimited Infrastructure Repositories'])) }} }">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider">Plan Deliverables & Inclusions</h2>
                    <p class="text-xs text-slate-400">Features displayed as checkmarked bullets on the pricing card.</p>
                </div>
                <button type="button" @click="items.push('')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-400 bg-indigo-950/60 border border-indigo-800/60 hover:bg-indigo-900/60 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Add Deliverable</span>
                </button>
            </div>

            <div class="space-y-2">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 text-xs font-mono w-4" x-text="index + 1"></span>
                        <input type="text" 
                               :name="'features[' + index + ']'" 
                               x-model="items[index]" 
                               placeholder="e.g. 24/7 Production Monitoring" 
                               class="flex-1 px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-xs focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="items.splice(index, 1)" class="p-2 text-slate-500 hover:text-rose-400 rounded-lg hover:bg-slate-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Toggles & Order -->
        <div class="border-t border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Order Index
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
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Highlight as Popular</span>
                </label>
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Active / Live</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.pricing.index') }}" class="px-5 py-2.5 rounded-xl text-slate-400 hover:text-white text-sm transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                Create Pricing Tier
            </button>
        </div>
    </form>
</div>
@endsection
