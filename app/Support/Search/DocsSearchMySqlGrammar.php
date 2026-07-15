<?php

namespace App\Support\Search;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use InvalidArgumentException;
use Spatie\SiteSearch\Drivers\Database\MySqlGrammar;

class DocsSearchMySqlGrammar extends MySqlGrammar
{
    protected const AllowedFilters = ['repo', 'version'];

    public function searchWithFilters(
        Connection $connection,
        string $indexName,
        string $query,
        int $limit,
        int $offset,
        array $filters,
    ): array {
        if (empty(trim($query))) {
            return $this->applyFilters(
                $connection->table('site_search_documents')
                    ->where('index_name', $indexName),
                $filters,
            )
                ->orderByDesc('date_modified_timestamp')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->map(fn ($row) => (array) $row)
                ->all();
        }

        $searchTerms = $this->prepareBooleanQuery($query);

        $results = $connection->table('site_search_documents')
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
        $queryBuilder = $connection->table('site_search_documents')
            ->where('index_name', $indexName);

        if (! empty(trim($query))) {
            $searchTerms = $this->prepareBooleanQuery($query);

            $queryBuilder->whereRaw(
                'MATCH(entry, page_title, h1, description, url) AGAINST(? IN BOOLEAN MODE)',
                [$searchTerms],
            );
        }

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
