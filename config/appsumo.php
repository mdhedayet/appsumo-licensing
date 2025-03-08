<?php
return [
    // OAuth credentials
    'client_id'     => env('APPSUMO_CLIENT_ID', ''),
    'client_secret' => env('APPSUMO_CLIENT_SECRET', ''),
    'redirect_url'  => env('APPSUMO_REDIRECT_URL', 'https://your-app.com/appsumo/oauth/callback'),

    // Webhook settings
    'webhook_url'   => env('APPSUMO_WEBHOOK_URL', 'https://your-app.com/appsumo/webhook'),
    'webhook_secret'=> env('APPSUMO_WEBHOOK_SECRET', ''),

    // Licensing API key
    'api_key'       => env('APPSUMO_API_KEY', ''),
];
