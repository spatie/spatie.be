<?php

namespace App\Http\Controllers;

use App\Guidelines\Guidelines;
use Illuminate\View\View;

class GuidelinesController
{
    public function index(Guidelines $guidelines): View
    {
        $pages = $guidelines->pages();

        return view('front.pages.guidelines.index', compact('pages'));
    }

    public function show(string $slug, Guidelines $guidelines): View
    {
        $page = $guidelines->page($slug);
        $pages = $guidelines->pages()->sortBy('weight')->values();
        $tableOfContents = $this->extractTableOfContents($page->contents);

        abort_unless($page, 404);

        return view('front.pages.guidelines.show', compact('page', 'pages', 'tableOfContents'));
    }

    private function extractTableOfContents(string $contents)
    {
        $matches = [];

        preg_match_all('/<h2.*><a.*id="([^"]+)".*>#<\/a>([^<]+)/', $contents, $matches);

        $allMatches = array_combine($matches[1], $matches[2]);

        return collect($allMatches)
            ->reject(fn (string $result) => str_contains($result, 'Beatles'))
            ->toArray();
    }
}
