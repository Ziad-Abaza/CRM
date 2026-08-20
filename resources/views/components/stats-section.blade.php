@props([
    'stats' => collect(),
])

<section class="py-16 bg-slate-900/50 border-y border-slate-800/80 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 divide-y sm:divide-y-0 sm:divide-x divide-slate-800">
            @forelse($stats as $stat)
                <div class="text-center px-4 py-4 sm:py-0 first:pt-0">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                        {{ $stat->value }}{{ $stat->suffix }}
                    </div>
                    <p class="text-xs sm:text-sm font-semibold text-slate-300 uppercase tracking-wider mt-2">
                        {{ $stat->label }}
                    </p>
                </div>
            @empty
                <div class="col-span-4 text-center text-slate-400">
                    Enterprise metrics loaded.
                </div>
            @endforelse
        </div>
    </div>
</section>
