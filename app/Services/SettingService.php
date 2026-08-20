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
     * Get all cached settings.
     *
     * @return Collection<string, object>
     */
    public function getAll(): Collection
    {
        $cached = Cache::get(self::CACHE_KEY);

        // If corrupted, incomplete class, or not an array, rebuild from database
        if (!is_array($cached)) {
            $cached = Setting::query()
                ->get(['id', 'key', 'value', 'group', 'type', 'is_public'])
                ->keyBy('key')
                ->map(fn ($item) => (object) [
                    'id' => $item->id,
                    'key' => $item->key,
                    'value' => $item->value,
                    'group' => $item->group,
                    'type' => $item->type,
                    'is_public' => (bool) $item->is_public,
                ])
                ->toArray();

            Cache::put(self::CACHE_KEY, $cached, self::CACHE_TTL);
        }

        return collect($cached)->map(fn ($item) => is_object($item) ? $item : (object) $item);
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

        if (!$settings->has($key)) {
            return $default;
        }

        $setting = $settings->get($key);

        return $this->castValue($setting->value ?? null, $setting->type ?? null);
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
        foreach ($settings as $key => $setting) {
            if (($setting->group ?? null) === $group) {
                $groupSettings[$key] = $this->castValue($setting->value ?? null, $setting->type ?? null);
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
