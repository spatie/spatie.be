<?php

namespace App\Livewire;

use App\Support\Search\DocsVersion;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->resetErrorBag('query');

        if (mb_strlen($this->query) < 3) {
            return collect();
        }

        if (mb_strlen($this->query) > 200) {
            $this->addError('query', 'Use at most 200 characters.');

            return collect();
        }

        $rateLimitKey = 'docs-search:'.request()->ip();

        if (RateLimiter::hit($rateLimitKey) > 60) {
            $this->addError('query', 'Too many searches. Please try again in a minute.');

            return collect();
        }

        $repo = DocsVersion::getRepo($this->currentUrl);
        $version = DocsVersion::getVersion($this->currentUrl);

        try {
            return Search::onIndex($this->indexName())
                ->limit(20)
                ->query($this->query)
                ->searchParameters(['filters' => [
                    'version' => $version,
                    'repo' => $repo,
                ]])
                ->get()
                ->hits;
        } catch (QueryException $exception) {
            if (($exception->errorInfo[1] ?? null) !== 3024) {
                throw $exception;
            }

            $this->addError('query', 'Search took too long. Try more specific terms.');

            return collect();
        }
    }

    protected function indexName(): string
    {
        return 'docs';
    }
}
