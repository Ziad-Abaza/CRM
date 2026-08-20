@props([
    'companyName' => null,
    'avatar' => null,
    'defaultMessage' => null,
    'promptOptions' => null,
])

@php
    $currentLocale = current_locale();
    $isRtl = is_rtl();
    $companyName = $companyName ?? setting('site_name', 'Apex Corporate Solutions');
    $avatar = $avatar ?? setting('company_logo');
    $defaultMessage = $defaultMessage ?? setting('whatsapp_default_message', __('frontend.whatsapp.default_message'));
    
    $promptOptions = $promptOptions ?? [
        [
            'icon' => '💼',
            'title' => $isRtl ? 'جلسة استراتيجية تنفيذية' : 'Executive Strategy Session',
            'text' => $isRtl ? 'مرحباً فريق أبيكس، أود طلب استشارة تنفيذية حول استراتيجية التحول المؤسسي.' : 'Hello Apex team, I would like to request an executive corporate strategy consultation.'
        ],
        [
            'icon' => '📊',
            'title' => $isRtl ? 'الفحص الفني والتدقيق للاستحواذ' : 'M&A & Operational Due Diligence',
            'text' => $isRtl ? 'مرحباً، أحتاج إلى استشارة استراتيجية حول الفحص النافي للجهالة التقني للاستحواذ والاندماج.' : 'Hi, I need strategic advisory regarding M&A technology audit and due diligence.'
        ],
        [
            'icon' => '🛡️',
            'title' => $isRtl ? 'حوكمة الامتثال ومعايير SOC 2' : 'SOC 2 & Compliance Governance',
            'text' => $isRtl ? 'مرحباً، أود مناقشة خارطة طريق الامتثال لمعايير SOC 2 وإدارة المخاطر لمؤسستنا.' : 'Hello, I would like to discuss our enterprise SOC 2 and risk compliance roadmap.'
        ],
        [
            'icon' => '⚡',
            'title' => $isRtl ? 'أتمتة العمليات والذكاء الاصطناعي' : 'Workflow & AI Automation',
            'text' => $isRtl ? 'مرحباً فريق أبيكس، أود استكشاف حلول أتمتة العمليات التنفيذية والتحول الرقمي.' : 'Hi Apex team, I want to explore automated executive RPA and workflow transformation.'
        ],
    ];
@endphp

