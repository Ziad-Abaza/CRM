<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\WhatsAppLeadClick;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadAnalyticsController extends Controller
{
    /**
     * Display WhatsApp leads telemetry analytics and paginated log.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $location = $request->query('button_location');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        // Base query with filters for the paginated table
        $query = WhatsAppLeadClick::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('source_page', 'like', "%{$search}%")
                    ->orWhere('button_location', 'like', "%{$search}%")
                    ->orWhere('prefilled_message', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('referrer', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if (!empty($location)) {
            $query->where('button_location', $location);
        }

        if (!empty($dateFrom)) {
            $query->where('created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }

        if (!empty($dateTo)) {
            $query->where('created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        $leads = $query->orderByDesc('id')->paginate(15)->withQueryString();

        // Telemetry Statistics (Global overview)
        $totalClicks = WhatsAppLeadClick::count();
        $todayClicks = WhatsAppLeadClick::whereDate('created_at', Carbon::today())->count();
        $thisWeekClicks = WhatsAppLeadClick::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $thisMonthClicks = WhatsAppLeadClick::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Top converting button location
        $topSourceRow = WhatsAppLeadClick::select('button_location', DB::raw('count(*) as count'))
            ->groupBy('button_location')
            ->orderByDesc('count')
            ->first();

        // Breakdown by Button Location / Section
        $locationBreakdown = WhatsAppLeadClick::select('button_location', DB::raw('count(*) as count'))
            ->groupBy('button_location')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) use ($totalClicks) {
                $item->percentage = $totalClicks > 0 ? round(($item->count / $totalClicks) * 100, 1) : 0;
                return $item;
            });

        // 14-Day Daily Trend
        $startDate = Carbon::now()->subDays(13)->startOfDay();
        $dailyRaw = WhatsAppLeadClick::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as click_date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count', 'click_date')
            ->toArray();

        $dailyTrends = [];
        for ($i = 13; $i >= 0; $i--) {
            $dateKey = Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyTrends[$dateKey] = [
                'date' => Carbon::parse($dateKey)->format('M d'),
                'count' => $dailyRaw[$dateKey] ?? 0,
            ];
        }

        // Distinct button locations for dropdown filter
        $availableLocations = WhatsAppLeadClick::distinct()
            ->whereNotNull('button_location')
            ->pluck('button_location')
            ->sort()
            ->values();

        return view('admin.leads.index', compact(
            'leads',
            'search',
            'location',
            'dateFrom',
            'dateTo',
            'totalClicks',
            'todayClicks',
            'thisWeekClicks',
            'thisMonthClicks',
            'topSourceRow',
            'locationBreakdown',
            'dailyTrends',
            'availableLocations'
        ));
    }

    /**
     * Stream export of filtered leads data to CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $search = $request->query('search');
        $location = $request->query('button_location');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = WhatsAppLeadClick::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('source_page', 'like', "%{$search}%")
                    ->orWhere('button_location', 'like', "%{$search}%")
                    ->orWhere('prefilled_message', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('referrer', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if (!empty($location)) {
            $query->where('button_location', $location);
        }

        if (!empty($dateFrom)) {
            $query->where('created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }

        if (!empty($dateTo)) {
            $query->where('created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        $filename = 'whatsapp-leads-export-' . date('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Header Row
            fputcsv($handle, [
                'ID',
                'Timestamp (UTC)',
                'Source Page',
                'Button Location',
                'Prefilled Message',
                'IP Address (Anonymized)',
                'Referrer',
                'Country',
                'User Agent',
            ]);

            $query->orderByDesc('id')->chunk(500, function ($leads) use ($handle) {
                foreach ($leads as $lead) {
                    fputcsv($handle, [
                        $lead->id,
                        $lead->created_at?->format('Y-m-d H:i:s') ?? '',
                        $lead->source_page ?? '',
                        $lead->button_location ?? '',
                        $lead->prefilled_message ?? '',
                        $lead->ip_address ?? '',
                        $lead->referrer ?? '',
                        $lead->country ?? '',
                        $lead->user_agent ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    /**
     * Delete a lead telemetry record and log audit trail.
     */
    public function destroy(WhatsAppLeadClick $lead, Request $request): RedirectResponse
    {
        $oldValues = $lead->toArray();
        $leadId = $lead->id;

        $lead->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_whatsapp_lead_click',
            'auditable_type' => WhatsAppLeadClick::class,
            'auditable_id' => $leadId,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead telemetry record deleted successfully.');
    }
}
