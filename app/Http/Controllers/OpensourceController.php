<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Repository;

class OpensourceController extends Controller
{
    public function index()
    {
        $repositories = Repository::getHighlightedPackages();

        $contributor = Contributor::first();

        return view('pages.open-source.index', compact('repositories', 'contributor'));
    }

    public function packages()
    {
        $repositories = Repository::getAllPackages();

        return view('pages.open-source.packages', compact('repositories'));
    }

    public function projects()
    {
        $repositories = Repository::getAllProjects();

        return view('pages.open-source.projects', compact('repositories'));
    }
}
