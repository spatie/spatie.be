<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Issue;
use App\Models\PatreonPledger;

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
        $issues = Issue::latest()->take(2)->get();

        $contributor = Contributor::first();

        return view('pages.open-source.index', [
            'issues' => $issues,
            'contributor' => $contributor,
            'patreonPledger' => $this->patreonPledger,
        ]);
    }

    public function packages()
    {
        return view('pages.open-source.packages', [
            'patreonPledger' => $this->patreonPledger,
        ]);
    }

    public function projects()
    {
        return view('pages.open-source.projects', [
            'patreonPledger' => $this->patreonPledger,
        ]);
    }
}
