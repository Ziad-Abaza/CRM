<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LocaleHelperTest extends TestCase
{
    public function test_supported_locales_returns_configured_locales(): void
    {
        $locales = supported_locales();

        $this->assertIsArray($locales);
        $this->assertArrayHasKey('en', $locales);
        $this->assertArrayHasKey('ar', $locales);

        $this->assertEquals('English', $locales['en']['name']);
        $this->assertEquals('English', $locales['en']['native']);
        $this->assertEquals('ltr', $locales['en']['direction']);
        $this->assertEquals('Plus Jakarta Sans', $locales['en']['font']);

        $this->assertEquals('Arabic', $locales['ar']['name']);
        $this->assertEquals('العربية', $locales['ar']['native']);
        $this->assertEquals('rtl', $locales['ar']['direction']);
        $this->assertEquals('Cairo', $locales['ar']['font']);
    }

    public function test_current_locale_returns_application_locale(): void
    {
        app()->setLocale('en');
        $this->assertEquals('en', current_locale());

        app()->setLocale('ar');
        $this->assertEquals('ar', current_locale());
    }

    public function test_locale_direction_and_is_rtl_helpers(): void
    {
        app()->setLocale('en');
        $this->assertEquals('ltr', locale_direction());
        $this->assertFalse(is_rtl());
        $this->assertEquals('rtl', locale_direction('ar'));
        $this->assertTrue(is_rtl('ar'));

        app()->setLocale('ar');
        $this->assertEquals('rtl', locale_direction());
        $this->assertTrue(is_rtl());
        $this->assertEquals('ltr', locale_direction('en'));
        $this->assertFalse(is_rtl('en'));

        // Unknown locale defaults to ltr / false
        $this->assertEquals('ltr', locale_direction('non_existent'));
        $this->assertFalse(is_rtl('non_existent'));
    }

    public function test_localized_route_generates_correct_urls(): void
    {
        Route::get('/{locale}/test-sample', fn () => 'ok')->name('test.sample');
        Route::get('/{locale}/test-item/{id}', fn ($locale, $id) => $id)->name('test.item');
        Route::getRoutes()->refreshNameLookups();

        app()->setLocale('en');
        $this->assertStringEndsWith('/en/test-sample', localized_route('test.sample'));
        $this->assertStringEndsWith('/ar/test-sample', localized_route('test.sample', [], 'ar'));

        $this->assertStringEndsWith('/en/test-item/99', localized_route('test.item', ['id' => 99]));
        $this->assertStringEndsWith('/ar/test-item/99', localized_route('test.item', ['id' => 99], 'ar'));
    }

    public function test_switch_locale_url_switches_locale_in_current_request(): void
    {
        Route::get('/{locale}/portfolio/{slug}', fn () => 'ok')->name('test.portfolio');
        Route::getRoutes()->refreshNameLookups();

        $this->get('/en/portfolio/cloud-transformation');

        $targetUrl = switch_locale_url('ar');
        $this->assertStringContainsString('/ar/portfolio/cloud-transformation', $targetUrl);
    }

    public function test_t_helper_translates_strings(): void
    {
        app()->setLocale('en');
        $this->assertEquals('Hello Apex', t('Hello :name', ['name' => 'Apex']));
    }
}
