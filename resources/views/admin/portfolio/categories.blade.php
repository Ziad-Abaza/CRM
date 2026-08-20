@extends('layouts.admin')

@section('title', 'Portfolio Categories')
@section('page_title', 'Portfolio / Categories')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Portfolio Categories</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Organize your projects and case studies into sector classifications.</p>
        </div>
        <a href="{{ route('admin.portfolio.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to Portfolio
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Create Category Form -->
        <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xl h-fit">
            <h2 class="text-base font-bold text-slate-900 dark:text-white mb-4">Add Category</h2>
            <form method="POST" action="{{ route('admin.portfolio.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Category Name <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           required 
                           placeholder="e.g. Cloud Infrastructure" 
                           class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Slug (Optional)
                    </label>
                    <input type="text" 
                           name="slug" 
                           placeholder="auto-generated" 
                           class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Description
                    </label>
                    <textarea name="description" 
                              rows="2" 
                              placeholder="Brief scope of projects in this category..." 
                              class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Sort Order
                    </label>
                    <input type="number" 
                           name="order" 
                           value="0" 
                           min="0" 
                           class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 rounded-xl text-slate-900 dark:text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition text-sm">
                        Create Category
                    </button>
                </div>
            </form>
        </div>

        <!-- Categories Table -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xl">
            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-50 dark:bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                            <tr>
                                <th class="px-6 py-3.5">Name</th>
                                <th class="px-6 py-3.5">Slug</th>
                                <th class="px-6 py-3.5">Projects</th>
                                <th class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-200 dark:divide-slate-800/60">
                            @foreach($categories as $category)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-100 dark:bg-slate-800/30 transition" x-data="{ editing: false, name: '{{ addslashes($category->name) }}', slug: '{{ $category->slug }}', description: '{{ addslashes($category->description ?? '') }}', order: '{{ $category->order }}' }">
                                    <td class="px-6 py-4">
                                        <div x-show="!editing">
                                            <span class="font-semibold text-slate-900 dark:text-white">{{ $category->name }}</span>
                                            @if($category->description)
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $category->description }}</p>
                                            @endif
                                        </div>
                                        <div x-show="editing" x-cloak class="space-y-2">
                                            <input type="text" x-model="name" class="w-full px-2 py-1 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded text-xs text-slate-900 dark:text-white">
                                            <input type="text" x-model="description" placeholder="Description" class="w-full px-2 py-1 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded text-xs text-slate-900 dark:text-white">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500 dark:text-slate-400">
                                        <span x-show="!editing">{{ $category->slug }}</span>
                                        <input x-show="editing" x-cloak type="text" x-model="slug" class="w-full px-2 py-1 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded text-xs text-slate-900 dark:text-white font-mono">
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-700 dark:text-slate-300 border border-slate-700">
                                            {{ $category->portfolios_count }} Case Studies
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2" x-show="!editing">
                                            <button @click="editing = true" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-indigo-400 hover:bg-slate-100 dark:bg-slate-800 rounded-lg transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <form method="POST" action="{{ route('admin.portfolio.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Associated portfolio items will be uncategorized.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-rose-400 hover:bg-slate-100 dark:bg-slate-800 rounded-lg transition" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="flex items-center justify-end gap-2" x-show="editing" x-cloak>
                                            <form method="POST" action="{{ route('admin.portfolio.categories.update', $category) }}" class="inline-flex items-center gap-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="name" :value="name">
                                                <input type="hidden" name="slug" :value="slug">
                                                <input type="hidden" name="description" :value="description">
                                                <button type="submit" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-500 text-slate-900 dark:text-white rounded text-xs font-semibold">Save</button>
                                                <button type="button" @click="editing = false" class="px-2 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded text-xs">Cancel</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($categories->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                        {{ $categories->links() }}
                    </div>
                @endif
            @else
                <div class="py-12 px-4 text-center">
                    <p class="text-sm text-slate-500 dark:text-slate-400">No categories created yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
