<?php

use App\Http\Api\GithubController;
use App\Http\Api\SatisAuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('satis/authenticate', SatisAuthenticationController::class);

Route::prefix('webhooks')->group(function () {
    Route::post('github', GithubController::class);
});
