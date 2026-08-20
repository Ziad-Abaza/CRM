@extends('layouts.admin')

@section('title', 'WhatsApp & Contact Profile')
@section('page_title', 'WhatsApp & Contact')

@section('content')
<div class="max-w-4l space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight">WhatsApp & Contact Profile Manager</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Configure global WhatsApp routing number, corporate email, office location, and default inquiry templates.</p>
    </div>

    <form method="POST" action="{{ route('admin.content.contact.update') }}" class="bg-slate-900/80 border border-slate-800/80 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <!-- WhatsApp Specific Configurations -->
        <div class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-800">
                <span class="p-1 rounded-mg bg-emerald-500/10 text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                </span>
                <h2 class="text-sm font-bold text-white uppercase tracking-wider">Direct WhatsApp Routing</h2>
            </div>

            <div>
                <label for="whatsapp_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    WhatsApp Number (International format with country code, e.g. +15550192834) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="whatsapp_number" 
                       name="whatsapp_number" 
                       value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}" 
                       required 
                       placeholder="+15550192834"
                       class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white font-mono text-sm focus:ring-2 focus:ring-indigo-500 @error('whatsapp_number') border-rose-500 @enderror">
                @error('whatsapp_number') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="whatsapp_default_message" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Default WhatsApp Inbound Message <span class="text-rose-400">*</span>
                </label>
                <textarea id="whatsapp_default_message" 
                          name="whatsapp_default_message" 
                          rows="3" 
                          required 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('whatsapp_default_message') border-rose-500 @enderror">{{ old('whatsapp_default_message', $settings['whatsapp_default_message']) }}</textarea>
                @error('whatsapp_default_message') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- General Corporate Contact Details -->
        <div class="border-t border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Corporate Channels</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="contact_email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Inquiry Email Address <span class="text-rose-400">*</span>
                    </label>
                    <input type="email" 
                           id="contact_email" 
                           name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('contact_email') border-rose-500 @enderror">
                @error('contact_email') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="contact_phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Display Telephone <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="contact_phone" 
                           name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('contact_phone') border-rose-500 @enderror">
                @error('contact_phone') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="contact_address" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Physical Headquarters / Legal Address <span class="text-rose-400">*</span>
                </label>
                <textarea id="contact_address" 
                          name="contact_address" 
                          rows="2" 
                          required 
                          class="w-full px-4 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-white text-sm focus:ring-indigo-500 @error('contact_address') border-rose-500 @enderror">{{ old('contact_address', $settings['contact_address']) }}</textarea>
                @error('contact_address') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                <span>Save Contact Configuration</span>
            </button>
        </div>
    </form>
</div>
@endsection
