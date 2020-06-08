<?php

namespace App\Http\Front\Livewire;

use App\Models\Repository;
use Illuminate\Support\Collection;
use Livewire\Component;

class RepositoriesComponent extends Component
{
    /** @var string */
    public $search = '';

    /** @var string */
    public $sort = 'name';

    /** @var string */
    public $type = 'packages';

    /** @var bool */
    public $filterable = true;

    /** @var bool */
    public $highlighted = false;

    protected $updatesQueryString = ['search', 'sort'];

    public function render()
    {
        return view('front.livewire.repositories', [
            'repositories' => $this->getRepositories(),
        ]);
    }

    public function mount(
        $type = 'packages',
        $filterable = true,
        $highlighted = false,
        $sort = 'name'
    ) {
        $this->type = $type;
        $this->filterable = $filterable;
        $this->highlighted = $highlighted;
        $this->sort = request()->query('sort', $sort);
        $this->search = request()->query('search', '');
    }

    private function getRepositories(): Collection
    {
        $query = Repository::visible();

        $this->type === 'projects'
            ? $query->projects()
            : $query->packages();

        if ($this->highlighted) {
            $query->highlighted();
        }

        $query
            ->search($this->search)
            ->applySort($this->sort);

        return $query->get();
    }
}
