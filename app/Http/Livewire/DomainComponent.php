<?php

namespace App\Http\Livewire;

use App\Models\License;
use Livewire\Component;

class DomainComponent extends Component
{
    /** @var null|string */
    public $domain = '';

    /** @var null|License */
    public $license = null;

    /** @var bool */
    public $editing = false;

    public function mount(License $license)
    {
        $this->license = $license;
        $this->domain = $license->domain;
    }

    public function render()
    {
        return view('front.pages.products.livewire.domain');
    }

    public function edit(): void
    {
        $this->editing = true;
    }

    public function save(): void
    {
        $this->license->update(['domain' => $this->domain]);

        $this->editing = false;
    }
}
