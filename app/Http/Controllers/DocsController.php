<?php

namespace App\Http\Controllers;

use App\Docs\Alias;
use App\Docs\Docs;
use App\Docs\DocumentationPage;
use Illuminate\Support\Collection;

class DocsController
{
    public function index(Docs $docs)
    {
        return view('front.pages.docs.index', [
            'repositories' => $docs->getRepositories(),
        ]);
    }

    public function repository(string $repository, ?string $alias = null, Docs $docs)
    {
        $repository = $docs->getRepository($repository);

        abort_if(is_null($repository), 404, 'Repository not found');

        if ($alias) {
            $alias = $repository->getAlias($alias);

            abort_if(is_null($alias), 404, 'Alias not found');
        } else {
            $alias = $repository->aliases->first(function (Alias $alias) {
                return $alias->branch !== 'v9';
            });
        }

        return redirect()->action([DocsController::class, 'show'], [
            $repository->slug,
            $alias->slug,
            $alias->pages->where('section', '_root')->first()->slug,
        ]);
    }

    public function show(string $repository, string $alias, string $slug, Docs $docs)
    {
        $repository = $docs->getRepository($repository);

        abort_if(is_null($repository), 404, 'Repository not found');

        $alias = $repository->getAlias($alias);

        abort_if(is_null($alias), 404, 'Alias not found');

        /** @var Collection $pages */
        $pages = $alias->pages;

        $page = $pages->firstWhere('slug', $slug);

        if (! $page) {
            return redirect()->action([DocsController::class, 'repository'], [$repository->slug, $alias->slug]);
        }

        $repositories = $docs->getRepositories();

        $navigation = $this->getNavigation($pages);

        $showBigTitle = $page->slug === $navigation['_root']['pages'][0]->slug;

        return view('front.pages.docs.show', compact(
            'page',
            'repositories',
            'repository',
            'pages',
            'navigation',
            'alias',
            'showBigTitle'
        ));
    }

    private function getNavigation(Collection $pages): Collection
    {
        $navigation = $pages
            ->reduce(function (array $navigation, DocumentationPage $page) {
                if ($page->isIndex()) {
                    $navigation[$page->section]['_index'] = $page;
                } else {
                    $navigation[$page->section]['pages'][] = $page;
                }

                return $navigation;
            }, []);

        return collect($navigation)->sortBy(fn (array $pages) => $pages['_index']->weight ?? -1);
    }
}
