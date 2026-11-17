<?php

namespace App\Http\Controllers;

use App\Docs\Docs;
use App\Domain\Blog\Models\BlogPost;
use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\Product;
use App\Guidelines\Guidelines;
use App\Models\Series;
use Illuminate\Http\Response;

class SitemapController
{
    public function __invoke(Docs $docs, Guidelines $guidelines): Response
    {
        $urls = collect([
            'home', 'web-development', 'about', 'products.index', 'open-source.index',
            'open-source.packages', 'open-source.postcards', 'vacancies.index',
            'blog', 'blog.all', 'courses.index', 'docs', 'guidelines', 'newsletter',
            'legal.index', 'legal.privacy', 'legal.disclaimer', 'legal.conditions', 'legal.gdpr',
        ])->map(fn (string $name) => route($name));

        foreach (BlogPost::visible()->pluck('slug') as $slug) {
            $urls->push(route('blog.show', $slug));
        }

        foreach (Product::where('visible', true)->pluck('slug') as $slug) {
            $urls->push(route('products.show', $slug));
        }

        foreach (Bundle::where('visible', true)->pluck('slug') as $slug) {
            $urls->push(route('bundles.show', $slug));
        }

        foreach (Series::where('visible', true)->pluck('slug') as $slug) {
            $urls->push(route('series.show', $slug));
        }

        foreach ($guidelines->pages() as $page) {
            $urls->push(url("guidelines/{$page->slug}"));
        }

        foreach ($docs->getRepositories() as $repository) {
            foreach ($repository->aliases as $alias) {
                foreach ($alias->pages as $page) {
                    if (! $page->isIndex()) {
                        $urls->push($page->url);
                    }
                }
            }
        }

        return response()->view('front.sitemap', ['urls' => $urls->unique()], 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
