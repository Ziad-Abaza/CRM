# Task 3 Brief: Dynamic Setting Service & Default Seeders

## Goal
Implement a high-performance, cached `SettingService` and `setting()` helper for dynamic retrieval and mutation of system settings, alongside a comprehensive, realistic `DefaultCompanySeeder` and `DatabaseSeeder` that seeds a complete, production-ready corporate profile (Apex Corporate Solutions) with zero hardcoded placeholders or AI clichés.

## Global Constraints
- Strictly follow `.Roles/roles.md`: zero hardcoding, realistic non-mock corporate identity, strict typing.
- All public settings must be cached in memory/cache store with automatic cache busting on updates.
- WhatsApp communication only (all CTA hooks and contact points configured for WhatsApp click-to-chat).
- Provide unit & feature tests verifying `SettingService` and database seeding.

## Files to Create / Modify
- `app/Services/SettingService.php`
- `app/Helpers/helpers.php`
- `composer.json` (add `"files": ["app/Helpers/helpers.php"]` to `autoload`)
- `database/seeders/DatabaseSeeder.php`
- `database/seeders/DefaultCompanySeeder.php`
- `tests/Unit/SettingServiceTest.php`
- `tests/Feature/DatabaseSeederTest.php`

## Steps:
1. Implement `app/Services/SettingService.php` with `get`, `getGroup`, `getAll`, `set`, `setMany`, `forget`, `clearCache`, supporting type casting (`string`, `text`, `json`, `boolean`, `integer`, `image`).
2. Create `app/Helpers/helpers.php` defining `setting($key = null, $default = null)` and register it in `composer.json` under `autoload.files`, then run `composer dump-autoload`.
3. Write `tests/Unit/SettingServiceTest.php` testing get, set, getGroup, default fallback, cache clearing, and helper function.
4. Implement `DefaultCompanySeeder.php` and `DatabaseSeeder.php` creating:
   - Admin User (`admin@apexcorporate.com` / `Admin@Secure2026!`)
   - Complete branding, contact, SEO, hero, about, footer settings
   - 5 Services with features, icons, and custom WhatsApp messages
   - 3 Pricing Plans (Advisory, Growth, Enterprise) with features & WhatsApp triggers
   - 3 Portfolio Categories and 4 Case Studies with metrics and technologies
   - 4 Executive Testimonials with star ratings
   - 4 Senior Team Members
   - 4 Stats Counters
   - 6 Categorized FAQs
5. Write `tests/Feature/DatabaseSeederTest.php` verifying that `php artisan db:seed` runs cleanly and populates all tables.
6. Run `php artisan migrate:fresh --seed` and `php artisan test`. Verify all tests pass.
7. Commit with message: `feat: implement dynamic setting service, global helper, and comprehensive company seeder`.
8. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-3-report.md`.
