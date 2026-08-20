# System Design Document: Dynamic Corporate & CRM Platform (Laravel)

**Date:** 2026-08-20  
**Status:** Validated Spec  
**Author:** Senior Full-Stack Engineer & UX/UI Architect  

---

## 1. Executive Summary & Vision
A production-ready, white-label Corporate & CRM platform built on Laravel, Blade, Tailwind CSS, and Alpine.js. The platform allows any business to manage its entire visual identity, color scheme, typography, content sections, offerings, and WhatsApp-only communication channels through a secure, comprehensive Admin Panel.

The front-end design eschews generic AI tropes (no gratuitous glassmorphism, no artificial zoom cards, no generic spinners) in favor of human-designed editorial typography, responsive CSS custom properties for dynamic theming, realistic skeleton loaders, accessible ARIA states, and crisp micro-interactions.

---

## 2. Architectural Overview

```
               +--------------------------------------------------------+
               |                   Client Browser                       |
               +--------------------------------------------------------+
                             |                              |
                   (Public SSR + Alpine.js)         (Admin Panel SPA/SSR)
                             |                              |
                             v                              v
               +--------------------------------------------------------+
               |             Laravel HTTP & Security Layer              |
               |  - CSRF Protection       - Rate Limiting Middleware    |
               |  - Security Headers      - Admin Auth & Gate/Policies  |
               +--------------------------------------------------------+
                             |                              |
               +-------------+-------------+  +-------------+-------------+
               |     Public Controllers    |  |     Admin Controllers     |
               |  - HomeController         |  |  - DashboardController    |
               |  - ServiceController      |  |  - BrandingController     |
               |  - PortfolioController    |  |  - ContentController      |
               |  - WhatsAppLeadController |  |  - LeadTrackingController |
               |  - SitemapController      |  |  - AuditLogController     |
               +---------------------------+  +---------------------------+
                             \                              /
                              v                            v
               +--------------------------------------------------------+
               |                  Eloquent ORM & Services               |
               |  - DynamicSettingService (Cached Key-Value store)      |
               |  - LeadAnalyticsService                                |
               |  - MediaUploadService (Validation & WebP conversion)   |
               +--------------------------------------------------------+
                                           |
                                           v
               +--------------------------------------------------------+
               |                 Database (SQLite / MySQL)              |
               +--------------------------------------------------------+
```

---

## 3. Core Modules & Data Model

### 3.1 Settings Table (`settings`)
Key-value store with data types (`string`, `text`, `json`, `boolean`, `image`) and grouped by categories:
- **`branding`**: `site_name`, `site_tagline`, `logo_light`, `logo_dark`, `favicon`, `primary_color`, `secondary_color`, `accent_color`, `font_heading`, `font_body`, `border_radius`.
- **`contact`**: `whatsapp_number`, `whatsapp_default_message`, `company_email`, `company_phone`, `address`, `google_maps_embed`, `working_hours`.
- **`seo`**: `meta_title_template`, `meta_default_description`, `meta_keywords`, `og_default_image`, `canonical_url`, `enable_sitemap`.
- **`hero`**: `hero_badge_text`, `hero_heading`, `hero_subheading`, `hero_cta_text`, `hero_cta_whatsapp_message`, `hero_image`, `hero_stats_json`.
- **`about`**: `about_badge`, `about_title`, `about_description`, `about_experience_years`, `about_points_json`, `about_image_1`, `about_image_2`.
- **`footer`**: `footer_tagline`, `footer_copyright`, `social_links_json`, `footer_nav_links_json`.

### 3.2 Services & Pricing (`services`, `pricing_plans`)
- **`services`**: `id`, `slug`, `title`, `icon`, `short_description`, `full_content`, `features_json`, `order`, `is_active`, `whatsapp_custom_message`.
- **`pricing_plans`**: `id`, `name`, `price`, `currency`, `billing_period`, `is_popular`, `features_json`, `order`, `whatsapp_custom_message`.

