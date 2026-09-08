<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
    ],

    'shiprocket' => [
        'email' => env('SHIPROCKET_EMAIL', 'digital@rnvalves.com'),
        'password' => env('SHIPROCKET_PASSWORD', 'E@Y6gjHRin7dD#n&qZdyd!PD8&pRETfO'),
        'pickup_location' => env('SHIPROCKET_PICKUP_LOCATION', 'Home'),
        'pickup_pincode' => env('SHIPROCKET_PICKUP_PINCODE', 201010),
        'base_url' => env('SHIPROCKET_BASE_URL', 'https://apiv2.shiprocket.in/v1/external/'),
    ],

    'shipway' => [
        'username' => env('SHIPWAY_USERNAME', 'rncom@rnvalves.com'),
        'password' => env('SHIPWAY_PASSWORD', '9D57l172eMP15a67WB7O1h51j4dv1XD7'),
        'warehouse_id' => env('SHIPWAY_WAREHOUSE_ID', '60832'),
        'pickup_pincode' => env('SHIPWAY_PICKUP_PINCODE', 201010),
        'track_url' => env('SHIPWAY_TRACK_URL', 'https://rnvalves.shipway.com/track'),
    ],

];
