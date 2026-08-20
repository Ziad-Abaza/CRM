@props([
    'title' => 'Ready to Modernize Your Enterprise Infrastructure?',
    'subtitle' => 'Schedule a strategic diagnostic session with our managing partners on WhatsApp today.',
    'ctaText' => 'Initiate Strategic Consultation',
    'buttonLocation' => 'cta_banner',
])

<section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 relative border-b border-slate-800/80 overflow-hidden">
    <!-- Ambient Backdrop Light -->
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 lg:w-[500px] h-48 sm:h-64 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-5 sm:space-y-6">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-500/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
            ⚡ Direct Executive Access
        </div>

        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight max-w-2xl mx-auto">
            {{ $title }}
        </h2>

        <p class="text-sm sm:text-base text-slate-300 max-w-xl mx-auto">
            {{ $subtitle }}
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-2">
            <x-whatsapp-cta-button 
                :text="$ctaText" 
                :buttonLocation="$buttonLocation" 
                variant="emerald" 
                size="md" 
                class="w-full sm:w-auto shadow-xl shadow-emerald-950/80" />
        </div>
    </div>
</section>
