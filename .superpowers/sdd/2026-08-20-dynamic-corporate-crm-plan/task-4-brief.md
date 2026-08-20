# Task 4 Brief: Security Layer, Authentication & Admin Authorization

## Goal
Implement the enterprise security layer (security headers middleware, rate limiting, audit logging on auth), secure authentication controllers for Admin users, protected route middleware/gates, a clean accessible login interface with Alpine.js micro-interactions, and comprehensive feature tests.

## Global Constraints
- Strictly follow `.Roles/roles.md`:
  - Never trust the frontend: enforce strict server-side validation.
  - Prevent IDOR with authorization checks/gates.
  - Prevent SQL injection (ORM / parameterized queries).
  - Prevent XSS (safe Blade escaping).
  - Rate limiting on authentication endpoints.
  - Security headers (CSP, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy).
  - Audit logging of administrative authentication events.

## Files to Create / Modify
- `app/Http/Middleware/SecurityHeadersMiddleware.php`
- `app/Http/Middleware/AdminAuthenticate.php`
- `app/Http/Controllers/Admin/AuthController.php`
- `resources/views/admin/auth/login.blade.php`
- `routes/web.php`
- `bootstrap/app.php`
- `tests/Feature/AdminAuthAndSecurityTest.php`

## Steps:
1. Create `SecurityHeadersMiddleware.php` applying HSTS (when HTTPS), X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy, and Content-Security-Policy. Register it globally in `bootstrap/app.php`.
2. Create `AdminAuthenticate.php` middleware ensuring the user is authenticated and is an active admin.
3. Create `AuthController.php` handling `showLogin`, `login` (with RateLimiter rate-limiting, session regeneration, and AuditLog recording), and `logout` (session invalidation, token regeneration, and AuditLog recording).
4. Build `resources/views/admin/auth/login.blade.php` with responsive design, accessible inputs, focus-visible states, Alpine.js password visibility toggle, error displays, and dynamic corporate branding.
5. Setup web routes in `routes/web.php` for admin auth and protected admin group (`/admin/*`).
6. Implement `tests/Feature/AdminAuthAndSecurityTest.php` verifying security headers, successful login, failed login, rate limiting throttling (429/validation error), unauthenticated protection, and logout.
7. Run test suite: `php artisan test --filter=AdminAuthAndSecurityTest`.
8. Commit with message: `feat: implement security headers, rate limiting, and admin authentication layer`.
9. Write detailed report to `.superpowers/sdd/2026-08-20-dynamic-corporate-crm-plan/task-4-report.md`.
