@props([
    'testimonials' => collect(),
])

<section class="py-12 sm:py-16 lg:py-20 bg-slate-950 bg-grid-pattern relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-2xl mx-auto text-center space-y-3 mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-950/70 border border-amber-500/30 text-amber-300 text-xs font-semibold uppercase tracking-wider">
                Executive Testimonials
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Trusted by Enterprise Leaders
            </h2>
            <p class="text-sm sm:text-base text-slate-300">
                Direct feedback from founders, CTOs, and compliance executives who partnered with Apex.
            </p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @forelse($testimonials as $testimonial)
                <div class="rounded-2xl bg-slate-900/80 border border-slate-800 p-5 sm:p-6 flex flex-col justify-between hover:border-slate-700 transition duration-300 backdrop-blur-sm">
                    <div class="space-y-4">
                        <!-- Rating Stars -->
                        <div class="flex text-amber-400">
                            @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <!-- Quote Text -->
                        <blockquote class="text-xs sm:text-sm text-slate-300 leading-relaxed italic line-clamp-4">
                            &ldquo;{{ $testimonial->content }}&rdquo;
                        </blockquote>
                    </div>

                    <!-- Client Bio Header -->
                    <div class="pt-4 mt-4 border-t border-slate-800 flex items-center gap-3">
                        @if($testimonial->avatar)
                            <img src="{{ $testimonial->avatar }}" alt="{{ $testimonial->client_name }}" class="h-10 w-10 rounded-full object-cover border border-slate-700 bg-slate-950 flex-shrink-0">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center font-bold text-white text-xs flex-shrink-0">
                                {{ substr($testimonial->client_name, 0, 2) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="font-bold text-xs sm:text-sm text-white truncate">{{ $testimonial->client_name }}</h4>
                            <p class="text-[11px] text-slate-400 truncate">{{ $testimonial->client_role }}</p>
                            <p class="text-[11px] font-semibold text-blue-400 truncate">{{ $testimonial->company }}</p>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 text-slate-400 text-sm">
                    No testimonials published at this time.
                </div>
            @endforelse
        </div>

    </div>
</section>
