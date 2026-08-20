@extends('layouts.public')

@section('title', $service->title . ' | ' . setting('site_name', 'Apex Corporate Solutions'))
@section('meta_description', $service->short_description)

@section('content')
    <!-- Breadcrumb & Header Hero -->
    <section class="py-16 lg:py-24 bg-slate-950 bg-grid-pattern relative border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl space-y-6">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <span>/</span>
                    <a href="{{ route('home') }}#services" class="hover:text-white transition">Services</a>
                    <span>/</span>
                    <span class="text-blue-400">{{ $service->title }}</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-950/70 border border-blue-500/30 text-blue-300 text-xs font-semibold uppercase tracking-wider">
                    Enterprise Capability Specification
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ $service->title }}
                </h1>

                <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-normal">
                    {{ $service->short_description }}
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <x-whatsapp-cta-button 
                        text="Request Scope & Quotation" 
                        :message="'Hello Apex team, I would like to request a detailed scope and quotation for ' . $service->title . '.'"
                        buttonLocation="service_detail_hero" 
                        variant="emerald" 
                        size="lg" />

                    <a href="{{ route('home') }}#services" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 text-sm font-semibold border border-slate-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>All Capabilities</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Content & Capabilities Blueprint -->
    <section class="py-16 lg:py-24 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">
                
                <!-- Main Description Column -->
                <div class="lg:col-span-8 space-y-10">
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-white tracking-tight">
                            Strategic Overview &amp; Execution Framework
                        </h2>
                        <div class="text-slate-300 leading-relaxed space-y-4 text-base">
                            <p>{{ $service->description }}</p>
                        </div>
                    </div>

                    <!-- Core Deliverables / Features Grid -->
                    @if(!empty($service->features))
                        <div class="space-y-6 pt-6 border-t border-slate-800/80">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                Key Technical &amp; Operational Deliverables
                            </h3>
                            <div class="grid sm:grid-cols-2 gap-4">
                                @foreach($service->features as $feature)
                                    <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800 flex items-start gap-3">
                                        <div class="h-6 w-6 rounded-lg bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-xs font-bold mt-0.5 flex-shrink-0">
                                            ✓
                                        </div>
                                        <p class="text-sm font-medium text-slate-200">{{ $feature }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- SLA & Governance Note -->
                    <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-3">
                        <div class="flex items-center gap-2 text-emerald-400 font-bold text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Institutional Delivery Guarantee</span>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Every engagement is governed by enterprise NDAs, audited milestone sprints, dedicated partner escalations, and strict SOC 2 compliance standards.
                        </p>
                    </div>
                </div>

                <!-- Sidebar Consultation Card -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="rounded-3xl bg-slate-900/90 border border-slate-800 p-6 sm:p-8 space-y-6 sticky top-28 backdrop-blur-xl shadow-xl shadow-slate-950">
                        <div class="space-y-2">
                            <span class="px-2.5 py-1 rounded-md bg-emerald-950 text-emerald-400 font-bold text-xs border border-emerald-800">Direct Hotline</span>
                            <h3 class="text-xl font-bold text-white">Consult Managing Partner</h3>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                Get direct insight into architecture roadmaps and commercial feasibility via our WhatsApp executive line.
                            </p>
                        </div>

                        <div class="space-y-3 pt-2">
                            <x-whatsapp-cta-button 
                                text="Chat on WhatsApp" 
                                :message="'Hi Apex team, I am reviewing ' . $service->title . ' and want to schedule a brief consultation.'"
                                buttonLocation="service_detail_sidebar" 
                                variant="emerald" 
                                size="md" 
                                class="w-full justify-center" />
                        </div>

                        <div class="pt-4 border-t border-slate-800 text-[11px] text-slate-400 space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Typical partner response: &lt; 15 mins</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                <span>Direct NDA upon initiation</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Services Carousel/Grid -->
    @if($relatedServices->count() > 0)
        <section class="py-16 bg-slate-950 bg-grid-pattern border-t border-slate-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-white">Other Enterprise Capabilities</h3>
                    <a href="{{ route('home') }}#services" class="text-xs font-bold text-blue-400 hover:text-blue-300">View All</a>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($relatedServices as $rel)
                        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 hover:border-blue-500/40 transition duration-200 flex flex-col justify-between">
                            <div class="space-y-3">
                                <h4 class="font-bold text-white text-base">
                                    <a href="{{ route('service.detail', $rel->slug) }}" class="hover:text-blue-400 transition">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-400 line-clamp-2">
                                    {{ $rel->short_description }}
                                </p>
                            </div>
                            <div class="pt-4 mt-4 border-t border-slate-800 flex items-center justify-between">
                                <a href="{{ route('service.detail', $rel->slug) }}" class="text-xs font-bold text-blue-400 hover:underline">
                                    Details &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
