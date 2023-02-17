<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Domain\Shop\Models\Bundle;

class BundlesController
{
    public function show(Bundle $bundle): View
    {
        $payLink = null;
        if (current_user()) {
            $payLink = current_user()->getPayLinkForBundle($bundle);
        }

        return view('front.pages.bundles.show', compact('bundle', 'payLink'));
    }
}
