<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | The PTMT Landing Page (external React/Vite app) POSTs to:
    |   POST /store-popup-form-response
    | This route must be allowed from any origin so that leads from the
    | landing page reach the Admin Enquiries panel.
    |
    */

    'paths' => [
        'store-popup-form-response',   // Public lead-capture endpoint (CallBack form)
        'api/*',                        // All API routes
    ],

    'allowed_methods' => ['POST', 'OPTIONS'],

    // '*' allows any domain (including the PTMT landing page on any host/port)
    // Narrow this to a specific domain once the landing page has a fixed URL, e.g.:
    // 'allowed_origins' => ['https://ptmt.rnvalves.com'],
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Accept'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Credentials (cookies/auth) are not needed for this public endpoint
    'supports_credentials' => false,

];
