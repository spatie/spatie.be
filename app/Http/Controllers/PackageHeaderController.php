<?php

namespace App\Http\Controllers;

use App\Models\Repository;

class PackageHeaderController
{
    public function html(string $name, $mode = 'dark')
    {
        \Debugbar::disable();

        $repository = Repository::where('name', $name)->firstOrFail();
        return view('front.pages.open-source.package-header', compact('repository', 'mode'));
    }
}
