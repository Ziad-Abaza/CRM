# Task 6 Brief: Admin Content Management (Services, Portfolio, Pricing, Testimonials, Team, FAQs, Stats)

## Goal
Implement full administrative CRUD management interfaces and controllers for all corporate content entities (Services, Portfolios & Categories, Pricing Plans, Testimonials, Team Members, Stats Counters, and FAQs) with strict validation, secure media upload handling, dynamic Alpine.js array managers for JSON fields, comprehensive audit logging, and automated feature test suites.

## Global Constraints
- Strictly follow `.Roles/roles.md`:
  - Never trust the frontend: strict server-side validation.
  - Prevent IDOR with authorization checks.
  - Zero hardcoding of business logic or mockup strings.
  - Provide human-designed, accessible UI with custom empty states, proper loading feedback, and realistic skeleton components.
  - Log audit trails for all creation, update, deletion, and toggle actions.

## Files to Create / Modify
- `app/Http/Controllers/Admin/ServiceController.php`
- `app/Http/Controllers/Admin/PortfolioController.php`
- `app/Http/Controllers/Admin/PricingPlanController.php`
- `app/Http/Controllers/Admin/TestimonialController.php`
- `app/Http/Controllers/Admin/TeamMemberController.php`
- `app/Http/Controllers/Admin/StatsCounterController.php`
- `app/Http/Controllers/Admin/FaqController.php`
- `resources/views/admin/services/*`
- `resources/views/admin/portfolio/*`
- `resources/views/admin/pricing/*`
- `resources/views/admin/testimonials/*`
- `resources/views/admin/team/*`
- `resources/views/admin/stats/*`
- `resources/views/admin/faqs/*`
- `routes/web.php`
- `tests/Feature/AdminContentCrudTest.php`

## Steps:
1. Implement `ServiceController.php` and views with slug validation, JSON features list editor, custom WhatsApp quote templates, order, and active toggle.
2. Implement `PortfolioController.php` and views with category management, cover image upload, tech stack array editor, results array editor, and active toggle.
3. Implement `PricingPlanController.php` and views with currency, price, billing cycle, popular badge toggle, features array editor, and custom WhatsApp quote templates.
4. Implement `TestimonialController.php` and views with client name, role, company, star rating (1-5), avatar upload, and active toggle.
5. Implement `TeamMemberController.php` and views with name, role, bio, photo upload, social links, and active toggle.
6. Implement `StatsCounterController.php` and `FaqController.php` with ordering, icons, category filters, and active toggles.
7. Register all resource and toggle routes in `routes/web.php` under the protected `admin.auth` group.
8. Ensure all mutations write structured entries to `AuditLog`.
9. Implement `tests/Feature/AdminContentCrudTest.php` thoroughly testing CRUD, validation failures, image uploads, and audit trails.
10. Run test suite: `php artisan test --filter=AdminContentCrudTest` and full suite.
11. Commit with message: `feat: implement admin content management crud for services, portfolio, pricing, testimonials, team, stats, and faqs`.
12. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-6-report.md`.
