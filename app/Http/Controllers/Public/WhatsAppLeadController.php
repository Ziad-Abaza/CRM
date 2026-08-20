<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppLeadClick;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WhatsAppLeadController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    /**
     * Asynchronously track a WhatsApp lead click via POST JSON API.
     */
    public function trackClick(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'source_page' => ['nullable', 'string', 'max:255'],
            'button_location' => ['nullable', 'string', 'max:255'],
            'prefilled_message' => ['nullable', 'string', 'max:2000'],
            'referrer' => ['nullable', 'string', 'max:500'],
            'country' => ['nullable', 'string', 'max:10'],
        ]);

        $message = !empty($validated['prefilled_message'])
            ? $validated['prefilled_message']
            : $this->settingService->get('whatsapp_default_message', 'Hello, I would like to inquire about your corporate services.');

        $lead = WhatsAppLeadClick::create([
            'source_page' => $validated['source_page'] ?? ($request->header('referer') ? parse_url($request->header('referer'), PHP_URL_PATH) : '/'),
            'button_location' => $validated['button_location'] ?? 'general_cta',
            'prefilled_message' => $message,
            'ip_address' => $this->anonymizeIp($request->ip()),
            'user_agent' => Str::limit($request->userAgent() ?? '', 500, ''),
            'referrer' => Str::limit($validated['referrer'] ?? ($request->header('referer') ?? ''), 500, ''),
            'country' => $validated['country'] ?? null,
        ]);

        $whatsappUrl = $this->buildWhatsAppUrl($message);

        return response()->json([
            'success' => true,
            'lead_id' => $lead->id,
            'whatsapp_url' => $whatsappUrl,
        ]);
    }

    /**
     * Log click and directly redirect to WhatsApp via GET.
     */
    public function redirect(Request $request): RedirectResponse
    {
        $message = $request->query('message') 
            ?? $request->query('prefilled_message') 
            ?? $this->settingService->get('whatsapp_default_message', 'Hello, I would like to inquire about your corporate services.');

        $buttonLocation = $request->query('button_location') 
            ?? $request->query('location') 
            ?? 'direct_redirect';

        $sourcePage = $request->query('source_page') 
            ?? ($request->header('referer') ? parse_url($request->header('referer'), PHP_URL_PATH) : '/');

        WhatsAppLeadClick::create([
            'source_page' => Str::limit($sourcePage, 255, ''),
            'button_location' => Str::limit($buttonLocation, 255, ''),
            'prefilled_message' => Str::limit($message, 2000, ''),
            'ip_address' => $this->anonymizeIp($request->ip()),
            'user_agent' => Str::limit($request->userAgent() ?? '', 500, ''),
            'referrer' => Str::limit($request->header('referer') ?? '', 500, ''),
            'country' => $request->query('country'),
        ]);

        $whatsappUrl = $this->buildWhatsAppUrl($message);

        return redirect()->away($whatsappUrl);
    }

    /**
     * Build the standard WhatsApp click-to-chat URL.
     */
    public function buildWhatsAppUrl(?string $message = null): string
    {
        $phoneSetting = $this->settingService->get('whatsapp_number', '+15550192834');
        $cleanPhone = preg_replace('/[^0-9]/', '', (string) $phoneSetting);

        if (empty($cleanPhone)) {
            $cleanPhone = '15550192834';
        }

        $message = $message ?: $this->settingService->get('whatsapp_default_message', 'Hello!');

        return 'https://wa.me/' . $cleanPhone . '?text=' . rawurlencode($message);
    }

    /**
     * Anonymize IP address for privacy compliance (IPv4 /24 mask, IPv6 /48 mask).
     */
    protected function anonymizeIp(?string $ip): ?string
    {
        if (empty($ip)) {
            return null;
        }

        $packed = @inet_pton($ip);
        if ($packed === false) {
            return null;
        }

        if (strlen($packed) === 4) {
            // IPv4: Zero out last octet (/24)
            $mask = inet_pton('255.255.255.0');
            return inet_ntop($packed & $mask);
        }

        if (strlen($packed) === 16) {
            // IPv6: Zero out last 80 bits (/48)
            $mask = inet_pton('ffff:ffff:ffff::');
            return inet_ntop($packed & $mask);
        }

        return null;
    }
}
