<?php

namespace App\Livewire;

use App\Models\Repository;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RepositoriesComponent extends Component
{
    /** @var string */
    public $search = '';

    /** @var string */
    public $sort = '-downloads';

    /** @var bool */
    public $filterable = true;

    public $type = 'packages';

    protected $queryString = ['search', 'sort'];

    public Collection $repositories;

    public function mount(
        $type = 'packages',
        $filterable = true,
        $sort = '-downloads',
    ): void {
        $this->type = $type;
        $this->filterable = $filterable;
        $this->sort = request()->query('sort', $sort);
        $this->search = request()->query('search', '');
        $this->repositories = collect();
        $this->loadRepositories();
    }

    private function loadRepositories(bool $loadingMore = false): void
    {
        Repository::query()
            ->visible()
            ->when(
                $loadingMore,
                fn (Builder $query) => $query->offset($this->repositories->count()),
            )
            ->search($this->search)
            ->applySort($this->sort)
            ->limit(9)
            ->get()
            ->each(function (Repository $repository) {
                $this->repositories->push($repository);
            });
    }

    public function updatedSearch(): void
    {
        $this->repositories = collect();
        $this->loadRepositories();
    }

    public function updatedSort(): void
    {
        $this->repositories = collect();
        $this->loadRepositories();
    }

    public function loadMore(): void
    {
        $this->loadRepositories(loadingMore: true);
    }

    #[Computed]
    public function total(): int
    {
        return Repository::query()
            ->visible()
            ->search($this->search)
            ->count();
    }

    #[Computed]
    public function hasMore(): bool
    {
        return $this->repositories->count() < $this->total();
    }

    public function render(): View
    {
        return view('front.livewire.repositories');
    }
}
