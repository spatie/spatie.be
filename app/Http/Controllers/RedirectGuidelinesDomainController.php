<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class RedirectGuidelinesDomainController
{
    public function __invoke(string $url = '')
    {
        $url = Arr::last(array_filter(explode('/', $url)), '');

        return Redirect::to("https://spatie.be/guidelines/{$url}", 301);
    }
}
