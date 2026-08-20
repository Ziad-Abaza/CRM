<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\StatsCounter;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Services\SettingService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function __invoke(): View
    {
        $services = Service::query()->active()->ordered()->get();
        $categories = PortfolioCategory::query()->active()->ordered()->get();
        $portfolioItems = Portfolio::query()->with('category')->active()->ordered()->get();
        $pricingPlans = PricingPlan::query()->active()->ordered()->get();
        $testimonials = Testimonial::query()->active()->ordered()->get();
        $teamMembers = TeamMember::query()->active()->ordered()->get();
        $stats = StatsCounter::query()->active()->ordered()->get();
        $faqs = Faq::query()->active()->ordered()->get();

        return view('public.home', compact(
            'services',
            'categories',
            'portfolioItems',
            'pricingPlans',
            'testimonials',
            'teamMembers',
            'stats',
            'faqs'
        ));
    }
}
