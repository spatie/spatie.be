<?php

namespace App\Providers;

use App\Http\Livewire\DomainComponent;
use App\Http\Livewire\RepositoriesComponent;
use App\Http\Livewire\VideoCompletedButtonComponent;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function register()
    {
        Livewire::component('repositories', RepositoriesComponent::class);
        Livewire::component('video-completed-button', VideoCompletedButtonComponent::class);
        Livewire::component('domain', DomainComponent::class);
    }
}
