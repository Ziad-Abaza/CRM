@extends('layouts.admin')

@section('title', __('admin.leads.title'))

@section('content')
<div class="space-y-6 sm:space-y-8" x-data="{ 
    selectedMessage: '', 
    messageModalOpen: false,
    deleteModalOpen: false,
    deleteActionUrl: '',
    openMessage(msg) {
        this.selectedMessage = msg;
        this.messageModalOpen = true;
    },
    confirmDelete(url) {
        this.deleteActionUrl = url;
        this.deleteModalOpen = true;
    }
}">

    <!-- Page Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                </span>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">{{ __('admin.leads.title') }}</h1>
            </div>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ __('admin.leads.subtitle') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.leads.export', request()->query()) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-sm font-semibold border border-slate-300 dark:border-slate-700 shadow-sm transition">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>{{ __('admin.leads.export_csv') }}</span>
            </a>
        </div>
    </div>

    <!-- Telemetry Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Inquiries -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 transition relative overflow-hidden group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('admin.dashboard.total_leads') }}</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5">{{ number_format($totalClicks) }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <span>{{ __('ui.badges.production') }}</span>
                <span class="text-emerald-600 dark:text-emerald-400 font-medium font-mono">100% WhatsApp</span>
            </div>
        </div>

        <!-- Today's Leads -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 transition relative overflow-hidden group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('admin.dashboard.new_leads_today') }}</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5">{{ number_format($todayClicks) }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <span>{{ __('ui.badges.active') }}</span>
                <span class="text-indigo-600 dark:text-indigo-400 font-medium">{{ Carbon\Carbon::today()->format('M d') }}</span>
            </div>
        </div>

        <!-- Last 7 Days -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 transition relative overflow-hidden group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-violet-50 dark:bg-violet-500/10 border border-violet-200 dark:border-violet-500/20 flex items-center justify-center text-violet-600 dark:text-violet-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('admin.leads.filter_date') }}</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5">{{ number_format($thisWeekClicks) }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <span>{{ Carbon\Carbon::now()->format('M Y') }}</span>
                <span class="text-violet-600 dark:text-violet-400 font-medium">{{ number_format($thisMonthClicks) }}</span>
            </div>
        </div>

        <!-- Top Converting Section -->
        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 transition relative overflow-hidden group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('admin.leads.table_source') }}</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white truncate mt-0.5">
                        {{ $topSourceRow ? ucwords(str_replace(['_', '-'], ' ', $topSourceRow->button_location)) : __('ui.status.na') }}
                    </p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <span>{{ __('admin.dashboard.conversion_rate') }}</span>
                <span class="text-amber-600 dark:text-amber-400 font-semibold">{{ $topSourceRow ? number_format($topSourceRow->count) : '0' }}</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
        <form method="GET" action="{{ route('admin.leads.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
            <!-- Keyword Search -->
            <div class="lg:col-span-4">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">{{ __('ui.buttons.search') }}</label>
                <div class="relative">
                    <span class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="{{ __('ui.search.placeholder') }}" 
                           class="w-full ps-9 pe-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Trigger Location Filter -->
            <div class="lg:col-span-3">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">{{ __('admin.leads.filter_source') }}</label>
                <select name="button_location" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                    <option value="">{{ __('ui.filter.all') }}</option>
                    @foreach($availableLocations as $locOption)
                        <option value="{{ $locOption }}" {{ $location === $locOption ? 'selected' : '' }}>
                            {{ ucwords(str_replace(['_', '-'], ' ', $locOption)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range From -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">{{ __('ui.time.date') }} ({{ __('ui.filter.oldest') }})</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" 
                       class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            </div>

            <!-- Date Range To -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">{{ __('ui.time.date') }} ({{ __('ui.filter.newest') }})</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" 
                       class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
            </div>

            <!-- Submit / Reset Buttons -->
            <div class="lg:col-span-1 flex items-center gap-2">
                <button type="submit" title="{{ __('ui.buttons.filter') }}" 
                        class="w-full py-2 px-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl text-sm flex items-center justify-center transition shadow-md shadow-indigo-600/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
                @if($search || $location || $dateFrom || $dateTo)
                    <a href="{{ route('admin.leads.index') }}" title="{{ __('ui.buttons.reset') }}" 
                       class="py-2 px-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-xl text-sm flex items-center justify-center border border-slate-300 dark:border-slate-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Leads Log Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900/60">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 dark:text-slate-300">
                {{ __('admin.leads.title') }}
                <span class="ms-2 px-2 py-0.5 text-xs font-mono rounded-full bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-400 border border-slate-300 dark:border-slate-700">
                    {{ $leads->total() }} {{ __('ui.pagination.results') }}
                </span>
            </h2>
            <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('admin.leads.subtitle') }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-start text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-950/60 text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-3.5">{{ __('admin.leads.table_created_at') }}</th>
                        <th class="px-6 py-3.5">{{ __('admin.leads.table_source') }}</th>
                        <th class="px-6 py-3.5">{{ __('admin.leads.conversion_source') }}</th>
                        <th class="px-6 py-3.5">{{ __('admin.leads.notes') }}</th>
                        <th class="px-6 py-3.5">{{ __('admin.leads.table_ip') }}</th>
                        <th class="px-6 py-3.5 text-end">{{ __('admin.leads.table_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800/80">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                            <!-- Timestamp -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-900 dark:text-white">{{ $lead->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ $lead->created_at->format('H:i:s') }} ({{ $lead->created_at->diffForHumans() }})</div>
                            </td>

                            <!-- Trigger Location -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium border
                                    @if(str_contains($lead->button_location, 'hero')) bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-500/20
                                    @elseif(str_contains($lead->button_location, 'floating')) bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-500/20
                                    @elseif(str_contains($lead->button_location, 'pricing')) bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-500/20
                                    @elseif(str_contains($lead->button_location, 'service')) bg-sky-50 dark:bg-sky-500/10 text-sky-700 dark:text-sky-300 border-sky-200 dark:border-sky-500/20
                                    @else bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-300 dark:border-slate-700 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full 
                                        @if(str_contains($lead->button_location, 'hero')) bg-indigo-500 dark:bg-indigo-400
                                        @elseif(str_contains($lead->button_location, 'floating')) bg-emerald-500 dark:bg-emerald-400
                                        @elseif(str_contains($lead->button_location, 'pricing')) bg-amber-500 dark:bg-amber-400
                                        @elseif(str_contains($lead->button_location, 'service')) bg-sky-500 dark:bg-sky-400
                                        @else bg-slate-500 dark:bg-slate-400 @endif"></span>
                                    {{ ucwords(str_replace(['_', '-'], ' ', $lead->button_location ?? 'General CTA')) }}
                                </span>
                            </td>

                            <!-- Source Page & Referrer -->
                            <td class="px-6 py-4 max-w-[200px]">
                                <div class="font-mono text-xs text-slate-800 dark:text-slate-200 truncate" title="{{ $lead->source_page }}">
                                    {{ $lead->source_page ?: '/' }}
                                </div>
                                @if($lead->referrer)
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate mt-0.5" title="{{ $lead->referrer }}">
                                        Ref: {{ $lead->referrer }}
                                    </div>
                                @endif
                            </td>

                            <!-- Prefilled Message -->
                            <td class="px-6 py-4 max-w-[260px]">
                                <div class="truncate text-xs text-slate-700 dark:text-slate-300 italic" title="{{ $lead->prefilled_message }}">
                                    "{{ $lead->prefilled_message }}"
                                </div>
                                @if(strlen($lead->prefilled_message) > 45)
                                    <button type="button" 
                                            @click="openMessage('{{ addslashes($lead->prefilled_message) }}')" 
                                            class="text-[11px] text-indigo-600 dark:text-indigo-400 hover:underline font-medium mt-0.5 inline-block">
                                        {{ __('ui.modals.details') }} &rarr;
                                    </button>
                                @endif
                            </td>

                            <!-- Client & IP -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-mono text-xs text-slate-800 dark:text-slate-300">
                                    {{ $lead->ip_address ?: 'Anonymous IP' }}
                                </div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate max-w-[150px]" title="{{ $lead->user_agent }}">
                                    {{ $lead->user_agent ? Str::limit($lead->user_agent, 25) : 'Unknown Device' }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-end text-xs">
                                <button type="button" 
                                        @click="confirmDelete('{{ route('admin.leads.destroy', $lead) }}')" 
                                        class="p-1.5 rounded-lg text-slate-500 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition" 
                                        title="{{ __('ui.buttons.delete') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <div class="max-w-sm mx-auto flex flex-col items-center">
                                    <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('ui.empty_states.no_records_found') }}</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                        {{ __('admin.leads.subtitle') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leads->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60">
                {{ $leads->links() }}
            </div>
        @endif
    </div>

    <!-- Full Message View Modal -->
    <div x-show="messageModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="messageModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 @click="messageModalOpen = false" 
                 class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="messageModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-start overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        {{ __('admin.leads.notes') }}
                    </h3>
                    <button type="button" @click="messageModalOpen = false" class="text-slate-400 hover:text-slate-900 dark:hover:text-white" aria-label="{{ __('ui.buttons.close') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-sm text-slate-800 dark:text-slate-200 leading-relaxed font-sans select-all whitespace-pre-wrap" x-text="selectedMessage"></div>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="messageModalOpen = false" 
                            class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition">
                        {{ __('ui.buttons.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Deletion Confirmation Modal -->
    <div x-show="deleteModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="deleteModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 @click="deleteModalOpen = false" 
                 class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="deleteModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-start overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full p-6">
                
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 flex items-center justify-center text-rose-600 dark:text-rose-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ __('ui.confirmations.delete_title') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ __('ui.confirmations.delete_message') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button type="button" @click="deleteModalOpen = false" 
                            class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 transition">
                        {{ __('ui.buttons.cancel') }}
                    </button>
                    <form :action="deleteActionUrl" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-rose-600/20 transition">
                            {{ __('ui.confirmations.delete_confirm') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
