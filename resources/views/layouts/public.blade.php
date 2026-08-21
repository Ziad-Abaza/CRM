<!DOCTYPE html>
<html lang="{{ current_locale() }}" dir="{{ locale_direction() }}" class="h-full scroll-smooth" data-theme="{{ setting('active_theme_default', 'dark') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $currentLocale = current_locale();
        $isRtl = is_rtl();
        $localeConfig = config("locales.supported.{$currentLocale}", []);
        
        $siteName = app_name();
        $tagline = app_tagline();
        $metaTitle = setting('seo_meta_title', t('seo.default_title', ['app' => $siteName, 'tagline' => $tagline]));
        $metaDesc = setting('seo_meta_description', __('seo.default_description'));
        $metaKeywords = setting('seo_meta_keywords', __('seo.default_keywords'));
        
        // Theme Engine Configuration
        $themeMode = setting('theme_mode', 'toggle_allowed');
        $activeThemeDefault = setting('active_theme_default', 'dark');

        // Dynamic Typography based on active locale
        if ($isRtl) {
            $typographyFont = setting('typography_font_ar', $localeConfig['font'] ?? 'Cairo');
            $typographyFontHeading = setting('typography_font_heading_ar', $localeConfig['font_heading'] ?? $typographyFont);
        } else {
            $typographyFont = setting('typography_font', $localeConfig['font'] ?? 'Plus Jakarta Sans');
            $typographyFontHeading = setting('typography_font_heading');
            if (!$typographyFontHeading || ($typographyFont !== 'Plus Jakarta Sans' && $typographyFontHeading === 'Plus Jakarta Sans')) {
                $typographyFontHeading = $typographyFont;
            }
        }

        $radiusCard = setting('radius_card', '1rem');
        $radiusButton = setting('radius_button', '0.75rem');
        $radiusInput = setting('radius_input', '0.75rem');
        $radiusBase = setting('radius_base', $radiusButton);

        // Primary / Accent with fallback
        $primaryColor = setting('primary_color', '#2563eb');
        $secondaryColor = setting('secondary_color', '#4f46e5');
        $accentColor = setting('accent_color', '#10b981');

        // Dark Palette
        $darkBgBody = setting('dark_bg_body', '#030712');
        $darkBgSurface = setting('dark_bg_surface', '#0f172a');
        $darkBgCard = setting('dark_bg_card', '#0f172a');
        $darkBgInput = setting('dark_bg_input', '#020617');
        $darkTextPrimary = setting('dark_text_primary', '#f8fafc');
        $darkTextMuted = setting('dark_text_muted', '#94a3b8');
        $darkBorderSubtle = setting('dark_border_subtle', '#1e293b');
        $darkBorderHighlight = setting('dark_border_highlight', '#334155');
        
        $darkPrimary = setting('dark_primary_color');
        if (!$darkPrimary || (setting('primary_color') && setting('primary_color') !== '#0F172A' && setting('primary_color') !== '#0f172a')) {
            $darkPrimary = $primaryColor;
        }

        $darkSecondary = setting('dark_secondary_color') ?? $secondaryColor;

        $darkAccent = setting('dark_accent_color');
        if (!$darkAccent || (setting('accent_color') && setting('accent_color') !== '#2563EB' && setting('accent_color') !== '#2563eb')) {
            $darkAccent = $accentColor;
        }

        // Light Palette
        $lightBgBody = setting('light_bg_body', '#f8fafc');
        $lightBgSurface = setting('light_bg_surface', '#f1f5f9');
        $lightBgCard = setting('light_bg_card', '#ffffff');
        $lightBgInput = setting('light_bg_input', '#ffffff');
        $lightTextPrimary = setting('light_text_primary', '#0f172a');
        $lightTextMuted = setting('light_text_muted', '#64748b');
        $lightBorderSubtle = setting('light_border_subtle', '#e2e8f0');
        $lightBorderHighlight = setting('light_border_highlight', '#cbd5e1');
        $lightPrimary = setting('light_primary_color', '#1d4ed8');
        $lightSecondary = setting('light_secondary_color', '#4338ca');
        $lightAccent = setting('light_accent_color', '#059669');

        $favicon = setting('company_favicon');
        $logo = setting('company_logo');

        $encodedFont = urlencode($typographyFont);
        $encodedFontHeading = urlencode($typographyFontHeading);
    @endphp

    <title>@yield('title', $metaTitle)</title>
    <meta name="description" content="@yield('meta_description', $metaDesc)">
    <meta name="keywords" content="@yield('meta_keywords', $metaKeywords)">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- OpenGraph / Facebook Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', $metaTitle)">
    <meta property="og:description" content="@yield('meta_description', $metaDesc)">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="{{ config("locales.supported.{$currentLocale}.og_locale", $isRtl ? 'ar_SA' : 'en_US') }}">
    @foreach(supported_locales() as $code => $localeData)
        @if($code !== $currentLocale)
            <meta property="og:locale:alternate" content="{{ $localeData['og_locale'] ?? $code }}">
        @endif
    @endforeach
    @if($logo)
        <meta property="og:image" content="{{ url($logo) }}">
    @endif
    
    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $metaTitle)">
    <meta name="twitter:description" content="@yield('meta_description', $metaDesc)">
    @if($logo)
        <meta name="twitter:image" content="{{ url($logo) }}">
    @endif

    <!-- Localized Hreflang Alternate Links -->
    @foreach(supported_locales() as $code => $localeData)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ switch_locale_url($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ switch_locale_url(config('locales.default', 'en')) }}">

    <!-- Schema.org JSON-LD Structured Data -->
    @php
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                array_filter([
                    '@type' => 'Organization',
                    '@id' => url('/#organization'),
                    'name' => $siteName,
                    'url' => url('/'),
                    'description' => $metaDesc,
                    'logo' => $logo ? url($logo) : null,
                    'contactPoint' => [
                        [
                            '@type' => 'ContactPoint',
                            'contactType' => 'Customer Support',
                            'telephone' => setting('company_phone', '+1 (800) 555-0199'),
                            'email' => app_email(),
                            'availableLanguage' => ['English', 'Arabic']
                        ]
                    ],
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => setting('company_address', '100 Enterprise Boulevard, Suite 800')
                    ]
                ]),
                [
                    '@type' => 'WebSite',
                    '@id' => url('/#website'),
                    'url' => url('/'),
                    'name' => $siteName,
                    'description' => $tagline,
                    'publisher' => [
                        '@id' => url('/#organization')
                    ]
                ]
            ]
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>

    @if($favicon)
        <link rel="icon" href="{{ $favicon }}">
    @endif

    <!-- High Performance Asynchronous Font Delivery (Zero Render-Blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family={{ $encodedFont }}:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ $encodedFont }}:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ $encodedFont }}:wght@400;500;600;700;800&display=swap">
    </noscript>
    @if($encodedFontHeading !== $encodedFont)
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family={{ $encodedFontHeading }}:wght@400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ $encodedFontHeading }}:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
        <noscript>
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={{ $encodedFontHeading }}:wght@400;500;600;700;800&display=swap">
        </noscript>
    @endif

    <!-- Production Optimized Asset Delivery (Zero Render-Blocking) -->
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
        $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
        $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
    @endphp

    @if($cssFile)
        <link rel="preload" href="{{ asset('build/' . $cssFile) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}"></noscript>
    @else
        @vite(['resources/css/app.css'])
    @endif

    @if($jsFile)
        <script type="module" src="{{ asset('build/' . $jsFile) }}" defer></script>
    @else
        @vite(['resources/js/app.js'])
    @endif

    <!-- Real-time Dynamic Light/Dark Theme & RTL/LTR Custom Properties Injection -->
    <style id="dynamic-theme-vars">
        :root {
            /* Fallback & Shared typography/geometry */
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
            --brand-accent: {{ $accentColor }};
            --font-heading: '{{ $typographyFontHeading }}', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-body: '{{ $typographyFont }}', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --radius-base: {{ $radiusBase }};
            --radius-card: {{ $radiusCard }};
            --radius-button: {{ $radiusButton }};
            --radius-input: {{ $radiusInput }};

            /* Light Mode Tokens Default */
            --bg-body: {{ $lightBgBody }};
            --bg-surface: {{ $lightBgSurface }};
            --bg-card: {{ $lightBgCard }};
            --bg-input: {{ $lightBgInput }};
            --text-primary: {{ $lightTextPrimary }};
            --text-muted: {{ $lightTextMuted }};
            --border-subtle: {{ $lightBorderSubtle }};
            --border-highlight: {{ $lightBorderHighlight }};
            --theme-primary: {{ $lightPrimary }};
            --theme-secondary: {{ $lightSecondary }};
            --theme-accent: {{ $lightAccent }};
        }

        /* Dark Mode Tokens Override */
        html[data-theme="dark"], html.dark {
            --brand-primary: {{ $darkPrimary }};
            --brand-secondary: {{ $darkSecondary }};
            --brand-accent: {{ $darkAccent }};
            --bg-body: {{ $darkBgBody }};
            --bg-surface: {{ $darkBgSurface }};
            --bg-card: {{ $darkBgCard }};
            --bg-input: {{ $darkBgInput }};
            --text-primary: {{ $darkTextPrimary }};
            --text-muted: {{ $darkTextMuted }};
            --border-subtle: {{ $darkBorderSubtle }};
            --border-highlight: {{ $darkBorderHighlight }};
            --theme-primary: {{ $darkPrimary }};
            --theme-secondary: {{ $darkSecondary }};
            --theme-accent: {{ $darkAccent }};
        }

        body {
            font-family: var(--font-body);
            overflow-x: clip;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: var(--font-heading);
        }

        [x-cloak] {
            display: none !important;
        }

        .bg-brand-primary { background-color: var(--brand-primary); }
        .bg-brand-secondary { background-color: var(--brand-secondary); }
        .bg-brand-accent { background-color: var(--brand-accent); }
        .text-brand-primary { color: var(--brand-primary); }
        .text-brand-accent { color: var(--brand-accent); }
        .border-brand-accent { border-color: var(--brand-accent); }

        /* Subtle grid background pattern */
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        html[data-theme="dark"] .bg-grid-pattern, html.dark .bg-grid-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
        }
    </style>

    <!-- Early Theme Initializer to prevent Flash of Unstyled Theme -->
    <script>
        (function() {
            const configuredMode = '{{ $themeMode }}';
            const defaultTheme = '{{ $activeThemeDefault }}';
            
            let targetTheme = defaultTheme;

            if (configuredMode === 'dark_only') {
                targetTheme = 'dark';
            } else if (configuredMode === 'light_only') {
                targetTheme = 'light';
            } else {
                const stored = localStorage.getItem('app_theme') || localStorage.getItem('apex_theme');
                if (stored === 'light' || stored === 'dark') {
                    targetTheme = stored;
                } else if (configuredMode === 'system' && window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
                    targetTheme = 'light';
                }
            }

            document.documentElement.setAttribute('data-theme', targetTheme);
            if (targetTheme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @stack('styles')
</head>
<body class="h-full antialiased text-slate-800 dark:text-slate-200 selection:bg-blue-600 selection:text-white flex flex-col min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-200"
      x-data="{
          mobileMenuOpen: false,
          theme: document.documentElement.getAttribute('data-theme') || '{{ $activeThemeDefault }}',
          toggleTheme() {
              this.theme = this.theme === 'dark' ? 'light' : 'dark';
              document.documentElement.setAttribute('data-theme', this.theme);
              if (this.theme === 'dark') {
                  document.documentElement.classList.add('dark');
                  document.documentElement.classList.remove('light');
              } else {
                  document.documentElement.classList.add('light');
                  document.documentElement.classList.remove('dark');
              }
              localStorage.setItem('app_theme', this.theme);
          }
      }">

    <!-- Top Sticky Corporate Navbar -->
    <header class="sticky top-0 z-40 w-full backdrop-blur-xl bg-white/90 dark:bg-slate-950/90 border-b border-slate-200/80 dark:border-slate-800/80 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-18">
                <!-- Brand Logo & Name -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <a href="{{ localized_route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group">
                        @php
                            $logoPath = $logo ? ltrim(parse_url($logo, PHP_URL_PATH) ?? $logo, '/') : null;
                            $hasLogo = $logoPath && (file_exists(public_path($logoPath)) || str_starts_with($logo, 'http'));
                        @endphp
                        @if($hasLogo)
                            @php
                                $webpLogoPath = preg_replace('/\.png$/i', '.webp', $logoPath);
                                $hasWebp = file_exists(public_path($webpLogoPath));
                            @endphp
                            <picture>
                                @if($hasWebp)
                                    <source srcset="{{ asset($webpLogoPath) }}" type="image/webp">
                                @endif
                                <img src="{{ str_starts_with($logo, 'http') ? $logo : asset($logoPath) }}" 
                                     alt="{{ $siteName }}" 
                                     width="64" 
                                     height="35" 
                                     fetchpriority="high"
                                     decoding="async"
                                     class="h-7 sm:h-8 w-auto object-contain transition group-hover:opacity-90">
                            </picture>
                        @else
                            <div class="h-8 w-8 sm:h-9 sm:w-9 rounded-lg sm:rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-md shadow-blue-600/30 text-white font-bold text-xs sm:text-sm tracking-wider border border-blue-400/30 group-hover:scale-105 transition transform">
                                {{ substr($siteName, 0, 2) }}
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="font-extrabold text-sm sm:text-base text-slate-900 dark:text-white tracking-tight leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition truncate max-w-[180px] sm:max-w-none">
                                {{ $siteName }}
                            </span>
                            <span class="text-[9px] text-slate-500 dark:text-slate-400 font-semibold tracking-wider uppercase hidden sm:block">
                                {{ $tagline }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-5 lg:gap-7 text-sm font-semibold text-slate-600 dark:text-slate-300">
                    <a href="{{ localized_route('home') }}#services" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 py-1">{{ __('ui.nav.services') }}</a>
                    <a href="{{ localized_route('home') }}#portfolio" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 py-1">{{ __('ui.nav.case_studies') }}</a>
                    <a href="{{ localized_route('home') }}#pricing" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 py-1">{{ __('ui.nav.pricing') }}</a>
                    <a href="{{ localized_route('home') }}#about" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 py-1">{{ __('ui.nav.about') }}</a>
                    <a href="{{ localized_route('home') }}#team" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 py-1">{{ __('ui.nav.team') }}</a>
                    <a href="{{ localized_route('home') }}#faqs" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 py-1">{{ __('ui.nav.faqs') }}</a>
                </nav>

                <!-- Desktop Actions: Language Switcher, Theme Toggle & WhatsApp CTA -->
                <div class="hidden lg:flex items-center gap-2.5">
                    <!-- Language Switcher Dropdown -->
                    <div class="relative" x-data="{ langMenuOpen: false }" @click.outside="langMenuOpen = false">
                        <button type="button" 
                                @click="langMenuOpen = !langMenuOpen" 
                                class="flex items-center gap-1.5 px-2.5 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-label="{{ __('ui.toggles.language') }}"
                                :aria-expanded="langMenuOpen">
                            <span>{{ config("locales.supported.{$currentLocale}.flag", '🌐') }}</span>
                            <span>{{ config("locales.supported.{$currentLocale}.native", strtoupper($currentLocale)) }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': langMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="langMenuOpen" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute {{ $isRtl ? 'left-0' : 'right-0' }} mt-2 w-36 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl py-1 z-50">
                            @foreach(supported_locales() as $code => $localeData)
                                <a href="{{ switch_locale_url($code) }}" 
                                   class="flex items-center justify-between px-3 py-2 text-xs font-medium {{ $currentLocale === $code ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition">
                                    <span class="flex items-center gap-2">
                                        <span>{{ $localeData['flag'] ?? '' }}</span>
                                        <span>{{ $localeData['native'] ?? $localeData['name'] }}</span>
                                    </span>
                                    @if($currentLocale === $code)
                                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if($themeMode !== 'dark_only' && $themeMode !== 'light_only')
                        <!-- Theme Toggle Button -->
                        <button type="button" 
                                @click="toggleTheme()" 
                                class="p-2 rounded-xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-slate-900 hover:bg-slate-200 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :aria-label="theme === 'dark' ? '{{ __('ui.toggles.switch_to_light') }}' : '{{ __('ui.toggles.switch_to_dark') }}'">
                            <!-- Sun icon when dark -->
                            <svg x-show="theme === 'dark'" class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <!-- Moon icon when light -->
                            <svg x-show="theme === 'light'" x-cloak class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    @endif

                    <x-whatsapp-cta-button 
                        :text="__('frontend.hero.consult_cta')" 
                        buttonLocation="navbar" 
                        variant="emerald" 
                        size="md" />
                </div>

                <!-- Mobile Menu Button, Mobile Language Switcher & Mobile Theme Toggle -->
                <div class="flex md:hidden items-center gap-1.5">
                    <!-- Mobile Direct Language Switch -->
                    @php
                        $alternateLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                        $alternateLocaleData = config("locales.supported.{$alternateLocale}", []);
                    @endphp
                    <a href="{{ switch_locale_url($alternateLocale) }}" 
                       class="px-2 py-1.5 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 transition"
                       aria-label="{{ __('ui.toggles.switch_language') }}">
                        <span>{{ $alternateLocaleData['flag'] ?? '' }}</span>
                        <span>{{ $alternateLocaleData['native'] ?? strtoupper($alternateLocale) }}</span>
                    </a>

                    @if($themeMode !== 'dark_only' && $themeMode !== 'light_only')
                        <button type="button" 
                                @click="toggleTheme()" 
                                class="p-2 rounded-xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 transition"
                                :aria-label="theme === 'dark' ? '{{ __('ui.toggles.switch_to_light') }}' : '{{ __('ui.toggles.switch_to_dark') }}'">
                            <svg x-show="theme === 'dark'" class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <svg x-show="theme === 'light'" x-cloak class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    @endif

                    <button type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2.5 rounded-xl text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            aria-label="Toggle navigation menu">
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-b border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-950/95 backdrop-blur-2xl px-4 pt-3 pb-6 space-y-3">
            <div class="flex flex-col space-y-1 font-semibold text-slate-700 dark:text-slate-200">
                <a href="{{ localized_route('home') }}#services" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-blue-600 dark:hover:text-blue-400 transition text-xs sm:text-sm">{{ __('ui.nav.services') }}</a>
                <a href="{{ localized_route('home') }}#portfolio" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-blue-600 dark:hover:text-blue-400 transition text-xs sm:text-sm">{{ __('ui.nav.case_studies') }}</a>
                <a href="{{ localized_route('home') }}#pricing" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-blue-600 dark:hover:text-blue-400 transition text-xs sm:text-sm">{{ __('ui.nav.pricing') }}</a>
                <a href="{{ localized_route('home') }}#about" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-blue-600 dark:hover:text-blue-400 transition text-xs sm:text-sm">{{ __('ui.nav.about') }}</a>
                <a href="{{ localized_route('home') }}#team" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-blue-600 dark:hover:text-blue-400 transition text-xs sm:text-sm">{{ __('ui.nav.team') }}</a>
                <a href="{{ localized_route('home') }}#faqs" @click="mobileMenuOpen = false" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-blue-600 dark:hover:text-blue-400 transition text-xs sm:text-sm">{{ __('ui.nav.faqs') }}</a>
            </div>

            <!-- Mobile Language Switcher -->
            <div class="pt-3 pb-1 border-t border-slate-200 dark:border-slate-800">
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2">{{ __('ui.toggles.language') }}</p>
                <div class="grid grid-cols-2 gap-2 px-1">
                    @foreach(supported_locales() as $code => $localeData)
                        <a href="{{ switch_locale_url($code) }}" 
                           class="flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold border transition {{ $currentLocale === $code ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-slate-100 dark:bg-slate-900 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:bg-slate-200 dark:hover:bg-slate-800' }}">
                            <span>{{ $localeData['flag'] ?? '' }}</span>
                            <span>{{ $localeData['native'] ?? $localeData['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                <x-whatsapp-cta-button 
                    :text="__('frontend.hero.consult_cta')" 
                    buttonLocation="navbar_mobile" 
                    variant="emerald" 
                    size="md" 
                    class="w-full justify-center" />
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Global Corporate Footer Component -->
    <x-footer />

    <!-- Persistent Floating WhatsApp Lead Conversion Widget -->
    <x-whatsapp-floating-widget />

    @stack('scripts')
</body>
</html>
