<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Services\SettingService;
use Illuminate\View\View;

class PortfolioDetailController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function show(string $locale, ?string $slug = null): View
    {
        if ($slug === null) {
            $slug = $locale;
        }

        $portfolio = Portfolio::query()
            ->with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedCaseStudies = Portfolio::query()
            ->with('category')
            ->where('id', '!=', $portfolio->id)
            ->active()
            ->ordered()
            ->take(3)
            ->get();

        return view('public.portfolio-detail', compact('portfolio', 'relatedCaseStudies'));
    }
}
