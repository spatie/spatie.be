<?php

namespace App\Support\Search;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use InvalidArgumentException;
use Spatie\SiteSearch\Drivers\Database\MySqlGrammar;

class DocsSearchMySqlGrammar extends MySqlGrammar
{
    protected const AllowedFilters = ['repo', 'version'];

    public function escapeSearchTerm(string $query): string
    {
        if (mb_strlen($query) > 200) {
            return '';
        }

        preg_match_all('/[\p{L}\p{N}_]+/u', parent::escapeSearchTerm($query), $matches);

        return collect($matches[0])
            ->filter(fn (string $word) => mb_strlen($word) >= 3)
            ->unique()
            ->take(8)
            ->implode(' ');
    }

    public function searchWithFilters(
        Connection $connection,
        string $indexName,
        string $query,
        int $limit,
        int $offset,
        array $filters,
    ): array {
        $searchTerms = $this->prepareBooleanQuery($query);

        if ($searchTerms === '') {
            return [];
        }

        $results = $connection->table('site_search_documents')
            ->timeout(1)
            ->select('*')
            ->selectRaw(
                'MATCH(entry, page_title, h1, description, url) AGAINST(? IN BOOLEAN MODE) as relevance',
                [$searchTerms],
            )
            ->where('index_name', $indexName)
            ->whereRaw(
                'MATCH(entry, page_title, h1, description, url) AGAINST(? IN BOOLEAN MODE)',
                [$searchTerms],
            );

        return $this->applyFilters($results, $filters)
            ->orderByDesc('relevance')
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->map(fn ($row) => $this->addHighlighting((array) $row, $query))
            ->all();
    }

    public function getTotalCountWithFilters(
        Connection $connection,
        string $indexName,
        string $query,
        array $filters,
    ): int {
        $searchTerms = $this->prepareBooleanQuery($query);

        if ($searchTerms === '') {
            return 0;
        }

        $queryBuilder = $connection->table('site_search_documents')
            ->timeout(1)
            ->where('index_name', $indexName)
            ->whereRaw(
                'MATCH(entry, page_title, h1, description, url) AGAINST(? IN BOOLEAN MODE)',
                [$searchTerms],
            );

        return $this->applyFilters($queryBuilder, $filters)->count();
    }

    protected function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $name => $value) {
            if (! in_array($name, self::AllowedFilters, strict: true)) {
                throw new InvalidArgumentException("Unsupported docs search filter: {$name}");
            }

            $query->where("extra->{$name}", $value);
        }

        return $query;
    }
}
