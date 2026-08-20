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
     * Get a specific setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->getAll();

        if (!isset($settings[$key])) {
            return $default;
        }

        $item = $settings[$key];
        $val = is_array($item) ? ($item['value'] ?? null) : ($item->value ?? null);
        $type = is_array($item) ? ($item['type'] ?? null) : ($item->type ?? null);

        return $this->castValue($val, $type);
    }

    /**
     * Get all settings belonging to a specific group.
     *
     * @param string $group
     * @return array<string, mixed>
     */
    public function getGroup(string $group): array
    {
        $settings = $this->getAll();

        $groupSettings = [];
        foreach ($settings as $key => $item) {
            $itemGroup = is_array($item) ? ($item['group'] ?? null) : ($item->group ?? null);
            $itemValue = is_array($item) ? ($item['value'] ?? null) : ($item->value ?? null);
            $itemType = is_array($item) ? ($item['type'] ?? null) : ($item->type ?? null);

            if ($itemGroup === $group) {
                $groupSettings[$key] = $this->castValue($itemValue, $itemType);
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
        $formattedValue = is_array($value) ? json_encode($value) : (is_bool($value) ? ($value ? '1' : '0') : (string) $value);

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
            $formattedValue = is_array($value) ? json_encode($value) : (is_bool($value) ? ($value ? '1' : '0') : (string) $value);

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
}
