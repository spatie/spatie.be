<?php

use App\Http\Api\SatisAuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('satis/authenticate', SatisAuthenticationController::class);
