<?php

use App\Services\SettingService;
use Illuminate\Support\Facades\Route;

if (!function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed as the key, we assume you want to set an array of values.
     *
     * @param string|array<string, mixed>|null $key
     * @param mixed $default
     * @param string|null $locale
     * @return mixed|\App\Services\SettingService
     */
    function setting(string|array|null $key = null, mixed $default = null, ?string $locale = null): mixed
    {
        $service = app(SettingService::class);

        if (is_null($key)) {
            return $service;
        }

        if (is_array($key)) {
            $service->setMany($key);
            return null;
        }

        return $service->get($key, $default, $locale);
    }
}

if (!function_exists('supported_locales')) {
    /**
     * Get the list of supported locales and their configuration.
     *
     * @return array<string, array<string, mixed>>
     */
    function supported_locales(): array
    {
        return config('locales.supported', []);
    }
}

if (!function_exists('current_locale')) {
    /**
     * Get the current active application locale.
     *
     * @return string
     */
    function current_locale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('locale_direction')) {
    /**
     * Get the text direction ('ltr' or 'rtl') for a specific or current locale.
     *
     * @param string|null $locale
     * @return string
     */
    function locale_direction(?string $locale = null): string
    {
        $locale = $locale ?: current_locale();
        $locales = supported_locales();

        return $locales[$locale]['direction'] ?? 'ltr';
    }
}

if (!function_exists('is_rtl')) {
    /**
     * Check if the given or current locale is Right-to-Left (RTL).
     *
     * @param string|null $locale
     * @return bool
     */
    function is_rtl(?string $locale = null): bool
    {
        return locale_direction($locale) === 'rtl';
    }
}

if (!function_exists('localized_route')) {
    /**
     * Generate a localized URL for a named route.
     *
     * @param string $name
     * @param mixed $parameters
     * @param string|null $locale
     * @param bool $absolute
     * @return string
     */
    function localized_route(string $name, mixed $parameters = [], ?string $locale = null, bool $absolute = true): string
    {
        $locale = $locale ?: current_locale();

        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        if (array_is_list($parameters)) {
            $parameters = array_merge([$locale], $parameters);
        } else {
            $parameters = array_merge(['locale' => $locale], $parameters);
        }

        return route($name, $parameters, $absolute);
    }
}

if (!function_exists('switch_locale_url')) {
    /**
     * Generate the URL to switch to the target locale from the current request.
     *
     * @param string $targetLocale
     * @return string
     */
    function switch_locale_url(string $targetLocale): string
    {
        $request = request();
        $currentRoute = $request->route();

        if ($currentRoute && $currentRoute->getName() && in_array('locale', $currentRoute->parameterNames() ?? [])) {
            $parameters = $currentRoute->parameters();
            $parameters['locale'] = $targetLocale;
            $query = $request->query();
            $url = route($currentRoute->getName(), $parameters);

            return !empty($query) ? $url . '?' . http_build_query($query) : $url;
        }

        $segments = $request->segments();
        $supported = array_keys(supported_locales());

        if (!empty($segments) && in_array($segments[0], $supported)) {
            $segments[0] = $targetLocale;
            $newPath = '/' . implode('/', $segments);
            $query = $request->getQueryString();

            return $query ? $newPath . '?' . $query : $newPath;
        }

        if (Route::has('locale.switch')) {
            return route('locale.switch', ['locale' => $targetLocale]);
        }

        return url('/' . $targetLocale);
    }
}

if (!function_exists('t')) {
    /**
     * Translate the given message or return translation.
     *
     * @param string $key
     * @param array<string, mixed> $replace
     * @param string|null $locale
     * @return string
     */
    function t(string $key, array $replace = [], ?string $locale = null): string
    {
        return (string) __($key, $replace, $locale);
    }
}
