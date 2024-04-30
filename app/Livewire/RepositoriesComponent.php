<?php

namespace App\Livewire;

use App\Models\Repository;
use Illuminate\Support\Collection;
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

    public function mount(
        $type = 'packages',
        $filterable = true,
        $sort = '-downloads'
    ): void {
        $this->type = $type;
        $this->filterable = $filterable;
        $this->sort = request()->query('sort', $sort);
        $this->search = request()->query('search', '');
    }

    private function getRepositories(): Collection
    {
        return Repository::visible()
            ->search($this->search)
            ->applySort($this->sort)
            ->get();
    }

    public function render()
    {
        return view('front.livewire.repositories', [
            'repositories' => $this->getRepositories(),
        ]);
    }
}
