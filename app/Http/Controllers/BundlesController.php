<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Bundle;
use Illuminate\View\View;

class BundlesController
{
    public function show(Bundle $bundle): View
    {
        abort_unless($bundle->visible || current_user()?->hasAccessToUnReleasedProducts(), 404);

        $payLink = null;

        if (current_user()) {
            $payLink = current_user()->getPayLinkForBundle($bundle);
        }

        return view('front.pages.bundles.show', compact('bundle', 'payLink'));
    }
}
