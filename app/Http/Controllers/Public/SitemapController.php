<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for SEO discovery.
     */
    public function index(): Response
    {
        $urls = [];

        $locales = array_keys(function_exists('supported_locales') ? supported_locales() : config('locales.supported', ['en' => [], 'ar' => []]));

        // 1. Homepages for all supported locales
        foreach ($locales as $locale) {
            $urls[] = [
                'loc' => localized_route('home', [], $locale),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ];
        }

        // 2. Active Services for all supported locales
        $services = Service::where('is_active', true)->latest('updated_at')->get();
        foreach ($locales as $locale) {
            foreach ($services as $service) {
                $urls[] = [
                    'loc' => localized_route('service.detail', ['slug' => $service->slug], $locale),
                    'lastmod' => $service->updated_at?->toAtomString() ?? now()->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }
        }

        // 3. Active Portfolio / Case Studies for all supported locales
        $portfolios = Portfolio::where('is_active', true)->latest('updated_at')->get();
        foreach ($locales as $locale) {
            foreach ($portfolios as $portfolio) {
                $urls[] = [
                    'loc' => localized_route('portfolio.detail', ['slug' => $portfolio->slug], $locale),
                    'lastmod' => $portfolio->updated_at?->toAtomString() ?? now()->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        }

        $xml = view('public.sitemap', compact('urls'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    /**
     * Generate dynamic robots.txt output.
     */
    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');

        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /whatsapp/redirect\n";
        $content .= "\n";
        $content .= "Sitemap: {$sitemapUrl}\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
