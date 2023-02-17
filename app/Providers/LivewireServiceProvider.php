<?php

namespace App\Providers;

use App\Http\Livewire\ActivationsComponent;
use App\Http\Livewire\DomainComponent;
use App\Http\Livewire\LessonCompletedButtonComponent;
use App\Http\Livewire\RepositoriesComponent;
use App\Http\Livewire\SearchDocsComponent;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Livewire::component('repositories', RepositoriesComponent::class);
        Livewire::component('lesson-completed-button', LessonCompletedButtonComponent::class);
        Livewire::component('domain', DomainComponent::class);
        Livewire::component('activations', ActivationsComponent::class);
        Livewire::component('search-docs', SearchDocsComponent::class);
    }
}
