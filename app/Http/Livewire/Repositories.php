<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Repository;
use Illuminate\Support\Collection;

class Repositories extends Component
{
    /** @var string */
    public $search = '';

    /** @var string */
    public $sort = 'name';

    /** @var string */
    public $type = 'packages';

    /** @var boolean */
    public $filterable = true;

    /** @var boolean */
    public $highlighted = false;

    protected $updatesQueryString = ['search', 'sort'];

    public function render()
    {
        return view('livewire.repositories', [
            'repositories' => $this->getRepositories(),
        ]);
    }

    public function mount(array $options = [])
    {
        $this->type = $options['type'] ?? 'packages';
        $this->filterable = $options['filterable'] ?? true;
        $this->highlighted = $options['highlighted'] ?? false;
        $this->sort = request()->query('sort', $options['sort'] ?? 'name');
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
