<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Branding & Visual Theme Customizer
        Route::get('/branding', [\App\Http\Controllers\Admin\BrandingController::class, 'index'])->name('branding.index');
        Route::put('/branding', [\App\Http\Controllers\Admin\BrandingController::class, 'update'])->name('branding.update');

        // Content Section Managers
        Route::prefix('content')->name('content.')->group(function () {
            Route::get('/hero', [\App\Http\Controllers\Admin\ContentSectionController::class, 'hero'])->name('hero');
            Route::put('/hero', [\App\Http\Controllers\Admin\ContentSectionController::class, 'updateHero'])->name('hero.update');

            Route::get('/about', [\App\Http\Controllers\Admin\ContentSectionController::class, 'about'])->name('about');
            Route::put('/about', [\App\Http\Controllers\Admin\ContentSectionController::class, 'updateAbout'])->name('about.update');

            Route::get('/contact', [\App\Http\Controllers\Admin\ContentSectionController::class, 'contact'])->name('contact');
            Route::put('/contact', [\App\Http\Controllers\Admin\ContentSectionController::class, 'updateContact'])->name('contact.update');

            Route::get('/seo', [\App\Http\Controllers\Admin\ContentSectionController::class, 'seo'])->name('seo');
            Route::put('/seo', [\App\Http\Controllers\Admin\ContentSectionController::class, 'updateSeo'])->name('seo.update');

            Route::get('/footer', [\App\Http\Controllers\Admin\ContentSectionController::class, 'footer'])->name('footer');
            Route::put('/footer', [\App\Http\Controllers\Admin\ContentSectionController::class, 'updateFooter'])->name('footer.update');
        });
    });
});
