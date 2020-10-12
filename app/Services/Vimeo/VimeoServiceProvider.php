<?php

namespace App\Services\Vimeo;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class VimeoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        app()->singleton(Vimeo::class, function () {
            return new Vimeo(new Client([
                'headers' => [
                    'Authorization' => 'Bearer '.config('services.vimeo.access'),
                ],
            ]));
        });
    }
}
