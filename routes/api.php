<?php

use App\Http\Api\HandleGitHubWebhookController;
use App\Http\Api\SatisAuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('satis/authenticate', SatisAuthenticationController::class)->middleware('auth:license-api');

Route::prefix('webhooks')->group(function () {
    Route::post('github', HandleGitHubWebhookController::class);
});
