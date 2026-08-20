<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Standard OWASP / enterprise HTTP security headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Content-Security-Policy (supports production and local Vite dev server)
        $csp = "default-src 'self' http: https: data: blob:; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' http: https:; " .
               "style-src 'self' 'unsafe-inline' http: https:; " .
               "img-src 'self' data: blob: http: https:; " .
               "font-src 'self' data: http: https:; " .
               "connect-src 'self' http: https: ws: wss:; " .
               "frame-ancestors 'self'; " .
               "base-uri 'self'; " .
               "form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
