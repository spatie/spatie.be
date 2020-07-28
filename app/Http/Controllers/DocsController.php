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
        /** @var DocumentationPage $page */
        $page = $docs->pages()
            ->filter(fn (DocumentationPage $page) => $page->isRootSection())
            ->filter(fn (DocumentationPage $page) => ! $page->isIndex())
            ->filter(fn(DocumentationPage $page) => $page->getRepositoryAttribute() === $repository)
            ->when($alias, function (Collection $pages) use ($alias) {
                return $pages->filter(fn(DocumentationPage $page) => $page->getAliasAttribute() === $alias);
            })
            ->sortBy('weight')
            ->first();

        return redirect($page->getUrlAttribute(), Response::HTTP_PERMANENTLY_REDIRECT);
    }

    public function show(string $repository, string $alias, string $page, Docs $docs, Sheets $sheets)
    {
        $path = "{$repository}/{$alias}/{$page}";

        $page = $sheets->collection('docs')->get($path) ?? abort(404);

        $repositories = $docs->getRepositories();

        $navigation = $this->getNavigation($page, $docs);

        $versions = $docs->getVersions($page->repository);

        return view('front.pages.docs.show', compact('page', 'repositories', 'navigation', 'versions'));
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
