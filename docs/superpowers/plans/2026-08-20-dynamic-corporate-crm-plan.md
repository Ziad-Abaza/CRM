# Dynamic Corporate & CRM Platform Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a production-ready, white-label Corporate & CRM platform in Laravel with Blade, Tailwind CSS, Alpine.js, SQLite database, dynamic live branding/theming, section content management, WhatsApp lead tracking CRM, and comprehensive admin panel.

**Architecture:** Laravel 11/12 MVC architecture with cached `DynamicSettingService`, clean Eloquent models for content entities (Services, Portfolios, Testimonials, Team, Pricing, Stats, FAQs, Leads, AuditLogs), strict security headers & Gate/Policy authorization, Blade component-driven UI with responsive CSS variables for instant live theme customization, and an asynchronous WhatsApp click-to-chat CRM analytics tracker.

**Tech Stack:** PHP 8.4+, Laravel 11/12, Blade, Tailwind CSS (Vite), Alpine.js, Lucide/Heroicons SVG, SQLite.

## Global Constraints
- Strictly follow `.Roles/roles.md`: zero hardcoding of branding or business logic, zero AI-archetype visual tropes, WCAG accessible, realistic skeleton loaders, custom empty/loading states.
- Customer communication strictly through WhatsApp (no web form submission inputs).
- Dynamic branding & colors injected via CSS variables (`--brand-primary`, `--brand-secondary`, etc.).
- Complete Admin Panel to manage branding, navigation, sections, services, pricing, portfolio, team, testimonials, stats, FAQs, and WhatsApp lead telemetry.

---

### Task 1: Initialize Laravel Application & Environment Setup
**Files:**
- Create/Initialize: `composer.json`, `.env.example`, `.env`, `artisan`, `vite.config.js`, `package.json`
- Modify: `config/database.php`, `config/app.php`
- Test: `tests/Feature/EnvironmentSetupTest.php`

**Interfaces:**
- Consumes: Composer, Node/NPM, PHP 8.4+
- Produces: Working Laravel application with SQLite database and Vite Tailwind setup

- [ ] **Step 1: Scaffold Laravel application via Composer if not already created**
Run: `composer create-project laravel/laravel . --prefer-dist --no-interaction` or ensure base structure.
- [ ] **Step 2: Configure `.env` for SQLite and App Key generation**
Run: `php artisan key:generate` and setup `database/database.sqlite`.
- [ ] **Step 3: Setup Tailwind CSS and Alpine.js assets**
Run: `npm install -D tailwindcss @tailwindcss/vite postcss autoprefixer; npm install alpinejs`
- [ ] **Step 4: Write test verifying application boots and database connection works**
Write `tests/Feature/EnvironmentSetupTest.php` to assert `true`.
- [ ] **Step 5: Run tests and verify passing**
Run: `php artisan test --filter=EnvironmentSetupTest`
- [ ] **Step 6: Commit**

---

### Task 2: Database Migrations & Eloquent Data Models
**Files:**
- Create: `database/migrations/*_create_settings_table.php`
- Create: `database/migrations/*_create_services_table.php`
- Create: `database/migrations/*_create_pricing_plans_table.php`
- Create: `database/migrations/*_create_portfolios_table.php`
- Create: `database/migrations/*_create_testimonials_table.php`
- Create: `database/migrations/*_create_team_members_table.php`
- Create: `database/migrations/*_create_stats_counters_table.php`
- Create: `database/migrations/*_create_faqs_table.php`
- Create: `database/migrations/*_create_whatsapp_lead_clicks_table.php`
- Create: `database/migrations/*_create_audit_logs_table.php`
- Create: `app/Models/Setting.php`, `app/Models/Service.php`, `app/Models/PricingPlan.php`, `app/Models/Portfolio.php`, `app/Models/PortfolioCategory.php`, `app/Models/Testimonial.php`, `app/Models/TeamMember.php`, `app/Models/StatsCounter.php`, `app/Models/Faq.php`, `app/Models/WhatsAppLeadClick.php`, `app/Models/AuditLog.php`
- Test: `tests/Feature/ModelsAndMigrationsTest.php`

**Interfaces:**
- Consumes: Eloquent ORM, SQLite schema builder
- Produces: Full database schema with relationships and casted JSON/boolean attributes

