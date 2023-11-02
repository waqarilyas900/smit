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
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://mysimit.netlify.app',
        'https://stage-mysimit.netlify.app',
        'http://192.168.0.121:3333',
        'http://172.20.10.2:3333',
        'http://customwebs.online',
        'http://192.168.0.124:3333',
        'http://192.168.0.110:3333',
        'http://10.0.7.173:3333',
        'http://192.168.1.16:3333',
        'http://192.168.100.13:3333'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
