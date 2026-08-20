# Task 5 Brief: Admin Panel UI & Core Configuration Modules

## Goal
Build the modern, human-designed Admin Panel Layout, Dashboard, and core Configuration Modules (Branding & Live Visual Customizer, Hero Section Manager, About Section Manager, WhatsApp & Contact Profile Manager, SEO & Metadata Manager, Footer & Social Links Manager) with strict validation, file upload security, audit logging, and automated tests.

## Global Constraints
- Strictly follow `.Roles/roles.md`:
  - Zero hardcoding of configuration values.
  - Strict server-side validation for all fields (hex colors, text lengths, MIME-checked image uploads).
  - No AI-archetype visual tropes: high-contrast layout, clean typography, realistic skeleton states, accessible focus states.
  - Audit logging of all administrative setting mutations.
  - WhatsApp-only customer communication configuration.

## Files to Create / Modify
- `resources/views/layouts/admin.blade.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/branding/index.blade.php`
- `resources/views/admin/content/hero.blade.php`
- `resources/views/admin/content/about.blade.php`
- `resources/views/admin/content/contact.blade.php`
- `resources/views/admin/content/seo.blade.php`
- `resources/views/admin/content/footer.blade.php`
- `app/Http/Controllers/Admin/DashboardController.php`
- `app/Http/Controllers/Admin/BrandingController.php`
- `app/Http/Controllers/Admin/ContentSectionController.php`
- `routes/web.php`
- `tests/Feature/AdminBrandingAndContentTest.php`

## Steps:
1. Create `resources/views/layouts/admin.blade.php` with responsive sidebar navigation, topbar with user profile & logout, flash toast notifications, active link highlights, and Alpine.js micro-interactions.
2. Implement `DashboardController.php` and `resources/views/admin/dashboard.blade.php` with metrics cards, recent lead clicks, quick-access shortcuts, and audit log snippets.
3. Implement `BrandingController.php` and `resources/views/admin/branding/index.blade.php` featuring live Alpine.js color/typography preview, secure file uploads for logos & favicon (`storage/app/public/branding`), and audit logging.
4. Implement `ContentSectionController.php` and corresponding blade views for Hero, About, Contact (WhatsApp numbers & messages), SEO, and Footer management.
5. Register admin routes in `routes/web.php` under the protected `admin.auth` group.
6. Implement `tests/Feature/AdminBrandingAndContentTest.php` testing dashboard metrics, branding updates, file uploads, section updates, and validation error cases.
7. Run `php artisan test --filter=AdminBrandingAndContentTest` and full test suite.
8. Commit with message: `feat: implement admin panel layout, dashboard, branding customizer, and core content section managers`.
9. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-5-report.md`.
