@extends('layouts.public')

@section('title', setting('seo_meta_title', setting('site_name', 'Apex Corporate Solutions') . ' | Enterprise Strategic Advisory & Digital Modernization'))
@section('meta_description', setting('seo_meta_description', 'High-impact enterprise digital consulting, high throughput architecture, and corporate acceleration solutions.'))
@section('meta_keywords', setting('seo_meta_keywords', 'consulting, enterprise solutions, digital transformation, crm architecture'))

@section('content')
    <!-- 1. Hero Section -->
    <x-hero-section />

    <!-- 2. Stats Counters Ribbon -->
    <x-stats-section :stats="$stats" />

    <!-- 3. Corporate Services Grid -->
    <x-services-section :services="$services" />

    <!-- 4. Portfolio & Case Studies Showcase (with Alpine category filtering) -->
    <x-portfolio-section :categories="$categories" :portfolios="$portfolioItems" />

    <!-- 5. About & Executive Capabilities Section -->
    <section id="about" class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <div class="lg:col-span-6 space-y-5 sm:space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/70 border border-blue-200 dark:border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider">
                        Institutional Methodology
                    </div>
                    
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                        {{ setting('about_title', 'Decades of Institutional Rigor in Modern Markets') }}
                    </h2>

                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                        {{ setting('about_description', 'Founded by veteran operational architects and compliance directors, Apex bridges the gap between ambitious corporate milestones and bulletproof day-to-day execution.') }}
                    </p>

                    <!-- Bullet Points -->
                    <div class="space-y-3 pt-2">
                        @if(setting('about_bullet_1'))
                            <div class="flex items-start gap-3">
                                <div class="h-5 w-5 rounded-md bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xs font-bold mt-0.5 flex-shrink-0">
                                    ✓
                                </div>
                                <p class="text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200">{{ setting('about_bullet_1') }}</p>
                            </div>
                        @endif

                        @if(setting('about_bullet_2'))
                            <div class="flex items-start gap-3">
                                <div class="h-5 w-5 rounded-md bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xs font-bold mt-0.5 flex-shrink-0">
                                    ✓
                                </div>
                                <p class="text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200">{{ setting('about_bullet_2') }}</p>
                            </div>
                        @endif

                        @if(setting('about_bullet_3'))
                            <div class="flex items-start gap-3">
                                <div class="h-5 w-5 rounded-md bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xs font-bold mt-0.5 flex-shrink-0">
                                    ✓
                                </div>
                                <p class="text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200">{{ setting('about_bullet_3') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4">
                        <x-whatsapp-cta-button 
                            text="Review Architecture with Partners" 
                            message="Hello Apex team, I would like to schedule an architecture review session."
                            buttonLocation="about_section" 
                            variant="emerald" 
                            size="md" />
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 space-y-2 shadow-sm">
                                <div class="text-xl sm:text-2xl">⚡</div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">High-Throughput</h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400">Zero-latency distributed infrastructure for financial workflows.</p>
                            </div>
                            <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 space-y-2 shadow-sm">
                                <div class="text-xl sm:text-2xl">🛡️</div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">Full Governance</h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400">SOC 2 Type II, ISO 27001, and automated audit frameworks.</p>
                            </div>
                        </div>
                        <div class="space-y-4 sm:pt-6">
                            <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 space-y-2 shadow-sm">
                                <div class="text-xl sm:text-2xl">🤝</div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">Direct Partner SLA</h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400">Direct WhatsApp executive access with &lt;15 minute SLA.</p>
                            </div>
                            <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 space-y-2 shadow-sm">
                                <div class="text-xl sm:text-2xl">📈</div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">Verified ROI</h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400">Measurable cost reduction and cycle compression in 90 days.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 6. Pricing Retainers Section -->
    <x-pricing-section :pricingPlans="$pricingPlans" />

    <!-- 7. Executive Testimonials Section -->
    <x-testimonials-section :testimonials="$testimonials" />

    <!-- 8. Operating Partners & Leadership Section -->
    <x-team-section :teamMembers="$teamMembers" />

    <!-- 9. Frequently Asked Questions (with Alpine accordion) -->
    <x-faqs-section :faqs="$faqs" />

    <!-- 10. Call-To-Action Banner -->
    <x-cta-banner 
        title="Ready to Accelerate Your Enterprise Systems?" 
        subtitle="Connect directly with our managing partners on WhatsApp for an executive diagnostic session." 
        ctaText="Schedule Executive WhatsApp Call" 
        buttonLocation="home_cta_banner" />
@endsection
