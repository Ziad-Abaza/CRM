<!DOCTYPE html>
<html lang="{{ current_locale() }}" dir="{{ locale_direction() }}" class="h-full" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('auth.login_title') }} - {{ $companyName }}</title>

    <!-- Vite Assets (Tailwind CSS v4 & Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Cairo for Arabic / Plus Jakarta Sans for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if(is_rtl())
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Cairo', system-ui, -apple-system, sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    @else
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    @endif
</head>
<body class="h-full antialiased bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 flex items-center justify-center p-4 sm:p-6 lg:p-8 transition-colors duration-200">
    <div class="w-full max-w-md space-y-6 sm:space-y-8">
        <!-- Language Switcher on Login -->
        <div class="flex justify-center">
            <div class="inline-flex items-center gap-1 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-slate-200 dark:border-slate-800 p-1 rounded-xl shadow-sm text-xs">
                <a href="{{ route('locale.switch', ['locale' => 'en']) }}" 
                   class="px-3 py-1 rounded-lg font-semibold transition {{ current_locale() === 'en' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    English
                </a>
                <a href="{{ route('locale.switch', ['locale' => 'ar']) }}" 
                   class="px-3 py-1 rounded-lg font-semibold transition {{ current_locale() === 'ar' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    العربية
                </a>
            </div>
        </div>

        <!-- Brand Header -->
        <div class="text-center space-y-3">
            @if(!empty($companyLogo))
                <img src="{{ $companyLogo }}" alt="{{ $companyName }}" class="h-12 w-auto mx-auto object-contain mb-2">
            @else
                <div class="mx-auto h-12 w-12 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-500/25 ring-1 ring-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            @endif
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $companyName }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('auth.login_subtitle') }}</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 sm:p-8 shadow-xl dark:shadow-2xl">
            <!-- Status message -->
            @if (session('status'))
                <div role="status" class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-800 dark:text-emerald-400 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Errors Alert -->
            @if ($errors->any())
                <div role="alert" class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-800 dark:text-rose-400 text-sm">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('ui.alerts.validation_error') }}</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-xs opacity-90 ps-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5" x-data="{ showPassword: false, submitting: false }" @submit="submitting = true">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ __('auth.email_label') }} <span class="text-rose-500" aria-hidden="true">*</span>
                    </label>
                    <div class="relative">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               autocomplete="email" 
                               required 
                               value="{{ old('email') }}"
                               placeholder="admin@corporate-crm.com"
                               class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150 ease-in-out @error('email') border-rose-500 ring-1 ring-rose-500 @enderror"
                               aria-required="true"
                               aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                    </div>
                </div>

                <!-- Password Input with Alpine.js Show/Hide -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                        {{ __('auth.password_label') }} <span class="text-rose-500" aria-hidden="true">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" 
                               name="password" 
                               :type="showPassword ? 'text' : 'password'" 
                               autocomplete="current-password" 
                               required 
                               placeholder="••••••••••••"
                               class="w-full px-4 py-2.5 pe-11 bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150 ease-in-out @error('password') border-rose-500 ring-1 ring-rose-500 @enderror"
                               aria-required="true"
                               aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                        <button type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute inset-y-0 end-0 flex items-center pe-3.5 text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 focus:outline-none"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'">
                            <!-- Eye icon -->
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye-off icon -->
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" 
                               name="remember" 
                               class="w-4 h-4 rounded bg-slate-100 dark:bg-slate-950/60 border-slate-300 dark:border-slate-800 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-slate-600 dark:text-slate-300">{{ __('auth.remember_me') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        :disabled="submitting" 
                        class="w-full relative flex justify-center items-center py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-600/30 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!submitting">{{ __('auth.sign_in') }}</span>
                    <span x-show="submitting" class="flex items-center gap-2" style="display: none;">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('auth.authenticating') }}
                    </span>
                </button>
            </form>
        </div>

        <!-- Security Footer Notice -->
        <p class="text-center text-xs text-slate-500 dark:text-slate-400">
            {{ __('auth.security_notice') }}
        </p>
    </div>
</body>
</html>
