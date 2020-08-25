<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class RedirectDocsDomainController
{
    public function __invoke(string $url = '')
    {
        $url = Str::beforeLast($url, '/');

        return Redirect::to("https://spatie.be/docs/{$url}", 301);
    }
}
