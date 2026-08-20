@props(['services'])

<section id="services" class="py-12 sm:py-16 lg:py-20 bg-slate-50/60 dark:bg-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-3 sm:space-y-4 mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/80 border border-blue-200 dark:border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider">
                Strategic Capabilities
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                Institutional-Grade Advisory &amp; Technical Execution
            </h2>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                Engineered for mid-market and enterprise organizations navigating mission-critical scaling inflection points.
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($services as $service)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800/90 bg-white dark:bg-slate-900/90 p-5 sm:p-6 shadow-sm hover:shadow-xl hover:border-blue-500/50 transition duration-300 flex flex-col justify-between group">
                    <div class="space-y-4">
                        
                        <!-- Service Icon Frame -->
                        <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl bg-gradient-to-tr from-blue-600/10 to-indigo-600/10 dark:from-blue-600/20 dark:to-indigo-600/20 border border-blue-500/30 dark:border-blue-500/40 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:scale-110 transition duration-200">
                            @if($service->icon === 'server-stack')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" /></svg>
                            @elseif($service->icon === 'chart-bar-square')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            @elseif($service->icon === 'shield-check')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            @elseif($service->icon === 'cpu-chip')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            @endif
                        </div>

                        <!-- Title & Description -->
                        <div class="space-y-1.5">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                <a href="{{ route('service.detail', $service->slug) }}">
                                    {{ $service->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-3">
                                {{ $service->short_description }}
                            </p>
                        </div>

                        <!-- Bullet Feature Checklist -->
                        @if(!empty($service->features))
                            <ul class="space-y-1.5 pt-2 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-300">
                                @foreach(array_slice($service->features, 0, 3) as $feature)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="truncate">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>

                    <!-- Bottom Action Row -->
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <a href="{{ route('service.detail', $service->slug) }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1">
                            <span>Detailed Specification</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <x-whatsapp-cta-button 
                            text="Inquire" 
                            :message="'Hello Apex Team, I would like to inquire about ' . $service->title . '.'"
                            buttonLocation="services_card" 
                            variant="dark" 
                            size="sm" 
                            :icon="false" />
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
