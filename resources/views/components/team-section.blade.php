@props([
    'teamMembers' => collect(),
])

<section id="team" class="py-20 lg:py-32 bg-slate-950 relative border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center space-y-4 mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-purple-950/70 border border-purple-500/30 text-purple-300 text-xs font-semibold uppercase tracking-wider">
                Leadership
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Operating Partners & Systems Architects
            </h2>
            <p class="text-base sm:text-lg text-slate-300">
                Seasoned corporate strategists and engineering directors embedded directly in your most critical initiatives.
            </p>
        </div>

        <!-- Team Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($teamMembers as $member)
                <div class="rounded-3xl bg-slate-900/80 border border-slate-800 p-6 flex flex-col justify-between group hover:border-blue-500/40 transition duration-300">
                    
                    <div class="space-y-4">
                        <!-- Member Photo / Avatar Frame -->
                        <div class="h-56 w-full rounded-2xl bg-gradient-to-tr from-slate-950 to-slate-800 border border-slate-800 overflow-hidden relative group-hover:border-slate-700 transition">
                            @if($member->photo)
                                <img src="{{ $member->photo }}" alt="{{ $member->name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-slate-400">
                                    {{ substr($member->name, 0, 2) }}
                                </div>
                            @endif
                        </div>

                        <!-- Name & Role -->
                        <div class="space-y-1">
                            <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition">{{ $member->name }}</h3>
                            <p class="text-xs font-semibold text-blue-400">{{ $member->role }}</p>
                        </div>

                        <!-- Bio snippet -->
                        <p class="text-xs text-slate-300 leading-relaxed line-clamp-3">
                            {{ $member->bio }}
                        </p>
                    </div>

                    <!-- Social / Direct Links -->
                    <div class="pt-4 mt-4 border-t border-slate-800/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @if(!empty($member->social_links['linkedin']))
                                <a href="{{ $member->social_links['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-slate-800 transition" aria-label="LinkedIn Profile">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                            @if(!empty($member->social_links['twitter']))
                                <a href="{{ $member->social_links['twitter'] }}" target="_blank" rel="noopener noreferrer" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-slate-800 transition" aria-label="Twitter Profile">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                        </div>

                        <x-whatsapp-cta-button 
                            text="Connect" 
                            :message="'Hello, I would like to consult directly with ' . $member->name . ' (' . $member->role . ').'"
                            :buttonLocation="'team_' . \Illuminate\Support\Str::slug($member->name)" 
                            variant="secondary" 
                            size="sm" />
                    </div>

                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-slate-400">
                    No team profiles published at this time.
                </div>
            @endforelse
        </div>

    </div>
</section>
