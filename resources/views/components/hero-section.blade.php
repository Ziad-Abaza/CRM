@props([
    'badge' => null,
    'title' => null,
    'subtitle' => null,
    'ctaText' => null,
    'whatsappMessage' => null,
    'ratingScore' => null,
    'ratingCount' => null,
])

@php
    $badge = $badge ?? setting('hero_badge', 'Enterprise Strategic Advisory');
    $title = $title ?? setting('hero_title', 'Accelerate Enterprise Scale with Predictable Precision');
    $subtitle = $subtitle ?? setting('hero_subtitle', 'Apex Corporate Solutions partners with institutional leaders to modernize legacy operations, implement high-yield automation, and safeguard governance at scale.');
    $ctaText = $ctaText ?? setting('hero_cta_text', 'Consult via WhatsApp');
    $whatsappMessage = $whatsappMessage ?? setting('hero_cta_whatsapp_message', 'Hello Apex team, I would like to schedule an executive strategy session.');
    $ratingScore = $ratingScore ?? setting('hero_rating_score', '4.9/5.0');
    $ratingCount = $ratingCount ?? setting('hero_rating_count', '250+ Enterprise Clients');
@endphp

<section class="relative overflow-hidden py-10 sm:py-14 lg:py-18 bg-slate-950 bg-grid-pattern border-b border-slate-800/80">
    <!-- Ambient Glow Orbs (Constrained to prevent horizontal scrolling on mobile) -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 sm:w-96 lg:w-[480px] h-64 sm:h-80 bg-blue-600/15 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-1/3 right-4 sm:right-10 w-48 sm:w-64 lg:w-80 h-48 sm:h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-10 items-center">
            
            <!-- Left Hero Content Column -->
            <div class="lg:col-span-7 space-y-5 sm:space-y-6 text-center lg:text-left">
                <!-- Badge Pill -->
                @if($badge)
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-500/30 text-blue-300 text-xs font-semibold tracking-wide shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        <span class="truncate max-w-[280px] sm:max-w-none">{{ $badge }}</span>
                    </div>
                @endif

                <!-- Main Punchy Heading -->
                <h1 class="text-2.5xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-[1.15]">
                    {{ $title }}
                </h1>

                <!-- Subtitle / Executive Overview -->
                <p class="text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    {{ $subtitle }}
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-4 pt-1">
                    <x-whatsapp-cta-button 
                        :text="$ctaText" 
                        :message="$whatsappMessage"
                        buttonLocation="hero_primary" 
                        variant="emerald" 
                        size="md" 
                        class="w-full sm:w-auto shadow-lg shadow-emerald-900/30" />

                    <a href="#services" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-5 py-2.5 sm:py-2.5 text-xs sm:text-sm rounded-xl gap-2 font-semibold bg-slate-900/90 hover:bg-slate-800 text-slate-200 border border-slate-700 hover:border-slate-600 transition">
                        <span>Explore Solutions</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                </div>

                <!-- Trust Signal / Social Proof -->
                <div class="pt-5 border-t border-slate-800/80 flex flex-wrap items-center justify-center lg:justify-start gap-4 sm:gap-6 text-xs text-slate-400">
                    <div class="flex items-center gap-1.5">
                        <div class="flex text-amber-400">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="font-bold text-slate-200">{{ $ratingScore }}</span>
                    </div>
                    <div class="h-3 w-px bg-slate-800 hidden sm:block"></div>
                    <span class="font-medium text-slate-300">{{ $ratingCount }}</span>
                    <div class="h-3 w-px bg-slate-800 hidden sm:block"></div>
                    <div class="flex items-center gap-1.5 text-emerald-400 font-semibold">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>SOC2 Verified</span>
                    </div>
                </div>
            </div>

            <!-- Right Visual / Interactive Architecture Card -->
            <div class="lg:col-span-5 relative w-full">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <!-- Glass Architecture Overview Panel -->
                    <div class="rounded-2xl bg-slate-900/90 border border-slate-700/70 shadow-xl shadow-slate-950/80 p-4 sm:p-6 backdrop-blur-xl relative overflow-hidden space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                            <div class="flex items-center gap-2">
                                <div class="h-2.5 w-2.5 rounded-full bg-rose-500/80"></div>
                                <div class="h-2.5 w-2.5 rounded-full bg-amber-500/80"></div>
                                <div class="h-2.5 w-2.5 rounded-full bg-emerald-500/80"></div>
                                <span class="text-[10px] sm:text-[11px] font-mono text-slate-400 ml-1.5">enterprise.system.monitor</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">LIVE RUNTIME</span>
                        </div>

                        <!-- Mini metrics stream -->
                        <div class="space-y-2.5">
                            <div class="p-2.5 sm:p-3 rounded-xl bg-slate-950/80 border border-slate-800 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="h-7 w-7 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 text-xs flex-shrink-0">⚡</div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-white truncate">Cloud Infrastructure Latency</p>
                                        <p class="text-[10px] text-slate-400 truncate">Microsecond Settlement</p>
                                    </div>
                                </div>
                                <span class="font-mono text-xs font-bold text-emerald-400 flex-shrink-0">12.4ms</span>
                            </div>

                            <div class="p-2.5 sm:p-3 rounded-xl bg-slate-950/80 border border-slate-800 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="h-7 w-7 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 text-xs flex-shrink-0">🛡️</div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-white truncate">Compliance & Governance</p>
                                        <p class="text-[10px] text-slate-400 truncate">Continuous Audit Telemetry</p>
                                    </div>
                                </div>
                                <span class="font-mono text-xs font-bold text-blue-400 flex-shrink-0">100% Pass</span>
                            </div>

                            <div class="p-2.5 sm:p-3 rounded-xl bg-slate-950/80 border border-slate-800 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="h-7 w-7 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-xs flex-shrink-0">💬</div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-white truncate">Executive WhatsApp SLA</p>
                                        <p class="text-[10px] text-slate-400 truncate">Partner Response Rate</p>
                                    </div>
                                </div>
                                <span class="font-mono text-xs font-bold text-emerald-400 flex-shrink-0">&lt; 15 mins</span>
                            </div>
                        </div>

                        <!-- Direct Consultation CTA Trigger inside card -->
                        <div class="pt-1">
                            <x-whatsapp-cta-button 
                                text="Initiate Direct Partner Call" 
                                message="Hello, I want to initiate a strategic consultation with a managing partner."
                                buttonLocation="hero_card" 
                                variant="emerald" 
                                size="sm" 
                                class="w-full justify-center" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
