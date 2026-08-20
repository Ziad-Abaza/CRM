<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $query = TeamMember::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('is_active', $status === '1' || $status === 'true');
        }

        $members = $query->orderBy('order')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.team.index', compact('members', 'search', 'status'));
    }

    public function create(): View
    {
        return view('admin.team.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'social_links' => ['nullable', 'array'],
            'social_links.*' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = Storage::url($path);
        }

        $validated['social_links'] = !empty($validated['social_links']) ? array_filter($validated['social_links']) : [];
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        $member = TeamMember::create($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'create_team_member',
            'auditable_type' => TeamMember::class,
            'auditable_id' => $member->id,
            'new_values' => $member->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Executive profile created successfully.');
    }

    public function edit(TeamMember $team): View
    {
        return view('admin.team.edit', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'social_links' => ['nullable', 'array'],
            'social_links.*' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldValues = $team->toArray();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('team', 'public');
            $validated['photo'] = Storage::url($path);
        }

        $validated['social_links'] = !empty($validated['social_links']) ? array_filter($validated['social_links']) : [];
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $team->order;

        $team->update($validated);

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'update_team_member',
            'auditable_type' => TeamMember::class,
            'auditable_id' => $team->id,
            'old_values' => $oldValues,
            'new_values' => $team->fresh()->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Executive profile updated successfully.');
    }

    public function destroy(Request $request, TeamMember $team): RedirectResponse
    {
        $oldValues = $team->toArray();
        $id = $team->id;
        $team->delete();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'delete_team_member',
            'auditable_type' => TeamMember::class,
            'auditable_id' => $id,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Executive profile deleted successfully.');
    }

    public function toggle(Request $request, TeamMember $team): JsonResponse|RedirectResponse
    {
        $oldStatus = $team->is_active;
        $team->is_active = !$oldStatus;
        $team->save();

        AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => 'toggle_team_member_status',
            'auditable_type' => TeamMember::class,
            'auditable_id' => $team->id,
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $team->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $team->is_active,
                'message' => 'Team member status updated.',
            ]);
        }

        return back()->with('success', 'Team member status updated successfully.');
    }
}
