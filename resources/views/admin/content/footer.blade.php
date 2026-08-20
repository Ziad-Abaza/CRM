@extends('layouts.admin')

@section('title', 'Footer & Social Links Manager')
@section('page_title', 'Footer & Social')

@section('content')
<div class="max-w-4l space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Footer & Social Profile Configuration</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Configure global footer summary, copyright statement, and executive social links.</p>
    </div>

    <form method="POST" action="{{ route('admin.content.footer.update') }}" class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label for="footer_about" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Footer Corporate Summary <span class="text-rose-400">*</span>
                </label>
                <textarea id="footer_about" 
                         name="footer_about" 
                          rows="3" 
                          required 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-indigo-500 @error('footer_about') border-rose-500 @enderror">{{ old('footer_about', $settings['footer_about']) }}</textarea>
                @error('footer_about') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="footer_copyright" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Copyright Notice Text <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="footer_copyright" 
                       name="footer_copyright" 
                       value="{{ old('footer_copyright', $settings['footer_copyright']) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('footer_copyright') border-rose-500 @enderror">
                @error('footer_copyright') <p class="mt-1 text-xs text-rose-400":{{ $message }}</p> @enderror
            </div>

        <!-- Social Media Profiles -->
        <div class="border-t border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Social Presence Channels</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="social_linkedin" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        LinkedIn Organization URL
                    </label>
                    <input type="url" 
                           id="social_linkedin" 
                         name="social_linkedin"
                         value="{{ old('social_linkedin', $settings['social_linkedin']) }}" 
                         placeholder="https://linkedin.com/company/..."
                         class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('social_linkedin') border-rose-500 @enderror">
                    @error('social_linkedin') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="social_twitter" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        X / Twitter Profile URL
                    </label>
                    <input type="url" 
                          id="social_twitter" 
                          name="social_twitter" 
                         value="{{ old('social_twitter', $settings['social_twitter']) }}" 
                         placeholder="https://x.com/..."
                         class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('social_twitter') border-rose-500 @enderror">
                    @error('social_twitter') <p class="mt-1 text-xs text-rose-400":{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                <span>Save Footer Configuration</span>
            </button>
        </div>
    </form>
</div>
@endsection
