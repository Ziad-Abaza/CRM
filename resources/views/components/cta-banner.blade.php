@props([
    'badge' => null,
    'title' => null,
    'subtitle' => null,
    'ctaText' => null,
    'buttonLocation' => 'cta_banner',
])

@php
    $badge = $badge ?? __('frontend.cta_banner.badge');
    $title = $title ?? setting('cta_banner_title', __('frontend.cta_banner.title'));
    $subtitle = $subtitle ?? setting('cta_banner_subtitle', __('frontend.cta_banner.subtitle'));
    $ctaText = $ctaText ?? setting('cta_banner_button_text', __('frontend.cta_banner.primary_button'));
@endphp

<section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-slate-100 via-slate-50 to-slate-100 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 overflow-hidden transition-colors duration-200">
    <!-- Ambient Backdrop Light -->
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 lg:w-[500px] h-48 sm:h-64 bg-blue-600/10 dark:bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-5 sm:space-y-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-950/80 border border-blue-300 dark:border-blue-500/30 text-blue-800 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider">
            <span>⚡</span>
            <span>{{ $badge }}</span>
        </div>

        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight max-w-2xl mx-auto">
            {{ $title }}
        </h2>

        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-xl mx-auto">
            {{ $subtitle }}
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-2">
            <x-whatsapp-cta-button 
                :text="$ctaText" 
                :buttonLocation="$buttonLocation" 
                variant="emerald" 
                size="md" 
                class="w-full sm:w-auto shadow-xl shadow-emerald-600/20 dark:shadow-emerald-950/80" />
        </div>
    </div>
</section>
