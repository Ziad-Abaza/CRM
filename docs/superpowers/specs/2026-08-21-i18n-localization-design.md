# Production-Ready i18n Localization Architecture Specification (Arabic & English)

## 1. Executive Summary & Goals
This document defines the complete architectural design for enterprise-grade internationalization (i18n) supporting **Arabic (العربية, RTL)** and **English (LTR)** across the entire public web presence and administrative portal of Apex Corporate Solutions.

### Key Objectives:
1. **URL & Route Architecture**: Public URL prefixing (`/{locale}/...`) with root automatic locale detection, canonical and `hreflang` SEO alternates; persistent session/cookie fallback for the admin panel (`/admin/...`).
2. **Translation Centralization**: Zero hardcoded strings. Centralized, modular translation dictionaries under `lang/en` and `lang/ar` (`ui.php`, `frontend.php`, `admin.php`, `validation.php`, `auth.php`, `seo.php`) alongside root JSON translation maps.
3. **Dynamic Content & Database Localization**: Translatable model attributes for `Service`, `PortfolioCategory`, `Portfolio`, `PricingPlan`, `Testimonial`, `TeamMember`, `StatsCounter`, `Faq`, and `Setting` with fallback logic and admin bilingual editor support.
4. **Bi-Directional Typography & Layout (RTL / LTR)**:
   - Dynamic `dir="ltr|rtl"` and `lang="en|ar"`.
   - Primary Arabic typography ('Cairo' / 'Tajawal' via Google Fonts) paired with 'Plus Jakarta Sans'.
   - Logical Tailwind styling (`ms-`, `me-`, `text-start`, `text-end`, RTL icon flips) preventing layout breakage.
5. **Interactive UI Language Switchers**: Fast, accessible, reactive language selector dropdowns in both public navbar/footer and admin header/sidebar.
6. **Future Extensibility**: Configuration-driven locale registry (`config/locales.php`) allowing zero-refactor onboarding of additional languages (e.g. French, German, Spanish).

---

## 2. Locale Configuration & Routing Architecture

### 2.1 Supported Locales Registry (`config/locales.php`)
A centralized configuration defining all supported languages, native names, text directions, date/number formats, and font stacks:
```php
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

### 2.2 Public & Admin Route Structure
- **Root Redirect (`/`)**: Evaluates user cookie/session or `Accept-Language` HTTP header, then redirects (302) to `/{locale}` (e.g., `/en` or `/ar`).
- **Public Localized Routes**:
  - `/{locale}` -> `HomeController`
  - `/{locale}/services/{slug}` -> `ServiceDetailController`
  - `/{locale}/portfolio/{slug}` -> `PortfolioDetailController`
- **Utility / API Routes**:
  - `/locale/{locale}` -> `LocaleSwitchController` (persists session & cookie, then redirects back or to localized route)
  - `/api/track-whatsapp-lead`
  - `/whatsapp/redirect`
  - `/sitemap.xml` & `/robots.txt` (updated to output multi-lingual alternate entries)
- **Admin Panel Routes**:
  - Kept under `/admin/...` with session/cookie locale resolution via `SetLocaleMiddleware`.

---

## 3. Middleware & Helpers

### 3.1 `SetLocaleMiddleware`
Handles request lifecycle locale resolution:
1. In public routes with `{locale}` parameter: validates against `config('locales.supported')`. If invalid, aborts 404 or redirects to default locale.
2. If parameter missing (admin or utility): reads `session('locale')` -> `Cookie::get('apex_locale')` -> Authenticated user preference -> `Accept-Language` header -> `config('locales.default')`.
3. Sets `App::setLocale($locale)` and shares locale metadata to all Blade views.

### 3.2 Global Helper Functions (`app/Helpers/helpers.php`)
- `current_locale()`: Returns active locale string (e.g., `'ar'`, `'en'`).
- `is_rtl()`: Returns boolean whether current locale is RTL.
- `locale_direction()`: Returns `'rtl'` or `'ltr'`.
- `supported_locales()`: Returns configured locales array.
- `localized_route($name, $parameters = [], $locale = null)`: Generates route URL for given or current locale.
- `switch_locale_url($targetLocale)`: Generates current page URL switched to target locale.
- `t($key, $replace = [], $locale = null)`: Translation helper alias.

---

## 4. Database & Dynamic Content Localization

### 4.1 `HasTranslations` Trait / Localized Models
Dynamic models (`Service`, `Portfolio`, `PortfolioCategory`, `PricingPlan`, `Testimonial`, `TeamMember`, `StatsCounter`, `Faq`, `Setting`) support bilingual attributes seamlessly:
- Supports JSON column storage or translated attributes (`{"en":"...","ar":"..."}`).
- Transparent attribute access: `$service->title` returns current locale's string with fallback to English.
- Direct localized retrieval: `$service->getTranslation('title', 'ar')`.

### 4.2 Seeders
`DefaultCompanySeeder.php` updated with high-quality, authentic professional Arabic and English content for all default models and corporate settings (Hero, About, Services, Pricing, Testimonials, Team, FAQs, WhatsApp messages, and SEO metadata).

---

## 5. UI, RTL / LTR Design & Typography

### 5.1 Fonts & Dynamic Styling
- Public layout loads Google Font `Cairo:wght@400;500;600;700;800;900` dynamically when locale is `ar`.
- HTML tag outputs:
  ```html
  <html lang="{{ current_locale() }}" dir="{{ locale_direction() }}" class="..." data-theme="...">
  ```
- CSS variables dynamically adapt body and heading font family for Arabic vs English.

### 5.2 Logical Properties & Directional Flipping
- Spacing and borders migrated to Tailwind CSS logical utilities: `ms-*`, `me-*`, `ps-*`, `pe-*`, `text-start`, `text-end`, `start-0`, `end-0`.
- Directional icons (arrows, chevrons, step progress indicators) flipped in RTL using `rtl:rotate-180` or conditional rendering.

### 5.3 Language Switchers
- **Public Header & Footer**: Dropdown / toggle with flags, native language names, active indicators, and keyboard navigation.
- **Admin Header & Sidebar**: Compact language switch button with persistent state.

---

## 6. Translation Files Structure
- `lang/en/ui.php` & `lang/ar/ui.php`: Navigation, buttons, badges, modals, common actions.
- `lang/en/frontend.php` & `lang/ar/frontend.php`: Public sections, hero, about, features, retainers, contact, testimonials.
- `lang/en/admin.php` & `lang/ar/admin.php`: Dashboard, sidebar, forms, tables, audit logs, leads, status pills, flash alerts.
- `lang/en/validation.php` & `lang/ar/validation.php`: Form validation feedback.
- `lang/en/auth.php` & `lang/ar/auth.php`: Login, credentials, session management.
- `lang/en/seo.php` & `lang/ar/seo.php`: Dynamic page titles, meta descriptions, OpenGraph tags.

---

## 7. Testing & Verification Strategy
- **Unit & Feature Tests**:
  - `LocaleRoutingTest.php`: Public URL locale prefixing, root redirect, fallback handling.
  - `LocaleSwitchTest.php`: Session/cookie persistence and redirection.
  - `TranslatableModelTest.php`: Attribute translations and fallback logic.
  - `PublicLocalizedViewsTest.php`: Verifies correct rendering of Arabic & English pages with RTL/LTR attributes and meta tags.
  - `AdminLocalizedTest.php`: Verifies admin panel translation and locale persistence.
- **Automated Verification**: Full `php artisan test` suite execution and validation.
