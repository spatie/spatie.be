<?php

namespace App\Spotlight;

use App\Http\Controllers\DocsController;
use App\Support\RepositoryAccess;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class DocsCommand extends SpotlightCommand
{
    public function __construct(private array $repository)
    {
    }

    public function getId(): string
    {
        return $this->repository['name'];
    }

    public function getName(): string
    {
        return $this->repository['name'];
    }

    public function getDescription(): string
    {
        return $this->repository['category'];
    }

    public function shouldBeShown(): bool
    {
        return ! RepositoryAccess::isRestricted($this->repository['name']) || RepositoryAccess::canViewRestricted();
    }

    public function execute(Spotlight $spotlight): void
    {
        abort_unless($this->shouldBeShown(), 404);

        $spotlight->redirect(action([DocsController::class, 'repository'], ['repository' => $this->repository['name']]));
    }
}
