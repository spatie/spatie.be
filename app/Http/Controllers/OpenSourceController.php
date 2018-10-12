<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepositoryResource;
use App\Models\Contributor;
use App\Models\Issue;
use App\Models\Patreon;
use App\Models\Repository;

class OpenSourceController extends Controller
{
    public function index()
    {
        $repositories = RepositoryResource::collection(
            Repository::getHighlightedPackages()
        )->resolve();

        $issues = Issue::latest()->take(2)->get();

        $contributor = Contributor::first();

        $patreon = Patreon::get()->random();

        return view('pages.open-source.index', compact('repositories', 'issues', 'contributor', 'patreon'));
    }

    public function packages()
    {
        $repositories = RepositoryResource::collection(
            Repository::getAllPackages()
        )->resolve();

        return view('pages.open-source.packages', compact('repositories'));
    }

    public function projects()
    {
        $repositories = RepositoryResource::collection(
            Repository::getAllProjects()
        )->resolve();

        return view('pages.open-source.projects', compact('repositories'));
    }
}
