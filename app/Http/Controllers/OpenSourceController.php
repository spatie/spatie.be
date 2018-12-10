<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepositoryResource;
use App\Models\Contributor;
use App\Models\Issue;
use App\Models\PatreonPledger;
use App\Models\Repository;

class OpenSourceController extends Controller
{
    /** @var \App\Models\PatreonPledger */
    protected $patreonPledger;

    public function __construct()
    {
        $this->patreonPledger = PatreonPledger::inRandomOrder()->first();
    }

    public function index()
    {
        $repositories = RepositoryResource::collection(
            Repository::getHighlightedPackages()
        )->resolve();

        $issues = Issue::latest()->take(2)->get();

        $contributor = Contributor::first();

        return view('pages.open-source.index', [
            'repositories' => $repositories,
            'issues' => $issues,
            'contributor' => $contributor,
            'patreonPledger' => $this->patreonPledger,
        ]);
    }

    public function packages()
    {
        $repositories = RepositoryResource::collection(
            Repository::getAllPackages()
        )->resolve();

        return view('pages.open-source.packages', [
            'repositories' => $repositories,
            'patreonPledger' => $this->patreonPledger,
        ]);
    }

    public function projects()
    {
        $repositories = RepositoryResource::collection(
            Repository::getAllProjects()
        )->resolve();

        return view('pages.open-source.projects', [
            'repositories' => $repositories,
            'patreonPledger' => $this->patreonPledger,
        ]);
    }
}
