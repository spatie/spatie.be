<?php

namespace App\Http\Controllers;

class RedirectDocsDomainController
{
    public function __invoke(string $url)
    {
        return redirect("/docs/{$url}", 301);
    }
}
