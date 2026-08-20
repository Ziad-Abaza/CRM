@props(['teamMembers'])

<section id="team" class="py-12 sm:py-16 lg:py-20 bg-slate-50/60 dark:bg-slate-950 relative border-b border-slate-200 dark:border-slate-800/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-3 sm:space-y-4 mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/80 border border-blue-200 dark:border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider">
                {{ __('frontend.team.section_badge') }}
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                {{ setting('team_section_title', __('frontend.team.section_title')) }}
            </h2>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                {{ setting('team_section_subtitle', __('frontend.team.section_subtitle')) }}
            </p>
        </div>

        <!-- Team Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @foreach($teamMembers as $member)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800/90 bg-white dark:bg-slate-900/90 overflow-hidden shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group text-start">
                    
                    <!-- Portrait Frame -->
                    <div class="h-44 sm:h-48 bg-slate-100 dark:bg-slate-950 relative overflow-hidden flex items-center justify-center">
                        @if($member->photo)
                            <img src="{{ $member->photo }}" 
                                 alt="{{ $member->name }}" 
                                 loading="lazy" 
                                 decoding="async" 
                                 width="300" 
                                 height="192"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-slate-200 to-slate-300 dark:from-slate-900 dark:to-slate-800 text-slate-500 dark:text-slate-400 font-bold text-2xl">
                                {{ substr($member->name, 0, 2) }}
                            </div>
                        @endif
                        <span class="absolute bottom-2 start-2 px-2 py-0.5 rounded bg-white/90 dark:bg-slate-950/80 backdrop-blur-md text-[10px] font-bold text-blue-700 dark:text-blue-300 border border-slate-200 dark:border-slate-800">
                            {{ __('frontend.team.leadership_team') }}
                        </span>
                    </div>

                    <!-- Information Body -->
                    <div class="p-4 sm:p-5 space-y-2 flex-1 flex flex-col justify-between">
                        <div class="space-y-1">
                            <h3 class="font-bold text-sm sm:text-base text-slate-900 dark:text-white leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $member->name }}</h3>
                            <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold">{{ $member->role }}</p>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-3 pt-1">
                                {{ $member->bio }}
                            </p>
                        </div>

                        <!-- Direct WhatsApp Consult CTA -->
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <x-whatsapp-cta-button 
                                :text="__('frontend.team.schedule_session')" 
                                :message="'Hello, I would like to schedule a strategy discussion with ' . $member->name . ' (' . $member->role . ').'"
                                buttonLocation="team_member_card" 
                                variant="dark" 
                                size="sm" 
                                class="w-full justify-center" />
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
