@props(['portfolios' => null, 'portfolioItems' => null, 'categories' => []])

@php
    $portfolios = $portfolios ?? $portfolioItems ?? collect();
    $categories = $categories ?? collect();
@endphp

<section id="portfolio" 
         x-data="{ 
            selectedCategory: 'all',
            filterPortfolios(categoryId) {
                this.selectedCategory = categoryId;
            }
         }" 
         class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-3 sm:space-y-4 mb-8 sm:mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider">
                Proven Track Record
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                Case Studies &amp; Architectural Engagements
            </h2>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                Real-world institutional deployments, mission-critical migrations, and measurable enterprise value creation.
            </p>

            <!-- Dynamic Category Filter Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-2 pt-2">
                <button type="button" 
                        @click="filterPortfolios('all')"
                        :class="selectedCategory === 'all' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-800'"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition">
                    All Engagements
                </button>
                @foreach($categories as $category)
                    <button type="button" 
                            @click="filterPortfolios({{ $category->id }})"
                            :class="selectedCategory === {{ $category->id }} ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-800'"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold transition">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Portfolio Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($portfolios as $portfolio)
                <div x-show="selectedCategory === 'all' || selectedCategory === {{ $portfolio->category_id ?? 0 }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="rounded-2xl border border-slate-200 dark:border-slate-800/90 bg-white dark:bg-slate-900/90 shadow-sm hover:shadow-xl hover:border-emerald-500/40 transition duration-300 flex flex-col justify-between overflow-hidden group">
                    
                    <!-- Cover Visual Frame -->
                    <div class="relative h-36 sm:h-40 overflow-hidden bg-slate-100 dark:bg-slate-950">
                        @if($portfolio->image)
                            <img src="{{ $portfolio->image }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-slate-200 via-slate-100 to-slate-200 dark:from-slate-900 dark:via-slate-950 dark:to-slate-900 text-slate-400 dark:text-slate-600">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        @endif

                        <!-- Category Pill -->
                        <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-white/90 dark:bg-slate-950/80 backdrop-blur-md border border-slate-200 dark:border-slate-800 text-[10px] font-bold text-emerald-700 dark:text-emerald-300 uppercase tracking-wider">
                            {{ $portfolio->category?->name ?? 'Case Study' }}
                        </span>
                    </div>

                    <!-- Body Content -->
                    <div class="p-5 sm:p-6 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Client: {{ $portfolio->client }}</span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white leading-snug group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">
                                <a href="{{ route('portfolio.detail', $portfolio->slug) }}">
                                    {{ $portfolio->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed">
                                {{ $portfolio->summary }}
                            </p>
                        </div>

                        <!-- Technology Stack Badges -->
                        @if(!empty($portfolio->technologies))
                            <div class="flex flex-wrap gap-1.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                                @foreach(array_slice($portfolio->technologies, 0, 4) as $tech)
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-[10px] font-mono text-slate-700 dark:text-slate-300">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Bottom Action Link -->
                    <div class="px-5 sm:px-6 py-3.5 bg-slate-50 dark:bg-slate-950/60 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <a href="{{ route('portfolio.detail', $portfolio->slug) }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 flex items-center gap-1">
                            <span>Read Full Case Study</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <x-whatsapp-cta-button 
                            text="Inquire" 
                            :message="'Hello Apex Team, I am inquiring about your case study: ' . $portfolio->title . '.'"
                            buttonLocation="portfolio_card" 
                            variant="dark" 
                            size="sm" 
                            :icon="false" />
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
