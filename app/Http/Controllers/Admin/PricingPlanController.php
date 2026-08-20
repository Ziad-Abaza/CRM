<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\PricingPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PricingPlanController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $query = PricingPlan::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('currency', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === '1' || $status === 'true');
        }

        $plans = $query->orderBy('order')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.pricing.index', compact('plans', 'search', 'status'));
    }

    public function create(): View
    {
        return view('admin.pricing.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pricing_plans,slug'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'billing_period' => ['required'],
            'description' => ['nullable'],
            'features' => ['nullable'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'whatsapp_message' => ['nullable'],
        ]);

        if (empty($validated['slug'])) {
            $nameValue = is_array($validated['name']) ? ($validated['name']['en'] ?? reset($validated['name'])) : $validated['name'];
            $validated['slug'] = Str::slug($nameValue ?: 'plan');
            $baseSlug = $validated['slug'];
            $count = PricingPlan::where('slug', 'like', $baseSlug . '%')->count();
            if ($count > 0) {
                $validated['slug'] = $baseSlug . '-' . ($count + 1);
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if (is_array($validated['features'] ?? null)) {
            if (isset($validated['features']['en']) || isset($validated['features']['ar'])) {
                $validated['features'] = [
                    'en' => array_values(array_filter((array) ($validated['features']['en'] ?? []))),
                    'ar' => array_values(array_filter((array) ($validated['features']['ar'] ?? []))),
                ];
            } else {
                $validated['features'] = array_values(array_filter($validated['features']));
            }
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $plan = PricingPlan::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_pricing_plan',
            'auditable_type' => PricingPlan::class,
            'auditable_id' => $plan->id,
            'new_values' => $plan->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.pricing.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function edit(PricingPlan $pricing): View
    {
        return view('admin.pricing.edit', ['plan' => $pricing]);
    }

    public function update(Request $request, PricingPlan $pricing): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('pricing_plans', 'slug')->ignore($pricing->id)],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'billing_period' => ['required'],
            'description' => ['nullable'],
            'features' => ['nullable'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'whatsapp_message' => ['nullable'],
        ]);

        $oldValues = $pricing->toArray();

        if (empty($validated['slug'])) {
            $nameValue = is_array($validated['name']) ? ($validated['name']['en'] ?? reset($validated['name'])) : $validated['name'];
            $validated['slug'] = Str::slug($nameValue ?: 'plan');
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if (is_array($validated['features'] ?? null)) {
            if (isset($validated['features']['en']) || isset($validated['features']['ar'])) {
                $validated['features'] = [
                    'en' => array_values(array_filter((array) ($validated['features']['en'] ?? []))),
                    'ar' => array_values(array_filter((array) ($validated['features']['ar'] ?? []))),
                ];
            } else {
                $validated['features'] = array_values(array_filter($validated['features']));
            }
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $pricing->order;

        $pricing->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_pricing_plan',
            'auditable_type' => PricingPlan::class,
            'auditable_id' => $pricing->id,
            'old_values' => $oldValues,
            'new_values' => $pricing->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.pricing.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function destroy(Request $request, PricingPlan $pricing): RedirectResponse
    {
        $oldValues = $pricing->toArray();
        $id = $pricing->id;
        $pricing->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_pricing_plan',
            'auditable_type' => PricingPlan::class,
            'auditable_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.pricing.index')->with('success', __('admin.messages.deleted_successfully'));
    }

    public function toggle(Request $request, PricingPlan $pricing): JsonResponse|RedirectResponse
    {
        $oldStatus = $pricing->is_active;
        $pricing->is_active = !$oldStatus;
        $pricing->save();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'toggle_pricing_plan_status',
            'auditable_type' => PricingPlan::class,
            'auditable_id' => $pricing->id,
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $pricing->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $pricing->is_active,
                'message' => __('admin.messages.saved_successfully'),
            ]);
        }

        return back()->with('success', __('admin.messages.saved_successfully'));
    }
}
