<?php

use Illuminate\Support\Facades\Route;
use YourNamespace\AppSumo\Controllers\OAuthController;
use YourNamespace\AppSumo\Controllers\WebhookController;

Route::group(['prefix' => 'appsumo'], function () {
    // OAuth callback route
    Route::get('/oauth/callback', [OAuthController::class, 'callback'])->name('appsumo.oauth.callback');

    // Webhook endpoint route
    Route::post('/webhook', [WebhookController::class, 'handle'])->name('appsumo.webhook');
});
