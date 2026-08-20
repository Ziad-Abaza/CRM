<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $query = Service::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === '1' || $status === 'true');
        }

        $services = $query->orderBy('order')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('admin.services.index', compact('services', 'search', 'status'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'short_description' => ['nullable'],
            'description' => ['nullable'],
            'icon' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'features' => ['nullable'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['slug'])) {
            $titleValue = is_array($validated['title']) ? ($validated['title']['en'] ?? reset($validated['title'])) : $validated['title'];
            $validated['slug'] = Str::slug($titleValue ?: 'service');
            $baseSlug = $validated['slug'];
            $count = Service::where('slug', 'like', $baseSlug . '%')->count();
            if ($count > 0) {
                $validated['slug'] = $baseSlug . '-' . ($count + 1);
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = Storage::url($path);
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

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        $service = Service::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_service',
            'auditable_type' => Service::class,
            'auditable_id' => $service->id,
            'new_values' => $service->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.services.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('services', 'slug')->ignore($service->id)],
            'short_description' => ['nullable'],
            'description' => ['nullable'],
            'icon' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'features' => ['nullable'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldValues = $service->toArray();

        if (empty($validated['slug'])) {
            $titleValue = is_array($validated['title']) ? ($validated['title']['en'] ?? reset($validated['title'])) : $validated['title'];
            $validated['slug'] = Str::slug($titleValue ?: 'service');
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = Storage::url($path);
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

        $validated['order'] = $validated['order'] ?? $service->order;
        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_service',
            'auditable_type' => Service::class,
            'auditable_id' => $service->id,
            'old_values' => $oldValues,
            'new_values' => $service->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.services.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $oldValues = $service->toArray();
        $serviceId = $service->id;
        $service->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_service',
            'auditable_type' => Service::class,
            'auditable_id' => $serviceId,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.services.index')->with('success', __('admin.messages.deleted_successfully'));
    }

    public function toggle(Request $request, Service $service): JsonResponse|RedirectResponse
    {
        $oldStatus = $service->is_active;
        $service->is_active = !$oldStatus;
        $service->save();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'toggle_service_status',
            'auditable_type' => Service::class,
            'auditable_id' => $service->id,
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $service->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $service->is_active,
                'message' => __('admin.messages.saved_successfully'),
            ]);
        }

        return back()->with('success', __('admin.messages.saved_successfully'));
    }
}
