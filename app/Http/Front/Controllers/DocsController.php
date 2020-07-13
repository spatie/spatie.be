<?php

namespace App\Http\Front\Controllers;

use App\Docs\Docs;
use App\Docs\DocumentationPage;

class DocsController
{
    public function __invoke(DocumentationPage $page, Docs $docs)
    {
        $repositories = $docs->getRepositories();

        $navigation = $this->getNavigation($page, $docs);

        $versions = $docs->getVersions($page->repository);

        return view('front.pages.docs.docs', compact('page', 'repositories', 'navigation', 'versions'));
    }

    private function getNavigation(DocumentationPage $page, Docs $docs): array
    {
        $pages = $docs->pages()->where('repository', $page->repository)->where('alias', $page->alias);

        $navigation = [];

        foreach ($pages as $page) {
            if ($page->isIndex()) {
                $navigation[$page->section]['_index'] = $page;
            } else {
                $navigation[$page->section]['pages'][] = $page;
            }
        }

        return $navigation;
    }
}
