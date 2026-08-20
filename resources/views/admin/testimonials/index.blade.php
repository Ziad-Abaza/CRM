@extends('layouts.admin')

@section('title', __('admin.testimonials.title'))
@section('page_title', __('admin.nav.testimonials'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.testimonials.title') }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('admin.testimonials.content_label') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>{{ __('admin.testimonials.add_new') }}</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-xl">
        <form method="GET" action="{{ route('admin.testimonials.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
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
                <select name="rating" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">{{ __('ui.filter.all') }}</option>
                    <option value="5" {{ $rating === '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ $rating === '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ $rating === '3' ? 'selected' : '' }}>3 Stars</option>
                </select>
            </div>
            <div class="sm:col-span-2">
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

    <!-- Testimonials List Table -->
    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        @if($testimonials->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-start text-sm text-slate-700 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">{{ __('admin.testimonials.order_label') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.testimonials.table_title') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.testimonials.table_rating') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.testimonials.table_quote') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.testimonials.table_featured') }}</th>
                            <th class="px-6 py-3.5">{{ __('admin.testimonials.table_status') }}</th>
                            <th class="px-6 py-3.5 text-end">{{ __('admin.testimonials.table_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                        @foreach($testimonials as $testimonial)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4 font-mono text-xs text-slate-500 dark:text-slate-400">
                                    #{{ $testimonial->order }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($testimonial->avatar)
                                            <img src="{{ $testimonial->avatar }}" alt="{{ $testimonial->client_name }}" class="w-9 h-9 rounded-full object-cover border border-slate-700">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-700 text-slate-700 dark:text-slate-300 flex items-center justify-center font-bold text-xs">
                                                {{ mb_substr($testimonial->client_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="font-semibold text-slate-900 dark:text-white hover:text-indigo-400 transition">
                                                {{ $testimonial->client_name }}
                                            </a>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ $testimonial->client_role ?? 'Executive' }} @if($testimonial->company) &bull; {{ $testimonial->company }} @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-amber-400">
                                        @for($i = 0; $i < $testimonial->rating; $i++)
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 italic">
                                        "{{ $testimonial->content }}"
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($testimonial->is_featured)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            {{ __('admin.testimonials.table_featured') }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-500">Standard</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.testimonials.toggle', $testimonial) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $testimonial->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $testimonial->is_active ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                                            <span>{{ $testimonial->is_active ? __('ui.filter.active') : __('ui.filter.inactive') }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-end">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-indigo-400 hover:bg-slate-100 dark:bg-slate-800 rounded-lg transition" title="{{ __('ui.buttons.edit') }}" aria-label="{{ __('ui.buttons.edit') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('{{ __('ui.confirmations.delete_testimonial') }}');">
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
            @if($testimonials->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $testimonials->links() }}
                </div>
            @endif
        @else
            <div class="py-16 px-4 text-center">
                <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ __('ui.empty_states.no_records_found') }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">{{ __('admin.testimonials.content_label') }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 transition">
                        <span>{{ __('admin.testimonials.add_new') }}</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
