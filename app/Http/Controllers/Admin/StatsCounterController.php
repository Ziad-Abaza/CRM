<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\StatsCounter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatsCounterController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $query = StatsCounter::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                    ->orWhere('value', 'like', "%{$search}%")
                    ->orWhere('suffix', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === '1' || $status === 'true');
        }

        $stats = $query->orderBy('order')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.stats.index', compact('stats', 'search', 'status'));
    }

    public function create(): View
    {
        return view('admin.stats.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:50'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $stat = StatsCounter::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_stats_counter',
            'auditable_type' => StatsCounter::class,
            'auditable_id' => $stat->id,
            'new_values' => $stat->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.stats.index')->with('success', 'Metric counter created successfully.');
    }

    public function edit(StatsCounter $stat): View
    {
        return view('admin.stats.edit', compact('stat'));
    }

    public function update(Request $request, StatsCounter $stat): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:50'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldValues = $stat->toArray();

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $stat->order;

        $stat->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_stats_counter',
            'auditable_type' => StatsCounter::class,
            'auditable_id' => $stat->id,
            'old_values' => $oldValues,
            'new_values' => $stat->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.stats.index')->with('success', 'Metric counter updated successfully.');
    }

    public function destroy(Request $request, StatsCounter $stat): RedirectResponse
    {
        $oldValues = $stat->toArray();
        $id = $stat->id;
        $stat->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_stats_counter',
            'auditable_type' => StatsCounter::class,
            'auditable_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.stats.index')->with('success', 'Metric counter deleted successfully.');
    }

    public function toggle(Request $request, StatsCounter $stat): JsonResponse|RedirectResponse
    {
        $oldStatus = $stat->is_active;
        $stat->is_active = !$oldStatus;
        $stat->save();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'toggle_stats_counter_status',
            'auditable_type' => StatsCounter::class,
            'auditable_id' => $stat->id,
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $stat->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $stat->is_active,
                'message' => 'Metric counter status updated.',
            ]);
        }

        return back()->with('success', 'Metric counter status updated successfully.');
    }
}
