@extends('layouts.admin')

@section('title', 'Team Leadership')
@section('page_title', 'Team Members')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Executive Leadership & Team</h1>
            <p class="text-sm text-slate-400 mt-1">Manage partner bios, professional credentials, and direct contact channels.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.team.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Team Member</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-4 shadow-xl">
        <form method="GET" action="{{ route('admin.team.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Search by name, role, email, or bio..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="status" class="w-full px-3 py-2 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="sm:col-span-1">
                <button type="submit" class="w-full py-2 px-3 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-sm font-semibold transition text-center flex items-center justify-center">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Team Members Table -->
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        @if($members->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">Order</th>
                            <th class="px-6 py-3.5">Member Details</th>
                            <th class="px-6 py-3.5">Role</th>
                            <th class="px-6 py-3.5">Contact Channels</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($members as $member)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-4 font-mono text-xs text-slate-400">
                                    #{{ $member->order }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($member->photo)
                                            <img src="{{ $member->photo }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-700">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 text-slate-300 flex items-center justify-center font-bold text-xs">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.team.edit', $member) }}" class="font-semibold text-white hover:text-indigo-400 transition">
                                                {{ $member->name }}
                                            </a>
                                            <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">
                                                {{ $member->bio ?? 'No bio provided.' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-indigo-300 border border-slate-700">
                                        {{ $member->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs space-y-1 font-mono text-slate-400">
                                    @if($member->email)
                                        <div>{{ $member->email }}</div>
                                    @endif
                                    @if($member->phone)
                                        <div>{{ $member->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.team.toggle', $member) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $member->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $member->is_active ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                                            <span>{{ $member->is_active ? 'Active' : 'Disabled' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.team.edit', $member) }}" class="p-1.5 text-slate-400 hover:text-indigo-400 hover:bg-slate-800 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.team.destroy', $member) }}" onsubmit="return confirm('Delete this team member profile?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition" title="Delete">
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
            @if($members->hasPages())
                <div class="px-6 py-4 border-t border-slate-800">
                    {{ $members->links() }}
                </div>
            @endif
        @else
            <div class="py-16 px-4 text-center">
                <div class="h-12 w-12 rounded-2xl bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-base font-bold text-white">No Team Profiles Listed</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Showcase your executive consultants, directors, and lead engineers.</p>
                <div class="mt-4">
                    <a href="{{ route('admin.team.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 transition">
                        <span>Add Team Member</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
