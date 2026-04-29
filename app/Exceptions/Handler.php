<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\FlareClient\Flare;
use Spatie\LaravelFlare\FlareConfig;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(static function (Throwable $exception): ?Flare {
            $config = app(FlareConfig::class);

            if ($config->apiToken === null) {
                return null;
            }

            $flare = app(Flare::class);

            $flare->report($exception);

            return $flare;
        });
    }
}
