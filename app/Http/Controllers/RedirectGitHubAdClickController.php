<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\RedirectResponse;

class RedirectGitHubAdClickController
{
    public function __invoke(Repository $repository): RedirectResponse
    {
        if (! $ad = $repository->ad) {
            return redirect()->route('products.index');
        }

        $utmQueryString = http_build_query([
            'utm_source' => 'github',
            'utm_medium' => 'banner',
            'utm_campaign' => "repo-{$repository->name}",
        ]);

        return redirect()->to("{$ad->click_redirect_url}?{$utmQueryString}");
    }
}
