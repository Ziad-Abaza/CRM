@props(['stats'])

<section class="py-10 sm:py-12 bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($stats as $stat)
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50/70 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800/80 text-center space-y-1 group hover:border-blue-500/40 transition">
                    <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                        {{ $stat->value }}{{ $stat->suffix }}
                    </p>
                    <p class="text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                        {{ $stat->label }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
