<?php

namespace App\Support\ValueStores;

use Illuminate\Support\Collection;
use Spatie\Valuestore\Valuestore;

class UpdatedRepositoriesValueStore
{
    protected Valuestore $valueStore;

    public static function make(): self
    {
        return new static();
    }

    public function __construct()
    {
        $this->valueStore = Valuestore::make('storage/updatesRepositories.json');
    }

    public function getNames(): array
    {
        return $this->valueStore->get('updatedRepositoryNames', []);
    }

    public function store(string $name): self
    {
        $updatedRepositoryNames = $this->valueStore->get('updatedRepositoryNames', []);

        $updatedRepositoryNames[] = $name;

        $this->valueStore->put('updatedRepositoryNames', $updatedRepositoryNames);

        return $this;
    }

    public function flush()
    {
        $this->valueStore->flush();
    }


}