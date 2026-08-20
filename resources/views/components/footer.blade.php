@php
    $siteName = setting('site_name', 'Apex Corporate Solutions');
    $tagline = setting('company_tagline', 'Enterprise Growth Architecture');
    $logo = setting('company_logo');
    $footerAbout = setting('footer_about', 'Apex Corporate Solutions delivers high-impact management consulting, digital transformation, and operational resilience to modern enterprises globally.');
    $footerCopyright = setting('footer_copyright', '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.');
    $email = setting('contact_email', 'contact@apexcorporate.com');
    $phone = setting('contact_phone', '+1 (555) 019-2834');
    $address = setting('contact_address', '100 Montgomery Street, Suite 2400, San Francisco, CA 94104');
    $linkedin = setting('social_linkedin');
    $twitter = setting('social_twitter');
@endphp

<footer class="bg-slate-950 border-t border-slate-800 text-slate-400 text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-8">
            
            <!-- Brand Column -->
            <div class="lg:col-span-2 space-y-6">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @if($logo)
                        <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-8 w-auto object-contain">
                    @else
                        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($siteName, 0, 2) }}
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-extrabold text-base text-white tracking-tight leading-tight group-hover:text-blue-400 transition">
                            {{ $siteName }}
                        </span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">
                            {{ $tagline }}
                        </span>
                    </div>
                </a>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-sm">
                    {{ $footerAbout }}
                </p>

                <!-- Social Icons -->
                <div class="flex items-center gap-3 pt-2">
                    @if($linkedin)
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:text-white hover:border-blue-500/40 transition" aria-label="LinkedIn">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    @endif
                    @if($twitter)
                        <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:text-white hover:border-blue-500/40 transition" aria-label="Twitter / X">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Navigation Links -->
            <div class="space-y-4">
                <h4 class="font-bold text-xs uppercase tracking-wider text-white">Navigation</h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ route('home') }}#services" class="hover:text-white transition">Services</a></li>
                    <li><a href="{{ route('home') }}#portfolio" class="hover:text-white transition">Case Studies</a></li>
                    <li><a href="{{ route('home') }}#pricing" class="hover:text-white transition">Pricing Plans</a></li>
                    <li><a href="{{ route('home') }}#about" class="hover:text-white transition">About Apex</a></li>
                    <li><a href="{{ route('home') }}#team" class="hover:text-white transition">Leadership</a></li>
                    <li><a href="{{ route('home') }}#faqs" class="hover:text-white transition">FAQs</a></li>
                </ul>
            </div>

            <!-- Direct Solutions -->
            <div class="space-y-4">
                <h4 class="font-bold text-xs uppercase tracking-wider text-white">Capabilities</h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ route('home') }}#services" class="hover:text-white transition">Digital Modernization</a></li>
                    <li><a href="{{ route('home') }}#services" class="hover:text-white transition">M&amp;A Due Diligence</a></li>
                    <li><a href="{{ route('home') }}#services" class="hover:text-white transition">Risk &amp; SOC2 Governance</a></li>
                    <li><a href="{{ route('home') }}#services" class="hover:text-white transition">Workflow Automation</a></li>
                    <li><a href="{{ route('home') }}#services" class="hover:text-white transition">Fractional C-Suite</a></li>
                </ul>
            </div>

            <!-- Contact / Direct WhatsApp -->
            <div class="space-y-4">
                <h4 class="font-bold text-xs uppercase tracking-wider text-white">Direct Channel</h4>
                <div class="space-y-3 text-xs">
                    <p class="leading-relaxed text-slate-300">{{ $address }}</p>
                    <p class="text-slate-300">{{ $phone }}</p>
                    <p class="text-blue-400 font-mono">{{ $email }}</p>
                    
                    <div class="pt-2">
                        <x-whatsapp-cta-button 
                            text="WhatsApp Channel" 
                            buttonLocation="footer" 
                            variant="emerald" 
                            size="sm" 
                            class="w-full justify-center" />
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright Bar -->
        <div class="pt-12 mt-12 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <p>{{ $footerCopyright }}</p>
            <div class="flex items-center gap-6">
                <span>Enterprise Tier Infrastructure</span>
                <span>•</span>
                <span class="text-emerald-400 font-semibold">100% WhatsApp Connected</span>
            </div>
        </div>
    </div>
</footer>
