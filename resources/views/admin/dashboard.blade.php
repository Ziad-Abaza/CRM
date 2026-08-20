@extends('layouts.admin')

@section('title', 'Executive Dashboard')
@section('page_title', 'Executive Dashboard')

@section('content')
<div class="space-y-6 sm:space-y-8">
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-5 sm:mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">System Performance &amp; Lead Overview</h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5 sm:mt-1">Real-time status of corporate engagement, inbound leads, and content assets.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="{{ route('admin.branding.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white dark:bg-slate-100 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 shadow-sm transition">
                    <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4h4a4 4 0 014 4 4 4 0 01-4 4H7zm0 0l9.5-9.5a2.121 2.121 0 113 3L10 21m-3 0h12" />
                    </svg>
                    <span>Brand Theme</span>
                </a>
                <a href="{{ route('admin.content.hero') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-slate-900 dark:text-white shadow-md shadow-indigo-600/30 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Hero Section</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-xl p-4 sm:p-5 shadow-sm relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">WhatsApps (Today)</span>
                    <span class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($metrics['today_whatsapp_clicks']) }}</span>
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Active Leads</span>
                </div>
                <div class="mt-2 flex items-center text-xs text-slate-500 dark:text-slate-400">
                    <span class="text-slate-800 dark:text-slate-700 dark:text-slate-300 font-semibold mr-1">{{ number_format($metrics['weekly_whatsapp_clicks']) }}</span> last 7 days
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-xl p-4 sm:p-5 shadow-sm relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Leads</span>
                    <span class="p-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($metrics['total_whatsapp_clicks']) }}</span>
                    <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">All Time</span>
                </div>
                <div class="mt-2 flex items-center text-xs text-slate-500 dark:text-slate-400">
                    Direct high-intent conversions
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-xl p-4 sm:p-5 shadow-sm relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Services &amp; Offerings</span>
                    <span class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($metrics['services_count']) }}</span>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Modules</span>
                </div>
                <div class="mt-2 flex items-center text-xs text-slate-500 dark:text-slate-400">
                    <span class="text-slate-800 dark:text-slate-700 dark:text-slate-300 font-semibold mr-1">{{ $metrics['pricing_plans_count'] }}</span> pricing tiers configured
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-xl p-4 sm:p-5 shadow-sm relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Social Proof</span>
                    <span class="p-1.5 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($metrics['portfolio_count'] + $metrics['testimonials_count']) }}</span>
                    <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Assets</span>
                </div>
                <div class="mt-2 flex items-center text-xs text-slate-500 dark:text-slate-400">
                    <span class="text-slate-800 dark:text-slate-700 dark:text-slate-300 font-semibold mr-1">{{ $metrics['portfolio_count'] }}</span> case studies, <span class="text-slate-800 dark:text-slate-700 dark:text-slate-300 font-semibold ml-1 mr-1">{{ $metrics['testimonials_count'] }}</span> testimonials
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-xl p-4 sm:p-5 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">Recent WhatsApp Lead Clicks</h2>
                    <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">High-intent client interactions initiated via site CTAs</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                    Live Tracking
                </span>
            </div>

            @if($recentClicks->count() > 0)
                <div class="divide-y divide-slate-100 dark:divide-slate-200 dark:divide-slate-200 dark:divide-slate-800/80 overflow-hidden flex-1">
                    @foreach($recentClicks as $click)
                        <div class="py-2.5 sm:py-3 flex items-start justify-between gap-3 sm:gap-4">
                            <div class="space-y-0.5 min-w-0">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/20 capitalize">
                                        {{ str_replace('_', ' ', $click->button_location) }}
                                    </span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-[120px] sm:max-w-none">{{ $click->source_page ?? '/' }}</span>
                                </div>
                                @if($click->prefilled_message)
                                    <p class="text-xs text-slate-700 dark:text-slate-700 dark:text-slate-300 truncate italic">"{{ $click->prefilled_message }}"</p>
                                @endif
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="text-[10px] sm:text-[11px] text-slate-500 dark:text-slate-400 block font-mono">{{ $click->created_at->diffForHumans() }}</span>
                                <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 dark:text-slate-500 font-mono">{{ $click->ip_address }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center py-8 sm:py-12 text-center text-slate-500 dark:text-slate-400">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-slate-700 dark:text-slate-300 dark:text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-700 dark:text-slate-300">No WhatsApp lead clicks recorded yet</p>
                    <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">Interactions on public CTAs will appear here automatically.</p>
                </div>
            @endif
        </div>

        <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-xl p-4 sm:p-5 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">System Audit &amp; Security Logs</h2>
                    <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">Immutable record of administrator actions and system events</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold bg-slate-100 dark:bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                    Security Layer
                </span>
            </div>

            @if($recentAuditLogs->count() > 0)
                <div class="divide-y divide-slate-100 dark:divide-slate-200 dark:divide-slate-200 dark:divide-slate-800/80 overflow-hidden flex-1">
                    @foreach($recentAuditLogs as $log)
                        <div class="py-2.5 sm:py-3 flex items-start justify-between gap-3 sm:gap-4">
                            <div class="space-y-0.5 min-w-0">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="font-mono text-xs font-semibold text-indigo-600 dark:text-indigo-400">{{ $log->action }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">by {{ $log->user->name ?? 'System' }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 dark:text-slate-500 truncate">IP: {{ $log->ip_address ?? '127.0.0.1' }}</p>
                            </div>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 dark:text-slate-400 font-mono flex-shrink-0">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center py-8 sm:py-12 text-center text-slate-500 dark:text-slate-400">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-slate-700 dark:text-slate-300 dark:text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-700 dark:text-slate-300">No audit logs recorded</p>
                    <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">Administrative activities will be logged securely here.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
