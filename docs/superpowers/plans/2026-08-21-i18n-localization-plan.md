# Arabic & English Production-Ready i18n Localization Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement complete, production-ready bilingual internationalization (i18n) for Arabic (RTL) and English (LTR) across the entire public website, content sections, and admin portal.

**Architecture:** A configuration-driven locale registry (`config/locales.php`) powers public URL prefix routing (`/{locale}/...`), automated root redirecting, persistent session/cookie fallbacks for admin, centralized translation files (`lang/en/` and `lang/ar/`), dynamic `HasTranslations` model attributes with English fallback, bi-directional RTL/LTR layouts with Cairo Arabic typography, and reactive language switchers.

**Tech Stack:** Laravel 12 (PHP 8.3), Blade, Tailwind CSS v4 with logical utilities, Alpine.js, PHPUnit.

## Global Constraints
- Supported locales: `en` (English, LTR, default), `ar` (Arabic, RTL).
- Zero hardcoded UI strings; all translatable strings centralized in `lang/{locale}/`.
- Public routes prefixed with `/{locale}`; admin routes remain under `/admin` with session/cookie locale resolution.
- Dynamic models fallback to default locale if a translation is missing.
- RTL layouts must use logical CSS (`ms-`, `me-`, `text-start`, `text-end`) and mirror directional elements.

---

### Task 1: Locales Configuration & Global Helpers

**Files:**
- Create: `config/locales.php`
- Modify: `app/Helpers/helpers.php`
- Test: `tests/Unit/LocaleHelperTest.php`

**Interfaces:**
- Consumes: Laravel config & session/cookie facilities
- Produces: `current_locale(): string`, `is_rtl(): bool`, `locale_direction(): string`, `supported_locales(): array`, `localized_route(string $name, array $params = [], ?string $locale = null): string`, `switch_locale_url(string $targetLocale): string`

- [ ] **Step 1: Write the failing unit test for locale helpers**

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;

class LocaleHelperTest extends TestCase
{
    public function test_supported_locales_returns_array(): void
    {
        $locales = supported_locales();
        $this->assertArrayHasKey('en', $locales);
        $this->assertArrayHasKey('ar', $locales);
        $this->assertEquals('ltr', $locales['en']['direction']);
        $this->assertEquals('rtl', $locales['ar']['direction']);
    }

