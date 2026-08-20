<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\SettingService;
use Illuminate\View\View;

class ServiceDetailController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function show(string $slug): View
    {
        $service = Service::query()->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedServices = Service::query()
            ->where('id', '!=', $service->id)
            ->active()
            ->ordered()
            ->take(3)
            ->get();

        return view('public.service-detail', compact('service', 'relatedServices'));
    }
}
