<?php

namespace App\Http\Front\Controllers;

use App\Docs\Docs;
use App\Docs\DocumentationPage;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Sheets\Sheets;

class DocsController
{
    public function index(Docs $docs)
    {
        $repositories = $docs->getRepositories();

        return view('front.pages.docs.index', compact('repositories'));
    }

    public function repository(string $repository, ?string $alias = null, Docs $docs)
    {
        $repository = $docs->getRepository($repository);

        abort_unless($repository, 404, 'Repository not found');

        if ($alias) {
            $alias = $repository->getAlias($alias);

            abort_unless($alias, 404, 'Alias not found');
        } else {
            $alias = $repository->aliases->last();
        }

        return redirect()->action([DocsController::class, 'show'], [
            $repository->slug,
            $alias->slug,
            $alias->pages->first()->slug,
        ]);
    }

    public function show(string $repository, string $alias, string $slug, Docs $docs, Sheets $sheets)
    {
        $repository = $docs->getRepository($repository);

        $alias = $repository->getAlias($alias);

        $pages = $alias->pages;

        $page = $pages->firstWhere('slug', $slug);

        $repositories = $docs->getRepositories();

        $navigation = $this->getNavigation($pages);

        return view('front.pages.docs.show', compact('page', 'repositories', 'repository', 'pages', 'navigation', 'alias'));
    }

    private function getNavigation(Collection $pages): array
    {
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
