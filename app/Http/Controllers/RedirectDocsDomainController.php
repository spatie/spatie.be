<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class RedirectDocsDomainController
{
    public function __invoke(string $url = ''): RedirectResponse
    {
        return Redirect::to("https://spatie.be/docs/{$url}", 301);
    }
}
