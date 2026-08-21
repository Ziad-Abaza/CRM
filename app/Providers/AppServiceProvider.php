<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::defaults(['locale' => config('locales.default', 'en')]);

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with([
                'appName' => app_name(),
                'appTagline' => app_tagline(),
                'appEmail' => app_email(),
            ]);
        });
    }
}
