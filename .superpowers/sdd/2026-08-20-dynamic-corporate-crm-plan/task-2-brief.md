# Task 2 Brief: Database Migrations & Eloquent Data Models

## Goal
Create all database migrations and Eloquent models for the entire platform with strict typing, proper casts (`json`, `boolean`, `integer`), mass-assignment `$fillable`, relationships, scopes (`scopeActive`, `scopeOrdered`), and comprehensive automated feature tests.

## Global Constraints
- Strictly follow `.Roles/roles.md`: zero hardcoding, strict validation/casting.
- SQLite compatibility (and standard ANSI SQL compatible with MySQL/PostgreSQL).
- Eloquent models must define casts for all JSON, boolean, and integer fields.
- Prevent IDOR with proper relationships and explicit type casting.

## Files to Create / Modify
### Migrations:
- `database/migrations/xxxx_xx_xx_xxxxxx_create_settings_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_services_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_pricing_plans_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_portfolio_categories_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_portfolios_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_testimonials_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_team_members_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_stats_counters_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_faqs_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_whatsapp_lead_clicks_table.php`
- `database/migrations/xxxx_xx_xx_xxxxxx_create_audit_logs_table.php`

### Models:
- `app/Models/Setting.php`
- `app/Models/Service.php`
- `app/Models/PricingPlan.php`
- `app/Models/PortfolioCategory.php`
- `app/Models/Portfolio.php`
- `app/Models/Testimonial.php`
- `app/Models/TeamMember.php`
- `app/Models/StatsCounter.php`
- `app/Models/Faq.php`
- `app/Models/WhatsAppLeadClick.php`
- `app/Models/AuditLog.php`

### Tests:
- `tests/Feature/ModelsAndMigrationsTest.php`

## Steps:
1. Write migration files for all 11 entities with appropriate indexes, foreign keys, and nullable fields.
2. Create Eloquent models in `app/Models/` with:
   - `$fillable` array defined.
   - `casts()` or `$casts` for json (`array`), boolean (`boolean`), integer (`integer`).
   - Relationships (`Portfolio::category()`, `PortfolioCategory::portfolios()`, `AuditLog::user()`).
   - Query scopes (`scopeActive($query)`, `scopeOrdered($query)`).
3. Write `tests/Feature/ModelsAndMigrationsTest.php` to test creating, querying, relationship traversal, and casting for every model.
4. Run `php artisan migrate:fresh` and `php artisan test --filter=ModelsAndMigrationsTest`. Ensure all tests pass.
5. Commit with message: `feat: implement database migrations and eloquent models for all platform entities`.
6. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-2-report.md`.
