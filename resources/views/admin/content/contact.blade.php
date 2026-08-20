@extends('layouts.admin')

@section('title', 'WhatsApp Profile & Contact Configuration')
@section('page_title', 'WhatsApp & Contact Profile')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">WhatsApp Profile &amp; Contact Information</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure company telephone, email, physical office address, and primary WhatsApp lead numbers.</p>
    </div>

    <form method="POST" action="{{ route('admin.content.contact.update') }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Corporate Channels</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="company_email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                        Official Corporate Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" 
                           id="company_email" 
                           name="company_email" 
                           value="{{ old('company_email', $settings['company_email']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('company_email') border-rose-500 @enderror">
                    @error('company_email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="company_phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                        Corporate Telephone Line <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="company_phone" 
                           name="company_phone" 
                           value="{{ old('company_phone', $settings['company_phone']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('company_phone') border-rose-500 @enderror">
                    @error('company_phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="company_address" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                    Physical Headquarters / Address <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="company_address" 
                       name="company_address" 
                       value="{{ old('company_address', $settings['company_address']) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('company_address') border-rose-500 @enderror">
                @error('company_address') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">WhatsApp Direct Lead Configuration</h2>

            <div>
                <label for="company_whatsapp_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                    WhatsApp Phone Number (E.164 without +, e.g. 18005550199) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="company_whatsapp_number" 
                       name="company_whatsapp_number" 
                       value="{{ old('company_whatsapp_number', $settings['company_whatsapp_number']) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 font-mono @error('company_whatsapp_number') border-rose-500 @enderror">
                @error('company_whatsapp_number') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="whatsapp_default_message" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-700 dark:text-slate-300 mb-1.5">
                    Global Fallback WhatsApp Message <span class="text-rose-500">*</span>
                </label>
                <textarea id="whatsapp_default_message" 
                          name="whatsapp_default_message" 
                          rows="2" 
                          required 
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('whatsapp_default_message') border-rose-500 @enderror">{{ old('whatsapp_default_message', $settings['whatsapp_default_message']) }}</textarea>
                @error('whatsapp_default_message') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-slate-900 dark:text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                <span>Save Contact Configuration</span>
            </button>
        </div>
    </form>
</div>
@endsection
