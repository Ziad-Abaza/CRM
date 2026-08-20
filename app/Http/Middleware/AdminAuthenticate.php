<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->guest(route('admin.login'));
        }

        $user = Auth::user();

        // Ensure user is active and has admin role
        if (!$user->is_active || !in_array($user->role, ['admin', 'super_admin'], true)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized access. Active administrator role required.'], 403);
            }

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your account does not have active administrative access.',
            ]);
        }

        return $next($request);
    }
}
