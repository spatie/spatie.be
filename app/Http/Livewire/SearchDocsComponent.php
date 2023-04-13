<?php

namespace App\Http\Livewire;

use App\Support\Search\DocsVersion;
use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\SiteSearch\Search;

class SearchDocsComponent extends Component
{
    public string $query = '';

    public string $currentUrl;

    protected $queryString = [
        'query' => ['except' => ''],
    ];

    public function mount()
    {
        $this->currentUrl = url()->current();
    }

    public function render()
    {
        return view('front.pages.docs.partials.search', [
            'hits' => $this->getResults(),
            'version' => DocsVersion::getVersion($this->currentUrl),
            'repo' => DocsVersion::getRepo($this->currentUrl),
        ]);
    }

    public function getResults(): Collection
    {
        if (strlen($this->query) < 3) {
            return collect();
        }

        $repo = DocsVersion::getRepo($this->currentUrl);
        $version = DocsVersion::getVersion($this->currentUrl);

        return Search::onIndex($this->indexName())
            ->limit(20)
            ->query($this->query)
            ->searchParameters(
                ['filter' => [
                    "version = '{$version}'",
                    "repo = '{$repo}'",

                ],
                ]
            )
            ->get()
            ->hits;
    }

    protected function indexName(): string
    {
        return 'docs';
    }
}
