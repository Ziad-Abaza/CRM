@extends('layouts.admin')

@section('title', __('admin.pricing.table_title') . ': ' . $plan->name)
@section('page_title', __('admin.pricing.table_title'))

@php
    $nameTrans = $plan->getTranslations('name');
    $billingTrans = $plan->getTranslations('billing_period');
    $descTrans = $plan->getTranslations('description');
    $featuresTrans = $plan->getTranslations('features');
    $featuresEn = is_array($featuresTrans) && isset($featuresTrans['en']) ? $featuresTrans['en'] : (is_array($plan->features) ? $plan->features : []);
    $featuresAr = is_array($featuresTrans) && isset($featuresTrans['ar']) ? $featuresTrans['ar'] : [];
    $whatsappTrans = $plan->getTranslations('whatsapp_message');
@endphp

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ 
    langTab: 'en',
    features_en: {{ json_encode(old('features.en', $featuresEn ?: [''])) }},
    features_ar: {{ json_encode(old('features.ar', $featuresAr ?: [''])) }}
}">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('ui.buttons.edit') }}: {{ $plan->name }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('admin.content.switch_tab_notice') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="inline-flex items-center gap-1 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-1 rounded-xl shadow-sm text-xs">
                <button type="button" @click="langTab = 'en'" :class="langTab === 'en' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    {{ __('admin.content.bilingual_tab_en') }}
                </button>
                <button type="button" @click="langTab = 'ar'" :class="langTab === 'ar' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    {{ __('admin.content.bilingual_tab_ar') }}
                </button>
            </div>
            <a href="{{ route('admin.pricing.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
                &larr; {{ __('ui.buttons.back') }}
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.pricing.update', $plan) }}" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <!-- English Tab -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div>
                <label for="name_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Plan Name (English) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="name_en" 
                       name="name[en]" 
                       value="{{ old('name.en', $nameTrans['en'] ?? $plan->name) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="billing_period_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Billing Period (English) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="billing_period_en" 
                       name="billing_period[en]" 
                       value="{{ old('billing_period.en', $billingTrans['en'] ?? $plan->billing_period) }}" 
                       required 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="description_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Plan Description (English)
                </label>
                <textarea id="description_en" 
                          name="description[en]" 
                          rows="2" 
                          dir="ltr"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('description.en', $descTrans['en'] ?? $plan->description) }}</textarea>
            </div>

            <div>
                <label for="whatsapp_message_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    WhatsApp Inquiry Message (English)
                </label>
                <input type="text" 
                       id="whatsapp_message_en" 
                       name="whatsapp_message[en]" 
                       value="{{ old('whatsapp_message.en', $whatsappTrans['en'] ?? $plan->whatsapp_message) }}" 
                       dir="ltr"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Features EN -->
            <div class="border-t border-slate-200 dark:border-slate-800 pt-4 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        {{ __('admin.pricing.features_label') }} (English)
                    </label>
                    <button type="button" @click="features_en.push('')" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800/60 hover:bg-indigo-100 transition">
                        + {{ __('ui.buttons.add') }}
                    </button>
                </div>
                <template x-for="(item, index) in features_en" :key="index">
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               :name="'features[en][' + index + ']'" 
                               x-model="features_en[index]" 
                               dir="ltr"
                               class="flex-1 px-3 py-2 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="features_en.splice(index, 1)" class="p-2 text-slate-400 hover:text-rose-500 rounded-lg transition" aria-label="{{ __('ui.buttons.delete') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Arabic Tab -->
        <div x-show="langTab === 'ar'" x-cloak class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_ar') }}</span>
            </div>

            <div>
                <label for="name_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    اسم الخطة (العربية) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="name_ar" 
                       name="name[ar]" 
                       value="{{ old('name.ar', $nameTrans['ar'] ?? '') }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="billing_period_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    دورة الفوترة (العربية) <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="billing_period_ar" 
                       name="billing_period[ar]" 
                       value="{{ old('billing_period.ar', $billingTrans['ar'] ?? '') }}" 
                       required 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="description_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    وصف الخطة (العربية)
                </label>
                <textarea id="description_ar" 
                          name="description[ar]" 
                          rows="2" 
                          dir="rtl"
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('description.ar', $descTrans['ar'] ?? '') }}</textarea>
            </div>

            <div>
                <label for="whatsapp_message_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    رسالة الاستفسار عبر واتساب (العربية)
                </label>
                <input type="text" 
                       id="whatsapp_message_ar" 
                       name="whatsapp_message[ar]" 
                       value="{{ old('whatsapp_message.ar', $whatsappTrans['ar'] ?? '') }}" 
                       dir="rtl"
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Features AR -->
            <div class="border-t border-slate-200 dark:border-slate-800 pt-4 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        {{ __('admin.pricing.features_label') }} (العربية)
                    </label>
                    <button type="button" @click="features_ar.push('')" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800/60 hover:bg-indigo-100 transition">
                        + {{ __('ui.buttons.add') }}
                    </button>
                </div>
                <template x-for="(item, index) in features_ar" :key="index">
                    <div class="flex items-center gap-2">
                        <input type="text" 
                               :name="'features[ar][' + index + ']'" 
                               x-model="features_ar[index]" 
                               dir="rtl"
                               class="flex-1 px-3 py-2 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="features_ar.splice(index, 1)" class="p-2 text-slate-400 hover:text-rose-500 rounded-lg transition" aria-label="{{ __('ui.buttons.delete') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Global Pricing Settings -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.pricing.price_label') }} <span class="text-rose-400">*</span>
                </label>
                <input type="number" 
                       step="0.01" 
                       id="price" 
                       name="price" 
                       value="{{ old('price', $plan->price) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm font-mono focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="currency" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.pricing.currency_label') }} <span class="text-rose-400">*</span>
                </label>
                <input type="text" 
                       id="currency" 
                       name="currency" 
                       value="{{ old('currency', $plan->currency) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm font-mono uppercase focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.pricing.order_label') }}
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $plan->order) }}" 
                       min="0" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-3 flex flex-wrap items-center gap-6 pt-2">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.pricing.is_featured_label') }}</span>
                </label>

                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.pricing.is_active_label') }}</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.pricing.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">{{ __('ui.buttons.cancel') }}</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                {{ __('ui.buttons.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
