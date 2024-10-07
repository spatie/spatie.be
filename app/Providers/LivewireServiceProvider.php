<?php

namespace App\Providers;

use App\Livewire\ActivationsComponent;
use App\Livewire\DomainComponent;
use App\Livewire\LessonCompletedButtonComponent;
use App\Livewire\Newsletter;
use App\Livewire\RepositoriesComponent;
use App\Livewire\SearchDocsComponent;
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
        Livewire::component('newsletter', Newsletter::class);
    }
}
