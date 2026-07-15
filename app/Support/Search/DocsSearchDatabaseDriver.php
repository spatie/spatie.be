<?php

namespace App\Support\Search;

use Illuminate\Support\Facades\DB;
use RuntimeException;
use Spatie\SiteSearch\Drivers\DatabaseDriver;
use Spatie\SiteSearch\Models\SiteSearchConfig;
use Spatie\SiteSearch\SearchResults\Hit;
use Spatie\SiteSearch\SearchResults\SearchResults;

class DocsSearchDatabaseDriver extends DatabaseDriver
{
    public static function make(SiteSearchConfig $config): self
    {
        $connectionName = $config->getExtraValue('database.connection');
        $connection = DB::connection($connectionName);

        if (! in_array($connection->getDriverName(), ['mysql', 'mariadb'], strict: true)) {
            throw new RuntimeException('The docs search database driver requires MySQL or MariaDB.');
        }

        return new self($connection, new DocsSearchMySqlGrammar());
    }

    public function search(
        string $indexName,
        string $query,
        ?int $limit = null,
        int $offset = 0,
        array $searchParameters = [],
    ): SearchResults {
        $startTime = microtime(true);
        $effectiveLimit = $limit ?? 20;
        $filters = $searchParameters['filters'] ?? [];

        /** @var DocsSearchMySqlGrammar $grammar */
        $grammar = $this->grammar;

        $grammar->ensureFtsSetup($this->connection);

        $results = $grammar->searchWithFilters(
            $this->connection,
            $indexName,
            $query,
            $effectiveLimit,
            $offset,
            $filters,
        );

        $totalCount = $grammar->getTotalCountWithFilters(
            $this->connection,
            $indexName,
            $query,
            $filters,
        );

        $hits = collect($results)
            ->map(fn (array $row) => new Hit($this->buildHitProperties($row)));

        return new SearchResults(
            $hits,
            (int) ((microtime(true) - $startTime) * 1000),
            $totalCount,
            $effectiveLimit,
            $offset,
        );
    }
}
