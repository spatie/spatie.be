<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Issue;

class OpenSourceController
{
    public function index()
    {
        $issues = Issue::latest()->take(2)->get();

        $contributor = Contributor::first();

        return view('pages.open-source.index', [
            'issues' => $issues,
            'contributor' => $contributor,
        ]);
    }

    public function packages()
    {
        return view('pages.open-source.packages');
    }

    public function projects()
    {
        return view('pages.open-source.projects');
    }

    public function support()
    {
        $contributor = Contributor::first();

        return view('pages.open-source.support', [
            'contributor' => $contributor,
        ]);
    }
}