- [ ] **Step 1: Write migrations for all entities**
- [ ] **Step 2: Create Eloquent models with fillable, casts, scopes, and relationships**
- [ ] **Step 3: Write test testing model CRUD and schema integrity**
- [ ] **Step 4: Run migration and tests**
Run: `php artisan migrate:fresh --seed=false; php artisan test --filter=ModelsAndMigrationsTest`
- [ ] **Step 5: Commit**

---

### Task 3: Dynamic Setting Service & Default Seeders
**Files:**
- Create: `app/Services/SettingService.php`
- Create: `app/Helpers/SettingHelper.php`
- Create: `database/seeders/DatabaseSeeder.php`
- Create: `database/seeders/DefaultCompanySeeder.php`
- Test: `tests/Unit/SettingServiceTest.php`

**Interfaces:**
- Consumes: `Setting` model, Cache facade
- Produces: `setting($key, $default = null)`, `SettingService::getGroup($group)`, `SettingService::set($key, $value)`

- [ ] **Step 1: Write failing unit test for `SettingService` (caching, fallback values, type casting)**
- [ ] **Step 2: Implement `SettingService` with tag/key caching and type preservation**
- [ ] **Step 3: Implement comprehensive `DefaultCompanySeeder` with realistic, non-AI corporate data (Apex Solutions Corp)**
- [ ] **Step 4: Run migrations and seed database**
Run: `php artisan migrate:fresh --seed; php artisan test --filter=SettingServiceTest`
- [ ] **Step 5: Commit**

---

### Task 4: Security Layer, Authentication & Admin Authorization
**Files:**
- Create: `app/Http/Middleware/SecurityHeadersMiddleware.php`
- Create: `app/Http/Middleware/AdminAuthenticate.php`
- Create: `app/Http/Controllers/Admin/AuthController.php`
- Create: `resources/views/admin/auth/login.blade.php`
- Test: `tests/Feature/AdminAuthAndSecurityTest.php`

**Interfaces:**
- Consumes: Session guard, Hash, RateLimiter
- Produces: Secure admin login, CSRF verification, CSP/HSTS headers, Audit logging

- [ ] **Step 1: Write tests for Admin login, authentication throttling, and security headers**
- [ ] **Step 2: Implement `SecurityHeadersMiddleware` and register in bootstrap/app.php**
- [ ] **Step 3: Implement `AuthController` with rate limiting, secure session regeneration, and logout**
- [ ] **Step 4: Build high-contrast, accessible Admin Login view**
- [ ] **Step 5: Run tests and verify passing**
- [ ] **Step 6: Commit**

---

### Task 5: Admin Panel UI & Core Configuration Modules
**Files:**
- Create: `resources/views/layouts/admin.blade.php`
- Create: `resources/views/admin/dashboard.blade.php`
- Create: `resources/views/admin/branding/index.blade.php`
- Create: `resources/views/admin/content/sections.blade.php`
- Create: `app/Http/Controllers/Admin/DashboardController.php`
- Create: `app/Http/Controllers/Admin/BrandingController.php`
- Create: `app/Http/Controllers/Admin/ContentSectionController.php`
- Test: `tests/Feature/AdminBrandingAndContentTest.php`

**Interfaces:**
- Consumes: `SettingService`, `AuditLog`
- Produces: Live theme color picker, font selector, logo uploader, hero/about/footer section managers

- [ ] **Step 1: Write tests for updating branding settings and content sections**
- [ ] **Step 2: Build responsive, accessible Admin Layout with sidebar, breadcrumbs, toasts, and skeleton loaders**
- [ ] **Step 3: Implement `BrandingController` & `ContentSectionController` with strict validation**
- [ ] **Step 4: Build interactive admin views with Alpine.js previewing**
- [ ] **Step 5: Run tests and verify passing**
- [ ] **Step 6: Commit**

---

### Task 6: Admin Content Management (Services, Portfolio, Pricing, Testimonials, Team, FAQs)
**Files:**
- Create: `app/Http/Controllers/Admin/ServiceController.php`
- Create: `app/Http/Controllers/Admin/PortfolioController.php`
- Create: `app/Http/Controllers/Admin/PricingPlanController.php`
- Create: `app/Http/Controllers/Admin/TestimonialController.php`
- Create: `app/Http/Controllers/Admin/TeamMemberController.php`
- Create: `app/Http/Controllers/Admin/FaqController.php`
- Create: `resources/views/admin/services/*`, `resources/views/admin/portfolio/*`, etc.
- Test: `tests/Feature/AdminCrudTest.php`

