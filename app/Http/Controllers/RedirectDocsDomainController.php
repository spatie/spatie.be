<?php

namespace App\Http\Controllers;

class RedirectDocsDomainController
{
    public function __invoke(string $url = '')
    {
        return redirect("https://spatie.be/docs/{$url}", 301);
    }
}
