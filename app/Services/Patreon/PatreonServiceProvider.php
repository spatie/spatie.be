<?php

namespace App\Services\Patreon;

use Carbon\Laravel\ServiceProvider;
use GuzzleHttp\Client;

class PatreonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Patreon::class, function () {
            /*
            $authenticator = new PatreonAuthenticator(config('services.patreon.id'), config('services.patreon.secret'));

            $tokens = $authenticator->autoRefresh();

            $client = $this->buildClient($tokens['access_token']);

            return new Patreon($client);
            */
        });
    }

    protected function buildClient($accessToken): Client
    {
        return new Client([
            'base_uri' => 'https://www.patreon.com/api/oauth2/api/',
            'headers' => [
                'authorization' => "Bearer {$accessToken}",
            ],
        ]);
    }
}
