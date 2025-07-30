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
        // Local development
        'http://localhost:5173',
        'http://localhost:5174',
        'http://127.0.0.1:5173',
        'http://127.0.0.1:5174',

        // Production (Railway, Vercel, Netlify, etc.)
        env('FRONTEND_URL', 'http://localhost:5173'),

        // Tambahkan domain production Anda di sini
        // 'https://your-frontend-domain.vercel.app',
        // 'https://your-frontend-domain.netlify.app',
    ],

    'allowed_origins_patterns' => [
        // Pattern untuk subdomain Railway
        '#^https://.*\.up\.railway\.app$#',
        // Pattern untuk subdomain Vercel
        '#^https://.*\.vercel\.app$#',
        // Pattern untuk subdomain Netlify
        '#^https://.*\.netlify\.app$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
