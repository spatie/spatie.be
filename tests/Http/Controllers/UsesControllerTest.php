<?php

use App\Http\Controllers\UsesController;
use App\Models\Enums\TechnologyType;
use App\Models\Technology;
use App\Models\User;
use Tests\TestCase;



it('can show the uses page', function () {
    $this->actingAs(User::factory()->make(['is_admin' => true]));

    $technologies = [];

    foreach (TechnologyType::toArray() as $type) {
        $technologies[] = Technology::factory()
            ->state(['type' => $type])
            ->create()
            ->getAttributes();
    }

    $this
        ->get(action([UsesController::class, 'index']))
        ->assertOk()
        ->assertSee($technologies[0]['name'])
        ->assertSee($technologies[1]['website_url'])
        ->assertSee($technologies[2]['description']);
});
