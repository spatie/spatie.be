<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Issue;

class OpenSourceController
{
    public function packages()
    {
        return view('front.pages.open-source.packages');
    }

    public function projects()
    {
        return view('front.pages.open-source.projects');
    }

    public function support()
    {
        $contributor = Contributor::first();

        return view('front.pages.open-source.support', [
            'contributor' => $contributor,
        ]);
    }
}
