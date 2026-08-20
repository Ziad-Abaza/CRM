<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = setting('site_name', 'Apex Corporate Solutions');
        $tagline = setting('company_tagline', 'Enterprise Strategic Advisory & Digital Modernization');
        $metaTitle = setting('seo_meta_title', $siteName . ' | ' . $tagline);
        $metaDesc = setting('seo_meta_description', 'High-impact enterprise digital consulting, high throughput architecture, and corporate acceleration solutions.');
        $metaKeywords = setting('seo_meta_keywords', 'corporate advisory, enterprise transformation, business consulting, digital workflow optimization, fintech compliance');
        
        $primaryColor = setting('primary_color', '#0F172A');
        $secondaryColor = setting('secondary_color', '#1E293B');
        $accentColor = setting('accent_color', '#2563EB');
        $typographyFont = setting('typography_font', 'Plus Jakarta Sans');
        $radiusBase = setting('radius_base', '0.75rem');
        $favicon = setting('company_favicon');
        $logo = setting('company_logo');

        $encodedFont = urlencode($typographyFont);
    @endphp

    <title>@yield('title', $metaTitle)</title>
    <meta name="description" content="@yield('meta_description', $metaDesc)">
    <meta name="keywords" content="@yield('meta_keywords', $metaKeywords)">
    
    <!-- OpenGraph / Social Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', $metaTitle)">
    <meta property="og:description" content="@yield('meta_description', $metaDesc)">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    @if($logo)
        <meta property="og:image" content="{{ url($logo) }}">
    @endif
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $metaTitle)">
    <meta name="twitter:description" content="@yield('meta_description', $metaDesc)">

    @if($favicon)
        <link rel="icon" href="{{ $favicon }}">
    @endif

    <!-- Dynamic Google Fonts Preconnect & Stylesheet -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family={{ $encodedFont }}:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Real-time Dynamic CSS Custom Properties Injection -->
    <style id="dynamic-theme-vars">
        :root {
            --brand-primary: {{ $primaryColor }};
            --brand-secondary: {{ $secondaryColor }};
            --brand-accent: {{ $accentColor }};
            --font-heading: '{{ $typographyFont }}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-body: '{{ $typographyFont }}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --radius-base: {{ $radiusBase }};
        }

        body {
            font-family: var(--font-body);
            background-color: #030712;
            color: #f3f4f6;
            overflow-x: hidden;
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
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full antialiased text-slate-200 selection:bg-blue-600 selection:text-white flex flex-col min-h-screen bg-slate-950"
      x-data="{ mobileMenuOpen: false }">

    <!-- Top Sticky Corporate Navbar -->
    <header class="sticky top-0 z-40 w-full backdrop-blur-xl bg-slate-950/85 border-b border-slate-800/80 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo & Name -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        @if($logo)
                            <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-9 w-auto object-contain transition group-hover:opacity-90">
                        @else
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-blue-600/30 text-white font-bold text-base tracking-wider border border-blue-400/30 group-hover:scale-105 transition transform">
                                {{ substr($siteName, 0, 2) }}
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="font-extrabold text-base sm:text-lg text-white tracking-tight leading-tight group-hover:text-blue-400 transition">
                                {{ $siteName }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase hidden sm:block">
                                {{ $tagline }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-300">
                    <a href="{{ route('home') }}#services" class="hover:text-blue-400 transition duration-150 py-1">Services</a>
                    <a href="{{ route('home') }}#portfolio" class="hover:text-blue-400 transition duration-150 py-1">Case Studies</a>
                    <a href="{{ route('home') }}#pricing" class="hover:text-blue-400 transition duration-150 py-1">Pricing</a>
                    <a href="{{ route('home') }}#about" class="hover:text-blue-400 transition duration-150 py-1">About</a>
                    <a href="{{ route('home') }}#team" class="hover:text-blue-400 transition duration-150 py-1">Team</a>
                    <a href="{{ route('home') }}#faqs" class="hover:text-blue-400 transition duration-150 py-1">FAQs</a>
                </nav>

                <!-- Desktop CTA Action Button -->
                <div class="hidden lg:flex items-center gap-4">
                    <x-whatsapp-cta-button 
                        text="Consult via WhatsApp" 
                        buttonLocation="navbar" 
                        variant="emerald" 
                        size="md" />
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center gap-2">
                    <button type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            aria-label="Toggle navigation menu">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
             class="md:hidden border-b border-slate-800 bg-slate-950/95 backdrop-blur-2xl px-4 pt-3 pb-6 space-y-3">
            <div class="flex flex-col space-y-2 font-semibold text-slate-200">
                <a href="{{ route('home') }}#services" @click="mobileMenuOpen = false" class="px-3 py-2.5 rounded-lg hover:bg-slate-800/80 hover:text-blue-400 transition">Services</a>
                <a href="{{ route('home') }}#portfolio" @click="mobileMenuOpen = false" class="px-3 py-2.5 rounded-lg hover:bg-slate-800/80 hover:text-blue-400 transition">Case Studies</a>
                <a href="{{ route('home') }}#pricing" @click="mobileMenuOpen = false" class="px-3 py-2.5 rounded-lg hover:bg-slate-800/80 hover:text-blue-400 transition">Pricing</a>
                <a href="{{ route('home') }}#about" @click="mobileMenuOpen = false" class="px-3 py-2.5 rounded-lg hover:bg-slate-800/80 hover:text-blue-400 transition">About</a>
                <a href="{{ route('home') }}#team" @click="mobileMenuOpen = false" class="px-3 py-2.5 rounded-lg hover:bg-slate-800/80 hover:text-blue-400 transition">Team</a>
                <a href="{{ route('home') }}#faqs" @click="mobileMenuOpen = false" class="px-3 py-2.5 rounded-lg hover:bg-slate-800/80 hover:text-blue-400 transition">FAQs</a>
            </div>
            <div class="pt-3 border-t border-slate-800">
                <x-whatsapp-cta-button 
                    text="Consult via WhatsApp" 
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
