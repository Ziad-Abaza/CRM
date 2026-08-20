@props([
    'categories' => collect(),
    'portfolioItems' => collect(),
])

<section id="portfolio" 
         x-data="{ activeCategory: 'all' }" 
         class="py-12 sm:py-16 lg:py-20 bg-slate-950 bg-grid-pattern relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-2xl mx-auto text-center space-y-3 mb-8 sm:mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/70 border border-emerald-500/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider">
                Proven Track Record
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Institutional Case Studies &amp; Impact
            </h2>
            <p class="text-sm sm:text-base text-slate-300">
                Measurable outcomes delivered across enterprise infrastructure, compliance audits, and high-frequency automation.
            </p>
        </div>

        <!-- Alpine.js Category Filter Tabs -->
        @if($categories->count() > 0)
            <div class="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 mb-8 sm:mb-10">
                <button type="button" 
                        @click="activeCategory = 'all'" 
                        :class="activeCategory === 'all' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30 border-blue-500' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white hover:border-slate-700'"
                        class="px-3 sm:px-3.5 py-1.5 rounded-lg sm:rounded-xl text-xs font-semibold border transition duration-150">
                    All Case Studies
                </button>
                @foreach($categories as $category)
                    <button type="button" 
                            @click="activeCategory = '{{ $category->slug }}'" 
                            :class="activeCategory === '{{ $category->slug }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30 border-blue-500' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white hover:border-slate-700'"
                            class="px-3 sm:px-3.5 py-1.5 rounded-lg sm:rounded-xl text-xs font-semibold border transition duration-150">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        @endif

        <!-- Case Studies Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @forelse($portfolioItems as $item)
                @php
                    $catSlug = $item->category?->slug ?? 'general';
                @endphp
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $catSlug }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="group rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-slate-700 p-5 sm:p-6 flex flex-col justify-between transition duration-300 hover:shadow-xl hover:shadow-slate-950">
                    
                    <div class="space-y-4">
                        <!-- Category & Client Top Line -->
                        <div class="flex items-center justify-between text-xs gap-2">
                            <span class="px-2 py-0.5 rounded-md bg-blue-950 text-blue-400 font-semibold border border-blue-800/50 text-[11px]">
                                {{ $item->category?->name ?? 'Enterprise' }}
                            </span>
                            <span class="text-slate-400 font-medium truncate max-w-[140px]">
                                {{ $item->client }}
                            </span>
                        </div>

                        <!-- Case Study Thumbnail / Banner Mockup -->
                        <div class="h-36 sm:h-40 w-full rounded-xl bg-gradient-to-tr from-slate-950 to-slate-800 border border-slate-800 flex items-center justify-center relative overflow-hidden group-hover:border-slate-700 transition">
                            @if($item->image)
                                <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                            @else
                                <div class="text-center p-3">
                                    <div class="text-2xl mb-1">🏢</div>
                                    <p class="text-xs font-semibold text-slate-300">{{ $item->client }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Title & Summary -->
                        <div class="space-y-1.5">
                            <h3 class="text-base font-bold text-white group-hover:text-blue-400 transition leading-snug">
                                <a href="{{ route('portfolio.detail', $item->slug) }}" class="hover:underline">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-300 line-clamp-2 leading-relaxed">
                                {{ $item->summary }}
                            </p>
                        </div>

                        <!-- Tech Stack Tags -->
                        @if(!empty($item->technologies))
                            <div class="flex flex-wrap gap-1 pt-1">
                                @foreach(array_slice($item->technologies, 0, 3) as $tech)
                                    <span class="px-1.5 py-0.5 rounded bg-slate-950 text-slate-400 border border-slate-800 text-[10px] font-mono">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="pt-4 mt-4 border-t border-slate-800/80 flex items-center justify-between gap-2">
                        <a href="{{ route('portfolio.detail', $item->slug) }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-400 hover:text-blue-300 transition truncate">
                            <span>Case Study</span>
                            <svg class="w-3 h-3 group-hover:translate-x-0.5 transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 text-slate-400 text-sm">
                    No case studies published at this time.
                </div>
            @endforelse
        </div>

    </div>
</section>
