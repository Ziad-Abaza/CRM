@extends('layouts.admin')

@section('title', 'Portfolio & Case Studies')
@section('page_title', 'Portfolio')

@section('content')
<div class="space-y-6">
    <!-- Page Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Portfolio & Case Studies</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Showcase client successes, architecture transformations, and technical stacks.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.portfolio.categories') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 border border-slate-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>Manage Categories</span>
            </a>
            <a href="{{ route('admin.portfolio.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-slate-900 dark:text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Case Study</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xl">
        <form method="GET" action="{{ route('admin.portfolio.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Search by project, client, or summary..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="category_id" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <select name="status" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="sm:col-span-1">
                <button type="submit" class="w-full py-2 px-3 bg-white dark:bg-slate-100 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 rounded-xl text-sm font-semibold transition text-center flex items-center justify-center">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Portfolio Table -->
    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        @if($portfolios->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">Order</th>
                            <th class="px-6 py-3.5">Project Details</th>
                            <th class="px-6 py-3.5">Category</th>
                            <th class="px-6 py-3.5">Tech Stack</th>
                            <th class="px-6 py-3.5">Featured</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-200 dark:divide-slate-800/60">
                        @foreach($portfolios as $portfolio)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-100 dark:bg-slate-800/30 transition">
                                <td class="px-6 py-4 font-mono text-xs text-slate-500 dark:text-slate-400">
                                    #{{ $portfolio->order }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($portfolio->image)
                                            <img src="{{ $portfolio->image }}" alt="{{ $portfolio->title }}" class="w-12 h-10 rounded-lg object-cover border border-slate-700">
                                        @else
                                            <div class="w-12 h-10 rounded-lg bg-indigo-950/60 border border-indigo-800/40 text-indigo-400 flex items-center justify-center font-bold text-xs uppercase">
                                                {{ substr($portfolio->title, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.portfolio.edit', $portfolio) }}" class="font-semibold text-slate-900 dark:text-white hover:text-indigo-400 transition">
                                                {{ $portfolio->title }}
                                            </a>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1 mt-0.5">
                                                Client: {{ $portfolio->client ?? 'Confidential' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-700 dark:text-slate-300 border border-slate-700">
                                        {{ $portfolio->category?->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @foreach(array_slice($portfolio->technologies ?? [], 0, 3) as $tech)
                                            <span class="px-2 py-0.5 rounded text-[11px] font-mono bg-indigo-950/60 text-indigo-300 border border-indigo-800/40">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                        @if(count($portfolio->technologies ?? []) > 3)
                                            <span class="text-[10px] text-slate-500 dark:text-slate-400">+{{ count($portfolio->technologies) - 3 }} more</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($portfolio->is_featured)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            Featured
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-500 dark:text-slate-400">Standard</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.portfolio.toggle', $portfolio) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $portfolio->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $portfolio->is_active ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                                            <span>{{ $portfolio->is_active ? 'Active' : 'Disabled' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.portfolio.edit', $portfolio) }}" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-indigo-400 hover:bg-slate-100 dark:bg-slate-800 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.portfolio.destroy', $portfolio) }}" onsubmit="return confirm('Are you sure you want to delete this case study?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-rose-400 hover:bg-slate-100 dark:bg-slate-800 rounded-lg transition" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($portfolios->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $portfolios->links() }}
                </div>
            @endif
        @else
            <div class="py-16 px-4 text-center">
                <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">No Case Studies Found</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">Create and publish corporate case studies to demonstrate verifiable industry authority.</p>
                <div class="mt-4">
                    <a href="{{ route('admin.portfolio.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-slate-900 dark:text-white bg-indigo-600 hover:bg-indigo-500 transition">
                        <span>Add Case Study</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
