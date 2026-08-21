<?php

return [
    'default' => env('APP_LOCALE', 'en'),
    'fallback' => env('APP_FALLBACK_LOCALE', 'en'),
    'rtl_locales' => ['ar', 'fa', 'he', 'ur'],
    'cookie_name' => 'app_locale',
    'session_key' => 'locale',
    'supported' => [
        'en' => [
            'code' => 'en',
            'name' => 'English',
            'native' => 'English',
            'direction' => 'ltr',
            'font' => 'Plus Jakarta Sans',
            'font_heading' => 'Plus Jakarta Sans',
            'flag' => '🇺🇸',
            'og_locale' => 'en_US',
            'regional' => 'en-US',
        ],
        'ar' => [
            'code' => 'ar',
            'name' => 'Arabic',
            'native' => 'العربية',
            'direction' => 'rtl',
            'font' => 'Cairo',
            'font_heading' => 'Cairo',
            'flag' => '🇸🇦',
            'og_locale' => 'ar_SA',
            'regional' => 'ar-SA',
        ],
    ],
];
