<?php

namespace App\Http\Livewire;

use App\Models\License;
use Livewire\Component;

class DomainComponent extends Component
{
    /** @var string|null */
    public $domain = '';

    /** @var License|null */
    public $license = null;

    /** @var bool */
    public $editing = false;

    public function mount(License $license): void
    {
        $this->license = $license;

        $this->domain = $license->domain;
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

    public function render()
    {
        return view('front.pages.products.livewire.domain');
    }
}
