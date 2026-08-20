@props([
    'categories' => collect(),
    'portfolioItems' => collect(),
])

<section id="portfolio" 
         x-data="{ activeCategory: 'all' }" 
         class="py-20 lg:py-32 bg-slate-950 bg-grid-pattern relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-4 mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-950/70 border border-emerald-500/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider">
                Proven Track Record
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Institutional Case Studies & Impact
            </h2>
            <p class="text-base sm:text-lg text-slate-300">
                Measurable outcomes delivered across enterprise infrastructure, compliance audits, and high-frequency automation.
            </p>
        </div>

        <!-- Alpine.js Category Filter Tabs -->
        @if($categories->count() > 0)
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-12">
                <button type="button" 
                        @click="activeCategory = 'all'" 
                        :class="activeCategory === 'all' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 border-blue-500' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white hover:border-slate-700'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border transition duration-150">
                    All Case Studies
                </button>
                @foreach($categories as $category)
                    <button type="button" 
                            @click="activeCategory = '{{ $category->slug }}'" 
                            :class="activeCategory === '{{ $category->slug }}' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 border-blue-500' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white hover:border-slate-700'"
                            class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold border transition duration-150">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        @endif

        <!-- Case Studies Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($portfolioItems as $item)
                @php
                    $catSlug = $item->category?->slug ?? 'general';
                @endphp
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $catSlug }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="group rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-slate-700 p-6 sm:p-7 flex flex-col justify-between transition duration-300 hover:shadow-2xl hover:shadow-slate-950">
                    
                    <div class="space-y-5">
                        <!-- Category & Client Top Line -->
                        <div class="flex items-center justify-between text-xs">
                            <span class="px-2.5 py-1 rounded-lg bg-blue-950 text-blue-400 font-semibold border border-blue-800/50">
                                {{ $item->category?->name ?? 'Enterprise' }}
                            </span>
                            <span class="text-slate-400 font-medium truncate max-w-[150px]">
                                {{ $item->client }}
                            </span>
                        </div>

                        <!-- Case Study Thumbnail / Banner Mockup -->
                        <div class="h-44 w-full rounded-2xl bg-gradient-to-tr from-slate-950 to-slate-800 border border-slate-800 flex items-center justify-center relative overflow-hidden group-hover:border-slate-700 transition">
                            @if($item->image)
                                <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                            @else
                                <div class="text-center p-4">
                                    <div class="text-3xl mb-2">🏢</div>
                                    <p class="text-xs font-semibold text-slate-300">{{ $item->client }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Title & Summary -->
                        <div class="space-y-2">
                            <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition leading-tight">
                                <a href="{{ route('portfolio.detail', $item->slug) }}" class="hover:underline">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-300 line-clamp-3 leading-relaxed">
                                {{ $item->summary }}
                            </p>
                        </div>

                        <!-- Tech Stack Tags -->
                        @if(!empty($item->technologies))
                            <div class="flex flex-wrap gap-1.5 pt-2">
                                @foreach(array_slice($item->technologies, 0, 4) as $tech)
                                    <span class="px-2 py-0.5 rounded-md bg-slate-950 text-slate-400 border border-slate-800 text-[11px] font-mono">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="pt-6 mt-6 border-t border-slate-800/80 flex items-center justify-between">
                        <a href="{{ route('portfolio.detail', $item->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-400 hover:text-blue-300 transition">
                            <span>Read Case Study</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <x-whatsapp-cta-button 
                            text="Discuss Similar" 
                            :message="'Hi, I was reviewing your case study: ' . $item->title . ' and would like to discuss a similar implementation.'"
                            :buttonLocation="'portfolio_card_' . $item->slug" 
                            variant="emerald" 
                            size="sm" />
                    </div>

                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    No case studies published at this time.
                </div>
            @endforelse
        </div>

    </div>
</section>
