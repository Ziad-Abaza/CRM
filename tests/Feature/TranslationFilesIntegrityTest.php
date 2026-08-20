<?php

namespace Tests\Feature;

use Tests\TestCase;

class TranslationFilesIntegrityTest extends TestCase
{
    /**
     * Required translation file bases in lang/{locale}/
     *
     * @var array<string>
     */
    protected array $requiredFiles = [
        'ui',
        'frontend',
        'admin',
        'validation',
        'auth',
        'seo',
    ];

    public function test_all_required_php_translation_files_exist_for_en_and_ar(): void
    {
        foreach ($this->requiredFiles as $file) {
            $enPath = lang_path("en/{$file}.php");
            $arPath = lang_path("ar/{$file}.php");

            $this->assertFileExists($enPath, "Missing English translation file: lang/en/{$file}.php");
            $this->assertFileExists($arPath, "Missing Arabic translation file: lang/ar/{$file}.php");

            $enArray = include $enPath;
            $arArray = include $arPath;

            $this->assertIsArray($enArray, "lang/en/{$file}.php must return an array");
            $this->assertIsArray($arArray, "lang/ar/{$file}.php must return an array");
            $this->assertNotEmpty($enArray, "lang/en/{$file}.php cannot be empty");
            $this->assertNotEmpty($arArray, "lang/ar/{$file}.php cannot be empty");
        }
    }

    public function test_all_php_translation_files_have_100_percent_key_parity(): void
    {
        foreach ($this->requiredFiles as $file) {
            $enPath = lang_path("en/{$file}.php");
            $arPath = lang_path("ar/{$file}.php");

            $enArray = include $enPath;
            $arArray = include $arPath;

            $enFlat = $this->flattenTranslations($enArray);
            $arFlat = $this->flattenTranslations($arArray);

            $missingInAr = array_diff_key($enFlat, $arFlat);
            $missingInEn = array_diff_key($arFlat, $enFlat);

            $this->assertEmpty(
                $missingInAr,
                "The following keys exist in lang/en/{$file}.php but are missing in lang/ar/{$file}.php: " . implode(', ', array_keys($missingInAr))
            );

            $this->assertEmpty(
                $missingInEn,
                "The following keys exist in lang/ar/{$file}.php but are missing in lang/en/{$file}.php: " . implode(', ', array_keys($missingInEn))
            );

            // Ensure no translations are empty strings
            foreach ($enFlat as $key => $val) {
                if (is_string($val)) {
                    $this->assertNotEmpty(trim($val), "English translation for '{$file}.{$key}' is empty.");
                }
            }

            foreach ($arFlat as $key => $val) {
                if (is_string($val)) {
                    $this->assertNotEmpty(trim($val), "Arabic translation for '{$file}.{$key}' is empty.");
                }
            }
        }
    }

    public function test_json_translation_files_exist_and_have_exact_key_parity(): void
    {
        $enJsonPath = lang_path('en.json');
        $arJsonPath = lang_path('ar.json');

        $this->assertFileExists($enJsonPath, 'Missing lang/en.json');
        $this->assertFileExists($arJsonPath, 'Missing lang/ar.json');

        $enContent = file_get_contents($enJsonPath);
        $arContent = file_get_contents($arJsonPath);

        $enData = json_decode($enContent, true);
        $arData = json_decode($arContent, true);

        $this->assertIsArray($enData, 'lang/en.json must contain valid JSON object');
        $this->assertIsArray($arData, 'lang/ar.json must contain valid JSON object');
        $this->assertNotEmpty($enData, 'lang/en.json cannot be empty');
        $this->assertNotEmpty($arData, 'lang/ar.json cannot be empty');

        $missingInAr = array_diff_key($enData, $arData);
        $missingInEn = array_diff_key($arData, $enData);

        $this->assertEmpty(
            $missingInAr,
            'The following keys exist in lang/en.json but are missing in lang/ar.json: ' . implode(', ', array_keys($missingInAr))
        );

        $this->assertEmpty(
            $missingInEn,
            'The following keys exist in lang/ar.json but are missing in lang/en.json: ' . implode(', ', array_keys($missingInEn))
        );

        foreach ($enData as $key => $val) {
            $this->assertNotEmpty(trim((string)$val), "English JSON translation for '{$key}' is empty.");
        }

        foreach ($arData as $key => $val) {
            $this->assertNotEmpty(trim((string)$val), "Arabic JSON translation for '{$key}' is empty.");
        }
    }

    public function test_core_ui_and_frontend_translations_resolve_correctly_in_both_locales(): void
    {
        // Test English
        app()->setLocale('en');
        $this->assertEquals('Services', __('ui.nav.services'));
        $this->assertEquals('Dashboard', __('admin.nav.dashboard'));
        $this->assertEquals('Consult via WhatsApp', __('frontend.hero.consult_cta'));
        $this->assertEquals('These credentials do not match our records.', __('auth.failed'));
        $this->assertStringContainsString('The email field is required.', __('validation.required', ['attribute' => 'email']));

        // Test Arabic
        app()->setLocale('ar');
        $this->assertEquals('الخدمات', __('ui.nav.services'));
        $this->assertEquals('لوحة التحكم', __('admin.nav.dashboard'));
        $this->assertEquals('استشر عبر واتساب', __('frontend.hero.consult_cta'));
        $this->assertEquals('بيانات الاعتماد هذه غير متطابقة مع سجلاتنا.', __('auth.failed'));
        $this->assertStringContainsString('حقل البريد الإلكتروني مطلوب.', __('validation.required', ['attribute' => 'البريد الإلكتروني']));
    }

    public function test_direct_json_translations_resolve_correctly(): void
    {
        app()->setLocale('en');
        $this->assertEquals('Dashboard', __('Dashboard'));
        $this->assertEquals('Consult via WhatsApp', __('Consult via WhatsApp'));

        app()->setLocale('ar');
        $this->assertEquals('لوحة التحكم', __('Dashboard'));
        $this->assertEquals('استشر عبر واتساب', __('Consult via WhatsApp'));
    }

    /**
     * Flatten multi-dimensional translation array with dot notation.
     *
     * @param array<string, mixed> $array
     * @param string $prefix
     * @return array<string, mixed>
     */
    protected function flattenTranslations(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = $prefix === '' ? (string) $key : "{$prefix}.{$key}";

            if (is_array($value) && !empty($value) && $this->isAssoc($value)) {
                $result = array_merge($result, $this->flattenTranslations($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Check if array is associative.
     *
     * @param array<mixed> $arr
     * @return bool
     */
    protected function isAssoc(array $arr): bool
    {
        if ([] === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
