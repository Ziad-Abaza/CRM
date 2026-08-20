<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported = array_keys(config('locales.supported', ['en' => [], 'ar' => []]));
        $default = config('locales.default', 'en');

        $routeLocale = $request->route('locale');

        if ($routeLocale && in_array($routeLocale, $supported, true)) {
            $locale = $routeLocale;
        } else {
            $sessionLocale = $request->hasSession() ? $request->session()->get('locale') : null;
            $cookieLocale = $request->cookie('apex_locale');
            $preferredLocale = $request->getPreferredLanguage($supported);

            if ($sessionLocale && in_array($sessionLocale, $supported, true)) {
                $locale = $sessionLocale;
            } elseif ($cookieLocale && in_array($cookieLocale, $supported, true)) {
                $locale = $cookieLocale;
            } elseif ($preferredLocale && in_array($preferredLocale, $supported, true)) {
                $locale = $preferredLocale;
            } else {
                $locale = $default;
            }
        }

        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }

        if (function_exists('view')) {
            view()->share('currentLocale', $locale);
            view()->share('localeDirection', function_exists('locale_direction') ? locale_direction($locale) : 'ltr');
            view()->share('isRtl', function_exists('is_rtl') ? is_rtl($locale) : false);
        }

        return $next($request);
    }
}
