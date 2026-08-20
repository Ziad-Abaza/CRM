@props([
    'pricingPlans' => collect(),
])

<section id="pricing" class="py-20 lg:py-32 bg-slate-950 relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-4 mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-950/70 border border-blue-500/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
                Transparent Advisory Retainers
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Predictable Engagements, Maximum Velocity
            </h2>
            <p class="text-base sm:text-lg text-slate-300">
                Fixed monthly retainer models with clear deliverables, guaranteed SLAs, and direct WhatsApp executive escalation.
            </p>
        </div>

        <!-- Pricing Cards Grid -->
        <div class="grid lg:grid-cols-3 gap-8 items-stretch">
            @forelse($pricingPlans as $plan)
                <div class="rounded-3xl p-8 flex flex-col justify-between transition duration-300 relative {{ $plan->is_featured ? 'bg-gradient-to-b from-slate-900 to-slate-950 border-2 border-blue-500 shadow-2xl shadow-blue-950/80 lg:-translate-y-2' : 'bg-slate-900/70 border border-slate-800 hover:border-slate-700' }}">
                    
                    <!-- Featured Badge -->
                    @if($plan->is_featured)
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider shadow-md">
                            Most Popular Engagement
                        </div>
                    @endif

                    <div class="space-y-6">
                        <!-- Header / Name -->
                        <div class="space-y-2">
                            <h3 class="text-2xl font-bold text-white">{{ $plan->name }}</h3>
                            <p class="text-xs sm:text-sm text-slate-300 min-h-[40px]">
                                {{ $plan->description }}
                            </p>
                        </div>

                        <!-- Price Tag -->
                        <div class="pt-4 border-t border-slate-800 flex items-baseline gap-1">
                            <span class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                                ${{ number_format($plan->price, 0) }}
                            </span>
                            <span class="text-sm font-semibold text-slate-400">
                                /{{ $plan->billing_period }}
                            </span>
                        </div>

                        <!-- Features List -->
                        @if(!empty($plan->features))
                            <ul class="space-y-3.5 pt-4 text-xs sm:text-sm text-slate-300 border-t border-slate-800">
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start gap-2.5">
                                        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <div class="pt-8 mt-8 border-t border-slate-800">
                        <x-whatsapp-cta-button 
                            text="Select {{ $plan->name }}" 
                            :message="$plan->whatsapp_message ?? ('Hello Apex team, I am interested in the ' . $plan->name . ' retainer plan.')"
                            :buttonLocation="'pricing_' . $plan->slug" 
                            :variant="$plan->is_featured ? 'emerald' : 'secondary'" 
                            size="lg" 
                            class="w-full justify-center" />
                    </div>

                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    No pricing tiers currently configured.
                </div>
            @endforelse
        </div>

    </div>
</section>
