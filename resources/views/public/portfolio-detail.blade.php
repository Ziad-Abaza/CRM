@extends('layouts.public')

@section('title', $portfolio->title . ' | Case Study | ' . setting('site_name', 'Apex Corporate Solutions'))
@section('meta_description', $portfolio->summary)

@section('content')
    <!-- Breadcrumb & Header Hero -->
    <section class="py-16 lg:py-24 bg-slate-950 bg-grid-pattern relative border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl space-y-6">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <span>/</span>
                    <a href="{{ route('home') }}#portfolio" class="hover:text-white transition">Case Studies</a>
                    <span>/</span>
                    <span class="text-blue-400">{{ $portfolio->client }}</span>
                </nav>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-500/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider">
                        {{ $portfolio->category?->name ?? 'Enterprise Transformation' }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400">Client: {{ $portfolio->client }}</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ $portfolio->title }}
                </h1>

                <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-normal">
                    {{ $portfolio->summary }}
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <x-whatsapp-cta-button 
                        text="Inquire About Similar Architecture" 
                        :message="'Hi Apex team, I am interested in building a solution similar to your case study with ' . $portfolio->client . '.'"
                        buttonLocation="portfolio_detail_hero" 
                        variant="emerald" 
                        size="lg" />

                    @if($portfolio->website_url)
                        <a href="{{ $portfolio->website_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 text-sm font-semibold border border-slate-800 transition">
                            <span>Live Reference</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Case Study Body & Architecture Details -->
    <section class="py-16 lg:py-24 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
                
                <!-- Main Case Study Content -->
                <div class="lg:col-span-8 space-y-12">
                    
                    <!-- Main Cover Visual / Showcase -->
                    @if($portfolio->image)
                        <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-2xl bg-slate-900">
                            <img src="{{ $portfolio->image }}" alt="{{ $portfolio->title }}" class="w-full h-auto max-h-[450px] object-cover">
                        </div>
                    @endif

                    <!-- Executive Briefing -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-white tracking-tight">
                            The Challenge &amp; Strategic Solution
                        </h2>
                        <div class="text-slate-300 leading-relaxed text-base space-y-4 whitespace-pre-line">
                            {{ $portfolio->content }}
                        </div>
                    </div>

                    <!-- Tech Stack & Infrastructure Modules -->
                    @if(!empty($portfolio->technologies))
                        <div class="space-y-6 pt-6 border-t border-slate-800/80">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                Technologies &amp; Architecture Components
                            </h3>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach($portfolio->technologies as $tech)
                                    <span class="px-3.5 py-1.5 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono text-blue-300">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Conversion Box -->
                    <div class="p-8 rounded-3xl bg-gradient-to-r from-slate-900 to-slate-950 border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div>
                            <h4 class="text-lg font-bold text-white">Require similar institutional velocity?</h4>
                            <p class="text-xs text-slate-300 mt-1">Our engineering team can evaluate your specifications directly on WhatsApp.</p>
                        </div>
                        <x-whatsapp-cta-button 
                            text="Connect with Solution Lead" 
                            :message="'Hello, I want to discuss a similar architecture to the ' . $portfolio->client . ' engagement.'"
                            buttonLocation="portfolio_detail_bottom" 
                            variant="emerald" 
                            size="md" />
                    </div>

                </div>

                <!-- Case Study Metadata Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="rounded-3xl bg-slate-900/90 border border-slate-800 p-6 sm:p-8 space-y-6 sticky top-28 backdrop-blur-xl shadow-xl">
                        <h3 class="text-lg font-bold text-white border-b border-slate-800 pb-4">Project Parameters</h3>
                        
                        <div class="space-y-4 text-xs">
                            <div>
                                <span class="text-slate-400 block font-medium mb-0.5">Enterprise Client</span>
                                <span class="text-white font-bold text-sm">{{ $portfolio->client }}</span>
                            </div>

                            <div>
                                <span class="text-slate-400 block font-medium mb-0.5">Focus Sector</span>
                                <span class="text-white font-semibold">{{ $portfolio->category?->name ?? 'Strategic Technology' }}</span>
                            </div>

                            @if($portfolio->completion_date)
                                <div>
                                    <span class="text-slate-400 block font-medium mb-0.5">Completion Milestone</span>
                                    <span class="text-white font-semibold">{{ $portfolio->completion_date->format('F Y') }}</span>
                                </div>
                            @endif

                            <div>
                                <span class="text-slate-400 block font-medium mb-0.5">Audit & Governance</span>
                                <span class="text-emerald-400 font-semibold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                    Production Verified
                                </span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-800">
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
        <section class="py-16 bg-slate-950 bg-grid-pattern border-t border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-white">More Enterprise Case Studies</h3>
                    <a href="{{ route('home') }}#portfolio" class="text-xs font-bold text-blue-400 hover:text-blue-300">View All</a>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($relatedCaseStudies as $rel)
                        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 hover:border-blue-500/40 transition duration-200 flex flex-col justify-between">
                            <div class="space-y-3">
                                <span class="text-[11px] font-semibold text-blue-400 uppercase tracking-wider">{{ $rel->category?->name ?? 'Case Study' }}</span>
                                <h4 class="font-bold text-white text-base">
                                    <a href="{{ route('portfolio.detail', $rel->slug) }}" class="hover:text-blue-400 transition">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-400 line-clamp-2">
                                    {{ $rel->summary }}
                                </p>
                            </div>
                            <div class="pt-4 mt-4 border-t border-slate-800 flex items-center justify-between">
                                <a href="{{ route('portfolio.detail', $rel->slug) }}" class="text-xs font-bold text-blue-400 hover:underline">
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
