<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $status = $request->query('status');

        $query = Faq::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === '1' || $status === 'true');
        }

        $faqs = $query->orderBy('order')->orderBy('id')->paginate(15)->withQueryString();
        $categories = Faq::whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category');

        return view('admin.faqs.index', compact('faqs', 'categories', 'search', 'category', 'status'));
    }

    public function create(): View
    {
        $categories = Faq::whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category');
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required'],
            'answer' => ['required'],
            'category' => ['nullable'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $faq = Faq::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_faq',
            'auditable_type' => Faq::class,
            'auditable_id' => $faq->id,
            'new_values' => $faq->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function edit(Faq $faq): View
    {
        $categories = Faq::whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category');
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required'],
            'answer' => ['required'],
            'category' => ['nullable'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldValues = $faq->toArray();

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $faq->order;

        $faq->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_faq',
            'auditable_type' => Faq::class,
            'auditable_id' => $faq->id,
            'old_values' => $oldValues,
            'new_values' => $faq->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', __('admin.messages.saved_successfully'));
    }

    public function destroy(Request $request, Faq $faq): RedirectResponse
    {
        $oldValues = $faq->toArray();
        $id = $faq->id;
        $faq->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_faq',
            'auditable_type' => Faq::class,
            'auditable_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', __('admin.messages.deleted_successfully'));
    }

    public function toggle(Request $request, Faq $faq): JsonResponse|RedirectResponse
    {
        $oldStatus = $faq->is_active;
        $faq->is_active = !$oldStatus;
        $faq->save();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'toggle_faq_status',
            'auditable_type' => Faq::class,
            'auditable_id' => $faq->id,
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $faq->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $faq->is_active,
                'message' => __('admin.messages.saved_successfully'),
            ]);
        }

        return back()->with('success', __('admin.messages.saved_successfully'));
    }
}