    public function test_locale_direction_and_is_rtl_helpers(): void
    {
        app()->setLocale('en');
        $this->assertEquals('en', current_locale());
        $this->assertEquals('ltr', locale_direction());
        $this->assertFalse(is_rtl());

        app()->setLocale('ar');
        $this->assertEquals('ar', current_locale());
        $this->assertEquals('rtl', locale_direction());
        $this->assertTrue(is_rtl());
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=LocaleHelperTest`
Expected: FAIL with "Call to undefined function supported_locales()"

- [ ] **Step 3: Create `config/locales.php` and implement helper functions in `app/Helpers/helpers.php`**

Create `config/locales.php`:
```php
<?php

return [
    'default' => 'en',
    'fallback' => 'en',
    'supported' => [
        'en' => [
            'name' => 'English',
            'native' => 'English',
            'direction' => 'ltr',
            'font' => 'Plus Jakarta Sans',
            'font_heading' => 'Plus Jakarta Sans',
            'flag' => '🇺🇸',
            'og_locale' => 'en_US',
        ],
        'ar' => [
            'name' => 'Arabic',
            'native' => 'العربية',
            'direction' => 'rtl',
            'font' => 'Cairo',
            'font_heading' => 'Cairo',
            'flag' => '🇸🇦',
            'og_locale' => 'ar_SA',
        ],
    ],
];
```

Modify `app/Helpers/helpers.php` to add helper functions.

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=LocaleHelperTest`
Expected: PASS

- [ ] **Step 5: Commit changes**

```bash
git add config/locales.php app/Helpers/helpers.php tests/Unit/LocaleHelperTest.php
git commit -m "feat(i18n): add locales configuration and global locale helpers"
```

---

### Task 2: Locale Routing, Middleware & Locale Switching

**Files:**
- Create: `app/Http/Middleware/SetLocaleMiddleware.php`
- Create: `app/Http/Controllers/Public/LocaleSwitchController.php`
- Modify: `bootstrap/app.php`
- Modify: `routes/web.php`
- Modify: `app/Http/Controllers/Public/SitemapController.php`
- Test: `tests/Feature/LocaleRoutingAndSwitchTest.php`

**Interfaces:**
- Consumes: `config/locales.php`, `app/Helpers/helpers.php`
- Produces: `SetLocaleMiddleware`, `LocaleSwitchController@switch`, localized route groups `/{locale}`

- [ ] **Step 1: Write the failing feature test for locale routing & switching**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleRoutingAndSwitchTest extends TestCase
{
    public function test_root_url_redirects_to_default_or_detected_locale(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/en');
    }

    public function test_can_access_english_and_arabic_home(): void
    {
        $responseEn = $this->get('/en');
        $responseEn->assertStatus(200);

        $responseAr = $this->get('/ar');
        $responseAr->assertStatus(200);
    }

    public function test_invalid_locale_returns_404(): void
    {
        $response = $this->get('/fr');
        $response->assertStatus(404);
    }

    public function test_locale_switch_sets_session_and_cookie(): void
    {
        $response = $this->get('/locale/ar');
        $response->assertSessionHas('locale', 'ar');
        $response->assertCookie('apex_locale', 'ar');
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=LocaleRoutingAndSwitchTest`
Expected: FAIL

- [ ] **Step 3: Implement `SetLocaleMiddleware`, `LocaleSwitchController`, update `bootstrap/app.php`, `routes/web.php`, and `SitemapController.php`**

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=LocaleRoutingAndSwitchTest`
Expected: PASS

- [ ] **Step 5: Commit changes**

```bash
git add app/Http/Middleware/SetLocaleMiddleware.php app/Http/Controllers/Public/LocaleSwitchController.php bootstrap/app.php routes/web.php app/Http/Controllers/Public/SitemapController.php tests/Feature/LocaleRoutingAndSwitchTest.php
git commit -m "feat(i18n): implement locale middleware, routing prefix, and locale switcher"
```

---

### Task 3: Translatable Model Support & Attribute Resolution

**Files:**
- Create: `app/Traits/HasTranslations.php`
- Modify: `app/Models/Service.php`
- Modify: `app/Models/Portfolio.php`
- Modify: `app/Models/PortfolioCategory.php`
- Modify: `app/Models/PricingPlan.php`
- Modify: `app/Models/Testimonial.php`
- Modify: `app/Models/TeamMember.php`
- Modify: `app/Models/StatsCounter.php`
- Modify: `app/Models/Faq.php`
- Modify: `app/Services/SettingService.php`
- Test: `tests/Feature/TranslatableModelTest.php`

**Interfaces:**
- Consumes: Model attributes
- Produces: `HasTranslations` trait, `$model->getTranslation(string $attribute, ?string $locale = null)`, transparent attribute getter overrides.

- [ ] **Step 1: Write the failing feature test for translatable models**

```php
<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslatableModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_resolves_translation_for_current_locale_with_fallback(): void
    {
        $service = Service::create([
            'title' => ['en' => 'Digital Consulting', 'ar' => 'الاستشارات الرقمية'],
            'slug' => 'digital-consulting',
            'short_description' => ['en' => 'Enterprise advisory', 'ar' => 'استشارات للمؤسسات'],
            'description' => ['en' => 'Detailed description', 'ar' => 'وصف تفصيلي'],
            'icon' => 'briefcase',
            'features' => ['en' => ['Scalability', 'Governance'], 'ar' => ['قابلية التوسع', 'الحوكمة']],
            'order' => 1,
            'is_active' => true,
        ]);

        app()->setLocale('en');
        $this->assertEquals('Digital Consulting', $service->title);
        $this->assertEquals(['Scalability', 'Governance'], $service->features);

        app()->setLocale('ar');
        $this->assertEquals('الاستشارات الرقمية', $service->title);
        $this->assertEquals(['قابلية التوسع', 'الحوكمة'], $service->features);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test --filter=TranslatableModelTest`
Expected: FAIL

- [ ] **Step 3: Implement `HasTranslations` trait, apply to models, and update `SettingService`**

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=TranslatableModelTest`
Expected: PASS

- [ ] **Step 5: Commit changes**

```bash
git add app/Traits/HasTranslations.php app/Models/ app/Services/SettingService.php tests/Feature/TranslatableModelTest.php
git commit -m "feat(i18n): implement HasTranslations trait and localized setting resolution"
```

---

### Task 4: Complete Translation Dictionaries (Arabic & English)

**Files:**
- Create: `lang/en/ui.php`, `lang/ar/ui.php`
- Create: `lang/en/frontend.php`, `lang/ar/frontend.php`
- Create: `lang/en/admin.php`, `lang/ar/admin.php`
- Create: `lang/en/validation.php`, `lang/ar/validation.php`
- Create: `lang/en/auth.php`, `lang/ar/auth.php`
- Create: `lang/en/seo.php`, `lang/ar/seo.php`
- Create: `lang/en.json`, `lang/ar.json`
- Test: `tests/Feature/TranslationFilesIntegrityTest.php`

**Interfaces:**
- Consumes: Key-value language dictionaries
- Produces: Complete coverage for all UI tokens, labels, alerts, validation, and content placeholders.

- [ ] **Step 1: Write the test verifying translation files integrity & parity**

- [ ] **Step 2: Run test to verify it fails**

- [ ] **Step 3: Create all modular PHP translation files and JSON translation files for both Arabic and English**

- [ ] **Step 4: Run test to verify it passes**

Run: `php artisan test --filter=TranslationFilesIntegrityTest`
Expected: PASS

- [ ] **Step 5: Commit changes**

```bash
git add lang/ tests/Feature/TranslationFilesIntegrityTest.php
git commit -m "feat(i18n): create complete Arabic and English translation dictionaries"
```

---

### Task 5: High-Quality Bilingual Database Seed Data

**Files:**
- Modify: `database/seeders/DefaultCompanySeeder.php`
- Test: `tests/Feature/BilingualDatabaseSeederTest.php`

**Interfaces:**
- Consumes: `HasTranslations` models, `SettingService`
- Produces: Realistic enterprise Arabic & English seeders for Settings, Services, Categories, Portfolio, Pricing, Testimonials, Team, Stats, FAQs.

- [ ] **Step 1: Write test verifying bilingual seeder creates both languages**

- [ ] **Step 2: Update `DefaultCompanySeeder.php` to populate high-fidelity bilingual fields**

- [ ] **Step 3: Re-run seeders and verify tests**

Run: `php artisan test --filter=BilingualDatabaseSeederTest`
Expected: PASS

- [ ] **Step 4: Commit changes**

```bash
git add database/seeders/DefaultCompanySeeder.php tests/Feature/BilingualDatabaseSeederTest.php
git commit -m "feat(i18n): populate comprehensive bilingual seed data for Arabic and English"
```

---

### Task 6: Public Layout, RTL/LTR Typography, SEO & Header/Footer Language Switchers

**Files:**
- Modify: `resources/views/layouts/public.blade.php`
- Modify: `resources/views/components/footer.blade.php`
- Modify: `resources/views/components/whatsapp-cta-button.blade.php`
- Modify: `resources/views/components/whatsapp-floating-widget.blade.php`
- Modify: `resources/views/components/hero-section.blade.php`
- Modify: `resources/views/components/services-section.blade.php`
- Modify: `resources/views/components/portfolio-section.blade.php`
- Modify: `resources/views/components/pricing-section.blade.php`
- Modify: `resources/views/components/team-section.blade.php`
- Modify: `resources/views/components/testimonials-section.blade.php`
- Modify: `resources/views/components/stats-section.blade.php`
- Modify: `resources/views/components/faqs-section.blade.php`
- Modify: `resources/views/components/cta-banner.blade.php`
- Modify: `resources/views/public/home.blade.php`
- Modify: `resources/views/public/service-detail.blade.php`
- Modify: `resources/views/public/portfolio-detail.blade.php`
- Test: `tests/Feature/PublicLocalizedViewsTest.php`

- [ ] **Step 1: Write feature test verifying public frontend in Arabic & English**
- [ ] **Step 2: Update public layout, components, and views to use translation functions, directional RTL typography, and language switchers**
- [ ] **Step 3: Run test to verify it passes**

Run: `php artisan test --filter=PublicLocalizedViewsTest`
Expected: PASS

- [ ] **Step 4: Commit changes**

```bash
git add resources/views/layouts/public.blade.php resources/views/components/ resources/views/public/ tests/Feature/PublicLocalizedViewsTest.php
git commit -m "feat(i18n): implement public RTL/LTR layout, typography, components, and language switchers"
```

---

### Task 7: Admin Panel Localization & Bilingual Editing

**Files:**
- Modify: `resources/views/layouts/admin.blade.php`
- Modify: `resources/views/admin/dashboard.blade.php`
- Modify: `resources/views/admin/auth/login.blade.php`
- Modify: `resources/views/admin/leads/index.blade.php`
- Modify: `resources/views/admin/audit-logs/index.blade.php`
- Modify: `resources/views/admin/branding/index.blade.php`
- Modify: `resources/views/admin/content/*.blade.php`
- Modify: `resources/views/admin/services/*.blade.php`
- Modify: `resources/views/admin/portfolio/*.blade.php`
- Modify: `resources/views/admin/pricing/*.blade.php`
- Modify: `resources/views/admin/testimonials/*.blade.php`
- Modify: `resources/views/admin/team/*.blade.php`
- Modify: `resources/views/admin/stats/*.blade.php`
- Modify: `resources/views/admin/faqs/*.blade.php`
- Modify: `app/Http/Controllers/Admin/*.php`
- Test: `tests/Feature/AdminLocalizedTest.php`

- [ ] **Step 1: Write feature test for admin localized UI and bilingual editing**
- [ ] **Step 2: Update admin layout, components, views, and controllers for complete Arabic/English support**
- [ ] **Step 3: Run test to verify it passes**

Run: `php artisan test --filter=AdminLocalizedTest`
Expected: PASS

- [ ] **Step 4: Commit changes**

```bash
git add resources/views/admin/ resources/views/layouts/admin.blade.php app/Http/Controllers/Admin/ tests/Feature/AdminLocalizedTest.php
git commit -m "feat(i18n): localize admin layout, dashboard, management views, and forms"
```

---

### Task 8: Verification & Regression Testing

**Files:**
- Run all test suites across the repository.

- [ ] **Step 1: Execute full test suite**

Run: `php artisan test`
Expected: All tests PASS with zero failures.

- [ ] **Step 2: Run frontend build**

Run: `npm run build`
Expected: Assets compiled cleanly.

- [ ] **Step 3: Final Commit**

```bash
git add .
git commit -m "chore(i18n): complete Arabic and English internationalization suite"
```
