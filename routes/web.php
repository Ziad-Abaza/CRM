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

        // 1. Services CRUD
        Route::patch('services/{service}/toggle', [\App\Http\Controllers\Admin\ServiceController::class, 'toggle'])->name('services.toggle');
        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->except(['show']);

        // 2. Portfolio & Categories CRUD
        Route::patch('portfolio/{portfolio}/toggle', [\App\Http\Controllers\Admin\PortfolioController::class, 'toggle'])->name('portfolio.toggle');
        Route::get('portfolio/categories', [\App\Http\Controllers\Admin\PortfolioController::class, 'categories'])->name('portfolio.categories');
        Route::post('portfolio/categories', [\App\Http\Controllers\Admin\PortfolioController::class, 'storeCategory'])->name('portfolio.categories.store');
        Route::put('portfolio/categories/{category}', [\App\Http\Controllers\Admin\PortfolioController::class, 'updateCategory'])->name('portfolio.categories.update');
        Route::delete('portfolio/categories/{category}', [\App\Http\Controllers\Admin\PortfolioController::class, 'destroyCategory'])->name('portfolio.categories.destroy');
        Route::resource('portfolio', \App\Http\Controllers\Admin\PortfolioController::class)->except(['show']);

        // 3. Pricing Plans CRUD
        Route::patch('pricing/{pricing}/toggle', [\App\Http\Controllers\Admin\PricingPlanController::class, 'toggle'])->name('pricing.toggle');
        Route::resource('pricing', \App\Http\Controllers\Admin\PricingPlanController::class)->except(['show']);

        // 4. Testimonials CRUD
        Route::patch('testimonials/{testimonial}/toggle', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggle'])->name('testimonials.toggle');
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);

        // 5. Team Members CRUD
        Route::patch('team/{team}/toggle', [\App\Http\Controllers\Admin\TeamMemberController::class, 'toggle'])->name('team.toggle');
        Route::resource('team', \App\Http\Controllers\Admin\TeamMemberController::class)->except(['show']);

        // 6. Stats Counters CRUD
        Route::patch('stats/{stat}/toggle', [\App\Http\Controllers\Admin\StatsCounterController::class, 'toggle'])->name('stats.toggle');
        Route::resource('stats', \App\Http\Controllers\Admin\StatsCounterController::class)->except(['show']);

        // 7. FAQs CRUD
        Route::patch('faqs/{faq}/toggle', [\App\Http\Controllers\Admin\FaqController::class, 'toggle'])->name('faqs.toggle');
        Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class)->except(['show']);
    });
});
