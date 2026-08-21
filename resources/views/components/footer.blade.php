@php
    $siteName = app_name();
    $tagline = app_tagline();
    $logo = setting('company_logo');
    $footerAbout = setting('footer_about', t('frontend.footer.about_text', ['app' => $siteName]));
    $footerCopyright = setting('footer_copyright', t('frontend.footer.copyright', ['app' => $siteName, 'year' => date('Y')]));
    $email = app_email();
    $phone = setting('contact_phone', '+1 (555) 019-2834');
    $address = setting('contact_address', __('frontend.footer.address'));
    $linkedin = setting('social_linkedin');
    $twitter = setting('social_twitter');
    $currentLocale = current_locale();
@endphp

<footer class="bg-slate-100 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 text-xs sm:text-sm transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-6">
            
            <!-- Brand Column -->
            <div class="lg:col-span-2 space-y-4 text-start">
                <a href="{{ localized_route('home') }}" class="flex items-center gap-2.5 group">
                    @php
                        $footerLogoPath = $logo ? ltrim(parse_url($logo, PHP_URL_PATH) ?? $logo, '/') : null;
                        $hasFooterLogo = $footerLogoPath && (file_exists(public_path($footerLogoPath)) || str_starts_with($logo, 'http'));
                    @endphp
                    @if($hasFooterLogo)
                        <img src="{{ str_starts_with($logo, 'http') ? $logo : asset($footerLogoPath) }}" alt="{{ $siteName }}" width="112" height="28" loading="lazy" decoding="async" class="h-7 w-auto object-contain">
                    @else
                        <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold text-xs">
                            {{ substr($siteName, 0, 2) }}
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-extrabold text-sm sm:text-base text-slate-900 dark:text-white tracking-tight leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                            {{ $siteName }}
                        </span>
                        <span class="text-[9px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-semibold">
                            {{ $tagline }}
                        </span>
                    </div>
                </a>

                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed max-w-sm">
                    {{ $footerAbout }}
                </p>

                <!-- Language Switcher in Footer -->
                <div class="pt-1 flex items-center gap-2">
                    <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">{{ __('ui.toggles.language') }}:</span>
                    <div class="flex items-center gap-1.5">
                        @foreach(supported_locales() as $code => $localeData)
                            <a href="{{ switch_locale_url($code) }}" 
                               class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold transition {{ $currentLocale === $code ? 'bg-blue-600 text-white shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:bg-slate-200 dark:hover:bg-slate-800' }}">
                                <span>{{ $localeData['flag'] ?? '' }}</span>
                                <span>{{ $localeData['native'] ?? $localeData['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Social Icons -->
                <div class="flex items-center gap-2 pt-1">
                    @if($linkedin)
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" class="p-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-blue-500/40 transition" aria-label="LinkedIn">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    @endif
                    @if($twitter)
                        <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" class="p-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-blue-500/40 transition" aria-label="Twitter / X">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Navigation Links -->
            <div class="space-y-3 text-start">
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-white">{{ __('frontend.footer.navigation_title') }}</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ localized_route('home') }}#services" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.services') }}</a></li>
                    <li><a href="{{ localized_route('home') }}#portfolio" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.case_studies') }}</a></li>
                    <li><a href="{{ localized_route('home') }}#pricing" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.pricing') }}</a></li>
                    <li><a href="{{ localized_route('home') }}#about" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.about') }}</a></li>
                    <li><a href="{{ localized_route('home') }}#team" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.team') }}</a></li>
                    <li><a href="{{ localized_route('home') }}#faqs" class="hover:text-slate-900 dark:hover:text-white transition">{{ __('ui.nav.faqs') }}</a></li>
                </ul>
            </div>

            <!-- Direct Solutions / Capabilities -->
            <div class="space-y-3 text-start">
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-white">{{ __('frontend.footer.capabilities_title') }}</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ localized_route('home') }}#services" class="hover:text-slate-900 dark:hover:text-white transition">{{ $currentLocale === 'ar' ? 'التحديث الرقمي والأنظمة السحابية' : 'Digital Modernization' }}</a></li>
                    <li><a href="{{ localized_route('home') }}#services" class="hover:text-slate-900 dark:hover:text-white transition">{{ $currentLocale === 'ar' ? 'الفحص النافي للجهالة التقني' : 'M&A Due Diligence' }}</a></li>
                    <li><a href="{{ localized_route('home') }}#services" class="hover:text-slate-900 dark:hover:text-white transition">{{ $currentLocale === 'ar' ? 'حوكمة الامتثال ومعايير SOC 2' : 'Risk & SOC2 Governance' }}</a></li>
                    <li><a href="{{ localized_route('home') }}#services" class="hover:text-slate-900 dark:hover:text-white transition">{{ $currentLocale === 'ar' ? 'أتمتة العمليات وهندسة التدفقات' : 'Workflow Automation' }}</a></li>
                    <li><a href="{{ localized_route('home') }}#services" class="hover:text-slate-900 dark:hover:text-white transition">{{ $currentLocale === 'ar' ? 'القيادة التنفيذية التقنية الجزئية' : 'Fractional C-Suite' }}</a></li>
                </ul>
            </div>

            <!-- Contact / Direct WhatsApp -->
            <div class="space-y-3 text-start">
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-white">{{ __('frontend.footer.direct_channel_title') }}</h4>
                <div class="space-y-2 text-xs">
                    <p class="leading-relaxed text-slate-700 dark:text-slate-300">{{ $address }}</p>
                    <p class="text-slate-700 dark:text-slate-300" dir="ltr">{{ $phone }}</p>
                    <p class="text-blue-600 dark:text-blue-400 font-mono" dir="ltr">{{ $email }}</p>
                    
                    <div class="pt-1">
                        <x-whatsapp-cta-button 
                            :text="__('frontend.whatsapp.direct_channel')" 
                            buttonLocation="footer" 
                            variant="emerald" 
                            size="sm" 
                            class="w-full justify-center" />
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright Bar -->
        <div class="pt-8 mt-8 border-t border-slate-200 dark:border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400">
            <p>{{ $footerCopyright }}</p>
            <div class="flex items-center gap-4 text-[11px]">
                <span>{{ __('frontend.footer.enterprise_infrastructure') }}</span>
                <span>•</span>
                <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ __('frontend.footer.whatsapp_connected') }}</span>
            </div>
        </div>
    </div>
</footer>
