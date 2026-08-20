@extends('layouts.admin')

@section('title', 'Security Audit Logs')
@section('page_title', 'Security Audit Logs')

@section('content')
<div class="space-y-6" x-data="{
    detailModalOpen: false,
    selectedLog: null,
    viewDetails(log) {
        this.selectedLog = log;
        this.detailModalOpen = true;
    }
}">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900/60 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm backdrop-blur-md">
        <div>
            <h1 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                System Audit & Security Logs
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Immutable change tracking, admin actions, and resource modifications.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.audit-logs.export', request()->query()) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white border border-slate-300 dark:border-slate-700 shadow-sm transition">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white dark:bg-slate-900/40 p-4 rounded-xl border border-slate-200 dark:border-slate-800/80 shadow-sm">
        <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-medium text-slate-500 dark:text-slate-400 mb-1">Search Keywords</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="User, model, IP..." 
                       class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-[11px] font-medium text-slate-500 dark:text-slate-400 mb-1">Action Type</label>
                <select name="action" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                    <option value="">All Actions</option>
                    @foreach($distinctActions as $act)
                        <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ strtoupper($act) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-medium text-slate-500 dark:text-slate-400 mb-1">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" 
                       class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-[11px] font-medium text-slate-500 dark:text-slate-400 mb-1">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" 
                       class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold transition shadow-sm">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'action', 'from_date', 'to_date']))
                    <a href="{{ route('admin.audit-logs.index') }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg text-xs font-medium border border-slate-300 dark:border-slate-700 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Audit Logs Table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-950/60 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">User</th>
                        <th class="py-3.5 px-4">Action</th>
                        <th class="py-3.5 px-4">Target Resource</th>
                        <th class="py-3.5 px-4">IP &amp; Client</th>
                        <th class="py-3.5 px-4">Timestamp</th>
                        <th class="py-3.5 px-4 text-right">Payload</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60 font-mono">
                    @forelse($logs as $log)
                        @php
                            $actionColor = match(strtolower($log->action)) {
                                'created' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
                                'updated' => 'bg-sky-50 dark:bg-sky-500/10 text-sky-700 dark:text-sky-400 border-sky-200 dark:border-sky-500/20',
                                'deleted' => 'bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-500/20',
                                'login' => 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/20',
                                default => 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-300 dark:border-slate-700',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition">
                            <td class="py-3 px-4 font-sans">
                                @if($log->user)
                                    <div class="font-semibold text-slate-900 dark:text-white">{{ $log->user->name }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400">{{ $log->user->email }}</div>
                                @else
                                    <span class="text-slate-400 italic">System / Anonymous</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $actionColor }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-slate-800 dark:text-slate-200 font-semibold">{{ class_basename($log->auditable_type) }}</div>
                                <div class="text-[10px] text-slate-500 dark:text-slate-400">ID #{{ $log->auditable_id ?? 'N/A' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-slate-800 dark:text-slate-300">{{ $log->ip_address ?? '127.0.0.1' }}</div>
                                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-sans truncate max-w-xs" title="{{ $log->user_agent }}">
                                    {{ Str::limit($log->user_agent, 30) }}
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-500 dark:text-slate-400">
                                <div>{{ $log->created_at->format('M d, Y H:i:s') }}</div>
                                <div class="text-[10px] text-slate-400 dark:text-slate-500">{{ $log->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3 px-4 text-right font-sans">
                                <button type="button" 
                                        @click="viewDetails(@js($log))" 
                                        class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700 text-xs font-medium transition">
                                    Diff Viewer
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-sans">
                                <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">No audit logs found</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Actions performed across the admin portal will be recorded here automatically.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/40">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <!-- JSON Diff / Detail Modal -->
    <div x-show="detailModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4"
         @keydown.escape.window="detailModalOpen = false">
        
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl w-full max-w-3xl overflow-hidden shadow-2xl transition transform"
             @click.outside="detailModalOpen = false">
            
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-950/50">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-900 dark:text-white text-sm">Audit Payload Details</span>
                    <span class="text-xs px-2 py-0.5 rounded bg-indigo-50 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/30 font-mono" x-text="selectedLog ? '#' + selectedLog.id : ''"></span>
                </div>
                <button @click="detailModalOpen = false" class="text-slate-400 hover:text-slate-700 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div class="p-3 bg-slate-50 dark:bg-slate-950/60 rounded-xl border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400 block mb-1">Actor</span>
                        <span class="font-semibold text-slate-900 dark:text-white" x-text="selectedLog?.user?.name || 'System / Anonymous'"></span>
                    </div>
                    <div class="p-3 bg-slate-50 dark:bg-slate-950/60 rounded-xl border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400 block mb-1">Resource</span>
                        <span class="font-semibold text-slate-900 dark:text-white font-mono" x-text="(selectedLog?.auditable_type ? selectedLog.auditable_type.split('\\').pop() : 'N/A') + ' #' + (selectedLog?.auditable_id || '')"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Old Values -->
                    <div>
                        <span class="text-xs font-semibold text-rose-600 dark:text-rose-400 block mb-2">Previous State (Old)</span>
                        <pre class="p-3 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 text-[11px] text-slate-800 dark:text-slate-300 font-mono overflow-x-auto max-h-60"
                             x-text="selectedLog?.old_values ? JSON.stringify(selectedLog.old_values, null, 2) : 'None / Null'"></pre>
                    </div>

                    <!-- New Values -->
                    <div>
                        <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 block mb-2">Updated State (New)</span>
                        <pre class="p-3 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 text-[11px] text-slate-800 dark:text-slate-300 font-mono overflow-x-auto max-h-60"
                             x-text="selectedLog?.new_values ? JSON.stringify(selectedLog.new_values, null, 2) : 'None / Null'"></pre>
                    </div>
                </div>
            </div>

            <div class="px-6 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/50 flex justify-end">
                <button type="button" @click="detailModalOpen = false" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-white rounded-xl text-xs font-medium border border-slate-300 dark:border-slate-700 transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
