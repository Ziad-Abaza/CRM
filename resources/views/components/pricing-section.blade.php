@props(['pricingPlans'])

<section id="pricing" class="py-12 sm:py-16 lg:py-20 bg-slate-50/60 dark:bg-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-3 sm:space-y-4 mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/80 border border-indigo-200 dark:border-indigo-500/30 text-indigo-700 dark:text-indigo-300 text-xs font-semibold uppercase tracking-wider">
                {{ __('frontend.pricing.section_badge') }}
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                {{ setting('pricing_section_title', __('frontend.pricing.section_title')) }}
            </h2>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                {{ setting('pricing_section_subtitle', __('frontend.pricing.section_subtitle')) }}
            </p>
        </div>

        <!-- Pricing Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            @foreach($pricingPlans as $plan)
                <div class="rounded-2xl border {{ $plan->is_featured ? 'border-emerald-500/60 bg-white dark:bg-slate-900 shadow-xl shadow-emerald-500/10 ring-2 ring-emerald-500/20' : 'border-slate-200 dark:border-slate-800/90 bg-white dark:bg-slate-900/80 shadow-sm' }} p-5 sm:p-6 lg:p-7 flex flex-col justify-between relative transition duration-300 text-start">
                    
                    @if($plan->is_featured)
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-emerald-600 text-white font-bold text-[10px] uppercase tracking-wider shadow-md shadow-emerald-600/30">
                            {{ __('frontend.pricing.popular_badge') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="space-y-1">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">{{ $plan->name }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 min-h-[32px]">{{ $plan->description }}</p>
                        </div>

                        <!-- Price Tag -->
                        <div class="py-2 border-y border-slate-100 dark:border-slate-800/80 flex items-baseline gap-1" dir="ltr">
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">{{ $plan->currency }}</span>
                            <span class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                                ${{ number_format($plan->price) }}
                            </span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">/ {{ $plan->billing_period }}</span>
                        </div>

                        <!-- Features List -->
                        <ul class="space-y-2 text-xs sm:text-sm text-slate-700 dark:text-slate-300">
                            @foreach($plan->features ?? [] as $feature)
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="leading-tight">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-5 mt-5 border-t border-slate-100 dark:border-slate-800">
                        <x-whatsapp-cta-button 
                            :text="__('frontend.pricing.get_started') . ' - ' . $plan->name" 
                            :message="$plan->whatsapp_message ?? 'Hello Apex team, I want to initiate the ' . $plan->name . ' tier.'"
                            buttonLocation="pricing_tier" 
                            :variant="$plan->is_featured ? 'emerald' : 'dark'" 
                            size="md" 
                            class="w-full justify-center" />
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
