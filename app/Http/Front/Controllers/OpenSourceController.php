<?php

namespace App\Http\Front\Controllers;

use App\Models\Contributor;
use App\Models\Issue;

class OpenSourceController
{
    public function index()
    {
        $issues = Issue::latest()->take(2)->get();

        /** @var Contributor $contributor */
        $contributor = Contributor::first();

        return view('front.pages.open-source.index', [
            'issues' => $issues,
            'contributor' => $contributor,
        ]);
    }

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
