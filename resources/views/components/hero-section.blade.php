@props([
    'badge' => null,
    'title' => null,
    'subtitle' => null,
    'ctaText' => null,
    'ctaWhatsappMessage' => null,
    'ratingScore' => null,
    'ratingCount' => null,
])

@php
    $badge = $badge ?? setting('hero_badge', __('frontend.hero.badge'));
    $title = $title ?? setting('hero_title', __('frontend.hero.title'));
    $subtitle = $subtitle ?? setting('hero_subtitle', __('frontend.hero.subtitle'));
    $ctaText = $ctaText ?? setting('hero_cta_text', __('frontend.hero.consult_cta'));
    $ctaWhatsappMessage = $ctaWhatsappMessage ?? setting('whatsapp_default_message', __('frontend.hero.default_msg'));
    $ratingScore = $ratingScore ?? __('frontend.hero.rating_score');
    $ratingCount = $ratingCount ?? __('frontend.hero.rating_count');
@endphp

<section class="relative overflow-hidden bg-white dark:bg-slate-950 py-12 sm:py-16 lg:py-20 border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <!-- Ambient Light Beam / Grid Pattern -->
    <div class="absolute inset-0 bg-grid-pattern opacity-60 dark:opacity-40 pointer-events-none"></div>
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-72 sm:w-96 lg:w-[480px] h-48 sm:h-64 bg-blue-500/10 dark:bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-10 items-center">
            
            <!-- Left/Start Column: Content -->
            <div class="lg:col-span-7 space-y-5 sm:space-y-6 text-start">
                <!-- Trust Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/80 border border-blue-200 dark:border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 dark:bg-blue-400 animate-pulse"></span>
                    <span>{{ $badge }}</span>
                </div>

                <!-- Main Editorial Heading -->
                <h1 class="text-2.5xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.15] max-w-2xl">
                    {{ $title }}
                </h1>

                <!-- Subtitle Description -->
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl font-normal">
                    {{ $subtitle }}
                </p>

                <!-- Primary CTA Action & Secondary Channel -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-1">
                    <x-whatsapp-cta-button 
                        :text="$ctaText" 
                        :message="$ctaWhatsappMessage"
                        buttonLocation="hero_primary" 
                        variant="emerald" 
                        size="lg" 
                        class="shadow-lg shadow-emerald-600/20 dark:shadow-emerald-950/60" />

                    <a href="#services" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold rounded-xl text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-700/80 transition transform active:scale-95 shadow-sm">
                        <span>{{ __('frontend.hero.explore_capabilities') }}</span>
                        <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

                <!-- Trust Signal Metric -->
                <div class="pt-3 flex items-center gap-3 sm:gap-4 border-t border-slate-200 dark:border-slate-800/80">
                    <div class="flex -space-x-2 rtl:space-x-reverse">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border-2 border-white dark:border-slate-900 bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-[10px] font-bold text-white shadow-sm">
                            DS
                        </div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border-2 border-white dark:border-slate-900 bg-gradient-to-tr from-emerald-600 to-teal-600 flex items-center justify-center text-[10px] font-bold text-white shadow-sm">
                            ER
                        </div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border-2 border-white dark:border-slate-900 bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-[10px] font-bold text-white shadow-sm">
                            JV
                        </div>
                    </div>
                    <div class="text-xs text-start">
                        <div class="flex items-center gap-1 text-amber-500 dark:text-amber-400 font-bold">
                            <span>★ ★ ★ ★ ★</span>
                            <span class="text-slate-800 dark:text-slate-200 ms-1 text-xs">{{ $ratingScore }}</span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-[11px]">{{ $ratingCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Right/End Column: Interactive Diagnostic Matrix Visual -->
            <div class="lg:col-span-5 relative mt-4 lg:mt-0">
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800/80 bg-white/90 dark:bg-slate-900/80 backdrop-blur-xl p-5 sm:p-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-950/80 space-y-4 relative overflow-hidden transition-colors duration-200 text-start">
                    
                    <!-- Decorative Top Header Bar -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500/80"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500/80"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/80"></span>
                        </div>
                        <span class="text-[10px] font-mono text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wider">
                            {{ __('frontend.hero.telemetry_engine') }}
                        </span>
                    </div>

                    <!-- Mini Diagnostic KPI Grid -->
                    <div class="grid grid-cols-2 gap-3 pt-1">
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 space-y-1">
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-semibold">{{ __('frontend.hero.audit_velocity') }}</span>
                            <p class="text-base sm:text-lg font-black text-slate-900 dark:text-white" dir="ltr">99.98%</p>
                            <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-medium">{{ __('frontend.hero.audit_velocity_sub') }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 space-y-1">
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-semibold">{{ __('frontend.hero.ledger_latency') }}</span>
                            <p class="text-base sm:text-lg font-black text-slate-900 dark:text-white" dir="ltr">&lt; 12ms</p>
                            <span class="text-[10px] text-blue-600 dark:text-blue-400 font-medium">{{ __('frontend.hero.ledger_latency_sub') }}</span>
                        </div>
                    </div>

                    <!-- Interactive Diagnostic Terminal Box -->
                    <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-[11px] font-mono text-slate-700 dark:text-slate-300 space-y-1.5" dir="ltr">
                        <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-[10px]">
                            <span>{{ __('frontend.hero.terminal_pipeline') }}</span>
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ __('frontend.hero.terminal_status') }}</span>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 truncate">{{ __('frontend.hero.terminal_line1') }}</p>
                        <p class="text-slate-600 dark:text-slate-400 truncate">{{ __('frontend.hero.terminal_line2') }}</p>
                    </div>

                    <!-- Direct Connect Row -->
                    <div class="pt-2">
                        <x-whatsapp-cta-button 
                            :text="__('frontend.hero.connect_architect')" 
                            :message="__('frontend.hero.connect_architect_msg')"
                            buttonLocation="hero_matrix" 
                            variant="dark" 
                            size="sm" 
                            class="w-full justify-center" />
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
