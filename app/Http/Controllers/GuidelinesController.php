<?php

namespace App\Http\Controllers;

use App\Actions\CreateArticleMarkdownResponseAction;
use App\Guidelines\Guidelines;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class GuidelinesController
{
    public function index(Guidelines $guidelines): View
    {
        $pages = $guidelines->pages();

        return view('front.pages.guidelines.index', compact('pages'));
    }

    public function show(string $slug, Guidelines $guidelines, Request $request, CreateArticleMarkdownResponseAction $markdown): Response
    {
        $page = $guidelines->page($slug);

        abort_unless($page, 404);

        if ($markdown->isRequested($request)) {
            return $markdown->execute($page->title, $page->contents->toHtml());
        }

        $pages = $guidelines->pages()->sortBy('weight')->values();
        $tableOfContents = $this->extractTableOfContents($page->contents);

        return response()->view('front.pages.guidelines.show', compact('page', 'pages', 'tableOfContents'))->setVary('Accept');
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
