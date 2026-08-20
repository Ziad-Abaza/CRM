@extends('layouts.admin')

@section('title', __('admin.pricing.title'))
@section('page_title', __('admin.nav.pricing'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.pricing.title') }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('admin.pricing.description_label') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pricing.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>{{ __('admin.pricing.add_new') }}</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xl">
        <form method="GET" action="{{ route('admin.pricing.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="{{ __('ui.search.placeholder') }}" 
                           class="w-full ps-10 pe-4 py-2 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 text-slate-500 absolute start-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="status" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">{{ __('ui.filter.all') }}</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>{{ __('ui.filter.active') }}</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>{{ __('ui.filter.inactive') }}</option>
                </select>
            </div>
            <div class="sm:col-span-1">
                <button type="submit" class="w-full py-2 px-3 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 rounded-xl text-sm font-semibold transition text-center flex items-center justify-center">
                    {{ __('ui.buttons.filter') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Pricing Table -->
    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        @if($plans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-start text-sm text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">{{ __('admin.pricing.order_label') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.pricing.table_title') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.pricing.table_price') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.pricing.table_features') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.pricing.table_featured') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.pricing.table_status') }}</th>
                            <th class="px-6 py-3.5 text-end">{{ __('admin.pricing.table_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                        @foreach($plans as $plan)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4 font-mono text-xs text-slate-500 dark:text-slate-400">
                                    #{{ $plan->order }}
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <a href="{{ route('admin.pricing.edit', $plan) }}" class="font-semibold text-slate-900 dark:text-white hover:text-indigo-400 transition">
                                            {{ $plan->name }}
                                        </a>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1 mt-0.5">
                                            {{ $plan->description ?? '' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono">
                                    <span class="text-base font-bold text-slate-900 dark:text-white">{{ $plan->currency }} {{ number_format($plan->price, 2) }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">/ {{ $plan->billing_period }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-700">
                                        {{ count((array) ($plan->features ?? [])) }} {{ __('admin.pricing.table_features') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($plan->is_featured)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            {{ __('admin.pricing.table_featured') }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-500">Standard</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.pricing.toggle', $plan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $plan->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $plan->is_active ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                                            <span>{{ $plan->is_active ? __('ui.filter.active') : __('ui.filter.inactive') }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-end">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.pricing.edit', $plan) }}" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-indigo-400 hover:bg-slate-100 dark:bg-slate-800 rounded-lg transition" title="{{ __('ui.buttons.edit') }}" aria-label="{{ __('ui.buttons.edit') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.pricing.destroy', $plan) }}" onsubmit="return confirm('{{ __('ui.confirmations.delete_plan') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-rose-400 hover:bg-slate-100 dark:bg-slate-800 rounded-lg transition" title="{{ __('ui.buttons.delete') }}" aria-label="{{ __('ui.buttons.delete') }}">
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
            @if($plans->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $plans->links() }}
                </div>
            @endif
        @else
            <div class="py-16 px-4 text-center">
                <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ __('ui.empty_states.no_records_found') }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">{{ __('admin.pricing.description_label') }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.pricing.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 transition">
                        <span>{{ __('admin.pricing.add_new') }}</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
