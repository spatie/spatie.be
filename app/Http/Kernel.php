<?php

namespace App\Http;

use App\Http\Middleware\AdminsOnly;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\HandleReferrer;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{
    protected $middleware = [
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        // Disabled for Livewire
        // \App\Http\Middleware\TrimStrings::class,
        // \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        TrustProxies::class,
        HandleCors::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            SubstituteBindings::class,
            HandleReferrer::class,
        ],

        'admin' => [
            VerifyCsrfToken::class,
        ],

        'api' => [
            ThrottleRequests::class.':60,1',
            'bindings',
        ],
    ];

    protected $middlewareAliases = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'throttle' => ThrottleRequests::class,
        'signed' => ValidateSignature::class,
        'forceJson' => ForceJsonResponse::class,
        'adminsOnly' => AdminsOnly::class,
    ];
}
