@props([
    'stats' => collect(),
])

<section class="py-10 sm:py-12 bg-slate-900/50 border-y border-slate-800/80 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 divide-y sm:divide-y-0 sm:divide-x divide-slate-800">
            @forelse($stats as $stat)
                <div class="text-center px-3 sm:px-4 py-3 sm:py-0 first:pt-0">
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
                        {{ $stat->value }}{{ $stat->suffix }}
                    </div>
                    <p class="text-[11px] sm:text-xs font-semibold text-slate-300 uppercase tracking-wider mt-1.5">
                        {{ $stat->label }}
                    </p>
                </div>
            @empty
                <div class="col-span-2 lg:col-span-4 text-center text-slate-400 text-sm">
                    Enterprise metrics loaded.
                </div>
            @endforelse
        </div>
    </div>
</section>
