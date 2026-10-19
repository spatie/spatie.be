<?php

namespace App\Support\ValueStores;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class UpdatedRepositoriesValueStore
{
    protected string $cacheKey = 'docs.updated-repository-names';

    public static function make(): self
    {
        return new static();
    }

    public function getNames(): array
    {
        return Arr::wrap($this->cache()->get($this->cacheKey, []));
    }

    public function store(string $name): self
    {
        $updatedRepositoryNames = $this->getNames();

        $updatedRepositoryNames[] = $name;

        $this->cache()->forever($this->cacheKey, array_values(array_unique($updatedRepositoryNames)));

        return $this;
    }

    public function flush(): void
    {
        $this->cache()->forget($this->cacheKey);
    }

    protected function cache(): CacheRepository
    {
        return Cache::store(config('docs.cache_store'));
    }
}
