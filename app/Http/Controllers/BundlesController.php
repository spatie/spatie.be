<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Bundle;

class BundlesController
{
    public function show(Bundle $bundle)
    {
        if (! auth()->check()) {
            return redirect(route('login') . "?next=" . route('bundles.show', [$bundle]));
        }

        $payLink = auth()->user()->getPayLinkForBundle($bundle);

        return view('front.pages.bundles.show', compact('bundle', 'payLink'));
    }
}
