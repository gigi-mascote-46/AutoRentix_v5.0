<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayPal API Credentials
    |--------------------------------------------------------------------------
    |
    | These credentials are used to authenticate with the PayPal API.
    | You can get these from your PayPal developer dashboard.
    |
    */

    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can be 'sandbox' or 'live'
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_SANDBOX_APP_ID', ''),
    ],

    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Action
    |--------------------------------------------------------------------------
    |
    | Available options: 'Sale', 'Authorization', 'Order'
    |
    */

    'payment_action' => 'Sale',

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    'currency' => env('PAYPAL_CURRENCY', 'EUR'),

    /*
    |--------------------------------------------------------------------------
    | Notify URL
    |--------------------------------------------------------------------------
    |
    | URL for IPN (Instant Payment Notification)
    |
    */

    'notify_url' => env('PAYPAL_NOTIFY_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    */

    'locale' => env('PAYPAL_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Validate SSL
    |--------------------------------------------------------------------------
    */

    'validate_ssl' => true,
];
