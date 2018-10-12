<?php

namespace App\Services\Patreon;

use Carbon\Laravel\ServiceProvider;

class PatreonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PatreonApi::class, function () {
            $authenticator = new PatreonAuthenticator(env('PATREON_CLIENT_ID'), env('PATREON_SECRET'));

            $tokens = $authenticator->autoRefresh('');

            return new PatreonApi($tokens['access_token']);
        });
    }
}
