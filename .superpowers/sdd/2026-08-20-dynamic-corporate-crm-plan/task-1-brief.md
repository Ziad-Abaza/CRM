# Task 1 Brief: Initialize Laravel Application & Environment Setup

## Goal
Scaffold and initialize the Laravel 11/12 application in the current directory (`D:/coding/projects/web developer/Laravel/CRM`), configure SQLite database, generate application key, setup Tailwind CSS & Alpine.js with Vite, and verify the setup with a passing feature test.

## Global Constraints
- Laravel PHP 8.4+ environment.
- Zero hardcoded environment configs (use `.env`).
- SQLite database configured as default (`database/database.sqlite`).
- Strict adhere to `.Roles/roles.md`.

## Files:
- Create/Initialize: `composer.json`, `.env.example`, `.env`, `artisan`, `vite.config.js`, `package.json`, `database/database.sqlite`
- Modify: `config/database.php`, `config/app.php`
- Test: `tests/Feature/EnvironmentSetupTest.php`

## Steps:
1. Initialize/scaffold Laravel structure if needed (e.g. composer create-project or artisan setup in place).
2. Configure `.env` and `config/database.php` for SQLite (`DB_CONNECTION=sqlite`, `DB_DATABASE=database/database.sqlite`). Ensure `database/database.sqlite` exists.
3. Setup `package.json` with `@tailwindcss/vite` or `tailwindcss`, `postcss`, `autoprefixer`, and `alpinejs`. Configure `vite.config.js` and `resources/css/app.css`, `resources/js/app.js`.
4. Write a feature test in `tests/Feature/EnvironmentSetupTest.php` asserting application boots, returns HTTP 200 on `/`, and database connection is operational.
5. Run test suite: `php artisan test --filter=EnvironmentSetupTest` and verify all tests pass.
6. Commit changes with a clean message.