**Interfaces:**
- Consumes: Models, File upload handling
- Produces: Complete CRUD interfaces with sorting, status toggle, validation, and audit tracking

- [ ] **Step 1: Write comprehensive CRUD feature tests**
- [ ] **Step 2: Implement Controllers with Form Requests & sanitization**
- [ ] **Step 3: Build human-designed Admin views with empty states and validation feedback**
- [ ] **Step 4: Run tests and verify passing**
- [ ] **Step 5: Commit**

---

### Task 7: WhatsApp CRM Engine & Telemetry Analytics
**Files:**
- Create: `app/Http/Controllers/Public/WhatsAppLeadController.php`
- Create: `app/Http/Controllers/Admin/LeadAnalyticsController.php`
- Create: `resources/views/admin/leads/index.blade.php`
- Create: `resources/views/components/whatsapp-floating-widget.blade.php`
- Create: `resources/views/components/whatsapp-cta-button.blade.php`
- Test: `tests/Feature/WhatsAppLeadTrackingTest.php`

**Interfaces:**
- Consumes: Request metadata, Client IP (hashed), User-Agent
- Produces: Asynchronous click logger (`/api/track-whatsapp-click`), dynamic WhatsApp redirection URLs, Admin CRM Analytics dashboard with CSV export

- [ ] **Step 1: Write tests for click logging and analytics calculation**
- [ ] **Step 2: Implement `WhatsAppLeadController` and `LeadAnalyticsController`**
- [ ] **Step 3: Build Admin Leads & CRM analytics view with charts/metrics**
- [ ] **Step 4: Run tests and verify passing**
- [ ] **Step 5: Commit**

---

### Task 8: Public Corporate Website Frontend & Dynamic Theming
**Files:**
- Create: `resources/views/layouts/public.blade.php`
- Create: `resources/views/public/home.blade.php`
- Create: `resources/views/public/service-detail.blade.php`
- Create: `resources/views/public/portfolio-detail.blade.php`
- Create: `resources/views/components/hero-section.blade.php`
- Create: `resources/views/components/services-section.blade.php`
- Create: `resources/views/components/portfolio-section.blade.php`
- Create: `resources/views/components/pricing-section.blade.php`
- Create: `resources/views/components/testimonials-section.blade.php`
- Create: `resources/views/components/team-section.blade.php`
- Create: `resources/views/components/faqs-section.blade.php`
- Create: `resources/views/components/stats-section.blade.php`
- Create: `resources/views/components/footer.blade.php`
- Create: `app/Http/Controllers/Public/HomeController.php`
- Test: `tests/Feature/PublicFrontendTest.php`

**Interfaces:**
- Consumes: `SettingService`, Eloquent models, Dynamic CSS variables
- Produces: Distinctive, modern corporate frontend with 0 AI visual tropes, full keyboard accessibility, skeleton states, and direct WhatsApp triggers

- [ ] **Step 1: Write tests checking public page rendering, dynamic CSS theme variables, and zero unescaped tags**
- [ ] **Step 2: Build Public Layout with dynamic font loading and CSS variable injection**
- [ ] **Step 3: Build modern, accessible section components with realistic skeleton states**
- [ ] **Step 4: Implement Service and Portfolio detail pages**
- [ ] **Step 5: Run tests and verify passing**
- [ ] **Step 6: Commit**

---

### Task 9: SEO, Sitemap, Audit Logs & Production Self-Audit
**Files:**
- Create: `app/Http/Controllers/Public/SitemapController.php`
- Create: `app/Http/Controllers/Admin/AuditLogController.php`
- Create: `resources/views/admin/audit-logs/index.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/SeoAndAuditTest.php`

**Interfaces:**
- Consumes: Models, System routes
- Produces: `sitemap.xml`, `robots.txt`, OpenGraph/Schema.org tags, Audit Logs viewer

- [ ] **Step 1: Write tests for Sitemap XML generation, robots.txt, and audit logs**
- [ ] **Step 2: Implement dynamic `SitemapController` and JSON-LD schema builder**
- [ ] **Step 3: Implement `AuditLogController` and view**
- [ ] **Step 4: Perform end-to-end audit (Security, Accessibility, Core Web Vitals, Performance, WhatsApp-only flow)**
- [ ] **Step 5: Run all test suites and compile production assets (`npm run build`)**
Run: `php artisan test; npm run build`
- [ ] **Step 6: Commit**
