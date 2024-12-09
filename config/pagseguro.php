<?php

return [
    'sandbox' => [
        'email' => env('PAGSEGURO_SANDBOX_EMAIL'),
        'token' => env('PAGSEGURO_SANDBOX_TOKEN'),
        'url' => 'https://sandbox.api.pagseguro.com/checkouts',
        'redirect_url' => env('PAGSEGURO_SANDBOX_REDIRECT_URL'),
        'notification_url' => env('PAGSEGURO_SANDBOX_NOTIFICATION_URL'),
        'payment_notification_url' => env('PAGSEGURO_SANDBOX_PAYMENT_NOTIFICATION_URL'),
    ],
    'production' => [
        'email' => env('PAGSEGURO_PRODUCTION_EMAIL'),
        'token' => env('PAGSEGURO_PRODUCTION_TOKEN'),
        'url' => 'https://api.pagseguro.com/checkouts',
        'redirect_url' => env('PAGSEGURO_PRODUCTION_REDIRECT_URL'),
        'notification_url' => env('PAGSEGURO_PRODUCTION_NOTIFICATION_URL'),
        'payment_notification_url' => env('PAGSEGURO_PRODUCTION_PAYMENT_NOTIFICATION_URL'),
    ],
];