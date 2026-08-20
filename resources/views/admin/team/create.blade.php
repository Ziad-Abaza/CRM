@extends('layouts.admin')

@section('title', __('admin.team.add_new'))
@section('page_title', __('admin.team.add_new'))

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ langTab: 'en' }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ __('admin.team.add_new') }}</h1>
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
            <a href="{{ route('admin.team.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
                &larr; {{ __('ui.buttons.back') }}
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf

        <!-- English Tab -->
        <div x-show="langTab === 'en'" class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_en') }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Member Name (English) <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="name_en" 
                           name="name[en]" 
                           value="{{ old('name.en') }}" 
                           required 
                           dir="ltr"
                           placeholder="e.g. David Vance" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="role_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Role / Designation (English) <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="role_en" 
                           name="role[en]" 
                           value="{{ old('role.en') }}" 
                           required 
                           dir="ltr"
                           placeholder="e.g. Managing Partner & Lead Architect" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="bio_en" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Biography (English)
                </label>
                <textarea id="bio_en" 
                          name="bio[en]" 
                          rows="3" 
                          dir="ltr"
                          placeholder="Executive background, prior advisory work, education..." 
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('bio.en') }}</textarea>
            </div>
        </div>

        <!-- Arabic Tab -->
        <div x-show="langTab === 'ar'" x-cloak class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-slate-800 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                <span>{{ __('admin.content.bilingual_tab_ar') }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        اسم العضو (العربية) <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                       id="name_ar" 
                       name="name[ar]" 
                       value="{{ old('name.ar') }}" 
                       required 
                       dir="rtl"
                       placeholder="مثال: د. ديفيد فانس" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="role_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        المسمى الوظيفي (العربية) <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           id="role_ar" 
                           name="role[ar]" 
                           value="{{ old('role.ar') }}" 
                           required 
                           dir="rtl"
                           placeholder="مثال: شريك إداري وكبير مهندسي النظم" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="bio_ar" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    النبذة المهنية (العربية)
                </label>
                <textarea id="bio_ar" 
                          name="bio[ar]" 
                          rows="3" 
                          dir="rtl"
                          placeholder="الخبرات السابقة، الشهادات، والإنجازات..." 
                          class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">{{ old('bio.ar') }}</textarea>
            </div>
        </div>

        <!-- Global Fields -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.team.email_label') }}
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="david@corporate.test" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.team.phone_label') }}
                </label>
                <input type="text" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone') }}" 
                       placeholder="+1 (555) 019-2834" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.team.photo_label') }}
                </label>
                <input type="file" 
                       name="photo" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-500 dark:text-slate-400 file:me-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
            </div>

            <div>
                <label for="order" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('admin.team.order_label') }}
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', 0) }}" 
                       min="0" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="sm:col-span-2 flex items-center pt-2">
                <label class="relative flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('admin.team.is_active_label') }}</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.team.index') }}" class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white text-sm transition">{{ __('ui.buttons.cancel') }}</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-600/30 transition">
                {{ __('ui.buttons.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
