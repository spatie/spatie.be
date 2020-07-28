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
        $path = "{$repository}/{$alias}/{$slug}";

        $slug = $sheets->collection('docs')->get($path) ?? abort(404);

        $repositories = $docs->getRepositories();

        $navigation = $this->getNavigation($slug, $docs);

        $versions = $docs->getVersions($slug->repository);

        return view('front.pages.docs.show', compact('slug', 'repositories', 'navigation', 'versions'));
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
