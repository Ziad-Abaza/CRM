@extends('layouts.public')

@section('title', $service->title . ' | ' . app_name())
@section('meta_description', $service->short_description)

@section('content')
    <!-- Breadcrumb & Header Hero -->
    <section class="py-10 sm:py-14 lg:py-16 bg-white dark:bg-slate-950 bg-grid-pattern relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl space-y-4 sm:space-y-5 text-start">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-1.5 sm:gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                    <a href="{{ localized_route('home') }}" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.home') }}</a>
                    <span>/</span>
                    <a href="{{ localized_route('home') }}#services" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.services') }}</a>
                    <span>/</span>
                    <span class="text-blue-600 dark:text-blue-400 truncate">{{ $service->title }}</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/70 border border-blue-200 dark:border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider">
                    {{ __('frontend.services.section_badge') }}
                </div>

                <h1 class="text-2.5xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                    {{ $service->title }}
                </h1>

                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                    {{ $service->short_description }}
                </p>

                <div class="pt-1 flex flex-wrap items-center gap-3 sm:gap-4">
                    <x-whatsapp-cta-button 
                        :text="__('frontend.services.request_quote')" 
                        :message="'Hello ' . app_name() . ' team, I would like to request a detailed scope and quotation for ' . $service->title . '.'"
                        buttonLocation="service_detail_hero" 
                        variant="emerald" 
                        size="md" />

                    <a href="{{ localized_route('home') }}#services" class="inline-flex items-center gap-1.5 px-4 py-2 sm:py-2.5 rounded-xl bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-semibold border border-slate-200 dark:border-slate-800 transition">
                        <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>{{ __('frontend.services.back_to_services') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Content & Capabilities Blueprint -->
    <section class="py-10 sm:py-14 lg:py-16 bg-slate-50/60 dark:bg-slate-950 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 text-start">
                
                <!-- Main Description Column -->
                <div class="lg:col-span-8 space-y-8">
                    <div class="space-y-3">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                            {{ __('frontend.services.methodology') }}
                        </h2>
                        <div class="text-slate-700 dark:text-slate-300 leading-relaxed space-y-3 text-sm sm:text-base">
                            <p>{{ $service->description }}</p>
                        </div>
                    </div>

                    <!-- Core Deliverables / Features Grid -->
                    @if(!empty($service->features))
                        <div class="space-y-4 pt-4 border-t border-slate-200 dark:border-slate-800/80">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">
                                {{ __('frontend.services.key_deliverables') }}
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                @foreach($service->features as $feature)
                                    <div class="p-3.5 rounded-xl bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 shadow-sm flex items-start gap-2.5">
                                        <div class="h-5 w-5 rounded-md bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xs font-bold mt-0.5 flex-shrink-0">
                                            ✓
                                        </div>
                                        <p class="text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200">{{ $feature }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- SLA & Governance Note -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-2">
                        <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-bold text-xs sm:text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('frontend.trust.enterprise_grade') }}</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ current_locale() === 'ar' ? 'تخضع جميع التعاملات لاتفاقيات عدم إفشاء رسمية، ومراحل تدقيق معتمدة، وتوافق تام مع معايير SOC 2 وISO 27001.' : 'Every engagement is governed by enterprise NDAs, audited milestone sprints, dedicated partner escalations, and strict SOC 2 compliance standards.' }}
                        </p>
                    </div>
                </div>

                <!-- Sidebar Consultation Card -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="rounded-2xl bg-white dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 p-5 sm:p-6 space-y-4 sticky top-24 backdrop-blur-xl shadow-lg shadow-slate-200/50 dark:shadow-slate-950">
                        <div class="space-y-1.5">
                            <span class="px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 font-bold text-[10px] border border-emerald-200 dark:border-emerald-800 uppercase tracking-wider">{{ __('frontend.whatsapp.direct_channel') }}</span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white">{{ __('frontend.services.consult_managing_partner') }}</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                                {{ current_locale() === 'ar' ? 'احصل على رؤى معمارية مباشرة ودراسة جدوى تقنية عبر خط واتساب التنفيذي.' : 'Get direct insight into architecture roadmaps and commercial feasibility via our WhatsApp executive line.' }}
                            </p>
                        </div>

                        <div class="pt-1">
                            <x-whatsapp-cta-button 
                                :text="__('frontend.hero.consult_cta')" 
                                :message="'Hi ' . app_name() . ' team, I am reviewing ' . $service->title . ' and want to schedule a brief consultation.'"
                                buttonLocation="service_detail_sidebar" 
                                variant="emerald" 
                                size="md" 
                                class="w-full justify-center" />
                        </div>

                        <div class="pt-3 border-t border-slate-200 dark:border-slate-800 text-[10px] sm:text-[11px] text-slate-500 dark:text-slate-400 space-y-1.5">
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                                <span>{{ __('frontend.whatsapp.reply_time') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-shrink-0"></span>
                                <span>{{ current_locale() === 'ar' ? 'اتفاقية سرية معلومات فورية عند البدء' : 'Direct NDA upon initiation' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Services Carousel/Grid -->
    @if($relatedServices->count() > 0)
        <section class="py-10 sm:py-14 bg-white dark:bg-slate-950 bg-grid-pattern border-t border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-start">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">{{ __('frontend.services.related_services') }}</h3>
                    <a href="{{ localized_route('home') }}#services" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">{{ __('ui.buttons.view_all') }}</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach($relatedServices as $rel)
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-blue-500/40 transition duration-200 flex flex-col justify-between">
                            <div class="space-y-2">
                                <h4 class="font-bold text-slate-900 dark:text-white text-sm sm:text-base">
                                    <a href="{{ localized_route('service.detail', $rel->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2">
                                    {{ $rel->short_description }}
                                </p>
                            </div>
                            <div class="pt-3 mt-3 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                                <a href="{{ localized_route('service.detail', $rel->slug) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                    <span>{{ __('frontend.services.learn_more') }}</span>
                                    <svg class="w-3.5 h-3.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
