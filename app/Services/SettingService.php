<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public const CACHE_KEY = 'settings.all';
    public const CACHE_TTL = 86400; // 24 hours

    /**
     * Get all cached settings as pure associative array.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getAll(): array
    {
        $cached = Cache::get(self::CACHE_KEY);

        // Ensure cache is a valid array of arrays; if corrupted or incomplete, rebuild from database
        if (!is_array($cached) || (count($cached) > 0 && !is_array(reset($cached)))) {
            $cached = [];
            $settings = Setting::query()->get(['id', 'key', 'value', 'group', 'type', 'is_public']);
            foreach ($settings as $setting) {
                $cached[$setting->key] = [
                    'id' => $setting->id,
                    'key' => $setting->key,
                    'value' => $setting->value,
                    'group' => $setting->group,
                    'type' => $setting->type,
                    'is_public' => (bool) $setting->is_public,
                ];
            }

            Cache::put(self::CACHE_KEY, $cached, self::CACHE_TTL);
        }

        return $cached;
    }

    /**
     * Get a specific setting value by key with locale support.
     *
     * @param string $key
     * @param mixed $default
     * @param string|null $locale
     * @return mixed
     */
    public function get(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        $settings = $this->getAll();
        $currentLocale = $locale ?: app()->getLocale();
        $defaultLocale = config('locales.default', config('locales.fallback', 'en'));

        // 1. If key with target locale suffix exists (e.g. hero_title_ar), use it
        $localeKey = $key . '_' . $currentLocale;
        if (isset($settings[$localeKey])) {
            $item = $settings[$localeKey];
            $val = is_array($item) ? ($item['value'] ?? null) : ($item->value ?? null);
            $type = is_array($item) ? ($item['type'] ?? null) : ($item->type ?? null);
            $cast = $this->castValue($val, $type);
            if ($cast !== null && $cast !== '') {
                return $cast;
            }
        }

        // 2. If direct key exists (e.g. hero_title)
        if (isset($settings[$key])) {
            $item = $settings[$key];
            $val = is_array($item) ? ($item['value'] ?? null) : ($item->value ?? null);
            $type = is_array($item) ? ($item['type'] ?? null) : ($item->type ?? null);
            $cast = $this->castValue($val, $type);

            // If it's a localized JSON array (e.g. ['en' => '...', 'ar' => '...'])
            if (is_array($cast) && $this->isLocalizedArray($cast)) {
                $resolved = $this->resolveTranslationFromArray($cast, $currentLocale);
                if ($resolved !== null && $resolved !== '') {
                    return $resolved;
                }
            } elseif ($cast !== null) {
                return $cast;
            }
        }

        // 3. Fallback to default locale key (e.g. hero_title_en) if different from current locale
        if ($currentLocale !== $defaultLocale) {
            $defaultKey = $key . '_' . $defaultLocale;
            if (isset($settings[$defaultKey])) {
                $item = $settings[$defaultKey];
                $val = is_array($item) ? ($item['value'] ?? null) : ($item->value ?? null);
                $type = is_array($item) ? ($item['type'] ?? null) : ($item->type ?? null);
                $cast = $this->castValue($val, $type);
                if ($cast !== null && $cast !== '') {
                    return $cast;
                }
            }
        }

        return $default;
    }

    /**
     * Get all settings belonging to a specific group.
     *
     * @param string $group
     * @param string|null $locale
     * @return array<string, mixed>
     */
    public function getGroup(string $group, ?string $locale = null): array
    {
        $settings = $this->getAll();
        $currentLocale = $locale ?: app()->getLocale();

        $groupSettings = [];
        foreach ($settings as $key => $item) {
            $itemGroup = is_array($item) ? ($item['group'] ?? null) : ($item->group ?? null);

            if ($itemGroup === $group) {
                $groupSettings[$key] = $this->get($key, null, $currentLocale);
            }
        }

        return $groupSettings;
    }

    /**
     * Set or update a single setting.
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param string $type
     * @param bool $isPublic
     * @return Setting
     */
    public function set(string $key, mixed $value, string $group = 'general', string $type = 'string', bool $isPublic = true): Setting
    {
        $formattedValue = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (is_bool($value) ? ($value ? '1' : '0') : (string) $value);

        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $formattedValue,
                'group' => $group,
                'type' => $type,
                'is_public' => $isPublic,
            ]
        );

        $this->clearCache();

        return $setting;
    }

    /**
     * Set multiple settings at once.
     *
     * @param array<string, mixed> $settings
     * @param string $group
     * @return void
     */
    public function setMany(array $settings, string $group = 'general'): void
    {
        foreach ($settings as $key => $value) {
            $type = is_array($value) ? 'json' : (is_bool($value) ? 'boolean' : (is_int($value) ? 'integer' : 'string'));
            $formattedValue = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (is_bool($value) ? ($value ? '1' : '0') : (string) $value);

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $formattedValue,
                    'group' => $group,
                    'type' => $type,
                    'is_public' => true,
                ]
            );
        }

        $this->clearCache();
    }

    /**
     * Forget/delete a setting by key.
     *
     * @param string $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        $deleted = Setting::where('key', $key)->delete();
        $this->clearCache();

        return $deleted > 0;
    }

    /**
     * Flush settings cache.
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget('public.home.page_data');
    }

    /**
     * Cast raw string value to appropriate PHP type.
     *
     * @param mixed $value
     * @param string|null $type
     * @return mixed
     */
    protected function castValue(mixed $value, ?string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer', 'int' => (int) $value,
            'json', 'array' => is_string($value) ? json_decode($value, true) : $value,
            'float', 'double' => (float) $value,
            default => (string) $value,
        };
    }

    /**
     * Check whether an array is structured as a localized map.
     *
     * @param mixed $value
     * @return bool
     */
    protected function isLocalizedArray(mixed $value): bool
    {
        if (!is_array($value) || empty($value) || array_is_list($value)) {
            return false;
        }

        $supported = array_keys(config('locales.supported', ['en' => [], 'ar' => []]));
        $default = config('locales.default', 'en');
        $fallback = config('locales.fallback', 'en');
        $validLocales = array_unique(array_merge($supported, [$default, $fallback]));

        foreach (array_keys($value) as $key) {
            if (!is_string($key)) {
                return false;
            }

            if (!in_array($key, $validLocales, true) && !preg_match('/^[a-z]{2}(-[A-Z]{2})?$/', $key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Resolve a translation value from a translation map.
     *
     * @param array<string, mixed> $translations
     * @param string|null $locale
     * @return mixed
     */
    protected function resolveTranslationFromArray(array $translations, ?string $locale = null): mixed
    {
        $locale = $locale ?: app()->getLocale();
        $defaultLocale = config('locales.fallback', config('locales.default', 'en'));

        if (isset($translations[$locale]) && $this->isNonEmptyTranslation($translations[$locale])) {
            return $translations[$locale];
        }

        if (isset($translations[$defaultLocale]) && $this->isNonEmptyTranslation($translations[$defaultLocale])) {
            return $translations[$defaultLocale];
        }

        foreach ($translations as $val) {
            if ($this->isNonEmptyTranslation($val)) {
                return $val;
            }
        }

        return $translations[$locale] ?? ($translations[$defaultLocale] ?? (reset($translations) ?: null));
    }

    /**
     * Determine whether a translation value is considered non-empty.
     *
     * @param mixed $value
     * @return bool
     */
    protected function isNonEmptyTranslation(mixed $value): bool
    {
        if ($value === null) {
            return false;
        }

        if (is_string($value)) {
            return trim($value) !== '';
        }

        if (is_array($value)) {
            return count($value) > 0;
        }

        return true;
    }
}
