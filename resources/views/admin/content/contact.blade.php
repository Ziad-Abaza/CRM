@extends('layouts.admin')

@section('title', __('admin.content.contact_title'))
@section('page_title', __('admin.nav.contact_section'))

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.content.contact_title') }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('admin.content.switch_tab_notice') }}</p>
        </div>

        <!-- Language Tabs -->
        <div class="inline-flex items-center gap-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-1 rounded-xl shadow-sm text-xs">
            <button type="button" @click="langTab = 'en'" :class="langTab === 'en' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                {{ __('admin.content.bilingual_tab_en') }}
            </button>
            <button type="button" @click="langTab = 'ar'" :class="langTab === 'ar' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                {{ __('admin.content.bilingual_tab_ar') }}
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.content.contact.update') }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">Corporate Channels</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="contact_email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ __('admin.team.email_label') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" 
                           id="contact_email" 
                           name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('contact_email') border-rose-500 @enderror">
                    @error('contact_email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="contact_phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ __('admin.leads.table_phone') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="contact_phone" 
                           name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone']) }}" 
                           required 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 @error('contact_phone') border-rose-500 @enderror">
                    @error('contact_phone') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- English Address -->
            <div x-show="langTab === 'en'">
                <label for="contact_address_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Physical Headquarters / Address (English) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="contact_address_en" 
                       name="contact_address[en]" 
                       value="{{ old('contact_address.en', is_array($settings['contact_address']) ? ($settings['contact_address']['en'] ?? '') : $settings['contact_address']) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Arabic Address -->
            <div x-show="langTab === 'ar'" x-cloak>
                <label for="contact_address_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    العنوان والمقر الرئيسي (العربية) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="contact_address_ar" 
                       name="contact_address[ar]" 
                       value="{{ old('contact_address.ar', is_array($settings['contact_address']) ? ($settings['contact_address']['ar'] ?? '') : $settings['contact_address']) }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 space-y-4">
            <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">{{ __('admin.nav.contact_section') }}</h2>

            <div>
                <label for="whatsapp_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    WhatsApp Phone Number (E.164 with +, e.g. +12345678901) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="whatsapp_number" 
                       name="whatsapp_number" 
                       value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 font-mono @error('whatsapp_number') border-rose-500 @enderror">
                @error('whatsapp_number') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- English WhatsApp Default Message -->
            <div x-show="langTab === 'en'">
                <label for="whatsapp_default_message_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Global Fallback WhatsApp Message (English) <span class="text-rose-500">*</span>
                </label>
                <textarea id="whatsapp_default_message_en" 
                          name="whatsapp_default_message[en]" 
                          rows="2" 
                          required 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('whatsapp_default_message.en', is_array($settings['whatsapp_default_message']) ? ($settings['whatsapp_default_message']['en'] ?? '') : $settings['whatsapp_default_message']) }}</textarea>
            </div>

            <!-- Arabic WhatsApp Default Message -->
            <div x-show="langTab === 'ar'" x-cloak>
                <label for="whatsapp_default_message_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    رسالة واتساب الافتراضية (العربية) <span class="text-rose-500">*</span>
                </label>
                <textarea id="whatsapp_default_message_ar" 
                          name="whatsapp_default_message[ar]" 
                          rows="2" 
                          required 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('whatsapp_default_message.ar', is_array($settings['whatsapp_default_message']) ? ($settings['whatsapp_default_message']['ar'] ?? '') : $settings['whatsapp_default_message']) }}</textarea>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition">
                <span>{{ __('ui.buttons.save_changes') }}</span>
            </button>
        </div>
    </form>
</div>
@endsection
