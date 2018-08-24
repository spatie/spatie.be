<?php

namespace App\Providers;

use App\Models\Insight;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Vinkla\Instagram\Instagram;

class InstagramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Instagram::class, function() {
            if (empty(config('services.instagram.token'))) {
                throw new Exception('You must provide an instagram token in the services config file.');
            }

            return new Instagram(config('services.instagram.token'));
        });
    }
}
