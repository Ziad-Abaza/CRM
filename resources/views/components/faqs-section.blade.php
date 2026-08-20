@props([
    'faqs' => collect(),
])

<section id="faqs" class="py-12 sm:py-16 lg:py-20 bg-slate-950 bg-grid-pattern relative border-b border-slate-800/80">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center space-y-3 mb-10 sm:mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/70 border border-blue-500/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
                Common Questions
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Frequently Asked Questions
            </h2>
            <p class="text-sm sm:text-base text-slate-300">
                Transparent answers regarding engagement timelines, compliance security, and executive access.
            </p>
        </div>

        <!-- Accordion Container using Alpine.js -->
        <div class="space-y-3" x-data="{ openFaq: null }">
            @forelse($faqs as $index => $faq)
                <div class="rounded-xl bg-slate-900/80 border border-slate-800 overflow-hidden transition duration-200">
                    <button type="button" 
                            @click="openFaq = (openFaq === {{ $index }} ? null : {{ $index }})" 
                            class="w-full px-4 sm:px-5 py-3.5 sm:py-4 text-left flex items-center justify-between gap-3 sm:gap-4 focus:outline-none group">
                        <span class="text-xs sm:text-sm font-bold text-slate-200 group-hover:text-white transition">
                            {{ $faq->question }}
                        </span>
                        <div class="h-7 w-7 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 group-hover:text-white transition flex-shrink-0">
                            <svg class="w-3.5 h-3.5 transform transition duration-200" :class="openFaq === {{ $index }} ? 'rotate-180 text-blue-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="openFaq === {{ $index }}" 
                         x-cloak 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-4 sm:px-5 pb-4 pt-1 text-xs sm:text-sm text-slate-300 leading-relaxed border-t border-slate-800/60">
                        {{ $faq->answer }}
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 text-sm">
                    No FAQs currently available.
                </div>
            @endforelse
        </div>

        <!-- Additional Inquiries Strip -->
        <div class="mt-8 sm:mt-10 p-4 sm:p-5 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <h4 class="font-bold text-xs sm:text-sm text-white">Have a more nuanced question?</h4>
                <p class="text-xs text-slate-400 mt-0.5">Our senior partner is available for direct confidential discussion.</p>
            </div>
            <x-whatsapp-cta-button 
                text="Ask via WhatsApp" 
                message="Hello, I have a specific question not covered in your FAQ section."
                buttonLocation="faqs_bottom" 
                variant="emerald" 
                size="sm" />
        </div>

    </div>
</section>
