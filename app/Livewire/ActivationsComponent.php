<?php

namespace App\Livewire;

use App\Domain\Shop\Models\License;
use Livewire\Component;

class ActivationsComponent extends Component
{
    public $license;

    public function mount(License $license)
    {
        $this->license = $license;
    }

    public function delete(int $activationId)
    {
        $this->license->activations()->where('id', $activationId)->delete();
    }

    public function render()
    {
        return view('front.pages.products.livewire.activations', [
            'activations' => $this->license->refresh()->activations,
        ]);
    }
}
