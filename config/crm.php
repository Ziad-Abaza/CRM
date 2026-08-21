<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency & Financial Configuration
    |--------------------------------------------------------------------------
    |
    | Central source of truth for financial currency codes, symbols, and formatting.
    |
    */
    'currency' => env('APP_CURRENCY', 'USD'),
    
    'supported_currencies' => [
        'USD' => ['code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar', 'native_ar' => 'دولار أمريكي'],
        'EUR' => ['code' => 'EUR', 'symbol' => '€', 'name' => 'Euro', 'native_ar' => 'يورو'],
        'GBP' => ['code' => 'GBP', 'symbol' => '£', 'name' => 'British Pound', 'native_ar' => 'جنيه إسترليني'],
        'SAR' => ['code' => 'SAR', 'symbol' => 'ر.س', 'name' => 'Saudi Riyal', 'native_ar' => 'ريال سعودي'],
        'AED' => ['code' => 'AED', 'symbol' => 'د.إ', 'name' => 'UAE Dirham', 'native_ar' => 'درهم إماراتي'],
        'EGP' => ['code' => 'EGP', 'symbol' => 'ج.م', 'name' => 'Egyptian Pound', 'native_ar' => 'جنيه مصري'],
        'KWD' => ['code' => 'KWD', 'symbol' => 'د.ك', 'name' => 'Kuwaiti Dinar', 'native_ar' => 'دينار كويتي'],
        'QAR' => ['code' => 'QAR', 'symbol' => 'ر.ق', 'name' => 'Qatari Riyal', 'native_ar' => 'ريال قطري'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Contact Channels
    |--------------------------------------------------------------------------
    */
    'whatsapp_default' => env('DEFAULT_WHATSAPP_NUMBER', '+15550192834'),
    'email_default' => env('MAIL_FROM_ADDRESS', 'advisory@aegis.com'),
];
