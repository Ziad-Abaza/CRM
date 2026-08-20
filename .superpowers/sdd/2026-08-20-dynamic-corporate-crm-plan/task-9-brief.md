# Task 9 Brief: SEO, Sitemap, Audit Logs & Production Self-Audit

## Goal
Implement dynamic XML Sitemap generator (`/sitemap.xml`), dynamic `robots.txt`, Schema.org JSON-LD structured data and OpenGraph tags, a dedicated Admin Audit Logs viewer with filter/search and CSV export, and perform a complete production self-audit (Security, Accessibility, Core Web Vitals, WhatsApp-only flow, zero hardcoding) with full automated test coverage and clean production asset build.

## Global Constraints
- Strictly follow `.Roles/roles.md`:
  - Production-ready, fully responsive, zero mock placeholders.
  - Complete security audit: strict validation, IDOR prevention, rate limiting, security headers.
  - SEO optimization: XML Sitemap, robots.txt, Schema.org JSON-LD Organization & Service metadata, OpenGraph tags.
  - Full automated tests passing and `npm run build` clean.

## Files to Create / Modify
- `app/Http/Controllers/Public/SitemapController.php`
- `app/Http/Controllers/Admin/AuditLogController.php`
- `resources/views/admin/audit-logs/index.blade.php`
- `resources/views/layouts/public.blade.php` (add Schema.org JSON-LD & OG tags)
- `resources/views/layouts/admin.blade.php` (ensure Audit Logs link is in sidebar)
- `routes/web.php`
- `tests/Feature/SeoAndAuditTest.php`

## Steps:
1. Implement `SitemapController.php` with:
   - `index()` returning `application/xml` or `text/xml` containing dynamic URLs for homepage, active services, and active case studies.
   - `robots()` returning `text/plain` robots.txt with `Sitemap: ...` directive.
2. Inject Schema.org JSON-LD structured data (`Organization`, `WebSite`) and OpenGraph/Twitter meta tags in `resources/views/layouts/public.blade.php`.
3. Implement `AuditLogController.php` and `resources/views/admin/audit-logs/index.blade.php` with search, action filtering, date filtering, pagination, JSON diff modal, and CSV export.
4. Register routes in `routes/web.php` (`/sitemap.xml`, `/robots.txt`, `/admin/audit-logs`, `/admin/audit-logs/export`).
5. Write `tests/Feature/SeoAndAuditTest.php` verifying sitemap XML structure, robots.txt response, audit logs index authentication, filtering, and CSV export.
6. Perform end-to-end production verification: run `php artisan test` (all tests passing) and `npm run build` (clean compilation).
7. Commit with message: `feat: implement dynamic sitemap, robots.txt, schema.org structured data, and admin audit logs explorer`.
8. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-9-report.md`.
