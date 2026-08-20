<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $rating = $request->query('rating');
        $status = $request->query('status');

        $query = Testimonial::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('client_role', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($rating) {
            $query->where('rating', $rating);
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === '1' || $status === 'true');
        }

        $testimonials = $query->orderBy('order')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('admin.testimonials.index', compact('testimonials', 'search', 'rating', 'status'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_role' => ['nullable'],
            'company' => ['nullable'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'content' => ['required'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('testimonials', 'public');
            $validated['avatar'] = Storage::url($path);
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $testimonial = Testimonial::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_testimonial',
            'auditable_type' => Testimonial::class,
            'auditable_id' => $testimonial->id,
            'new_values' => $testimonial->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_role' => ['nullable'],
            'company' => ['nullable'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'content' => ['required'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $oldValues = $testimonial->toArray();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('testimonials', 'public');
            $validated['avatar'] = Storage::url($path);
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $testimonial->order;

        $testimonial->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_testimonial',
            'auditable_type' => Testimonial::class,
            'auditable_id' => $testimonial->id,
            'old_values' => $oldValues,
            'new_values' => $testimonial->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function destroy(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $oldValues = $testimonial->toArray();
        $id = $testimonial->id;
        $testimonial->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_testimonial',
            'auditable_type' => Testimonial::class,
            'auditable_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', __('admin.messages.deleted_successfully'));
    }

    public function toggle(Request $request, Testimonial $testimonial): JsonResponse|RedirectResponse
    {
        $oldStatus = $testimonial->is_active;
        $testimonial->is_active = !$oldStatus;
        $testimonial->save();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'toggle_testimonial_status',
            'auditable_type' => Testimonial::class,
            'auditable_id' => $testimonial->id,
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $testimonial->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $testimonial->is_active,
                'message' => __('admin.messages.saved_successfully'),
            ]);
        }

        return back()->with('success', __('admin.messages.saved_successfully'));
    }
}
