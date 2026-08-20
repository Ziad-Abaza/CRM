@props([
    'testimonials' => collect(),
])

<section class="py-20 lg:py-32 bg-slate-950 bg-grid-pattern relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-4 mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-950/70 border border-amber-500/30 text-amber-300 text-xs font-semibold uppercase tracking-wider">
                Executive Testimonials
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Trusted by Enterprise Leaders
            </h2>
            <p class="text-base sm:text-lg text-slate-300">
                Direct feedback from founders, CTOs, and compliance executives who partnered with Apex.
            </p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($testimonials as $testimonial)
                <div class="rounded-3xl bg-slate-900/80 border border-slate-800 p-8 flex flex-col justify-between hover:border-slate-700 transition duration-300 backdrop-blur-sm">
                    <div class="space-y-6">
                        <!-- Rating Stars -->
                        <div class="flex text-amber-400">
                            @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <!-- Quote Text -->
                        <blockquote class="text-sm sm:text-base text-slate-300 leading-relaxed italic">
                            &ldquo;{{ $testimonial->content }}&rdquo;
                        </blockquote>
                    </div>

                    <!-- Client Bio Header -->
                    <div class="pt-6 mt-6 border-t border-slate-800 flex items-center gap-4">
                        @if($testimonial->avatar)
                            <img src="{{ $testimonial->avatar }}" alt="{{ $testimonial->client_name }}" class="h-12 w-12 rounded-full object-cover border border-slate-700 bg-slate-950">
                        @else
                            <div class="h-12 w-12 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center font-bold text-white text-sm">
                                {{ substr($testimonial->client_name, 0, 2) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="font-bold text-sm text-white truncate">{{ $testimonial->client_name }}</h4>
                            <p class="text-xs text-slate-400 truncate">{{ $testimonial->client_role }}</p>
                            <p class="text-xs font-semibold text-blue-400 truncate">{{ $testimonial->company }}</p>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400">
                    No testimonials published at this time.
                </div>
            @endforelse
        </div>

    </div>
</section>