<div x-data="{
        isOpen: false,
        customMessage: '',
        isSending: false,
        
        async startChat(promptText) {
            const messageToSend = promptText || this.customMessage || '{{ addslashes($defaultMessage) }}';
            this.isSending = true;
            
            try {
                const response = await fetch('{{ route('api.whatsapp.track') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        source_page: window.location.pathname + window.location.search,
                        button_location: 'floating_widget',
                        prefilled_message: messageToSend,
                        referrer: document.referrer || null
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.whatsapp_url) {
                        window.open(data.whatsapp_url, '_blank', 'noopener,noreferrer');
                    } else {
                        this.fallbackRedirect(messageToSend);
                    }
                } else {
                    this.fallbackRedirect(messageToSend);
                }
            } catch (err) {
                console.warn('Telemetry tracking fallback:', err);
                this.fallbackRedirect(messageToSend);
            } finally {
                this.isSending = false;
                this.customMessage = '';
                this.isOpen = false;
            }
        },

        fallbackRedirect(msg) {
            const encoded = encodeURIComponent(msg);
            const redirectUrl = '{{ route('whatsapp.redirect') }}?button_location=floating_widget&message=' + encoded;
            window.open(redirectUrl, '_blank', 'noopener,noreferrer');
        }
    }" 
    class="fixed bottom-4 right-4 rtl:right-auto rtl:left-4 sm:bottom-6 sm:right-6 rtl:sm:right-auto rtl:sm:left-6 z-50 flex flex-col {{ $isRtl ? 'items-start' : 'items-end' }}"
    @keydown.escape.window="isOpen = false">

    <!-- Floating Chat Card (Fluid and responsive with Light/Dark support) -->
    <div x-show="isOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-300 transform origin-bottom-right rtl:origin-bottom-left"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform origin-bottom-right rtl:origin-bottom-left"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         @click.outside="isOpen = false"
         class="mb-3 w-[calc(100vw-2rem)] max-w-[350px] rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/80 shadow-2xl shadow-slate-900/10 dark:shadow-slate-950/90 overflow-hidden flex flex-col backdrop-blur-xl transition-colors duration-200 text-start">

        <!-- Card Header -->
        <div class="px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-700 dark:from-emerald-700 dark:to-teal-800 text-white flex items-center justify-between relative overflow-hidden">
            <div class="flex items-center gap-2.5 relative z-10 min-w-0">
                <div class="relative flex-shrink-0">
                    @php
                        $avatarPath = $avatar ? ltrim(parse_url($avatar, PHP_URL_PATH) ?? $avatar, '/') : null;
                        $hasAvatar = $avatarPath && (file_exists(public_path($avatarPath)) || str_starts_with($avatar, 'http'));
                    @endphp
                    @if($hasAvatar)
                        <img src="{{ str_starts_with($avatar, 'http') ? $avatar : asset($avatarPath) }}" alt="{{ $companyName }}" class="h-8 w-8 rounded-full object-cover border-2 border-white/30 bg-slate-950">
                    @else
                        <div class="h-8 w-8 rounded-full bg-slate-900 border-2 border-white/30 flex items-center justify-center font-bold text-xs text-emerald-400">
                            {{ substr($companyName, 0, 2) }}
                        </div>
                    @endif
                    <span class="absolute bottom-0 end-0 h-2.5 w-2.5 rounded-full bg-emerald-400 border-2 border-white dark:border-slate-900"></span>
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-xs sm:text-sm leading-tight text-white truncate">{{ $companyName }}</h3>
                    <p class="text-[10px] text-emerald-100 font-medium flex items-center gap-1 mt-0.5 truncate">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse flex-shrink-0"></span>
                        <span>{{ __('frontend.whatsapp.chat_header_title') }}</span>
                    </p>
                </div>
            </div>

            <button type="button" 
                    @click="isOpen = false" 
                    class="relative z-10 p-1 rounded-full text-emerald-100 hover:text-white hover:bg-white/10 transition flex-shrink-0"
                    aria-label="{{ __('ui.modals.close') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat Body & Prompt Options -->
        <div class="p-3 space-y-3 max-h-[300px] overflow-y-auto bg-slate-50/80 dark:bg-slate-950/60">
            <!-- Automated Welcome Bubble -->
            <div class="flex items-start gap-2">
                <div class="h-6 w-6 rounded-full bg-emerald-100 dark:bg-emerald-600/20 border border-emerald-300 dark:border-emerald-500/30 flex items-center justify-center text-emerald-700 dark:text-emerald-400 text-xs font-bold flex-shrink-0 mt-0.5">
                    ⚡
                </div>
                <div class="p-2.5 rounded-xl {{ $isRtl ? 'rounded-tr-sm' : 'rounded-tl-sm' }} bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 text-xs text-slate-800 dark:text-slate-200 leading-relaxed shadow-sm">
                    <p class="font-semibold text-slate-900 dark:text-white mb-0.5">{{ $isRtl ? 'مرحباً بك.' : 'Welcome.' }}</p>
                    <p class="text-slate-600 dark:text-slate-300 text-[11px]">{{ __('frontend.whatsapp.prompt_intro') }}</p>
                </div>
            </div>

            <!-- Quick Inquiry Prompt Pills -->
            <div class="space-y-1.5 pt-0.5">
                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 px-0.5">{{ $isRtl ? 'الموضوعات المقترحة' : 'Suggested Topics' }}</p>
                @foreach($promptOptions as $option)
                    <button type="button" 
                            @click="startChat('{{ addslashes($option['text']) }}')"
                            :disabled="isSending"
                            class="w-full text-start p-2 rounded-lg bg-white dark:bg-slate-900/90 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 hover:border-emerald-500/40 transition group flex items-center justify-between text-xs gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="text-sm flex-shrink-0">{{ $option['icon'] }}</span>
                            <span class="font-medium text-slate-700 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-300 truncate text-[11px] transition">{{ $option['title'] }}</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 rtl:rotate-180 group-hover:translate-x-0.5 rtl:group-hover:-translate-x-0.5 transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Custom Message Input Box -->
        <div class="p-2.5 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
            <form @submit.prevent="startChat(customMessage)" class="flex items-center gap-1.5">
                <input type="text" 
                       x-model="customMessage" 
                       placeholder="{{ $isRtl ? 'اكتب استفسارك الاستراتيجي...' : 'Type your strategic inquiry...' }}" 
                       :disabled="isSending"
                       class="flex-1 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-lg px-2.5 py-1.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                <button type="submit" 
                        :disabled="isSending"
                        class="p-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white transition disabled:opacity-50 shadow-md shadow-emerald-600/30 flex items-center justify-center flex-shrink-0"
                        aria-label="{{ __('ui.buttons.submit') }}">
                    <svg x-show="!isSending" class="w-3.5 h-3.5 fill-none rtl:rotate-180" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <svg x-show="isSending" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
            <div class="mt-1 text-center text-[9px] text-slate-500 dark:text-slate-400">
                {{ $isRtl ? '🔒 تواصل مباشر وآمن عبر قناة واتساب المؤسسية الرسمية' : '🔒 Privacy-First Communication via Official WhatsApp Channel' }}
            </div>
        </div>
    </div>

    <!-- Floating Trigger Button -->
    <div class="relative group">
        <!-- Floating Prompt Badge on Hover -->
        <div x-show="!isOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-x-2 rtl:-translate-x-2"
             x-transition:enter-end="opacity-100 translate-x-0"
             class="hidden md:flex absolute {{ $isRtl ? 'left-14' : 'right-14' }} top-2 items-center pointer-events-none opacity-0 group-hover:opacity-100 transition duration-200 whitespace-nowrap bg-slate-900 text-white text-xs font-semibold px-2.5 py-1 rounded-lg border border-slate-700 shadow-xl">
            <span>{{ __('frontend.whatsapp.direct_channel') }}</span>
            <div class="w-2 h-2 bg-slate-900 border-t {{ $isRtl ? 'border-l -left-1' : 'border-r -right-1' }} border-slate-700 transform rotate-45 absolute"></div>
        </div>

        <button type="button" 
                @click="isOpen = !isOpen" 
                class="h-12 w-12 sm:h-13 sm:w-13 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white shadow-xl shadow-emerald-600/30 dark:shadow-emerald-950/80 flex items-center justify-center transition transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 relative"
                aria-label="{{ __('frontend.whatsapp.floating_button_tooltip') }}">
            
            <!-- Pulse Glow Ring -->
            <span class="absolute -inset-1 rounded-full bg-emerald-500/30 animate-ping opacity-60 pointer-events-none"></span>

            <!-- WhatsApp Icon -->
            <svg x-show="!isOpen" class="w-6 h-6 fill-current relative z-10" viewBox="0 0 24 24">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.27-2.42 5.83s-3.63 2.42-5.82 2.42c-1.42 0-2.82-.37-4.06-1.07l-.29-.17-3.02.79.81-2.94-.19-.3A8.216 8.216 0 013.8 11.91c0-4.54 3.7-8.24 8.25-8.24zm4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.49-1.4-1.74-.15-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43l-.48-.01c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08s.89 2.41 1.01 2.58c.13.17 1.76 2.68 4.26 3.76.59.26 1.06.41 1.42.53.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.17-.48-.29z"/>
            </svg>

            <!-- Close (X) Icon -->
            <svg x-show="isOpen" x-cloak class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
