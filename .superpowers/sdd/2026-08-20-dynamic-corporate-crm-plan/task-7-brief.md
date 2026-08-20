# Task 7 Brief: WhatsApp CRM Engine & Telemetry Analytics

## Goal
Implement the end-to-end WhatsApp CRM conversion engine, including the telemetry click tracking API, direct WhatsApp redirection handlers, reusable Blade WhatsApp CTA & Floating Launcher components, the Admin CRM Analytics & Leads Dashboard, and CSV export capabilities with comprehensive automated test coverage.

## Global Constraints
- Strictly follow `.Roles/roles.md`:
  - Customer communication MUST be through WhatsApp only (zero web-form submissions).
  - Anonymize IP addresses stored in lead clicks for privacy.
  - Zero hardcoding of phone numbers or message templates (pull dynamically from `SettingService` or model properties).
  - Provide human-designed, responsive, accessible components with realistic animations.
  - Comprehensive feature tests for all tracking, redirection, and admin analytics flows.

## Files to Create / Modify
- `app/Http/Controllers/Public/WhatsAppLeadController.php`
- `app/Http/Controllers/Admin/LeadAnalyticsController.php`
- `resources/views/admin/leads/index.blade.php`
- `resources/views/components/whatsapp-floating-widget.blade.php`
- `resources/views/components/whatsapp-cta-button.blade.php`
- `resources/js/whatsapp-tracker.js` (or inline Alpine.js component helper)
- `routes/web.php`
- `tests/Feature/WhatsAppLeadTrackingTest.php`

## Steps:
1. Implement `WhatsAppLeadController.php` with:
   - `trackClick(Request $request)` (POST API): Validates payload, stores lead click with anonymized IP, resolves WhatsApp number & prefilled message, and returns JSON with generated `whatsapp_url`.
   - `redirect(Request $request)` (GET): Logs click and directly redirects to `https://wa.me/...`.
2. Implement `LeadAnalyticsController.php` with:
   - `index(Request $request)`: Computes KPI summary cards, daily trends, source section breakdown, and paginated lead table with search/filters.
   - `exportCsv(Request $request)`: Streams CSV download of lead records.
   - `destroy(WhatsAppLeadClick $lead)`: Deletes record and logs audit trail.
3. Build `resources/views/admin/leads/index.blade.php` with telemetry metrics, source breakdown chart/bars, search filter bar, CSV export, and table.
4. Build `resources/views/components/whatsapp-floating-widget.blade.php` with interactive Alpine.js popup, agent status, quick inquiry prompt buttons, and asynchronous telemetry logging.
5. Build `resources/views/components/whatsapp-cta-button.blade.php` with customizable styles, icon, section tag, and asynchronous telemetry trigger.
6. Register public tracking and admin CRM routes in `routes/web.php`.
7. Implement `tests/Feature/WhatsAppLeadTrackingTest.php` testing API tracking, redirection, admin leads view, CSV export, and deletion.
8. Run `php artisan test --filter=WhatsAppLeadTrackingTest` and full test suite.
9. Commit with message: `feat: implement whatsapp crm engine, telemetry click tracking, and admin analytics dashboard`.
10. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-7-report.md`.
