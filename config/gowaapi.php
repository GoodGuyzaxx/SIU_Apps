<?php

return [
    /*
    |--------------------------------------------------------------------------
    | GOWA WhatsApp API Configuration
    |--------------------------------------------------------------------------
    |
    | base_url  : Base URL API server (e.g. https://api.example.com)
    |             Used for status check endpoint: GET /app/status
    |
    | url       : Full send link endpoint URL
    |             Used for sending messages with link preview
    |
    | user/pass : HTTP Basic Auth credentials
    | device    : Device ID for multi-device support (default: main)
    |
    */

    'base_url' => env('WA_API_BASE_URL', ''),
    'url'      => env('WA_API_LINK', ''),
    'user'     => env('WA_AUTH_USER', ''),
    'pass'     => env('WA_AUTH_PASS', ''),
    'device'   => env('WA_DEVICE_ID', 'main'),
];
