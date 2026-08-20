# Task 8 Brief: Public Corporate Website Frontend & Dynamic Theming

## Goal
Build the public corporate website frontend (Home page, Service Detail page, Portfolio Case Study Detail page) with dynamic real-time CSS custom property theming, Google Fonts loader, human-designed accessible UI components (Hero, Services, Portfolio, Pricing, Testimonials, Team, Stats, FAQs, CTA Banner, Footer, Floating WhatsApp Widget), and comprehensive feature tests.

## Global Constraints
- Strictly follow `.Roles/roles.md`:
  - Production-ready corporate aesthetic (editorial typography, crisp borders, no generic AI tropes).
  - Zero hardcoding: all content, identity, colors, typography, and links must be dynamically pulled from `SettingService` and Eloquent models.
  - Customer communication strictly through WhatsApp (all CTAs wired with WhatsApp tracking).
  - Semantic HTML5, WCAG accessible, realistic skeleton/loading states, responsive design.

## Files to Create / Modify
- `resources/views/layouts/public.blade.php`
- `resources/views/public/home.blade.php`
- `resources/views/public/service-detail.blade.php`
- `resources/views/public/portfolio-detail.blade.php`
- `resources/views/components/hero-section.blade.php`
- `resources/views/components/services-section.blade.php`
- `resources/views/components/portfolio-section.blade.php`
- `resources/views/components/pricing-section.blade.php`
- `resources/views/components/testimonials-section.blade.php`
- `resources/views/components/team-section.blade.php`
- `resources/views/components/faqs-section.blade.php`
- `resources/views/components/cta-banner.blade.php`
- `resources/views/components/footer.blade.php`
- `app/Http/Controllers/Public/HomeController.php`
- `app/Http/Controllers/Public/ServiceDetailController.php` (or `ServiceController.php`)
- `app/Http/Controllers/Public/PortfolioDetailController.php` (or `PortfolioController.php`)
- `routes/web.php`
- `tests/Feature/PublicFrontendTest.php`

## Steps:
1. Create `resources/views/layouts/public.blade.php` with dynamic CSS variables (`--brand-primary`, `--brand-secondary`, `--brand-accent`, `--font-heading`, `--font-body`, `--radius-base`), Google Fonts dynamically loaded based on settings, navbar, floating WhatsApp widget, and footer.
2. Implement `HomeController.php` retrieving all active models and rendering `resources/views/public/home.blade.php` with all 8 dynamic section components.
3. Implement `ServiceDetailController.php` and `resources/views/public/service-detail.blade.php` for rich individual service pages with custom WhatsApp quote button.
4. Implement `PortfolioDetailController.php` and `resources/views/public/portfolio-detail.blade.php` for rich case study showcases with metrics, tech stacks, and WhatsApp inquiry button.
5. Register public routes in `routes/web.php` (`/`, `/services/{slug}`, `/portfolio/{slug}`).
6. Verify assets compilation: `npm run build`.
7. Implement `tests/Feature/PublicFrontendTest.php` asserting HTTP 200, dynamic theme injection, model data rendering, slug detail routing, 404 handling, and WhatsApp CTA attributes.
8. Run `php artisan test --filter=PublicFrontendTest` and full suite.
9. Commit with message: `feat: implement public corporate website frontend, dynamic theme engine, and detail pages`.
10. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-8-report.md`.
