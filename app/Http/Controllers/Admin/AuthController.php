<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Show admin login view.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'], true) && Auth::user()->is_active) {
            return redirect()->route('admin.dashboard');
        }

        $companyName = $this->settingService->get('company_name', config('app.name', 'CRM Corporate'));
        $companyLogo = $this->settingService->get('company_logo', null);

        return view('admin.auth.login', compact('companyName', 'companyLogo'));
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        // Enterprise rate limiting: 5 attempts per minute
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            AuditLog::create([
                'user_id' => null,
                'action' => 'auth.login.throttled',
                'auditable_type' => null,
                'auditable_id' => null,
                'old_values' => null,
                'new_values' => [
                    'email' => $request->input('email'),
                    'retry_after_seconds' => $seconds,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (!$user->is_active || !in_array($user->role, ['admin', 'super_admin'], true)) {
                Auth::logout();
                RateLimiter::hit($throttleKey, 60);

                AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'auth.login.denied_role_or_inactive',
                    'auditable_type' => get_class($user),
                    'auditable_id' => $user->id,
                    'old_values' => null,
                    'new_values' => ['role' => $user->role, 'is_active' => $user->is_active],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                throw ValidationException::withMessages([
                    'email' => 'Your account does not have active administrative access.',
                ]);
            }

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'auth.login.success',
                'auditable_type' => get_class($user),
                'auditable_id' => $user->id,
                'old_values' => null,
                'new_values' => ['role' => $user->role, 'email' => $user->email],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey, 60);

        AuditLog::create([
            'user_id' => null,
            'action' => 'auth.login.failed',
            'auditable_type' => null,
            'auditable_id' => null,
            'old_values' => null,
            'new_values' => ['email' => $request->input('email')],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'auth.logout',
                'auditable_type' => get_class($user),
                'auditable_id' => $user->id,
                'old_values' => null,
                'new_values' => ['email' => $user->email],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been logged out successfully.');
    }
}
