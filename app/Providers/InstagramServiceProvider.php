<?php

namespace App\Providers;

use App\Models\Insight;
use App\Models\Member;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Vinkla\Instagram\Instagram;

class InstagramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Instagram::class, function() {
            return new Instagram(config('services.instagram.token'));
        });
    }
}
