@props(['faqs'])

<section id="faqs" class="py-12 sm:py-16 lg:py-20 bg-slate-50/60 dark:bg-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center space-y-3 sm:space-y-4 mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/80 border border-blue-200 dark:border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider">
                Clarification &amp; Governance
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                Frequently Asked Questions
            </h2>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                Key specifics regarding our corporate engagements, SLAs, and direct WhatsApp communication.
            </p>
        </div>

        <!-- FAQs Accordion -->
        <div class="space-y-3" x-data="{ activeAccordion: null }">
            @foreach($faqs as $faq)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800/90 bg-white dark:bg-slate-900/90 overflow-hidden shadow-sm transition">
                    <button type="button" 
                            @click="activeAccordion = (activeAccordion === {{ $faq->id }} ? null : {{ $faq->id }})"
                            class="w-full px-4 sm:px-5 py-3.5 sm:py-4 text-left flex items-center justify-between gap-4 font-bold text-slate-900 dark:text-white text-xs sm:text-sm hover:text-blue-600 dark:hover:text-blue-400 transition">
                        <span class="leading-snug">{{ $faq->question }}</span>
                        <div class="h-6 w-6 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 flex-shrink-0 transition transform duration-200"
                             :class="{ 'rotate-180 bg-blue-600 text-white dark:bg-blue-600': activeAccordion === {{ $faq->id }} }">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="activeAccordion === {{ $faq->id }}" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-4 sm:px-5 pb-4 pt-1 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-100 dark:border-slate-800/60">
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
