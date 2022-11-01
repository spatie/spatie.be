<?php

namespace App\Support\Search;

use Illuminate\Support\Str;
use Spatie\SiteSearch\Indexers\DefaultIndexer;

class DocsSearchIndexer extends DefaultIndexer
{
    public function pageTitle(): ?string
    {
        $pageTitle = parent::pageTitle();

        return Str::before($pageTitle, ' |');
    }

    protected function getHtmlToIndex(): ?string
    {
        return attempt(function () {
            $this->removeIgnoredContent($this->domCrawler);

            return $this->domCrawler->filter('#site-search-docs-content')->html();
        });
    }

    public function extra(): array
    {
        return [
            'repo' => DocsVersion::getRepo($this->url()),
            'version' => DocsVersion::getVersion($this->url()),
        ];
    }
}
