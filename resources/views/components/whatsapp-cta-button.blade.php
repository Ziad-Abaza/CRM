@props([
    'text' => null,
    'buttonLocation' => 'general_cta',
    'location' => null,
    'message' => null,
    'prefilledMessage' => null,
    'variant' => 'emerald',
    'size' => 'md',
    'icon' => true,
    'class' => '',
])

@php
    $text = $text ?? __('frontend.hero.consult_cta');
    $finalLocation = $location ?? $buttonLocation;
    $finalMessage = $message ?? $prefilledMessage ?? setting('whatsapp_default_message', __('frontend.whatsapp.default_message'));
    
    // Style Variants with Light & Dark support
    $variantClasses = match ($variant) {
        'primary' => 'bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-600/30 border border-blue-500/30',
        'secondary' => 'bg-slate-200 hover:bg-slate-300 text-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-100 shadow-sm border border-slate-300 dark:border-slate-700',
        'emerald' => 'bg-emerald-600 hover:bg-emerald-500 text-white shadow-md shadow-emerald-600/30 border border-emerald-500/30',
        'outline' => 'bg-transparent hover:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/40 hover:border-emerald-500',
        'dark' => 'bg-slate-900 hover:bg-slate-800 text-white dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 border border-slate-700 dark:border-slate-700/80 shadow-sm',
        default => 'bg-emerald-600 hover:bg-emerald-500 text-white shadow-md shadow-emerald-600/30 border border-emerald-500/30',
    };

    // Responsive Sizes
    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs rounded-lg gap-1.5 font-medium',
        'lg' => 'px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm md:text-base rounded-xl gap-2 sm:gap-2.5 font-bold',
        default => 'px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm rounded-xl gap-2 font-semibold',
    };

    $iconSize = match ($size) {
        'sm' => 'w-3.5 h-3.5',
        'lg' => 'w-4 h-4 sm:w-4.5 sm:h-4.5',
        default => 'w-3.5 h-3.5 sm:w-4 sm:h-4',
    };
@endphp

<button type="button"
        x-data="{
            isLogging: false,
            async handleClick() {
                this.isLogging = true;
                const msg = '{{ addslashes($finalMessage) }}';
                const loc = '{{ addslashes($finalLocation) }}';
                
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
                            button_location: loc,
                            prefilled_message: msg,
                            referrer: document.referrer || null
                        })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        if (data.whatsapp_url) {
                            window.open(data.whatsapp_url, '_blank', 'noopener,noreferrer');
                        } else {
                            this.doFallback(loc, msg);
                        }
                    } else {
                        this.doFallback(loc, msg);
                    }
                } catch (e) {
                    this.doFallback(loc, msg);
                } finally {
                    this.isLogging = false;
                }
            },
            doFallback(loc, msg) {
                const encoded = encodeURIComponent(msg);
                const locEncoded = encodeURIComponent(loc);
                const url = '{{ route('whatsapp.redirect') }}?button_location=' + locEncoded + '&message=' + encoded;
                window.open(url, '_blank', 'noopener,noreferrer');
            }
        }"
        @click="handleClick()"
        :disabled="isLogging"
        {{ $attributes->merge(['class' => "inline-flex items-center justify-center transition transform active:scale-95 disabled:opacity-75 cursor-pointer {$variantClasses} {$sizeClasses} {$class}"]) }}>
    
    @if($icon)
        <svg class="{{ $iconSize }} flex-shrink-0 fill-current" viewBox="0 0 24 24">
            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.27-2.42 5.83s-3.63 2.42-5.82 2.42c-1.42 0-2.82-.37-4.06-1.07l-.29-.17-3.02.79.81-2.94-.19-.3A8.216 8.216 0 013.8 11.91c0-4.54 3.7-8.24 8.25-8.24zm4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.49-1.4-1.74-.15-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43l-.48-.01c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08s.89 2.41 1.01 2.58c.13.17 1.76 2.68 4.26 3.76.59.26 1.06.41 1.42.53.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.17-.48-.29z"/>
        </svg>
    @endif

    <span class="truncate">{{ trim((string)$slot) !== '' ? $slot : $text }}</span>
</button>
