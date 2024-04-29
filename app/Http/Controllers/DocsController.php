<?php

namespace App\Http\Controllers;

use App\Docs\Alias;
use App\Docs\Docs;
use App\Docs\DocumentationPage;
use App\Docs\Highlighting\DiffLanguage;
use App\Support\CommonMark\ImageRenderer;
use App\Support\CommonMark\LinkRenderer;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Table\TableExtension;
use RuntimeException;
use Spatie\CommonMarkWireNavigate\WireNavigateExtension;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Tempest\Highlight\CommonMark\CodeBlockRenderer;
use Tempest\Highlight\CommonMark\InlineCodeBlockRenderer;
use Tempest\Highlight\Highlighter;

class DocsController
{
    public function index(Docs $docs): View
    {
        return view('front.pages.docs.index', [
            'repositories' => $docs->getRepositories(),
        ]);
    }

    public function repository(Docs $docs, string $repository, ?string $alias = null)
    {
        try {
            $repository = $docs->getRepository($repository);
        } catch (RuntimeException $e) {
            abort(404, 'Repository not found');
        }

        abort_if(is_null($repository), 404, 'Repository not found');

        if ($alias) {
            preg_match('/v\d+/', $alias, $matches);

            if (! count($matches)) {
                $latest = $repository->aliases->keys()->first();
                $slug = $alias;
                $alias = $latest;

                return redirect()->action([DocsController::class, 'show'], [$repository->slug, $alias, $slug]);
            }

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
        try {
            $repository = $docs->getRepository($repository);
        } catch (RuntimeException $e) {
            abort(404, 'Repository not found');
        }

        preg_match('/v\d+/', $alias, $matches);

        if (! count($matches)) {
            $latest = $repository->aliases->keys()->first();
            $slug = "{$alias}/{$slug}";
            $alias = $latest;

            return redirect()->action([DocsController::class, 'show'], [$repository->slug, $alias, $slug]);
        }

        abort_if(is_null($repository), 404, 'Repository not found');

        $alias = $repository->getAlias($alias);

        if (! $alias) {
            $alias = $repository->aliases->keys()->first();

            return redirect()->action([DocsController::class, 'show'], [$repository->slug, $alias, $slug]);
        }

        /** @var Collection $pages */
        $pages = $alias->pages;

        $page = $pages->firstWhere('slug', $slug);

        if (! $page) {
            return redirect()->action([DocsController::class, 'repository'], [$repository->slug, $alias->slug]);
        }

        $page->contents = $this->renderMarkdown($page->contents);

        $repositories = $docs->getRepositories();

        $navigation = $this->getNavigation($pages);

        $prevPage = $this->getPrevPage($page, $navigation);
        $nextPage = $this->getNextPage($page, $navigation);

        $showBigTitle = $page->slug === $navigation['_root']['pages'][0]->slug;

        $tableOfContents = $this->extractTableOfContents($page->contents);

        return view('front.pages.docs.show', compact(
            'page',
            'prevPage',
            'nextPage',
            'repositories',
            'repository',
            'pages',
            'navigation',
            'alias',
            'showBigTitle',
            'tableOfContents'
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

    private function extractTableOfContents(string $contents)
    {
        $matches = [];

        preg_match_all('/<h2.*><a.*id="([^"]+)".*>#<\/a>([^<]+)/', $contents, $matches);

        $allMatches = array_combine($matches[1], $matches[2]);

        return collect($allMatches)
            ->reject(fn (string $result) => str_contains($result, 'Beatles'))
            ->toArray();
    }

    private function renderMarkdown(string $contents): string
    {
        $highlighter = new Highlighter();
        $highlighter->addLanguage(new DiffLanguage());

        return app(MarkdownRenderer::class)
            ->highlightCode(false)
            ->addExtension(new TableExtension())
            ->addExtension(new HeadingPermalinkExtension())
            ->addExtension(new WireNavigateExtension())
            ->addInlineRenderer(Image::class, new ImageRenderer())
            ->addInlineRenderer(Link::class, new LinkRenderer())
            ->addInlineRenderer(FencedCode::class, new CodeBlockRenderer($highlighter), 10)
            ->addInlineRenderer(Code::class, new InlineCodeBlockRenderer($highlighter), 10)
            ->commonmarkOptions([
                'heading_permalink' => [
                    'html_class' => 'anchor-link',
                    'symbol' => '#',
                ],
                'wire_navigate' => [
                    'paths' => ['docs'],
                ]
            ])->toHtml($contents);
    }

    private function getPrevPage(DocumentationPage $currentPage, Collection $navigation): ?DocumentationPage
    {
        $prevPage = null;
        $currentFound = false;

        $previousSection = null;

        foreach ($navigation as $key => $section) {
            foreach ($section['pages'] as $index => $page) {
                if ($currentPage->slug === $page->slug) {
                    $prevPage = $section['pages'][$index - 1] ?? null;
                    $currentFound = true;
                }
            }

            if (! $prevPage && $currentFound && $previousSection) {
                return Arr::last($previousSection['pages']);
            }

            $previousSection = $section;
        }

        return $prevPage;
    }

    private function getNextPage(DocumentationPage $currentPage, Collection $navigation): ?DocumentationPage
    {
        $nextPage = null;
        $currentFound = false;

        foreach ($navigation as $key => $section) {
            if (! $nextPage && $currentFound) {
                return $section['pages'][0];
            }

            foreach ($section['pages'] as $index => $page) {
                if ($currentPage->slug === $page->slug) {
                    $nextPage = $section['pages'][$index + 1] ?? null;
                    $currentFound = true;
                }
            }
        }

        return $nextPage;
    }
}
