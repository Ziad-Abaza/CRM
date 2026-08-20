<?php

namespace App\Providers;

use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\StatsCounter;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;
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
        // Auto cache invalidation on any content mutation
        $clearHomeCache = static function () {
            Cache::forget('public.home.page_data');
        };

        Service::saved($clearHomeCache);
        Service::deleted($clearHomeCache);
        Portfolio::saved($clearHomeCache);
        Portfolio::deleted($clearHomeCache);
        PortfolioCategory::saved($clearHomeCache);
        PortfolioCategory::deleted($clearHomeCache);
        PricingPlan::saved($clearHomeCache);
        PricingPlan::deleted($clearHomeCache);
        Testimonial::saved($clearHomeCache);
        Testimonial::deleted($clearHomeCache);
        TeamMember::saved($clearHomeCache);
        TeamMember::deleted($clearHomeCache);
        StatsCounter::saved($clearHomeCache);
        StatsCounter::deleted($clearHomeCache);
        Faq::saved($clearHomeCache);
        Faq::deleted($clearHomeCache);
    }
}
