<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\WhatsAppLeadClick;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display executive CRM overview and analytics dashboard.
     */
    public function index(Request $request): View
    {
        $metrics = [
            'services_count' => Service::count(),
            'portfolio_count' => Portfolio::count(),
            'testimonials_count' => Testimonial::count(),
            'faqs_count' => Faq::count(),
            'pricing_plans_count' => PricingPlan::count(),
            'total_whatsapp_clicks' => WhatsAppLeadClick::count(),
            'today_whatsapp_clicks' => WhatsAppLeadClick::whereDate('created_at', today())->count(),
            'weekly_whatsapp_clicks' => WhatsAppLeadClick::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Recent WhatsApp Lead conversions
        $recentClicks = WhatsAppLeadClick::recent()
            ->limit(8)
            ->get();

        // Lead distribution by button / CTA location
        $clicksByLocation = WhatsAppLeadClick::selectRaw('button_location, count(*) as total')
            ->groupBy('button_location')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Recent administrative audit logs
        $recentAuditLogs = AuditLog::with('user')
            ->recent()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('metrics', 'recentClicks', 'clicksByLocation', 'recentAuditLogs'));
    }
}
