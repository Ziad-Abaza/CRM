@extends('layouts.admin')

@section('title', 'Edit Team Member: ' . $member->name)
@section('page_title', 'Team / Edit')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Edit Executive Profile</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Update profile information for "{{ $member->name }}".</p>
        </div>
        <a href="{{ route('admin.team.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
            &larr; Back to Team
        </a>
    </div>

    <form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Full Name <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $member->name) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('name') border-rose-500 @enderror">
                @error('name') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Executive Role / Title <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="role" 
                       name="role" 
                       value="{{ old('role', $member->role) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('role') border-rose-500 @enderror">
                @error('role') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Email Address
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $member->email) }}" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Phone Number
                </label>
                <input type="text" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone', $member->phone) }}" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-2">
                <label for="bio" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Executive Biography
                </label>
                <textarea id="bio" 
                          name="bio" 
                          rows="3" 
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('bio', $member->bio) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Portrait / Photo
                </label>
                @if($member->photo)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $member->photo }}" alt="Photo" class="w-12 h-12 rounded-full object-cover border border-slate-700">
                        <span class="text-xs text-slate-500 dark:text-slate-400">Current visual uploaded</span>
                    </div>
                @endif
                <input type="file" 
                       name="photo" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
            </div>
        </div>

        <!-- Social Links Manager -->
        @php
            $social = $member->social_links ?? [];
        @endphp
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Social & Professional Channels</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">LinkedIn Profile</label>
                    <input type="url" 
                           name="social_links[linkedin]" 
                           value="{{ old('social_links.linkedin', $social['linkedin'] ?? '') }}" 
                           placeholder="https://linkedin.com/in/..." 
                           class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Twitter / X</label>
                    <input type="url" 
                           name="social_links[twitter]" 
                           value="{{ old('social_links.twitter', $social['twitter'] ?? '') }}" 
                           placeholder="https://twitter.com/..." 
                           class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">GitHub / Portfolio</label>
                    <input type="url" 
                           name="social_links[github]" 
                           value="{{ old('social_links.github', $social['github'] ?? '') }}" 
                           placeholder="https://github.com/..." 
                           class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <!-- Order & Status -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Display Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $member->order) }}" 
                       min="0" 
                       class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center pt-6">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-100 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">Active / Visible</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.team.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-slate-900 dark:text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                Update Member Profile
            </button>
        </div>
    </form>
</div>
@endsection
