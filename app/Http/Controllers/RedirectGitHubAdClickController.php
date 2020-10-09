<?php

namespace App\Http\Controllers;

use App\Models\Repository;

class RedirectGitHubAdClickController
{
    public function __invoke(Repository $repository)
    {
        if (! $ad = $repository->ad) {
            return redirect()->route('products.index');
        }

        return redirect()->to($ad->click_redirect_url . "?utm_source=repo-{$repository->name}");
    }
}
