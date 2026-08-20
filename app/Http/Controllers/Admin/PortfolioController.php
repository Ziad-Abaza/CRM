<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');

        $query = Portfolio::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === '1' || $status === 'true');
        }

        $portfolios = $query->orderBy('order')->orderBy('id', 'desc')->paginate(15)->withQueryString();
        $categories = PortfolioCategory::orderBy('name')->get();

        return view('admin.portfolio.index', compact('portfolios', 'categories', 'search', 'categoryId', 'status'));
    }

    public function create(): View
    {
        $categories = PortfolioCategory::orderBy('name')->get();
        return view('admin.portfolio.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:portfolio_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:portfolios,slug'],
            'client' => ['nullable', 'string', 'max:255'],
            'completion_date' => ['nullable', 'date'],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['nullable', 'string', 'max:100'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = Portfolio::where('slug', 'like', $validated['slug'] . '%')->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = Storage::url($path);
        }

        $validated['technologies'] = !empty($validated['technologies']) ? array_values(array_filter($validated['technologies'])) : [];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $portfolio = Portfolio::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_portfolio',
            'auditable_type' => Portfolio::class,
            'auditable_id' => $portfolio->id,
            'new_values' => $portfolio->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.portfolio.index')->with('success', 'Case study created successfully.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $categories = PortfolioCategory::orderBy('name')->get();
        return view('admin.portfolio.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:portfolio_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('portfolios', 'slug')->ignore($portfolio->id)],
            'client' => ['nullable', 'string', 'max:255'],
            'completion_date' => ['nullable', 'date'],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['nullable', 'string', 'max:100'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $oldValues = $portfolio->toArray();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = Storage::url($path);
        }

        $validated['technologies'] = !empty($validated['technologies']) ? array_values(array_filter($validated['technologies'])) : [];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $portfolio->order;

        $portfolio->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_portfolio',
            'auditable_type' => Portfolio::class,
            'auditable_id' => $portfolio->id,
            'old_values' => $oldValues,
            'new_values' => $portfolio->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.portfolio.index')->with('success', 'Case study updated successfully.');
    }

    public function destroy(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $oldValues = $portfolio->toArray();
        $id = $portfolio->id;
        $portfolio->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_portfolio',
            'auditable_type' => Portfolio::class,
            'auditable_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.portfolio.index')->with('success', 'Case study deleted successfully.');
    }

    public function toggle(Request $request, Portfolio $portfolio): JsonResponse|RedirectResponse
    {
        $oldStatus = $portfolio->is_active;
        $portfolio->is_active = !$oldStatus;
        $portfolio->save();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'toggle_portfolio_status',
            'auditable_type' => Portfolio::class,
            'auditable_id' => $portfolio->id,
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $portfolio->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $portfolio->is_active,
                'message' => 'Portfolio status updated.',
            ]);
        }

        return back()->with('success', 'Portfolio status updated successfully.');
    }

    // Category sub-management
    public function categories(): View
    {
        $categories = PortfolioCategory::withCount('portfolios')->orderBy('order')->orderBy('name')->paginate(15);
        return view('admin.portfolio.categories', compact('categories'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:portfolio_categories,slug'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            $count = PortfolioCategory::where('slug', 'like', $validated['slug'] . '%')->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        $category = PortfolioCategory::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_portfolio_category',
            'auditable_type' => PortfolioCategory::class,
            'auditable_id' => $category->id,
            'new_values' => $category->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.portfolio.categories')->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, PortfolioCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('portfolio_categories', 'slug')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldValues = $category->toArray();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['order'] = $validated['order'] ?? $category->order;
        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_portfolio_category',
            'auditable_type' => PortfolioCategory::class,
            'auditable_id' => $category->id,
            'old_values' => $oldValues,
            'new_values' => $category->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.portfolio.categories')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(Request $request, PortfolioCategory $category): RedirectResponse
    {
        $oldValues = $category->toArray();
        $id = $category->id;
        $category->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_portfolio_category',
            'auditable_type' => PortfolioCategory::class,
            'auditable_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.portfolio.categories')->with('success', 'Category deleted successfully.');
    }
}
