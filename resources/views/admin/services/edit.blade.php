@extends('layouts.admin')

@section('title', 'Edit Service: ' . $service->title)
@section('page_title', 'Services / Edit')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Edit Service</h1>
            <p class="text-sm text-slate-400 mt-1">Modify capability details and feature bullets for "{{ $service->title }}".</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to Services
        </a>
    </div>

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Service Title <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $service->title) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('title') border-rose-500 @enderror">
                @error('title') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    URL Slug
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug', $service->slug) }}" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                @error('slug') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="icon" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Icon Identifier
                </label>
                <input type="text" 
                       id="icon" 
                       name="icon" 
                       value="{{ old('icon', $service->icon) }}" 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                @error('icon') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="short_description" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Short Summary (Landing Page)
                </label>
                <textarea id="short_description" 
                          name="short_description" 
                          rows="2" 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('short_description', $service->short_description) }}</textarea>
                @error('short_description') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Detailed Scope of Work
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('description', $service->description) }}</textarea>
                @error('description') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Service Image
                </label>
                @if($service->image)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $service->image }}" alt="Current Service Image" class="w-16 h-16 rounded-xl object-cover border border-slate-700">
                        <span class="text-xs text-slate-400">Current visual uploaded</span>
                    </div>
                @endif
                <input type="file" 
                       name="image" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
                @error('image') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Alpine.js Dynamic Array Manager for JSON Features -->
        <div class="border-t border-slate-800 pt-6 space-y-4" x-data="{ items: {{ json_encode(old('features', $service->features ?? [])) }} }">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider">Key Service Highlights / Features</h2>
                    <p class="text-xs text-slate-400">Bullet points showcased on the service card.</p>
                </div>
                <button type="button" @click="items.push('')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-400 bg-indigo-950/60 border border-indigo-800/60 hover:bg-indigo-900/60 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Add Item</span>
                </button>
            </div>

            <div class="space-y-2">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 text-xs font-mono w-4" x-text="index + 1"></span>
                        <input type="text" 
                               :name="'features[' + index + ']'" 
                               x-model="items[index]" 
                               placeholder="e.g. SOC2 Type II Certified Process" 
                               class="flex-1 px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-xs focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="items.splice(index, 1)" class="p-2 text-slate-500 hover:text-rose-400 rounded-lg hover:bg-slate-800 transition" title="Remove">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Order & Status -->
        <div class="border-t border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Sort Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $service->order) }}" 
                       min="0" 
                       class="w-full px-4 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Published Status</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl text-slate-400 hover:text-white text-sm transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                Update Service
            </button>
        </div>
    </form>
</div>
@endsection
