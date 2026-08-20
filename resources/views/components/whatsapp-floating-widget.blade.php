@props([
    'companyName' => null,
    'avatar' => null,
    'defaultMessage' => null,
    'promptOptions' => null,
])

@php
    $companyName = $companyName ?? setting('site_name', 'Apex Corporate Solutions');
    $avatar = $avatar ?? setting('company_logo');
    $defaultMessage = $defaultMessage ?? setting('whatsapp_default_message', 'Hello, I would like to schedule an executive strategy session.');
    
    $promptOptions = $promptOptions ?? [
        [
            'icon' => '💼',
            'title' => 'Executive Strategy Session',
            'text' => 'Hello Apex team, I would like to request an executive corporate strategy consultation.'
        ],
        [
            'icon' => '📊',
            'title' => 'M&A & Operational Due Diligence',
            'text' => 'Hi, I need strategic advisory regarding M&A technology audit and due diligence.'
        ],
        [
            'icon' => '🛡️',
            'title' => 'SOC 2 & Compliance Governance',
            'text' => 'Hello, I would like to discuss our enterprise SOC 2 and risk compliance roadmap.'
        ],
        [
            'icon' => '⚡',
            'title' => 'Workflow & AI Automation',
            'text' => 'Hi Apex team, I want to explore automated executive RPA and workflow transformation.'
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
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end"
    @keydown.escape.window="isOpen = false">

    <!-- Floating Chat Card (Expanded) -->
    <div x-show="isOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
         x-transition:enter-start="opacity-0 translate-y-6 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-90"
         @click.outside="isOpen = false"
         class="mb-4 w-[340px] sm:w-[380px] rounded-3xl bg-slate-900 border border-slate-700/80 shadow-2xl shadow-slate-950/90 overflow-hidden flex flex-col backdrop-blur-xl">

        <!-- Card Header -->
        <div class="px-5 py-4 bg-gradient-to-r from-emerald-700 to-teal-800 text-white flex items-center justify-between relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            
            <div class="flex items-center gap-3 relative z-10">
                <div class="relative">
                    @if($avatar)
                        <img src="{{ $avatar }}" alt="{{ $companyName }}" class="h-10 w-10 rounded-full object-cover border-2 border-white/30 bg-slate-950">
                    @else
                        <div class="h-10 w-10 rounded-full bg-slate-900 border-2 border-white/30 flex items-center justify-center font-bold text-sm text-emerald-400">
                            {{ substr($companyName, 0, 2) }}
                        </div>
                    @endif
                    <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-emerald-400 border-2 border-slate-900"></span>
                </div>
                <div>
                    <h3 class="font-bold text-sm leading-tight text-white">{{ $companyName }}</h3>
                    <p class="text-[11px] text-emerald-100 font-medium flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        Direct Partner WhatsApp Channel
                    </p>
                </div>
            </div>

            <button type="button" 
                    @click="isOpen = false" 
                    class="relative z-10 p-1.5 rounded-full text-emerald-100 hover:text-white hover:bg-white/10 transition"
                    aria-label="Close Chat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Chat Body & Prompt Options -->
        <div class="p-4 space-y-4 max-h-[380px] overflow-y-auto bg-slate-950/60">
            <!-- Automated Welcome Bubble -->
            <div class="flex items-start gap-2.5">
                <div class="h-7 w-7 rounded-full bg-emerald-600/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-xs font-bold flex-shrink-0 mt-1">
                    ⚡
                </div>
                <div class="p-3.5 rounded-2xl rounded-tl-sm bg-slate-800 border border-slate-700/80 text-xs text-slate-200 leading-relaxed shadow-sm">
                    <p class="font-semibold text-white mb-1">Welcome to executive advisory.</p>
                    <p class="text-slate-300">Choose an initiative below or send a custom inquiry to connect with our managing team on WhatsApp:</p>
                </div>
            </div>

            <!-- Quick Inquiry Prompt Pills -->
            <div class="space-y-2 pt-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-1">Quick Select Topic</p>
                @foreach($promptOptions as $option)
                    <button type="button" 
                            @click="startChat('{{ addslashes($option['text']) }}')"
                            :disabled="isSending"
                            class="w-full text-left p-2.5 rounded-xl bg-slate-900/90 hover:bg-slate-800 border border-slate-800 hover:border-emerald-500/40 transition group flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="text-base flex-shrink-0">{{ $option['icon'] }}</span>
                            <span class="font-medium text-slate-200 group-hover:text-emerald-300 truncate transition">{{ $option['title'] }}</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-400 group-hover:translate-x-0.5 transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Custom Message Input Box -->
        <div class="p-3 bg-slate-900 border-t border-slate-800">
            <form @submit.prevent="startChat(customMessage)" class="flex items-center gap-2">
                <input type="text" 
                       x-model="customMessage" 
                       placeholder="Type your strategic inquiry..." 
                       :disabled="isSending"
                       class="flex-1 bg-slate-950 border border-slate-700/80 rounded-xl px-3 py-2 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                <button type="submit" 
                        :disabled="isSending"
                        class="p-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white transition disabled:opacity-50 shadow-md shadow-emerald-600/30 flex items-center justify-center">
                    <svg x-show="!isSending" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <svg x-show="isSending" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
            <div class="mt-2 text-center text-[10px] text-slate-400">
                🔒 Privacy-First Communication via Official WhatsApp Channel
            </div>
        </div>
    </div>

    <!-- Floating Trigger Button -->
    <div class="relative group">
        <!-- Floating Prompt Badge on Hover -->
        <div x-show="!isOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-x-2"
             x-transition:enter-end="opacity-100 translate-x-0"
             class="hidden md:flex absolute right-16 top-2 items-center pointer-events-none opacity-0 group-hover:opacity-100 transition duration-200 whitespace-nowrap bg-slate-900 text-white text-xs font-semibold px-3 py-1.5 rounded-xl border border-slate-700 shadow-xl">
            <span>Direct WhatsApp Channel</span>
            <div class="w-2 h-2 bg-slate-900 border-t border-r border-slate-700 transform rotate-45 absolute -right-1"></div>
        </div>

        <button type="button" 
                @click="isOpen = !isOpen" 
                class="h-14 w-14 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white shadow-xl shadow-emerald-950/80 flex items-center justify-center transition transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 relative"
                aria-label="Open WhatsApp Chat">
            
            <!-- Pulse Glow Ring -->
            <span class="absolute -inset-1 rounded-full bg-emerald-500/30 animate-ping opacity-60 pointer-events-none"></span>

            <!-- WhatsApp Icon -->
            <svg x-show="!isOpen" class="w-7 h-7 fill-current relative z-10" viewBox="0 0 24 24">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.27-2.42 5.83s-3.63 2.42-5.82 2.42c-1.42 0-2.82-.37-4.06-1.07l-.29-.17-3.02.79.81-2.94-.19-.3A8.216 8.216 0 013.8 11.91c0-4.54 3.7-8.24 8.25-8.24zm4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.49-1.4-1.74-.15-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43l-.48-.01c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08s.89 2.41 1.01 2.58c.13.17 1.76 2.68 4.26 3.76.59.26 1.06.41 1.42.53.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.17-.48-.29z"/>
            </svg>

            <!-- Close (X) Icon -->
            <svg x-show="isOpen" x-cloak class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
