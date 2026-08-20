@props([
    'title' => 'Ready to Modernize Your Enterprise Infrastructure?',
    'subtitle' => 'Schedule a strategic diagnostic session with our managing partners on WhatsApp today.',
    'ctaText' => 'Initiate Strategic Consultation',
    'buttonLocation' => 'cta_banner',
])

<section class="py-20 lg:py-24 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 relative border-b border-slate-800/80 overflow-hidden">
    <!-- Ambient Backdrop Light -->
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[300px] bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-8">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-950/80 border border-blue-500/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
            ⚡ Direct Executive Access
        </div>

        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight max-w-3xl mx-auto">
            {{ $title }}
        </h2>

        <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto">
            {{ $subtitle }}
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <x-whatsapp-cta-button 
                :text="$ctaText" 
                :buttonLocation="$buttonLocation" 
                variant="emerald" 
                size="lg" 
                class="w-full sm:w-auto shadow-2xl shadow-emerald-950/80" />
        </div>
    </div>
</section>
