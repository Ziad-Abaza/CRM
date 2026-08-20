<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Get the translatable attributes for the model.
     *
     * @return array<int, string>
     */
    public function getTranslatableAttributes(): array
    {
        return property_exists($this, 'translatable') && is_array($this->translatable)
            ? $this->translatable
            : [];
    }

    /**
     * Determine whether the given attribute is translatable.
     *
     * @param string $key
     * @return bool
     */
    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes(), true);
    }

    /**
     * Get a plain attribute's value or its translated value.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttributeValue($key): mixed
    {
        $value = parent::getAttributeValue($key);

        if ($this->isTranslatableAttribute($key)) {
            return $this->getTranslatableAttributeValue($key, $value);
        }

        return $value;
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array<string, mixed>
     */
    public function attributesToArray(): array
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getTranslatableAttributes() as $key) {
            if (array_key_exists($key, $attributes)) {
                $attributes[$key] = $this->getAttributeValue($key);
            }
        }

        return $attributes;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value): mixed
    {
        if ($this->isTranslatableAttribute($key)) {
            if (is_array($value)) {
                if ($this->isLocalizedArray($value)) {
                    return $this->setTranslations($key, $value);
                }

                if ($this->hasCast($key, ['array', 'json', 'object', 'collection'])) {
                    return parent::setAttribute($key, $value);
                }

                return $this->setTranslations($key, [config('locales.default', 'en') => $value]);
            }

            if (is_string($value) && $value !== '' && ($value[0] === '{' || $value[0] === '[')) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && $this->isLocalizedArray($decoded)) {
                    return $this->setTranslations($key, $decoded);
                }
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Get the translated value for an attribute in the specified locale.
     *
     * @param string $attribute
     * @param string|null $locale
     * @param bool $fallback
     * @return mixed
     */
    public function getTranslation(string $attribute, ?string $locale = null, bool $fallback = true): mixed
    {
        $translations = $this->getTranslations($attribute);

        if (empty($translations)) {
            $raw = $this->attributes[$attribute] ?? null;
            if ($raw !== null && is_string($raw)) {
                if ($raw !== '' && ($raw[0] === '{' || $raw[0] === '[')) {
                    $decoded = json_decode($raw, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && $this->isLocalizedArray($decoded)) {
                        return $this->resolveTranslationFromArray($decoded, $locale, $fallback);
                    }
                }

                return ($fallback || $locale === config('locales.default', 'en') || $locale === null) ? $raw : null;
            }

            return null;
        }

        return $this->resolveTranslationFromArray($translations, $locale, $fallback);
    }

    /**
     * Set a translation for a specific locale.
     *
     * @param string $attribute
     * @param string $locale
     * @param mixed $value
     * @return $this
     */
    public function setTranslation(string $attribute, string $locale, mixed $value): self
    {
        $translations = $this->getTranslations($attribute);
        $translations[$locale] = $value;

        return $this->setTranslations($attribute, $translations);
    }

    /**
     * Set all translations for a given attribute.
     *
     * @param string $attribute
     * @param array<string, mixed> $translations
     * @return $this
     */
    public function setTranslations(string $attribute, array $translations): self
    {
        $json = json_encode($translations, JSON_UNESCAPED_UNICODE);
        $this->attributes[$attribute] = $json;

        return $this;
    }

    /**
     * Get all translations for a given attribute, or all translatable attributes.
     *
     * @param string|null $attribute
     * @return array<string, mixed>
     */
    public function getTranslations(?string $attribute = null): array
    {
        if ($attribute === null) {
            $result = [];
            foreach ($this->getTranslatableAttributes() as $field) {
                $result[$field] = $this->getTranslations($field);
            }

            return $result;
        }

        if (!isset($this->attributes[$attribute]) || $this->attributes[$attribute] === null) {
            return [];
        }

        $raw = $this->attributes[$attribute];

        if (is_array($raw)) {
            if ($this->isLocalizedArray($raw)) {
                return $raw;
            }

            return [config('locales.default', 'en') => $raw];
        }

        if (is_string($raw) && $raw !== '') {
            if ($raw[0] === '{' || $raw[0] === '[') {
                $decoded = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    if ($this->isLocalizedArray($decoded)) {
                        return $decoded;
                    }

                    return [config('locales.default', 'en') => $decoded];
                }
            }

            return [config('locales.default', 'en') => $raw];
        }

        return [];
    }

    /**
     * Resolve translatable attribute value for current locale.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function getTranslatableAttributeValue(string $key, mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            if ($this->isLocalizedArray($value)) {
                return $this->resolveTranslationFromArray($value, app()->getLocale(), true);
            }

            return $value;
        }

        if (is_string($value) && $value !== '' && ($value[0] === '{' || $value[0] === '[')) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && $this->isLocalizedArray($decoded)) {
                return $this->resolveTranslationFromArray($decoded, app()->getLocale(), true);
            }
        }

        return $value;
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
     * @param bool $fallback
     * @return mixed
     */
    protected function resolveTranslationFromArray(array $translations, ?string $locale = null, bool $fallback = true): mixed
    {
        $locale = $locale ?: app()->getLocale();
        $defaultLocale = config('locales.fallback', config('locales.default', 'en'));

        if (isset($translations[$locale]) && $this->isNonEmptyTranslation($translations[$locale])) {
            return $translations[$locale];
        }

        if (!$fallback) {
            return $translations[$locale] ?? null;
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
