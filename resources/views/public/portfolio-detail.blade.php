@extends('layouts.public')

@section('title', $portfolio->title . ' | Case Study | ' . setting('site_name', 'Apex Corporate Solutions'))
@section('meta_description', $portfolio->summary)

@section('content')
    <!-- Breadcrumb & Header Hero -->
    <section class="py-10 sm:py-14 lg:py-16 bg-white dark:bg-slate-950 bg-grid-pattern relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl space-y-4 sm:space-y-5">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-1.5 sm:gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                    <a href="{{ route('home') }}" class="hover:text-slate-900 dark:hover:text-white transition">Home</a>
                    <span>/</span>
                    <a href="{{ route('home') }}#portfolio" class="hover:text-slate-900 dark:hover:text-white transition">Case Studies</a>
                    <span>/</span>
                    <span class="text-blue-600 dark:text-blue-400 truncate">{{ $portfolio->client }}</span>
                </nav>

                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider">
                        {{ $portfolio->category?->name ?? 'Enterprise Transformation' }}
                    </span>
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Client: {{ $portfolio->client }}</span>
                </div>

                <h1 class="text-2.5xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                    {{ $portfolio->title }}
                </h1>

                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                    {{ $portfolio->summary }}
                </p>

                <div class="pt-1 flex flex-wrap items-center gap-3 sm:gap-4">
                    <x-whatsapp-cta-button 
                        text="Inquire About Similar Architecture" 
                        :message="'Hi Apex team, I am interested in building a solution similar to your case study with ' . $portfolio->client . '.'"
                        buttonLocation="portfolio_detail_hero" 
                        variant="emerald" 
                        size="md" />

                    @if($portfolio->website_url)
                        <a href="{{ $portfolio->website_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-2 sm:py-2.5 rounded-xl bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-semibold border border-slate-200 dark:border-slate-800 transition">
                            <span>Live Reference</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Case Study Body & Architecture Details -->
    <section class="py-10 sm:py-14 lg:py-16 bg-slate-50/60 dark:bg-slate-950 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">
                
                <!-- Main Case Study Content -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Main Cover Visual / Showcase -->
                    @if($portfolio->image)
                        <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-lg bg-slate-100 dark:bg-slate-900">
                            <img src="{{ $portfolio->image }}" alt="{{ $portfolio->title }}" class="w-full h-auto max-h-[360px] object-cover">
                        </div>
                    @endif

                    <!-- Executive Briefing -->
                    <div class="space-y-3">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                            The Challenge &amp; Strategic Solution
                        </h2>
                        <div class="text-slate-700 dark:text-slate-300 leading-relaxed text-sm sm:text-base space-y-3 whitespace-pre-line">
                            {{ $portfolio->content }}
                        </div>
                    </div>

                    <!-- Tech Stack & Infrastructure Modules -->
                    @if(!empty($portfolio->technologies))
                        <div class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800/80">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white tracking-tight">
                                Technologies &amp; Architecture Components
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($portfolio->technologies as $tech)
                                    <span class="px-2.5 py-1 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-mono text-blue-700 dark:text-blue-300">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Conversion Box -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="text-base font-bold text-slate-900 dark:text-white">Require similar institutional velocity?</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">Our engineering team can evaluate your specifications directly on WhatsApp.</p>
                        </div>
                        <x-whatsapp-cta-button 
                            text="Connect with Lead" 
                            :message="'Hello, I want to discuss a similar architecture to the ' . $portfolio->client . ' engagement.'"
                            buttonLocation="portfolio_detail_bottom" 
                            variant="emerald" 
                            size="sm" />
                    </div>

                </div>

                <!-- Case Study Metadata Sidebar -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 p-5 sm:p-6 space-y-4 sticky top-24 backdrop-blur-xl shadow-lg shadow-slate-200/50 dark:shadow-slate-950">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3">Project Parameters</h3>
                        
                        <div class="space-y-3 text-xs">
                            <div>
                                <span class="text-slate-500 dark:text-slate-400 block font-medium mb-0.5">Enterprise Client</span>
                                <span class="text-slate-900 dark:text-white font-bold text-sm">{{ $portfolio->client }}</span>
                            </div>

                            <div>
                                <span class="text-slate-500 dark:text-slate-400 block font-medium mb-0.5">Focus Sector</span>
                                <span class="text-slate-900 dark:text-white font-semibold">{{ $portfolio->category?->name ?? 'Strategic Technology' }}</span>
                            </div>

                            @if($portfolio->completion_date)
                                <div>
                                    <span class="text-slate-500 dark:text-slate-400 block font-medium mb-0.5">Completion Milestone</span>
                                    <span class="text-slate-900 dark:text-white font-semibold">{{ $portfolio->completion_date->format('F Y') }}</span>
                                </div>
                            @endif

                            <div>
                                <span class="text-slate-500 dark:text-slate-400 block font-medium mb-0.5">Audit &amp; Governance</span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Production Verified
                                </span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                            <x-whatsapp-cta-button 
                                text="Discuss with Architect" 
                                :message="'Hello, I would like to speak with the architect behind the ' . $portfolio->title . ' case study.'"
                                buttonLocation="portfolio_sidebar" 
                                variant="emerald" 
                                size="md" 
                                class="w-full justify-center" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Case Studies -->
    @if($relatedCaseStudies->count() > 0)
        <section class="py-10 sm:py-14 bg-white dark:bg-slate-950 bg-grid-pattern border-t border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">More Enterprise Case Studies</h3>
                    <a href="{{ route('home') }}#portfolio" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach($relatedCaseStudies as $rel)
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-blue-500/40 transition duration-200 flex flex-col justify-between">
                            <div class="space-y-2">
                                <span class="text-[10px] font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">{{ $rel->category?->name ?? 'Case Study' }}</span>
                                <h4 class="font-bold text-slate-900 dark:text-white text-sm sm:text-base">
                                    <a href="{{ route('portfolio.detail', $rel->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2">
                                    {{ $rel->summary }}
                                </p>
                            </div>
                            <div class="pt-3 mt-3 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                                <a href="{{ route('portfolio.detail', $rel->slug) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                    Read Study &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
