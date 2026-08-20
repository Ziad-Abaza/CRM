@props([
    'services' => collect(),
])

<section id="services" class="py-20 lg:py-32 bg-slate-950 relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-4 mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-950/70 border border-blue-500/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
                Our Capabilities
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Engineered for High-Stakes Transformation
            </h2>
            <p class="text-base sm:text-lg text-slate-300">
                Institutional-grade technology, workflow engineering, and governance solutions built to accelerate modern enterprises.
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="group rounded-3xl bg-slate-900/80 border border-slate-800 hover:border-blue-500/40 p-8 flex flex-col justify-between transition duration-300 hover:shadow-2xl hover:shadow-blue-950/50 relative overflow-hidden backdrop-blur-sm">
                    
                    <!-- Hover Glow Background Accent -->
                    <div class="absolute -right-20 -top-20 w-40 h-40 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition duration-500 pointer-events-none"></div>

                    <div class="space-y-6 relative z-10">
                        <!-- Icon Pill -->
                        <div class="h-14 w-14 rounded-2xl bg-blue-950/80 border border-blue-500/30 flex items-center justify-center text-blue-400 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-md">
                            @if($service->icon === 'server-stack')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                            @elseif($service->icon === 'chart-bar-square')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            @elseif($service->icon === 'shield-check')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            @elseif($service->icon === 'cpu-chip')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                            @elseif($service->icon === 'user-group')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            @else
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            @endif
                        </div>

                        <!-- Title & Description -->
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-white group-hover:text-blue-400 transition leading-snug">
                                <a href="{{ route('service.detail', $service->slug) }}" class="hover:underline">
                                    {{ $service->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-slate-300 leading-relaxed">
                                {{ $service->short_description }}
                            </p>
                        </div>

                        <!-- Features bullet list -->
                        @if(!empty($service->features))
                            <ul class="space-y-2.5 pt-2 text-xs text-slate-300 border-t border-slate-800">
                                @foreach(array_slice($service->features, 0, 3) as $feature)
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="truncate">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Footer Action Link -->
                    <div class="pt-6 mt-6 border-t border-slate-800 flex items-center justify-between relative z-10">
                        <a href="{{ route('service.detail', $service->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-400 hover:text-blue-300 transition group-hover:translate-x-1 duration-200">
                            <span>View Full Specifications</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <x-whatsapp-cta-button 
                            text="Inquire" 
                            :message="'Hello, I would like to inquire regarding ' . $service->title . '.' "
                            :buttonLocation="'service_card_' . $service->slug" 
                            variant="emerald" 
                            size="sm" />
                    </div>

                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    No active services currently published.
                </div>
            @endforelse
        </div>

    </div>
</section>
