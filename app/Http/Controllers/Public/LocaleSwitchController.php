<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleSwitchController extends Controller
{
    /**
     * Switch application locale and redirect user back to translated page or home.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $supported = array_keys(config('locales.supported', ['en' => [], 'ar' => []]));

        if (!in_array($locale, $supported, true)) {
            abort(404);
        }

        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }

        $cookie = cookie('apex_locale', $locale, 60 * 24 * 365);

        $previousUrl = url()->previous();
        $targetUrl = url('/' . $locale);

        if ($previousUrl && $previousUrl !== url()->current()) {
            $parsed = parse_url($previousUrl);
            $currentHost = $request->getHost();

            // Only redirect back if previous URL belongs to the same host
            if (!isset($parsed['host']) || $parsed['host'] === $currentHost) {
                $path = $parsed['path'] ?? '/';
                $segments = explode('/', trim($path, '/'));

                if (!empty($segments) && in_array($segments[0], $supported, true)) {
                    $segments[0] = $locale;
                    $newPath = '/' . implode('/', $segments);
                    $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
                    $targetUrl = url($newPath . $query);
                } elseif (str_starts_with($path, '/admin')) {
                    $targetUrl = $previousUrl;
                }
            }
        }

        return redirect($targetUrl)->withCookie($cookie);
    }

    /**
     * Invoke single-action controller.
     */
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        return $this->switch($request, $locale);
    }
}