### 3.3 Portfolio & Case Studies (`portfolios`, `portfolio_categories`)
- **`portfolio_categories`**: `id`, `name`, `slug`, `order`.
- **`portfolios`**: `id`, `category_id`, `title`, `slug`, `client_name`, `summary`, `cover_image`, `gallery_json`, `technologies_json`, `results_json`, `order`, `is_active`.

### 3.4 Trust & Social Proof (`testimonials`, `team_members`, `stats_counters`, `faqs`)
- **`testimonials`**: `id`, `client_name`, `client_role`, `company_name`, `avatar`, `rating` (1-5), `content`, `order`, `is_active`.
- **`team_members`**: `id`, `name`, `role`, `bio`, `photo`, `social_links_json`, `order`, `is_active`.
- **`stats_counters`**: `id`, `label`, `value`, `prefix`, `suffix`, `icon`, `order`.
- **`faqs`**: `id`, `category`, `question`, `answer`, `order`, `is_active`.

### 3.5 WhatsApp CRM & Lead Tracking (`whatsapp_lead_clicks`)
- **`whatsapp_lead_clicks`**: `id`, `source_section` (hero, service_card, floating_widget, navbar, pricing, portfolio), `reference_type` (service, pricing_plan, general), `reference_id`, `prefilled_message`, `ip_address` (hashed/anonymized for privacy compliance), `user_agent`, `referrer_url`, `created_at`.
- *Features*: Admin analytics chart (daily WhatsApp conversion clicks, top clicked services, most active page sources) and CSV export.

### 3.6 Security & Audit Trail (`users`, `audit_logs`)
- **`users`**: Standard secure authentication (Bcrypt, Two-Factor ready, role/permission gates).
- **`audit_logs`**: `id`, `user_id`, `action` (created, updated, deleted, settings_updated), `model_type`, `model_id`, `old_values_json`, `new_values_json`, `ip_address`, `created_at`.

---

## 4. UI/UX Design System & Customization Engine

1. **Dynamic Theme Generation**:
   - Backend injects CSS variables into `<head>`:
     ```css
     :root {
       --brand-primary: #0f172a;
       --brand-secondary: #0284c7;
       --brand-accent: #22c55e;
       --font-heading: 'Plus Jakarta Sans', sans-serif;
       --font-body: 'Inter', sans-serif;
       --radius-base: 0.5rem;
     }
     ```
   - Admin settings change these values in real-time, instantly restyling the entire public application without recompilation.

2. **Refined Component States**:
   - Realistic Skeleton Loaders with shimmer animations for images, cards, and async stats.
   - Polished `:focus-visible` with high-contrast dual-ring accessibility outlines.
   - Interactive WhatsApp floating launcher with agent online badge, customized welcome bubble, and quick message prompts.
   - Clean empty states with intuitive icons and actionable call-to-actions when sections have no items yet.

---

## 5. Security & Performance Guardrails

- **Zero Unsanitized HTML**: Strict Blade `{{ $variable }}` escaping; sanitization via Purifier for rich text where explicitly enabled.
- **Strict Authorization**: Laravel Gate/Policies preventing Insecure Direct Object References (IDOR).
- **Security Headers**: Standard CSP, HSTS, `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`.
- **Zero Hardcoding**: All corporate details, contact numbers, text, images, and routes originate from dynamic configuration services with cached fallbacks.
- **Image Optimization**: Auto-resize, webp generation, lazy loading with `decoding="async"` and responsive `srcset`.
- **SEO Ready**: Auto-generated dynamic `sitemap.xml`, `robots.txt`, rich Schema.org JSON-LD (Organization, LocalBusiness, Service), and OpenGraph meta tags.

---

## 6. Verification & Test Strategy
- Unit and Feature tests with PHPUnit / Pest testing:
  - Settings retrieval and fallback defaults.
  - WhatsApp lead tracking click endpoint (validating analytics storage).
  - Admin authentication, authorization, and CRUD protection.
  - Public route rendering and dynamic theme variable injection.
