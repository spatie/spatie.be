<?php

use App\Models\RepositoryRelease;

it('shows the releases index page to admins', function () {
    $this->actingAsAdmin();

    RepositoryRelease::factory()->create();

    $this->get(route('filament.admin.resources.content.repository-releases.index'))
        ->assertSuccessful();
});

it('does not expose a create page', function () {
    $this->actingAsAdmin();

    expect(fn () => route('filament.admin.resources.content.repository-releases.create'))
        ->toThrow(Symfony\Component\Routing\Exception\RouteNotFoundException::class);
});
