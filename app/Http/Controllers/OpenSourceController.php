<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Issue;
use App\Models\PatreonPledger;

class OpenSourceController extends Controller
{
    /** @var \Illuminate\Support\Collection */
    protected $patreonPledgers;

    public function __construct()
    {
        $this->patreonPledgers = PatreonPledger::inRandomOrder()->get();
    }

    public function index()
    {
        $issues = Issue::latest()->take(2)->get();

        $contributor = Contributor::first();

        return view('pages.open-source.index', [
            'issues' => $issues,
            'contributor' => $contributor,
            'patreonPledgers' => $this->patreonPledgers,
        ]);
    }

    public function packages()
    {
        return view('pages.open-source.packages', [
            'patreonPledgers' => $this->patreonPledgers,
        ]);
    }

    public function projects()
    {
        return view('pages.open-source.projects', [
            'patreonPledgers' => $this->patreonPledgers,
        ]);
    }
}
