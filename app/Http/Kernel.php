<?php

namespace App\Http;

use App\Http\Middleware\AdminsOnly;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\HandleReferrer;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // Disabled for Livewire
        // \App\Http\Middleware\TrimStrings::class,
        // \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            HandleReferrer::class,
        ],

        'admin' => [
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':60,1',
            'bindings',
        ],
    ];

    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'forceJson' => ForceJsonResponse::class,
        'adminsOnly' => AdminsOnly::class,
    ];
}
