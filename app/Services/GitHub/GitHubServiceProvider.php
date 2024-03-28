<?php

namespace App\Services\GitHub;

use Github\AuthMethod;
use Github\Client;
use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GitHubApi::class, function () {
            $client = new Client();

            $client->authenticate(config('services.github.token'), null,  AuthMethod::ACCESS_TOKEN);

            return new GitHubApi($client);
        });
    }
}
