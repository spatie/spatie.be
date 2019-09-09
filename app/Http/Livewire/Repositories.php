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
        $this->sort = $options['sort'] ?? 'name';
    }

    private function getRepositories(): Collection
    {
        $query = Repository::visible();

        if ($this->type === 'projects') {
            $query->projects();
        } else {
            $query->packages();
        }

        if ($this->highlighted) {
            $query->highlighted();
        }

        $query
            ->search($this->search)
            ->applySort($this->sort);

        return $query->get();
    }
}
