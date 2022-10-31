<?php

namespace App\Spotlight;

use App\Http\Controllers\DocsController;
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

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirect(action([DocsController::class, 'repository'], ['repository' => $this->repository['name']]));
    }
}
