@props([
    'pricingPlans' => collect(),
])

<section id="pricing" class="py-12 sm:py-16 lg:py-20 bg-slate-950 relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-2xl mx-auto text-center space-y-3 mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/70 border border-blue-500/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
                Transparent Advisory Retainers
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Predictable Engagements, Maximum Velocity
            </h2>
            <p class="text-sm sm:text-base text-slate-300">
                Fixed monthly retainer models with clear deliverables, guaranteed SLAs, and direct WhatsApp executive escalation.
            </p>
        </div>

        <!-- Pricing Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7 items-stretch">
            @forelse($pricingPlans as $plan)
                <div class="rounded-2xl p-5 sm:p-6 lg:p-7 flex flex-col justify-between transition duration-300 relative {{ $plan->is_featured ? 'bg-gradient-to-b from-slate-900 to-slate-950 border-2 border-blue-500 shadow-xl shadow-blue-950/60 lg:-translate-y-1' : 'bg-slate-900/70 border border-slate-800 hover:border-slate-700' }}">
                    
                    <!-- Featured Badge -->
                    @if($plan->is_featured)
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-blue-600 text-white text-[11px] font-bold uppercase tracking-wider shadow-md whitespace-nowrap">
                            Most Popular
                        </div>
                    @endif

                    <div class="space-y-4">
                        <!-- Header / Name -->
                        <div class="space-y-1">
                            <h3 class="text-lg sm:text-xl font-bold text-white">{{ $plan->name }}</h3>
                            <p class="text-xs text-slate-300 min-h-[32px] line-clamp-2">
                                {{ $plan->description }}
                            </p>
                        </div>

                        <!-- Price Tag -->
                        <div class="pt-3 border-t border-slate-800 flex items-baseline gap-1">
                            <span class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                                ${{ number_format($plan->price, 0) }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400">
                                /{{ $plan->billing_period }}
                            </span>
                        </div>

                        <!-- Features List -->
                        @if(!empty($plan->features))
                            <ul class="space-y-2.5 pt-3 text-xs text-slate-300 border-t border-slate-800">
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="leading-relaxed">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <div class="pt-5 mt-5 border-t border-slate-800">
                        <x-whatsapp-cta-button 
                            text="Select {{ $plan->name }}" 
                            :message="$plan->whatsapp_message ?? ('Hello Apex team, I am interested in the ' . $plan->name . ' retainer plan.')"
                            :buttonLocation="'pricing_' . $plan->slug" 
                            :variant="$plan->is_featured ? 'emerald' : 'secondary'" 
                            size="md" 
                            class="w-full justify-center" />
                    </div>

                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 text-slate-400 text-sm">
                    No pricing tiers currently configured.
                </div>
            @endforelse
        </div>

    </div>
</section>
