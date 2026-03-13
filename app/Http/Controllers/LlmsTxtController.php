<?php

namespace App\Http\Controllers;

use App\Docs\Docs;
use App\Docs\Repository;
use App\Domain\Shop\Models\Product;
use App\Guidelines\Guidelines;
use App\Models\Series;
use Illuminate\Http\Response;

class LlmsTxtController
{
    public function __invoke(Docs $docs, Guidelines $guidelines): Response
    {
        $lines = [
            '# Spatie',
            '',
            '> Spatie is a web development agency from Antwerp, Belgium. We create Laravel and PHP open source packages, and sell digital products like courses and tools. We have created over 400 open source packages that have been downloaded more than 500 million times.',
            '',
            'Docs pages can be visited as markdown by appending `.md` to the URL.',
            '',
        ];

        $this->addGuidelinesSection($lines, $guidelines);
        $this->addAiGuidelinesSection($lines);
        $this->addDocsSection($lines, $docs);
        $this->addProductsSection($lines);
        $this->addCoursesSection($lines);
        $this->addOpenSourceSection($lines);
        $this->addBlogSection($lines);

        $content = implode("\n", $lines);

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    private function addGuidelinesSection(array &$lines, Guidelines $guidelines): void
    {
        $pages = $guidelines->pages();

        if ($pages->isEmpty()) {
            return;
        }

        $lines[] = '## Guidelines';
        $lines[] = '';
        $lines[] = "Spatie's coding guidelines for Laravel and PHP projects.";
        $lines[] = '';

        foreach ($pages as $page) {
            $url = url("/guidelines/{$page->slug}");
            $lines[] = "- [{$page->title}]({$url})";
        }

        $lines[] = '';
    }

    private function addAiGuidelinesSection(array &$lines): void
    {
        $url = url('/laravel-php-ai-guidelines.md');

        $lines[] = '## AI Coding Guidelines';
        $lines[] = '';
        $lines[] = "- [Laravel & PHP AI Guidelines]({$url}): Guidelines for AI assistants writing Laravel and PHP code following Spatie conventions";
        $lines[] = '';
    }

    private function addDocsSection(array &$lines, Docs $docs): void
    {
        $repositories = $docs->getRepositories();

        if ($repositories->isEmpty()) {
            return;
        }

        $grouped = $repositories->groupBy(fn (Repository $repo) => $repo->category ?? 'Other');

        $lines[] = '## Package Documentation';
        $lines[] = '';

        foreach ($grouped as $category => $repos) {
            $lines[] = "### {$category}";
            $lines[] = '';

            foreach ($repos as $repository) {
                $alias = $repository->aliases->first();

                if (! $alias) {
                    continue;
                }

                $firstPage = $alias->pages->where('section', '_root')->first();

                if (! $firstPage) {
                    continue;
                }

                $slogan = $alias->slogan ? ": {$alias->slogan}" : '';
                $pageList = $alias->pages
                    ->reject(fn ($page) => $page->isIndex())
                    ->map(fn ($page) => "  - [{$page->title}]({$page->url}.md)")
                    ->implode("\n");

                $lines[] = "- [{$repository->slug}]({$firstPage->url}.md){$slogan}";

                if ($pageList !== '') {
                    $lines[] = $pageList;
                }
            }

            $lines[] = '';
        }
    }

    private function addProductsSection(array &$lines): void
    {
        $products = Product::query()
            ->where('visible', true)
            ->orderBy('sort_order')
            ->get();

        if ($products->isEmpty()) {
            return;
        }

        $lines[] = '## Products';
        $lines[] = '';

        foreach ($products as $product) {
            $description = $product->description ? ': ' . str($product->description)->limit(200) : '';
            $lines[] = "- [{$product->title}]({$product->getUrl()}){$description}";
        }

        $lines[] = '';
    }

    private function addCoursesSection(array &$lines): void
    {
        $series = Series::query()
            ->where('visible', true)
            ->orderBy('sort_order')
            ->get();

        if ($series->isEmpty()) {
            return;
        }

        $lines[] = '## Courses';
        $lines[] = '';

        foreach ($series as $course) {
            $description = $course->description ? ': ' . str($course->description)->limit(200) : '';
            $lines[] = "- [{$course->title}]({$course->url}){$description}";
        }

        $lines[] = '';
    }

    private function addOpenSourceSection(array &$lines): void
    {
        $url = url('/open-source/packages');

        $lines[] = '## Open Source';
        $lines[] = '';
        $lines[] = "- [All Packages]({$url}): Browse all Spatie open source packages";
        $lines[] = '';
    }

    private function addBlogSection(array &$lines): void
    {
        $url = url('/blog');

        $lines[] = '## Blog';
        $lines[] = '';
        $lines[] = "- [Blog]({$url}): Articles about Laravel, PHP, and web development";
        $lines[] = '';
    }
}
