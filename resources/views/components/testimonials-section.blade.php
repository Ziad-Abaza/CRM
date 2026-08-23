@props(['testimonials'])

<section class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-3 sm:space-y-4 mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-950/80 border border-amber-200 dark:border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-semibold uppercase tracking-wider">
                {{ __('frontend.testimonials.section_badge') }}
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                {{ setting('testimonials_section_title', __('frontend.testimonials.section_title')) }}
            </h2>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                {{ setting('testimonials_section_subtitle', __('frontend.testimonials.section_subtitle')) }}
            </p>
        </div>

        <!-- Testimonial Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @foreach($testimonials as $testimonial)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800/90 bg-slate-50/60 dark:bg-slate-900/80 p-5 sm:p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between space-y-4 text-start">
                    <div class="space-y-3">
                        <!-- Rating Stars -->
                        <div class="flex items-center gap-1 text-amber-500 text-xs font-bold" dir="ltr">
                            @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                                <span>★</span>
                            @endfor
                        </div>

                        <!-- Quote Content -->
                        <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed italic">
                            "{{ $testimonial->content }}"
                        </p>
                    </div>

                    <!-- Client Profile -->
                    <div class="pt-3 border-t border-slate-200 dark:border-slate-800/80 flex items-center gap-3">
                        @if(!empty($testimonial->avatar))
                            <img src="{{ $testimonial->avatar }}" 
                                 alt="{{ $testimonial->client_name }}" 
                                 loading="lazy" 
                                 decoding="async" 
                                 width="40" 
                                 height="40" 
                                 class="h-10 w-10 rounded-full object-cover border border-slate-200 dark:border-slate-700 flex-shrink-0 shadow-sm">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-700 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                                {{ substr($testimonial->client_name, 0, 2) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate">{{ $testimonial->client_name }}</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $testimonial->client_role }}</p>
                            <p class="text-[10px] text-blue-600 dark:text-blue-400 font-semibold truncate">{{ $testimonial->company }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
